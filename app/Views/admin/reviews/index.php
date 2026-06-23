<!-- Reviews List -->
<div class="admin-section">
    <div class="flex-between mb-4">
        <h3 style="font-size: 1rem; color: var(--color-text-muted);">
            <?= count($reviews) ?> avaliações cadastradas
        </h3>
        <a href="<?= baseUrl('admin/avaliacoes/criar') ?>" class="btn btn-primary">+ Nova Avaliação</a>
    </div>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Empresa</th>
                    <th>Avaliação</th>
                    <th>Nota</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reviews)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 2rem;">Nenhuma avaliação cadastrada.</td></tr>
                <?php else: ?>
                    <?php foreach ($reviews as $rev): ?>
                    <tr>
                        <td>
                            <div class="flex gap-3" style="align-items:center;">
                                <?php if ($rev['avatar']): ?>
                                    <img src="<?= baseUrl($rev['avatar']) ?>" alt="" style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                                <?php else: ?>
                                    <div style="width:32px; height:32px; border-radius:50%; background:var(--color-gold); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:#000;">
                                        <?= mb_strtoupper(mb_substr($rev['client_name'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <strong><?= e($rev['client_name']) ?></strong>
                            </div>
                        </td>
                        <td><?= e($rev['company'] ?? '-') ?></td>
                        <td style="max-width:200px;"><?= e(mb_strimwidth($rev['text'], 0, 60, '...')) ?></td>
                        <td>
                            <span class="text-gold"><?= str_repeat('★', $rev['rating']) ?></span><span style="color:var(--color-text-muted);"><?= str_repeat('★', 5 - $rev['rating']) ?></span>
                        </td>
                        <td>
                            <span class="badge <?= $rev['is_active'] ? 'badge-new' : '' ?>">
                                <?= $rev['is_active'] ? 'Ativa' : 'Inativa' ?>
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="<?= baseUrl('admin/avaliacoes/editar/' . $rev['id']) ?>" class="btn btn-ghost btn-sm">Editar</a>
                                <form action="<?= baseUrl('admin/avaliacoes/deletar/' . $rev['id']) ?>" method="POST" style="display:inline;">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn btn-sm" style="color:#ef5350;" data-confirm="Excluir esta avaliação?">Excluir</button>
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
