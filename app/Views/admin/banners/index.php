<!-- Banners List -->
<div class="admin-section">
    <div class="flex-between mb-4">
        <h3 style="font-size: 1rem; color: var(--color-text-muted);">
            <?= count($banners) ?> banners cadastrados
        </h3>
        <a href="<?= baseUrl('admin/banners/criar') ?>" class="btn btn-primary">+ Novo Banner</a>
    </div>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ordem</th>
                    <th>Imagem</th>
                    <th>Título</th>
                    <th>Botão</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($banners)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 2rem;">Nenhum banner cadastrado.</td></tr>
                <?php else: ?>
                    <?php foreach ($banners as $ban): ?>
                    <tr>
                        <td><?= $ban['order_position'] ?></td>
                        <td>
                            <img src="<?= baseUrl($ban['image_path']) ?>" alt="" style="width:80px; height:40px; border-radius:4px; object-fit:cover;">
                        </td>
                        <td>
                            <strong><?= e($ban['title']) ?></strong>
                            <?php if ($ban['subtitle']): ?>
                                <br><small style="color: var(--color-text-muted);"><?= e(mb_strimwidth($ban['subtitle'], 0, 50, '...')) ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($ban['button_link']): ?>
                                <code><?= e($ban['button_text']) ?></code>
                            <?php else: ?>
                                <span style="color: var(--color-text-muted);">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?= $ban['is_active'] ? 'badge-new' : '' ?>">
                                <?= $ban['is_active'] ? 'Ativo' : 'Inativo' ?>
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="<?= baseUrl('admin/banners/editar/' . $ban['id']) ?>" class="btn btn-ghost btn-sm">Editar</a>
                                <form action="<?= baseUrl('admin/banners/deletar/' . $ban['id']) ?>" method="POST" style="display:inline;">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn btn-sm" style="color:#ef5350;" data-confirm="Excluir este banner?">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
