<?php
/**
 * SOLYRA - Definição de Rotas
 * Named routes, middlewares por grupo, páginas de erro
 */

// ========================================
// ROTAS PÚBLICAS
// ========================================

// Home
$router->get('/', 'HomeController', 'index', 'home');

// Catálogo
$router->get('/catalogo', 'CatalogController', 'index', 'catalog');
$router->get('/catalogo/{slug}', 'CatalogController', 'category', 'catalog.category');

// Produto
$router->get('/produto/{slug}', 'ProductController', 'show', 'product.show');

// Páginas estáticas
$router->get('/sobre', 'PageController', 'about', 'about');
$router->get('/contato', 'PageController', 'contact', 'contact');

// Pronta Entrega
$router->get('/pronta-entrega', 'ReadyProductController', 'index', 'ready');
$router->get('/pronta-entrega/{slug}', 'ReadyProductController', 'show', 'ready.show');

// API pública (busca, filtros)
$router->get('/api/products/search', 'ApiController', 'searchProducts', 'api.search');
$router->get('/api/products/filter', 'ApiController', 'filterProducts', 'api.filter');

// SEO
$router->get('/sitemap.xml', 'SeoController', 'sitemap', 'sitemap');
$router->get('/robots.txt', 'SeoController', 'robots', 'robots');

// ========================================
// ROTAS ADMIN (protegidas por middleware auth)
// ========================================

// Login (guest)
$router->group('admin', 'guest', function ($router) {
    $router->get('/login', 'AdminAuthController', 'showLogin', 'admin.login');
    $router->post('/login', 'AdminAuthController', 'login', 'admin.login.post');
});

