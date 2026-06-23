<!-- Cards List -->
<div class="admin-section">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: var(--space-6);">
        <a href="<?= baseUrl('admin/paginas') ?>" class="btn btn-ghost">&larr; Voltar</a>
        <a href="<?= baseUrl('admin/cards/' . $section . '/criar') ?>" class="btn btn-primary">+ Novo Card</a>
    </div>

    <?php if (empty($cards)): ?>
        <p style="text-align:center; color: var(--color-text-muted); padding: var(--space-8);">Nenhum card cadastrado.</p>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Ordem</th>
                        <th>Ícone</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cards as $card): ?>
                    <tr>
                        <td><?= $card['order_position'] ?></td>
                        <td style="font-size: 1.5rem;"><?= $card['icon'] ?></td>
                        <td><strong><?= e($card['title']) ?></strong></td>
                        <td style="max-width:300px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= e($card['description']) ?></td>
                        <td>
                            <?php if ($card['is_active']): ?>
                                <span class="badge badge-new">Ativo</span>
                            <?php else: ?>
                                <span class="badge" style="background: rgba(244,67,54,0.15); color: #ef5350;">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= baseUrl('admin/cards/editar/' . $card['id']) ?>" class="btn btn-ghost btn-sm">Editar</a>
                            <form action="<?= baseUrl('admin/cards/deletar/' . $card['id']) ?>" method="POST" style="display:inline;">
                                <?= csrfField() ?>
                                <button type="submit" class="btn btn-sm" style="color:#ef5350;" onclick="return confirm('Excluir este card?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
