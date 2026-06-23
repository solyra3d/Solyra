<?php
/**
 * SOLYRA - Funções Helpers Globais
 */

/**
 * Redirecionar para URL
 */
function redirect(string $url): void
{
    header("Location: {$url}");
    exit;
}

/**
 * Redirecionar para rota nomeada
 */
function redirectRoute(string $name, array $params = []): void
{
    $url = Router::route($name, $params);
    redirect($url);
}

/**
 * Obter URL base
 */
function baseUrl(string $path = ''): string
{
    $config = require ROOT_PATH . '/config/app.php';
    return rtrim($config['url'], '/') . '/' . ltrim($path, '/');
}

/**
 * Obter URL de asset
 */
function asset(string $path): string
{
    $version = '2.0';
    return baseUrl('assets/' . ltrim($path, '/')) . '?v=' . $version;
}

/**
 * Obter URL de upload
 */
function uploadUrl(string $path): string
{
    return baseUrl('uploads/' . ltrim($path, '/'));
}

/**
 * Escape HTML (proteção XSS)
 */
function e(?string $value): string
{
    if ($value === null) {
        return '';
    }
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Gerar campo CSRF Token
 */
function csrfField(): string
{
    $token = Session::generateCsrfToken();
    return '<input type="hidden" name="_csrf_token" value="' . e($token) . '">';
}

/**
 * Obter CSRF Token
 */
function csrfToken(): string
{
    return Session::generateCsrfToken();
}

/**
 * Flash message de sucesso
 */
function flashSuccess(): ?string
{
    return Session::getFlash('success');
}

/**
 * Flash message de erro
 */
function flashError(): ?string
{
    return Session::getFlash('error');
}

/**
 * Verificar se é a rota atual
 */
function isCurrentUrl(string $url): bool
{
    $currentUri = '/' . trim($_GET['url'] ?? '', '/');
    return $currentUri === $url;
}

/**
 * Formatar preço
 */
function formatPrice(?float $value): string
{
    if ($value === null || $value <= 0) {
        return 'Sob consulta';
    }
    return 'R$ ' . number_format($value, 2, ',', '.');
}

/**
 * Truncar texto
 */
function truncate(string $text, int $length = 100, string $suffix = '...'): string
{
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . $suffix;
}

/**
 * Gerar link WhatsApp com mensagem
 */
function whatsappLink(string $number, string $message = ''): string
{
    $number = preg_replace('/[^0-9]/', '', $number);
    if (!$number) {
        return '#';
    }
    $params = $message ? '?text=' . urlencode($message) : '';
    return "https://wa.me/{$number}{$params}";
}

/**
 * Gerar link WhatsApp para produto
 */
function whatsappProductLink(string $number, string $productName): string
{
    $message = "Olá! Tenho interesse no produto: {$productName}. Gostaria de solicitar um orçamento.";
    return whatsappLink($number, $message);
}

/**
 * Tempo relativo (ex: "há 2 dias")
 */
function timeAgo(string $datetime): string
{
    $time = strtotime($datetime);
    $diff = time() - $time;

    if ($diff < 60) return 'agora';
    if ($diff < 3600) return floor($diff / 60) . ' min atrás';
    if ($diff < 86400) return floor($diff / 3600) . 'h atrás';
    if ($diff < 2592000) return floor($diff / 86400) . ' dias atrás';
    
    return date('d/m/Y', $time);
}

/**
 * Obter configuração do site (cache simples)
 */
function setting(string $key, string $default = ''): string
{
    static $settings = null;

    if ($settings === null) {
        try {
            $rows = Database::fetchAll("SELECT setting_key, setting_value FROM settings");
            $settings = [];
            foreach ($rows as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (\Exception $e) {
            $settings = [];
        }
    }

    return $settings[$key] ?? $default;
}

/**
 * Obter conteúdo dinâmico de página (cache estático)
 */
function pageContent(string $page, string $section, string $key, string $default = ''): string
{
    return PageContent::get($page, $section, $key, $default);
}

/**
 * Verificar se usuário está logado
 */
function isLoggedIn(): bool
{
    return Auth::check();
}

/**
 * Obter dados do usuário logado
 */
function currentUser(): ?array
{
    return Auth::user();
}
