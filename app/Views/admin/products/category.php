<!-- Produtos por Categoria -->
<div class="admin-section">
    <!-- Breadcrumb -->
    <div class="mb-4">
        <a href="<?= baseUrl('admin/produtos') ?>" style="color: var(--color-text-muted); text-decoration: none; font-size: var(--text-sm);">
            ← Voltar para categorias
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="cat-stats-grid mb-6">
        <div class="cat-stat-card">
            <span class="cat-stat-number"><?= (int) $stats['total'] ?></span>
            <span class="cat-stat-label">Produtos</span>
        </div>
        <div class="cat-stat-card">
            <span class="cat-stat-number cat-stat-active"><?= (int) $stats['ativos'] ?></span>
            <span class="cat-stat-label">Ativos</span>
        </div>
        <div class="cat-stat-card">
            <span class="cat-stat-number cat-stat-featured"><?= (int) $stats['destaques'] ?></span>
            <span class="cat-stat-label">Destaques</span>
        </div>
    </div>

    <!-- Toolbar: Search + Filters + New -->
    <div class="cat-toolbar mb-4">
        <form action="<?= baseUrl('admin/produtos/categoria/' . $category['id']) ?>" method="GET" class="cat-toolbar-search">
            <input type="text" name="q" class="form-control" placeholder="Buscar produto..." value="<?= e($search) ?>">
            <?php if ($filter !== 'todos'): ?>
                <input type="hidden" name="filtro" value="<?= e($filter) ?>">
            <?php endif; ?>
        </form>

        <div class="cat-toolbar-filters">
            <?php
            $filters = [
                'todos' => 'Todos',
                'ativos' => 'Ativos',
                'inativos' => 'Inativos',
                'destaques' => 'Destaques',
            ];
            foreach ($filters as $key => $label):
                $isActive = ($filter === $key);
                $url = baseUrl('admin/produtos/categoria/' . $category['id']) . '?filtro=' . $key;
                if ($search) $url .= '&q=' . urlencode($search);
            ?>
                <a href="<?= $url ?>" class="cat-filter-btn <?= $isActive ? 'cat-filter-active' : '' ?>"><?= $label ?></a>
            <?php endforeach; ?>
        </div>

        <a href="<?= baseUrl('admin/produtos/criar?categoria=' . $category['id']) ?>" class="btn btn-primary">+ Novo Produto</a>
    </div>

    <!-- Products Table -->
    <?php if (empty($products)): ?>
        <div style="text-align: center; padding: 3rem 1rem; color: var(--color-text-muted);">
            <p style="font-size: var(--text-lg);">Nenhum produto encontrado.</p>
            <?php if ($search || $filter !== 'todos'): ?>
                <a href="<?= baseUrl('admin/produtos/categoria/' . $category['id']) ?>" class="btn btn-ghost" style="margin-top: var(--space-4);">Limpar filtros</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 45%;">Nome</th>
                        <th style="width: 12%; text-align: center;">Status</th>
                        <th style="width: 12%; text-align: center;">Destaque</th>
                        <th style="width: 13%;">Data</th>
                        <th style="width: 18%; text-align: right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $prod): ?>
                    <tr>
                        <td><strong><?= e($prod['name']) ?></strong></td>
                        <td style="text-align: center;">
                            <form action="<?= baseUrl('admin/produtos/toggle/' . $prod['id']) ?>" method="POST" style="display:inline;">
                                <?= csrfField() ?>
                                <button type="submit" class="badge <?= $prod['is_active'] ? 'badge-new' : '' ?>" style="cursor:pointer; border:none;">
                                    <?= $prod['is_active'] ? 'Ativo' : 'Inativo' ?>
                                </button>
                            </form>
                        </td>
                        <td style="text-align: center;">
                            <?= $prod['is_featured'] ? '<span class="text-gold">★</span>' : '-' ?>
                        </td>
                        <td><?= timeAgo($prod['created_at']) ?></td>
                        <td style="text-align: right;">
                            <div class="flex gap-2" style="justify-content: flex-end;">
                                <a href="<?= baseUrl('admin/produtos/editar/' . $prod['id']) ?>" class="btn btn-ghost btn-sm">Editar</a>
                                <form action="<?= baseUrl('admin/produtos/deletar/' . $prod['id']) ?>" method="POST" style="display:inline;">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn btn-sm" style="color:#ef5350;" data-confirm="Tem certeza que deseja excluir este produto?">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($pagination['total_pages'] > 1): ?>
            <div class="pagination" style="margin-top: var(--space-6);">
                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <?php
                    $url = baseUrl('admin/produtos/categoria/' . $category['id']) . '?page=' . $i;
                    if ($search) $url .= '&q=' . urlencode($search);
                    if ($filter !== 'todos') $url .= '&filtro=' . urlencode($filter);
                    ?>
                    <?php if ($i == $pagination['current_page']): ?>
                        <span class="active"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?= $url ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.cat-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: var(--space-4);
}
.cat-stat-card {
    background: var(--color-bg-elevated);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: var(--space-5);
    text-align: center;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.cat-stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--color-text);
}
.cat-stat-active {
    color: #66bb6a;
}
.cat-stat-featured {
    color: #ffc107;
}
.cat-stat-label {
    font-size: var(--text-sm);
    color: var(--color-text-muted);
    font-weight: 500;
}
.cat-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: var(--space-3);
}
.cat-toolbar-search {
    max-width: 260px;
}
.cat-toolbar-filters {
    display: flex;
    gap: var(--space-2);
    flex: 1;
}
.cat-filter-btn {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: var(--text-sm);
    font-weight: 500;
    text-decoration: none;
    color: var(--color-text-muted);
    background: var(--color-bg-secondary);
    border: 1px solid var(--color-border);
    transition: all .15s;
    white-space: nowrap;
}
.cat-filter-btn:hover {
    border-color: var(--color-primary);
    color: var(--color-text);
}
.cat-filter-active {
    background: var(--gradient-primary);
    color: white;
    border-color: transparent;
}
.cat-filter-active:hover {
    color: white;
}

@media (max-width: 768px) {
    .cat-toolbar {
        flex-direction: column;
        align-items: stretch;
    }
    .cat-toolbar-search {
        max-width: none;
    }
    .cat-toolbar-filters {
        overflow-x: auto;
    }
}
</style>