// Área administrativa (auth)
$router->group('admin', 'auth', function ($router) {
    // Dashboard
    $router->get('/', 'AdminDashboardController', 'index', 'admin.dashboard');
    $router->get('/logout', 'AdminAuthController', 'logout', 'admin.logout');

    // Produtos
    $router->get('/produtos', 'AdminProductController', 'index', 'admin.products');
    $router->get('/produtos/categoria/{id}', 'AdminProductController', 'category', 'admin.products.category');
    $router->get('/produtos/criar', 'AdminProductController', 'create', 'admin.products.create');
    $router->post('/produtos/criar', 'AdminProductController', 'store', 'admin.products.store');
    $router->get('/produtos/editar/{id}', 'AdminProductController', 'edit', 'admin.products.edit');
    $router->post('/produtos/editar/{id}', 'AdminProductController', 'update', 'admin.products.update');
    $router->post('/produtos/deletar/{id}', 'AdminProductController', 'delete', 'admin.products.delete');
    $router->post('/produtos/toggle/{id}', 'AdminProductController', 'toggle', 'admin.products.toggle');
    $router->post('/produtos/imagem-deletar/{id}', 'AdminProductController', 'deleteImage', 'admin.products.deleteImage');
    $router->post('/produtos/video-deletar/{id}', 'AdminProductController', 'deleteVideo', 'admin.products.deleteVideo');

    // Categorias
    $router->get('/categorias', 'AdminCategoryController', 'index', 'admin.categories');
    $router->get('/categorias/criar', 'AdminCategoryController', 'create', 'admin.categories.create');
    $router->post('/categorias/criar', 'AdminCategoryController', 'store', 'admin.categories.store');
    $router->get('/categorias/editar/{id}', 'AdminCategoryController', 'edit', 'admin.categories.edit');
    $router->post('/categorias/editar/{id}', 'AdminCategoryController', 'update', 'admin.categories.update');
    $router->post('/categorias/deletar/{id}', 'AdminCategoryController', 'delete', 'admin.categories.delete');

    // Banners
    $router->get('/banners', 'AdminBannerController', 'index', 'admin.banners');
    $router->get('/banners/criar', 'AdminBannerController', 'create', 'admin.banners.create');
    $router->post('/banners/criar', 'AdminBannerController', 'store', 'admin.banners.store');
    $router->get('/banners/editar/{id}', 'AdminBannerController', 'edit', 'admin.banners.edit');
    $router->post('/banners/editar/{id}', 'AdminBannerController', 'update', 'admin.banners.update');
    $router->post('/banners/deletar/{id}', 'AdminBannerController', 'delete', 'admin.banners.delete');

    // Avaliações
    $router->get('/avaliacoes', 'AdminReviewController', 'index', 'admin.reviews');
    $router->get('/avaliacoes/criar', 'AdminReviewController', 'create', 'admin.reviews.create');
    $router->post('/avaliacoes/criar', 'AdminReviewController', 'store', 'admin.reviews.store');
    $router->get('/avaliacoes/editar/{id}', 'AdminReviewController', 'edit', 'admin.reviews.edit');
    $router->post('/avaliacoes/editar/{id}', 'AdminReviewController', 'update', 'admin.reviews.update');
    $router->post('/avaliacoes/deletar/{id}', 'AdminReviewController', 'delete', 'admin.reviews.delete');

    // Configurações
    $router->get('/configuracoes', 'AdminSettingController', 'index', 'admin.settings');
    $router->post('/configuracoes', 'AdminSettingController', 'update', 'admin.settings.update');

    // Páginas (CMS)
    $router->get('/paginas', 'AdminPageController', 'index', 'admin.pages');
    $router->get('/paginas/home', 'AdminPageController', 'editHome', 'admin.pages.home');
    $router->post('/paginas/home', 'AdminPageController', 'updateHome', 'admin.pages.home.update');
    $router->get('/paginas/sobre', 'AdminPageController', 'editAbout', 'admin.pages.about');
    $router->post('/paginas/sobre', 'AdminPageController', 'updateAbout', 'admin.pages.about.update');
    $router->get('/paginas/footer', 'AdminPageController', 'editFooter', 'admin.pages.footer');
    $router->post('/paginas/footer', 'AdminPageController', 'updateFooter', 'admin.pages.footer.update');

    // Cards (Seções)
    $router->get('/cards/{section}', 'AdminSectionCardController', 'index', 'admin.cards');
    $router->get('/cards/{section}/criar', 'AdminSectionCardController', 'create', 'admin.cards.create');
    $router->post('/cards/{section}/criar', 'AdminSectionCardController', 'store', 'admin.cards.store');
    $router->get('/cards/editar/{id}', 'AdminSectionCardController', 'edit', 'admin.cards.edit');
    $router->post('/cards/editar/{id}', 'AdminSectionCardController', 'update', 'admin.cards.update');
    $router->post('/cards/deletar/{id}', 'AdminSectionCardController', 'delete', 'admin.cards.delete');

    // Galeria
    $router->get('/galeria', 'AdminGalleryController', 'index', 'admin.gallery');
    $router->post('/galeria', 'AdminGalleryController', 'store', 'admin.gallery.store');
    $router->post('/galeria/deletar/{id}', 'AdminGalleryController', 'delete', 'admin.gallery.delete');

    // Pronta Entrega
    $router->get('/pronta-entrega', 'AdminReadyProductController', 'index', 'admin.ready');
    $router->get('/pronta-entrega/criar', 'AdminReadyProductController', 'create', 'admin.ready.create');
    $router->post('/pronta-entrega/criar', 'AdminReadyProductController', 'store', 'admin.ready.store');
    $router->get('/pronta-entrega/editar/{id}', 'AdminReadyProductController', 'edit', 'admin.ready.edit');
    $router->post('/pronta-entrega/editar/{id}', 'AdminReadyProductController', 'update', 'admin.ready.update');
    $router->post('/pronta-entrega/deletar/{id}', 'AdminReadyProductController', 'delete', 'admin.ready.delete');
    $router->post('/pronta-entrega/imagem-deletar/{id}', 'AdminReadyProductController', 'deleteImage', 'admin.ready.deleteImage');

    // Portfólio
    $router->get('/portfolio', 'AdminPortfolioController', 'index', 'admin.portfolio');
    $router->get('/portfolio/criar', 'AdminPortfolioController', 'create', 'admin.portfolio.create');
    $router->post('/portfolio/criar', 'AdminPortfolioController', 'store', 'admin.portfolio.store');
    $router->get('/portfolio/editar/{id}', 'AdminPortfolioController', 'edit', 'admin.portfolio.edit');
    $router->post('/portfolio/editar/{id}', 'AdminPortfolioController', 'update', 'admin.portfolio.update');
    $router->post('/portfolio/deletar/{id}', 'AdminPortfolioController', 'delete', 'admin.portfolio.delete');
    $router->post('/portfolio/imagem-deletar/{id}', 'AdminPortfolioController', 'deleteImage', 'admin.portfolio.deleteImage');
});
