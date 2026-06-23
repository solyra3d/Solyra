-- =============================================
-- SOLYRA CMS - Seed de conteúdo inicial
-- =============================================

-- HOME - Hero
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('home', 'hero', 'badge', 'Impressão 3D Premium', 'text'),
('home', 'hero', 'title', 'Luminárias e peças<br><span class="text-gradient">que encantam</span>', 'text'),
('home', 'hero', 'description', 'Design exclusivo, tecnologia de ponta e acabamento impecável. Cada peça é criada para transformar ambientes.', 'textarea'),
('home', 'hero', 'btn_primary', 'Ver Catálogo', 'text'),
('home', 'hero', 'btn_secondary', 'Solicitar Orçamento', 'text');

-- HOME - Categorias
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('home', 'categories', 'title', 'Nossas <span class="text-gradient">Categorias</span>', 'text'),
('home', 'categories', 'subtitle', 'Explore nosso catálogo diversificado de produtos premium', 'text');

-- HOME - Produtos em Destaque
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('home', 'featured', 'title', 'Produtos em <span class="text-gradient">Destaque</span>', 'text'),
('home', 'featured', 'subtitle', 'Os mais procurados pelos nossos clientes', 'text');

-- HOME - Pronta Entrega
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('home', 'ready', 'title', 'Pronta <span class="text-gradient">Entrega</span>', 'text'),
('home', 'ready', 'subtitle', 'Produtos prontos para envio imediato. Sem espera!', 'text');

-- HOME - Processo
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('home', 'process', 'title', 'Como <span class="text-gradient">Funciona</span>', 'text'),
('home', 'process', 'subtitle', 'Do pedido à entrega em passos simples', 'text');

-- HOME - Diferenciais
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('home', 'differentials', 'title', 'Por que escolher a <span class="text-gradient">SOLYRA</span>?', 'text'),
('home', 'differentials', 'subtitle', 'Tecnologia, qualidade e inovação em cada produto', 'text');

-- HOME - Avaliações
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('home', 'reviews', 'title', 'O que dizem nossos <span class="text-gradient">clientes</span>', 'text'),
('home', 'reviews', 'subtitle', 'Depoimentos de quem já experimentou a qualidade SOLYRA', 'text');

-- HOME - CTA Final
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('home', 'cta', 'title', 'Pronto para criar algo <span class="text-gradient">incrível</span>?', 'text'),
('home', 'cta', 'description', 'Entre em contato e transforme sua ideia em realidade. Orçamento sem compromisso!', 'textarea'),
('home', 'cta', 'btn_primary', 'Solicitar Orçamento', 'text'),
('home', 'cta', 'btn_secondary', 'Ver Catálogo', 'text');

-- ABOUT - Hero
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('about', 'hero', 'title', 'Sobre a <span class="text-gradient">SOLYRA</span>', 'text'),
('about', 'hero', 'subtitle', 'Transformando ideias em experiências únicas através de brindes personalizados, luminárias decorativas e peças exclusivas.', 'textarea');

-- ABOUT - Conteúdo
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('about', 'content', 'title', 'Quem Somos', 'text'),
('about', 'content', 'paragraph1', 'A <strong>SOLYRA</strong> nasceu da paixão por criar produtos únicos que encantam e surpreendem. Somos especialistas em brindes personalizados, luminárias decorativas, peças 3D, itens colecionáveis e presentes criativos.', 'textarea'),
('about', 'content', 'paragraph2', 'Cada produto é desenvolvido com atenção aos detalhes, utilizando tecnologia de ponta e materiais de alta qualidade para garantir resultados que superam expectativas.', 'textarea'),
('about', 'content', 'paragraph3', 'Nossa missão é oferecer soluções criativas e inovadoras que fortaleçam marcas, celebrem momentos especiais e transformem ambientes.', 'textarea'),
('about', 'content', 'image', '', 'image');

-- ABOUT - CTA
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('about', 'cta', 'title', 'Pronto para criar algo incrível?', 'text'),
('about', 'cta', 'description', 'Entre em contato e vamos transformar sua ideia em realidade.', 'textarea'),
('about', 'cta', 'btn_text', 'Falar no WhatsApp', 'text');

-- CONTACT - Hero
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('contact', 'hero', 'title', 'Fale <span class="text-gradient">Conosco</span>', 'text'),
('contact', 'hero', 'subtitle', 'Estamos prontos para atender você. Escolha o canal de sua preferência.', 'text');

-- FOOTER - Brand
INSERT INTO page_contents (page, section, content_key, content_value, content_type) VALUES
('footer', 'brand', 'description', 'Luminárias, decoração e peças exclusivas impressas em 3D com tecnologia de ponta.', 'textarea');

-- =============================================
-- SECTION CARDS - Processo (Home)
-- =============================================
INSERT INTO section_cards (section, icon, title, description, order_position) VALUES
('home_process', '💬', '1. Contato', 'Envie sua ideia pelo WhatsApp ou formulário de contato', 0),
('home_process', '🎨', '2. Design', 'Criamos o modelo 3D com aprovação antes da produção', 1),
('home_process', '🖨️', '3. Impressão', 'Produção com tecnologia FDM ou resina de alta precisão', 2),
('home_process', '📦', '4. Entrega', 'Acabamento premium e envio seguro para todo o Brasil', 3);

-- SECTION CARDS - Diferenciais (Home)
INSERT INTO section_cards (section, icon, title, description, order_position) VALUES
('home_differentials', '🖨️', 'Tecnologia 3D', 'Impressão de alta precisão com FDM e resina', 0),
('home_differentials', '✨', 'Design Premium', 'Acabamento profissional com atenção a cada detalhe', 1),
('home_differentials', '🎨', 'Personalização', 'Produtos sob medida para sua marca ou ocasião', 2),
('home_differentials', '⚡', 'Agilidade', 'Produção rápida com qualidade garantida', 3);

-- SECTION CARDS - Features (Sobre)
INSERT INTO section_cards (section, icon, title, description, order_position) VALUES
('about_features', '🎨', 'Personalização Total', 'Cada projeto é único e feito sob medida para atender exatamente o que você precisa.', 0),
('about_features', '⚡', 'Tecnologia 3D', 'Utilizamos impressão 3D e corte a laser para criar peças com precisão milimétrica.', 1),
('about_features', '💎', 'Qualidade Premium', 'Materiais selecionados e acabamento impecável em todos os nossos produtos.', 2),
('about_features', '🚀', 'Entrega Rápida', 'Processos otimizados para entregar seu pedido no menor prazo possível.', 3);
