<div class="admin-header-actions">
    <a href="<?= baseUrl('admin/portfolio/criar') ?>" class="btn btn-primary btn-sm">+ Novo Projeto</a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Ordem</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($items)): ?>
                <tr><td colspan="5" style="text-align:center; color: var(--color-text-muted);">Nenhum projeto cadastrado.</td></tr>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><strong><?= e($item['title']) ?></strong></td>
                        <td><?= e($item['category'] ?: '-') ?></td>
                        <td><?= (int)$item['order_position'] ?></td>
                        <td><?= $item['is_active'] ? '<span class="badge badge-new">Ativo</span>' : '<span class="badge">Inativo</span>' ?></td>
                        <td>
                            <a href="<?= baseUrl('admin/portfolio/editar/' . $item['id']) ?>" class="btn btn-ghost btn-sm">Editar</a>
                            <form action="<?= baseUrl('admin/portfolio/deletar/' . $item['id']) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Excluir este projeto?')">
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
