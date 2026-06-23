USE solyra;

-- =============================================
-- Tabela: ready_products (Pronta Entrega)
-- =============================================
CREATE TABLE IF NOT EXISTS ready_products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL,
    description TEXT,
    short_description VARCHAR(500),
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock_quantity INT UNSIGNED NOT NULL DEFAULT 0,
    category_id INT UNSIGNED NULL,
    cover_image VARCHAR(255),
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE INDEX idx_ready_slug (slug),
    INDEX idx_ready_active (is_active),
    INDEX idx_ready_featured (is_featured),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabela: ready_product_images
-- =============================================
CREATE TABLE IF NOT EXISTS ready_product_images (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ready_product_id INT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    order_position INT UNSIGNED DEFAULT 0,
    
    FOREIGN KEY (ready_product_id) REFERENCES ready_products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabela: portfolio
-- =============================================
CREATE TABLE IF NOT EXISTS portfolio (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    cover_image VARCHAR(255),
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    order_position INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE INDEX idx_portfolio_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabela: portfolio_images
-- =============================================
CREATE TABLE IF NOT EXISTS portfolio_images (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    portfolio_id INT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    order_position INT UNSIGNED DEFAULT 0,
    
    FOREIGN KEY (portfolio_id) REFERENCES portfolio(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
