<div class="admin-header-actions">
    <a href="<?= baseUrl('admin/pronta-entrega/criar') ?>" class="btn btn-primary btn-sm">+ Novo Produto</a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Destaque</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products['items'])): ?>
                <tr><td colspan="6" style="text-align:center; color: var(--color-text-muted);">Nenhum produto cadastrado.</td></tr>
            <?php else: ?>
                <?php foreach ($products['items'] as $p): ?>
                    <tr>
                        <td><strong><?= e($p['name']) ?></strong></td>
                        <td><?= formatPrice((float)$p['price']) ?></td>
                        <td><?= (int)$p['stock_quantity'] ?></td>
                        <td><?= $p['is_featured'] ? '<span class="badge badge-purple">Sim</span>' : '-' ?></td>
                        <td><?= $p['is_active'] ? '<span class="badge badge-new">Ativo</span>' : '<span class="badge">Inativo</span>' ?></td>
                        <td>
                            <a href="<?= baseUrl('admin/pronta-entrega/editar/' . $p['id']) ?>" class="btn btn-ghost btn-sm">Editar</a>
                            <form action="<?= baseUrl('admin/pronta-entrega/deletar/' . $p['id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Excluir este produto?')">
                                <?= csrfField() ?>
                                <button type="submit" class="btn btn-ghost btn-sm" style="color: var(--color-error);">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($products['total_pages'] > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $products['total_pages']; $i++): ?>
            <?php if ($i == $products['current_page']): ?>
                <span class="active"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
<?php endif; ?>
