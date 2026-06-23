-- =============================================
-- SOLYRA CMS - Tabelas de conteúdo dinâmico
-- =============================================

-- Blocos de conteúdo de página (textos editáveis)
CREATE TABLE IF NOT EXISTS page_contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page VARCHAR(50) NOT NULL,
    section VARCHAR(50) NOT NULL,
    content_key VARCHAR(100) NOT NULL,
    content_value TEXT,
    content_type ENUM('text','textarea','image') DEFAULT 'text',
    UNIQUE KEY unique_content (page, section, content_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cards editáveis (processo, diferenciais, features)
CREATE TABLE IF NOT EXISTS section_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(50) NOT NULL,
    icon VARCHAR(10) DEFAULT '',
    title VARCHAR(255) NOT NULL,
    description TEXT,
    order_position INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Galeria da empresa
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255) DEFAULT '',
    order_position INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Adicionar YouTube nas settings
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES ('site_youtube', '');
