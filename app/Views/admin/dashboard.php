<!-- Dashboard Stats -->
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: var(--color-gold-muted);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="var(--color-gold)"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm-8 12H4v-2h8v2zm0-4H4V8h8v4z"/></svg>
        </div>
        <div class="admin-stat-info">
            <span class="admin-stat-value"><?= $totalProducts ?></span>
            <span class="admin-stat-label">Produtos</span>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: rgba(76, 175, 80, 0.15);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="#66bb6a"><path d="M12 2l-5.5 9h11z"/><circle cx="17.5" cy="17.5" r="4.5"/><path d="M3 13.5h8v8H3z"/></svg>
        </div>
        <div class="admin-stat-info">
            <span class="admin-stat-value"><?= $totalCategories ?></span>
            <span class="admin-stat-label">Categorias</span>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: rgba(33, 150, 243, 0.15);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="#42a5f5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <div class="admin-stat-info">
            <span class="admin-stat-value"><?= $totalReviews ?></span>
            <span class="admin-stat-label">Avaliações</span>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: rgba(156, 39, 176, 0.15);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="#ab47bc"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg>
        </div>
        <div class="admin-stat-info">
            <span class="admin-stat-value"><?= $featuredProducts ?></span>
            <span class="admin-stat-label">Em Destaque</span>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-section">
    <h3 class="admin-section-title">Ações Rápidas</h3>
    <div class="admin-quick-actions">
        <a href="<?= baseUrl('admin/produtos/criar') ?>" class="btn btn-primary">+ Novo Produto</a>
        <a href="<?= baseUrl('admin/categorias/criar') ?>" class="btn btn-secondary">+ Nova Categoria</a>
        <a href="<?= baseUrl('admin/banners/criar') ?>" class="btn btn-ghost">+ Novo Banner</a>
    </div>
</div>

<!-- Latest Products -->
<?php if (!empty($latestProducts)): ?>
<div class="admin-section">
    <h3 class="admin-section-title">Últimos Produtos Cadastrados</h3>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($latestProducts as $prod): ?>
                <tr>
                    <td><strong><?= e($prod['name']) ?></strong></td>
                    <td><?= e($prod['category_name'] ?? '-') ?></td>
                    <td>
                        <?php if ($prod['is_active']): ?>
                            <span class="badge badge-new">Ativo</span>
                        <?php else: ?>
                            <span class="badge" style="background: rgba(244,67,54,0.15); color: #ef5350;">Inativo</span>
                        <?php endif; ?>
                    </td>
                    <td><?= timeAgo($prod['created_at']) ?></td>
                    <td>
                        <a href="<?= baseUrl('admin/produtos/editar/' . $prod['id']) ?>" class="btn btn-ghost btn-sm">Editar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Status Info -->
<div class="admin-section">
    <h3 class="admin-section-title">Status do Catálogo</h3>
    <div class="admin-stats-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="admin-stat-card">
            <div class="admin-stat-info">
                <span class="admin-stat-value"><?= $activeProducts ?></span>
                <span class="admin-stat-label">Produtos Ativos</span>
            </div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-info">
                <span class="admin-stat-value"><?= $newProducts ?></span>
                <span class="admin-stat-label">Produtos Novos</span>
            </div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-info">
                <span class="admin-stat-value"><?= $featuredProducts ?></span>
                <span class="admin-stat-label">Em Destaque</span>
            </div>
        </div>
    </div>
</div>
