<!-- Categories List -->
<div class="admin-section">
    <div class="flex-between mb-4">
        <h3 style="font-size: 1rem; color: var(--color-text-muted);">
            <?= count($categories) ?> categorias cadastradas
        </h3>
        <a href="<?= baseUrl('admin/categorias/criar') ?>" class="btn btn-primary">+ Nova Categoria</a>
    </div>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ordem</th>
                    <th>Nome</th>
                    <th>Slug</th>
                    <th>Produtos</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 2rem;">Nenhuma categoria cadastrada.</td></tr>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['order_position'] ?></td>
                        <td>
                            <div class="flex gap-3" style="align-items:center;">
                                <?php if ($cat['image']): ?>
                                    <img src="<?= baseUrl($cat['image']) ?>" alt="" style="width:36px; height:36px; border-radius:6px; object-fit:cover;">
                                <?php endif; ?>
                                <strong><?= e($cat['name']) ?></strong>
                            </div>
                        </td>
                        <td><code><?= e($cat['slug']) ?></code></td>
                        <td><?= $cat['product_count'] ?></td>
                        <td>
                            <span class="badge <?= $cat['is_active'] ? 'badge-new' : '' ?>">
                                <?= $cat['is_active'] ? 'Ativa' : 'Inativa' ?>
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="<?= baseUrl('admin/categorias/editar/' . $cat['id']) ?>" class="btn btn-ghost btn-sm">Editar</a>
                                <?php if ($cat['product_count'] == 0): ?>
                                <form action="<?= baseUrl('admin/categorias/deletar/' . $cat['id']) ?>" method="POST" style="display:inline;">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn btn-sm" style="color:#ef5350;" data-confirm="Tem certeza que deseja excluir esta categoria?">Excluir</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
