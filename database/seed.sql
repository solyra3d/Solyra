-- =============================================
-- SOLYRA - Dados Iniciais (Seed)
-- =============================================

USE solyra;

-- =============================================
-- Admin padrão (senha: Mega98527)
-- =============================================
INSERT INTO users (name, email, password, role) VALUES
('Administrador', 'cyber.allnet@gmail.com', '$2y$12$I.2e26.7qYfy9W0UTfmZIO5ji.E0iH9FCjfCEqKNQE44Qumrny5I2', 'admin');

-- =============================================
-- Categorias
-- =============================================
INSERT INTO categories (name, slug, description, icon, order_position, is_active) VALUES
('Luminárias', 'luminarias', 'Luminárias decorativas personalizadas com design exclusivo', 'lightbulb', 1, 1),
('Brindes', 'brindes', 'Brindes personalizados para empresas e eventos', 'gift', 2, 1),
('Decoração', 'decoracao', 'Peças decorativas modernas para ambientes', 'palette', 3, 1),
('Personalizados', 'personalizados', 'Produtos sob medida para sua necessidade', 'brush', 4, 1),
('Pokémon', 'pokemon', 'Colecionáveis e itens temáticos Pokémon', 'pokeball', 5, 1),
('Geek', 'geek', 'Produtos para a cultura geek e nerd', 'gamepad', 6, 1),
('Empresas', 'empresas', 'Soluções corporativas e brindes empresariais', 'briefcase', 7, 1),
('Colecionáveis', 'colecionaveis', 'Peças exclusivas para colecionadores', 'trophy', 8, 1);

-- =============================================
-- Configurações do site
-- =============================================
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'SOLYRA'),
('site_slogan', 'Design que Ilumina, Presentes que Marcam'),
('site_logo', ''),
('site_favicon', ''),
('site_whatsapp', ''),
('social_instagram', ''),
('social_facebook', ''),
('social_tiktok', ''),
('site_email', 'contato@solyra.com.br'),
('site_phone', ''),
('site_address', ''),
('site_hours', 'Seg-Sex: 9h às 18h'),
('seo_title', 'SOLYRA - Brindes Personalizados, Luminárias e Decoração Premium'),
('seo_description', 'Brindes personalizados, luminárias decorativas, peças 3D e itens colecionáveis. Design premium e inovação para sua empresa e casa.'),
('google_analytics', ''),
('google_tag_manager', '');

-- =============================================
-- Avaliações de exemplo
-- =============================================
INSERT INTO reviews (client_name, company, text, rating, is_active) VALUES
('Maria Silva', 'Tech Solutions', 'Produtos incríveis! A luminária personalizada que encomendamos para o escritório ficou sensacional. Qualidade premium e entrega pontual.', 5, 1),
('Carlos Mendes', 'Studio Design', 'Parceria excelente para brindes corporativos. O acabamento dos produtos é impecável e o atendimento é muito atencioso.', 5, 1),
('Ana Oliveira', NULL, 'Comprei peças colecionáveis e superou todas as expectativas. O nível de detalhe é impressionante! Já estou planejando a próxima compra.', 5, 1),
('Roberto Almeida', 'Agência Criativa', 'A SOLYRA transformou nossa ideia em realidade. Os brindes personalizados para nosso evento foram um sucesso absoluto!', 5, 1);

-- =============================================
-- Banners de exemplo
-- =============================================
INSERT INTO banners (title, subtitle, button_text, button_link, image_path, is_active, order_position) VALUES
('Design que Ilumina', 'Luminárias decorativas e brindes personalizados com tecnologia 3D', 'Ver Catálogo', '/catalogo', 'uploads/banners/placeholder-hero.jpg', 1, 1),
('Presentes que Marcam', 'Crie produtos únicos e memoráveis para sua empresa ou ocasião especial', 'Solicitar Orçamento', '#orcamento', 'uploads/banners/placeholder-hero2.jpg', 1, 2);
