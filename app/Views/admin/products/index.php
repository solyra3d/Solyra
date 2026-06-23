<!-- Produtos — Hub de Categorias -->
<div class="admin-section">
    <div class="flex-between mb-6">
        <p style="color: var(--color-text-muted); font-size: var(--text-sm);">
            Selecione uma categoria para gerenciar seus produtos
        </p>
        <a href="<?= baseUrl('admin/produtos/criar') ?>" class="btn btn-primary">+ Novo Produto</a>
    </div>

    <?php if (empty($categories)): ?>
        <div style="text-align: center; padding: 4rem 1rem; color: var(--color-text-muted);">
            <p style="font-size: var(--text-lg); margin-bottom: var(--space-4);">Nenhuma categoria cadastrada.</p>
            <a href="<?= baseUrl('admin/categorias/criar') ?>" class="btn btn-primary">Criar Categoria</a>
        </div>
    <?php else: ?>
        <div class="products-hub-grid">
            <?php foreach ($categories as $cat): ?>
                <a href="<?= baseUrl('admin/produtos/categoria/' . $cat['id']) ?>" class="products-hub-card">
                    <div class="products-hub-card-icon">
                        <?php if ($cat['image']): ?>
                            <img src="<?= baseUrl($cat['image']) ?>" alt="<?= e($cat['name']) ?>">
                        <?php else: ?>
                            <span class="products-hub-emoji"><?= $cat['icon'] ?: '📦' ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="products-hub-card-body">
                        <h3 class="products-hub-card-title"><?= e($cat['name']) ?></h3>
                        <span class="products-hub-card-count"><?= (int) $cat['total_products'] ?> produto<?= $cat['total_products'] != 1 ? 's' : '' ?></span>
                    </div>
                    <div class="products-hub-card-meta">
                        <span class="products-hub-badge products-hub-badge-active"><?= (int) $cat['active_products'] ?> ativo<?= $cat['active_products'] != 1 ? 's' : '' ?></span>
                        <?php if ($cat['featured_products'] > 0): ?>
                            <span class="products-hub-badge products-hub-badge-featured"><?= (int) $cat['featured_products'] ?> destaque<?= $cat['featured_products'] != 1 ? 's' : '' ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="products-hub-card-arrow">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.products-hub-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: var(--space-4);
}
.products-hub-card {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-5);
    background: var(--color-bg-elevated);
    border: 1px solid var(--color-border);
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all .2s ease;
    position: relative;
    overflow: hidden;
}
.products-hub-card:hover {
    border-color: var(--color-primary);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,.3);
}
.products-hub-card-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    background: var(--color-bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}
.products-hub-card-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
}
.products-hub-emoji {
    font-size: 28px;
    line-height: 1;
}
.products-hub-card-body {
    flex: 1;
    min-width: 0;
}
.products-hub-card-title {
    font-size: var(--text-base);
    font-weight: 600;
    color: var(--color-text);
    margin: 0 0 4px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.products-hub-card-count {
    font-size: var(--text-sm);
    color: var(--color-text-muted);
}
.products-hub-card-meta {
    display: flex;
    flex-direction: column;
    gap: 4px;
    align-items: flex-end;
}
.products-hub-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 10px;
    white-space: nowrap;
}
.products-hub-badge-active {
    background: rgba(76, 175, 80, .15);
    color: #66bb6a;
}
.products-hub-badge-featured {
    background: rgba(255, 193, 7, .15);
    color: #ffc107;
}
.products-hub-card-arrow {
    color: var(--color-text-muted);
    opacity: 0;
    transition: opacity .2s;
}
.products-hub-card:hover .products-hub-card-arrow {
    opacity: 1;
}

@media (max-width: 640px) {
    .products-hub-grid {
        grid-template-columns: 1fr;
    }
    .products-hub-card-meta {
        display: none;
    }
}
</style>
