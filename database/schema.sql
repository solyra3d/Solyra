-- =============================================
-- SOLYRA - Database Schema
-- Engine: InnoDB | Charset: utf8mb4
-- =============================================

CREATE DATABASE IF NOT EXISTS solyra
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE solyra;

-- =============================================
-- TABELA: users (Administradores)
-- =============================================
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE INDEX idx_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- TABELA: categories (Categorias de Produtos)
-- =============================================
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL,
    description TEXT NULL,
    image VARCHAR(255) NULL,
    icon VARCHAR(50) NULL,
    order_position INT UNSIGNED DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE INDEX idx_categories_slug (slug),
    INDEX idx_categories_active (is_active),
    INDEX idx_categories_order (order_position)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- TABELA: products (Produtos)
-- =============================================
CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL,
    short_description VARCHAR(500) NULL,
    description TEXT NULL,
    price_from DECIMAL(10,2) NULL DEFAULT NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    is_new TINYINT(1) NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    seo_title VARCHAR(200) NULL,
    seo_description VARCHAR(300) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE INDEX idx_products_slug (slug),
    INDEX idx_products_category (category_id),
    INDEX idx_products_active (is_active),
    INDEX idx_products_featured (is_featured),
    INDEX idx_products_new (is_new),
    INDEX idx_products_created (created_at),
    INDEX idx_products_category_active (category_id, is_active),
    
    CONSTRAINT fk_products_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- TABELA: product_images (Galeria de Imagens)
-- =============================================
CREATE TABLE product_images (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_cover TINYINT(1) NOT NULL DEFAULT 0,
    order_position INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_images_product (product_id),
    INDEX idx_images_cover (product_id, is_cover),
    INDEX idx_images_order (product_id, order_position),
    
    CONSTRAINT fk_images_product
        FOREIGN KEY (product_id) REFERENCES products(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- TABELA: banners (Banners Rotativos)
-- =============================================
CREATE TABLE banners (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    subtitle VARCHAR(300) NULL,
    button_text VARCHAR(50) NULL DEFAULT 'Saiba Mais',
    button_link VARCHAR(255) NULL,
    image_path VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    order_position INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_banners_active (is_active),
    INDEX idx_banners_order (order_position)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- TABELA: reviews (Avaliações/Depoimentos)
-- =============================================
CREATE TABLE reviews (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    company VARCHAR(100) NULL,
    text TEXT NOT NULL,
    rating TINYINT UNSIGNED NOT NULL DEFAULT 5,
    avatar VARCHAR(255) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_reviews_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- TABELA: settings (Configurações do Site)
-- =============================================
CREATE TABLE settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL,
    setting_value TEXT NULL,
    
    UNIQUE INDEX idx_settings_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
