<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin') ?> - SOLYRA Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="admin-body">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="admin-sidebar">
        <div class="admin-sidebar-header">
            <a href="<?= baseUrl('admin') ?>" class="admin-brand">SOLYRA</a>
            <span class="admin-brand-sub">Painel Admin</span>
        </div>
        
        <nav class="admin-nav">
            <a href="<?= baseUrl('admin') ?>" class="admin-nav-link <?= isCurrentUrl('/admin') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                Dashboard
            </a>
            <a href="<?= baseUrl('admin/produtos') ?>" class="admin-nav-link <?= str_contains($_GET['url'] ?? '', 'admin/produtos') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm-8 12H4v-2h8v2zm0-4H4V8h8v4z"/></svg>
                Produtos
            </a>
            <a href="<?= baseUrl('admin/categorias') ?>" class="admin-nav-link <?= str_contains($_GET['url'] ?? '', 'admin/categorias') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l-5.5 9h11z"/><circle cx="17.5" cy="17.5" r="4.5"/><path d="M3 13.5h8v8H3z"/></svg>
                Categorias
            </a>
            <a href="<?= baseUrl('admin/banners') ?>" class="admin-nav-link <?= str_contains($_GET['url'] ?? '', 'admin/banners') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                Banners
            </a>
            <a href="<?= baseUrl('admin/pronta-entrega') ?>" class="admin-nav-link <?= str_contains($_GET['url'] ?? '', 'admin/pronta-entrega') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg>
                Pronta Entrega
            </a>
            <a href="<?= baseUrl('admin/portfolio') ?>" class="admin-nav-link <?= str_contains($_GET['url'] ?? '', 'admin/portfolio') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"/></svg>
                Portfólio
            </a>
            <a href="<?= baseUrl('admin/avaliacoes') ?>" class="admin-nav-link <?= str_contains($_GET['url'] ?? '', 'admin/avaliacoes') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Avaliações
            </a>
            <a href="<?= baseUrl('admin/paginas') ?>" class="admin-nav-link <?= str_contains($_GET['url'] ?? '', 'admin/paginas') || str_contains($_GET['url'] ?? '', 'admin/cards') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                Páginas
            </a>
            <a href="<?= baseUrl('admin/galeria') ?>" class="admin-nav-link <?= str_contains($_GET['url'] ?? '', 'admin/galeria') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"/></svg>
                Galeria
            </a>
            <a href="<?= baseUrl('admin/configuracoes') ?>" class="admin-nav-link <?= str_contains($_GET['url'] ?? '', 'admin/configuracoes') ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
                Configurações
            </a>
        </nav>

        <div class="admin-sidebar-footer">
            <div class="admin-user-info">
                <strong><?= e(Auth::user()['name'] ?? 'Admin') ?></strong>
                <span><?= e(Auth::user()['email'] ?? '') ?></span>
            </div>
            <a href="<?= baseUrl('admin/logout') ?>" class="admin-nav-link admin-logout">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                Sair
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Bar -->
        <header class="admin-topbar">
            <button class="admin-toggle-sidebar" id="toggle-sidebar" aria-label="Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
            </button>
            <h1 class="admin-page-title"><?= e($pageTitle ?? 'Admin') ?></h1>
            <a href="<?= baseUrl() ?>" target="_blank" class="btn btn-ghost btn-sm">Ver Site</a>
        </header>

        <!-- Flash Messages -->
        <?php if ($msg = flashSuccess()): ?>
            <div class="admin-flash admin-flash-success"><?= e($msg) ?></div>
        <?php endif; ?>
        <?php if ($msg = flashError()): ?>
            <div class="admin-flash admin-flash-error"><?= e($msg) ?></div>
        <?php endif; ?>

        <!-- Page Content -->
        <div class="admin-content">
            <?= $content ?>
        </div>
    </div>

    <script src="<?= asset('js/admin.js') ?>"></script>
</body>
</html>
