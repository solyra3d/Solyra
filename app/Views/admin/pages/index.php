<!-- Páginas Editáveis -->
<div class="admin-section">
    <h3 class="admin-section-title">Páginas do Site</h3>
    <p style="color: var(--color-text-muted); margin-bottom: var(--space-6);">Edite os textos e conteúdos de cada página do site.</p>

    <div class="admin-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
        <?php foreach ($pages as $page): ?>
            <a href="<?= baseUrl('admin/paginas/' . ($page['slug'] === 'footer' ? 'footer' : $page['slug'])) ?>" class="admin-stat-card" style="text-decoration:none; cursor:pointer; transition: transform .2s;">
                <div class="admin-stat-info">
                    <span class="admin-stat-value" style="font-size: var(--text-lg);"><?= e($page['name']) ?></span>
                    <span class="admin-stat-label"><?= e($page['desc']) ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Cards Editáveis -->
<div class="admin-section" style="margin-top: var(--space-8);">
    <h3 class="admin-section-title">Cards / Blocos de Conteúdo</h3>
    <p style="color: var(--color-text-muted); margin-bottom: var(--space-6);">Gerencie os cards de processo, diferenciais e features.</p>

    <div class="admin-quick-actions">
        <a href="<?= baseUrl('admin/cards/home_process') ?>" class="btn btn-secondary">Como Funciona (Home)</a>
        <a href="<?= baseUrl('admin/cards/home_differentials') ?>" class="btn btn-secondary">Diferenciais (Home)</a>
        <a href="<?= baseUrl('admin/cards/about_features') ?>" class="btn btn-secondary">Features (Sobre)</a>
    </div>
</div>
