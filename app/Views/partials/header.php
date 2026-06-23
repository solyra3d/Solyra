<header class="navbar" id="navbar">
    <div class="container flex-between">
        <!-- Logo -->
        <a href="<?= baseUrl() ?>" class="navbar-brand">
            <?php $logo = setting('site_logo'); ?>
            <?php if ($logo): ?>
                <img src="<?= e(baseUrl($logo)) ?>" alt="SOLYRA" class="navbar-logo" onerror="this.style.display='none';this.nextElementSibling.style.display='inline'">
                <span class="navbar-logo-text" style="display:none">SOLYRA</span>
            <?php else: ?>
                <span class="navbar-logo-text">SOLYRA</span>
            <?php endif; ?>
        </a>

        <!-- Navigation -->
        <nav class="navbar-nav" id="navbar-nav">
            <a href="<?= baseUrl() ?>" class="navbar-link <?= isCurrentUrl('/') ? 'active' : '' ?>">Home</a>
            <a href="<?= baseUrl('catalogo') ?>" class="navbar-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'catalogo') ? 'active' : '' ?>">Catálogo</a>
            <a href="<?= baseUrl('pronta-entrega') ?>" class="navbar-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'pronta-entrega') ? 'active' : '' ?>">Pronta Entrega</a>
            <a href="<?= baseUrl('sobre') ?>" class="navbar-link <?= isCurrentUrl('/sobre') ? 'active' : '' ?>">Sobre</a>
            <a href="<?= baseUrl('contato') ?>" class="navbar-link <?= isCurrentUrl('/contato') ? 'active' : '' ?>">Contato</a>
            <a href="<?= whatsappLink(setting('site_whatsapp'), 'Olá! Gostaria de solicitar um orçamento.') ?>" target="_blank" class="navbar-cta">
                Orçamento
            </a>
        </nav>

        <!-- Mobile Toggle -->
        <button class="navbar-toggle" id="navbar-toggle" aria-label="Menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
        </button>
    </div>
</header>
