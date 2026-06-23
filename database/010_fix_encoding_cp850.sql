-- =====================================================
-- SOLYRA - Fix encoding (CP850 -> UTF-8)
-- Corrige textos importados via CMD Windows (charset CP850)
-- Executar apenas UMA VEZ após detectar problema de encoding
-- =====================================================

-- page_contents
UPDATE page_contents 
SET content_value = CONVERT(CAST(CONVERT(content_value USING cp850) AS BINARY) USING utf8mb4) 
WHERE content_value LIKE '%├%';

-- section_cards (title)
UPDATE section_cards 
SET title = CONVERT(CAST(CONVERT(title USING cp850) AS BINARY) USING utf8mb4) 
WHERE title LIKE '%├%';

-- section_cards (description)
UPDATE section_cards 
SET description = CONVERT(CAST(CONVERT(description USING cp850) AS BINARY) USING utf8mb4) 
WHERE description LIKE '%├%';

-- reviews
UPDATE reviews 
SET text = CONVERT(CAST(CONVERT(text USING cp850) AS BINARY) USING utf8mb4) 
WHERE text LIKE '%├%';

UPDATE reviews 
SET client_name = CONVERT(CAST(CONVERT(client_name USING cp850) AS BINARY) USING utf8mb4) 
WHERE client_name LIKE '%├%';

UPDATE reviews 
SET company = CONVERT(CAST(CONVERT(company USING cp850) AS BINARY) USING utf8mb4) 
WHERE company LIKE '%├%';

-- settings
UPDATE settings 
SET setting_value = CONVERT(CAST(CONVERT(setting_value USING cp850) AS BINARY) USING utf8mb4) 
WHERE setting_value LIKE '%├%';

-- banners
UPDATE banners 
SET title = CONVERT(CAST(CONVERT(title USING cp850) AS BINARY) USING utf8mb4) 
WHERE title LIKE '%├%';

UPDATE banners 
SET subtitle = CONVERT(CAST(CONVERT(subtitle USING cp850) AS BINARY) USING utf8mb4) 
WHERE subtitle LIKE '%├%';

-- products (caso necessário)
UPDATE products 
SET name = CONVERT(CAST(CONVERT(name USING cp850) AS BINARY) USING utf8mb4) 
WHERE name LIKE '%├%';

UPDATE products 
SET description = CONVERT(CAST(CONVERT(description USING cp850) AS BINARY) USING utf8mb4) 
WHERE description LIKE '%├%';

-- categories (caso necessário)
UPDATE categories 
SET name = CONVERT(CAST(CONVERT(name USING cp850) AS BINARY) USING utf8mb4) 
WHERE name LIKE '%├%';
