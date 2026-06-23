#!/bin/bash
# ============================================================
# SOLYRA — Deploy Script v1.0
# Ubuntu 24.04 | PHP 8.3 | MariaDB | Nginx
# ============================================================

set -e

GREEN='\033[0;32m'; BLUE='\033[0;34m'
YELLOW='\033[1;33m'; RED='\033[0;31m'; NC='\033[0m'

step()  { echo -e "\n${BLUE}▶ $1${NC}"; }
ok()    { echo -e "${GREEN}  ✓ $1${NC}"; }
warn()  { echo -e "${YELLOW}  ⚠ $1${NC}"; }
err()   { echo -e "${RED}  ✗ $1${NC}"; exit 1; }

echo -e "${GREEN}"
echo "╔══════════════════════════════════════╗"
echo "║        SOLYRA — Deploy v1.0          ║"
echo "╚══════════════════════════════════════╝"
echo -e "${NC}"

export DEBIAN_FRONTEND=noninteractive

# ─────────────────────────────────────────────
# 1. AMBIENTE
# ─────────────────────────────────────────────
step "Verificando ambiente..."

SERVER_IP=$(curl -s --max-time 5 https://api.ipify.org 2>/dev/null || hostname -I | awk '{print $1}')
ok "IP do servidor: $SERVER_IP"

# Verifica Docker e porta 80
DOCKER_ON_80=""
if command -v docker &>/dev/null; then
    DOCKER_ON_80=$(docker ps --format "{{.Names}}:::{{.Ports}}" 2>/dev/null | grep "0.0.0.0:80->" | cut -d: -f1 || true)
    if [ -n "$DOCKER_ON_80" ]; then
        warn "Porta 80 em uso pelo container Docker: $DOCKER_ON_80"
    fi
fi

# ─────────────────────────────────────────────
# 2. DEPENDÊNCIAS
# ─────────────────────────────────────────────
step "Instalando dependências (PHP 8.3, MariaDB, Nginx, Git)..."

apt-get update -qq

# Adiciona repositório PHP 8.3 se necessário
if ! dpkg -l php8.3 &>/dev/null 2>&1; then
    apt-get install -y -qq software-properties-common
    LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php
    apt-get update -qq
fi

apt-get install -y -qq \
    nginx \
    php8.3 \
    php8.3-fpm \
    php8.3-mysql \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-curl \
    php8.3-zip \
    php8.3-intl \
    php8.3-gd \
    mariadb-server \
    git \
    curl

ok "PHP $(php8.3 --version | head -1 | cut -d' ' -f2) instalado"
ok "MariaDB instalado"
ok "Nginx instalado"

# ─────────────────────────────────────────────
# 3. MARIADB
# ─────────────────────────────────────────────
step "Configurando banco de dados..."

systemctl enable mariadb --now
sleep 2

DB_NAME="solyra"
DB_USER="solyra_user"
DB_PASS="Solyra@Prod2024"

mysql -u root << SQL
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;
SQL

ok "Banco '${DB_NAME}' criado | Usuário '${DB_USER}' configurado"

# ─────────────────────────────────────────────
# 4. REPOSITÓRIO
# ─────────────────────────────────────────────
step "Clonando repositório do GitHub..."

DEPLOY_DIR="/var/www/solyra"

if [ -d "$DEPLOY_DIR/.git" ]; then
    cd "$DEPLOY_DIR"
    git pull origin main
    ok "Repositório atualizado"
else
    git clone https://github.com/solyra3d/Solyra.git "$DEPLOY_DIR"
    ok "Repositório clonado em $DEPLOY_DIR"
fi

cd "$DEPLOY_DIR"

# ─────────────────────────────────────────────
# 5. CONFIGURAÇÃO DA APLICAÇÃO
# ─────────────────────────────────────────────
step "Configurando aplicação..."

# config/database.php
cat > config/database.php << PHP
<?php
return [
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'database'  => '${DB_NAME}',
    'username'  => '${DB_USER}',
    'password'  => '${DB_PASS}',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];
PHP

# config/app.php — URL de produção e debug off
sed -i "s|'url' => 'http://solyra'|'url' => 'http://${SERVER_IP}'|g" config/app.php
sed -i "s|'debug' => true|'debug' => false|g" config/app.php

ok "config/database.php atualizado"
ok "config/app.php atualizado (URL: http://${SERVER_IP})"

# ─────────────────────────────────────────────
# 6. MIGRATIONS
# ─────────────────────────────────────────────
step "Executando migrations do banco..."

mysql -u root "$DB_NAME" < database/schema.sql
ok "schema.sql executado"

mysql -u root "$DB_NAME" < database/seed.sql
ok "seed.sql executado"

# Additional migrations
for f in database/migration_v2.sql database/008_create_cms_tables.sql database/009_seed_cms_data.sql; do
    [ -f "$f" ] && mysql -u root "$DB_NAME" < "$f" 2>/dev/null && ok "$f executado" || true
done

# Admin user
ADMIN_PASS_HASH=$(php8.3 -r "echo password_hash('Solyra@Admin2024', PASSWORD_BCRYPT, ['cost'=>12]);")
mysql -u root "$DB_NAME" << SQL
INSERT INTO users (name, email, password, role, created_at)
VALUES ('Administrador', 'admin@solyra.com.br', '${ADMIN_PASS_HASH}', 'admin', NOW())
ON DUPLICATE KEY UPDATE password='${ADMIN_PASS_HASH}', name='Administrador';
SQL

ok "Usuário admin criado"

# ─────────────────────────────────────────────
# 7. PERMISSÕES
# ─────────────────────────────────────────────
step "Configurando permissões de arquivos..."

chown -R www-data:www-data "$DEPLOY_DIR"
chmod -R 755 "$DEPLOY_DIR"
mkdir -p "$DEPLOY_DIR/public/uploads"
chmod -R 775 "$DEPLOY_DIR/public/uploads"

ok "Permissões configuradas"

# ─────────────────────────────────────────────
# 8. PHP-FPM
# ─────────────────────────────────────────────
step "Iniciando PHP-FPM 8.3..."

systemctl enable php8.3-fpm --now
ok "PHP-FPM rodando"

# ─────────────────────────────────────────────
# 9. NGINX
# ─────────────────────────────────────────────
step "Configurando Nginx..."

# Se porta 80 está em uso por Docker, paramos o container temporariamente
if [ -n "$DOCKER_ON_80" ]; then
    warn "Parando container '$DOCKER_ON_80' para liberar porta 80..."
    warn "Os outros serviços (n8n etc.) voltarão depois com docker start $DOCKER_ON_80"
    docker stop "$DOCKER_ON_80" 2>/dev/null || true
fi

# Virtual host Solyra
cat > /etc/nginx/sites-available/solyra << NGINX
server {
    listen 80 default_server;
    listen [::]:80 default_server;

    root /var/www/solyra/public;
    index index.php index.html;
    server_name _;

    # Logs
    access_log /var/log/nginx/solyra_access.log;
    error_log  /var/log/nginx/solyra_error.log;

    # Rewrite para index.php (MVC)
    location / {
        try_files \$uri \$uri/ /index.php?url=\$uri&\$query_string;
    }

    # PHP-FPM
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    # Uploads — limite de tamanho
    client_max_body_size 10M;

    # Bloqueia acesso a arquivos ocultos
    location ~ /\. {
        deny all;
    }

    # Bloqueia acesso direto a config e database
    location ~* ^/(config|database|core|app/Models|app/Controllers)/ {
        deny all;
    }
}
NGINX

# Desativa default e ativa solyra
rm -f /etc/nginx/sites-enabled/default
ln -sf /etc/nginx/sites-available/solyra /etc/nginx/sites-enabled/solyra

# Testa e reinicia
nginx -t
systemctl enable nginx --now
systemctl restart nginx

ok "Nginx configurado e rodando"

# ─────────────────────────────────────────────
# 10. VERIFICAÇÃO FINAL
# ─────────────────────────────────────────────
step "Verificação final..."

sleep 2
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost/" 2>/dev/null || echo "0")

if [ "$HTTP_CODE" = "200" ] || [ "$HTTP_CODE" = "302" ]; then
    ok "Site respondendo (HTTP $HTTP_CODE)"
else
    warn "Site retornou HTTP $HTTP_CODE — verifique os logs: tail -20 /var/log/nginx/solyra_error.log"
fi

# ─────────────────────────────────────────────
# SUCESSO
# ─────────────────────────────────────────────
echo ""
echo -e "${GREEN}╔══════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║       DEPLOY CONCLUÍDO COM SUCESSO! 🎉   ║${NC}"
echo -e "${GREEN}╚══════════════════════════════════════════╝${NC}"
echo ""
echo -e "  🌐  Site:       ${BLUE}http://${SERVER_IP}/${NC}"
echo -e "  🔐  Admin:      ${BLUE}http://${SERVER_IP}/admin${NC}"
echo -e "  👤  E-mail:     admin@solyra.com.br"
echo -e "  🔑  Senha:      Solyra@Admin2024"
echo ""
echo -e "  🗄️   Banco:      ${DB_NAME}"
echo -e "  👤  DB User:    ${DB_USER}"
echo -e "  🔑  DB Senha:   ${DB_PASS}"
echo ""
echo -e "${YELLOW}  ⚠  IMPORTANTE: Altere a senha do admin no primeiro acesso!${NC}"
if [ -n "$DOCKER_ON_80" ]; then
    echo ""
    echo -e "${YELLOW}  ⚠  O container '${DOCKER_ON_80}' foi parado para liberar a porta 80.${NC}"
    echo -e "${YELLOW}     Para restaurar n8n e outros serviços: docker start ${DOCKER_ON_80}${NC}"
    echo -e "${YELLOW}     (Será necessário configurar proxy para coexistir com Solyra)${NC}"
fi
echo ""
