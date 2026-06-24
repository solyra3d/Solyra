ALTER TABLE products
  ADD COLUMN is_ready_delivery TINYINT(1) NOT NULL DEFAULT 0 AFTER is_active,
  ADD COLUMN stock_quantity    INT UNSIGNED NOT NULL DEFAULT 0 AFTER is_ready_delivery;

CREATE INDEX idx_products_ready ON products (is_active, is_ready_delivery, stock_quantity);
