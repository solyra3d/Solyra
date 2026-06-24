<!-- Header -->
<div class="admin-header-actions" style="display:flex; align-items:center; gap:var(--space-4); flex-wrap:wrap;">
    <form method="GET" style="display:flex; gap:var(--space-3); align-items:center;">
        <input type="text" name="q" class="form-control" placeholder="Buscar produto..." value="<?= e($search) ?>" style="max-width:260px;">
        <button type="submit" class="btn btn-ghost btn-sm">Buscar</button>
    </form>
    <a href="<?= baseUrl('admin/produtos') ?>" class="btn btn-primary btn-sm">+ Cadastrar Produto</a>
    <small style="color:var(--color-text-muted);">
        Produtos aparecem aqui automaticamente quando "Pronta Entrega" está ativado e estoque &gt; 0.
    </small>
</div>

<!-- Table -->
<div class="admin-table-wrapper" style="margin-top:var(--space-6);">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Status</th>
                <th style="min-width:260px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="6" style="text-align:center; color:var(--color-text-muted); padding:var(--space-8);">
                        Nenhum produto com Pronta Entrega ativado.<br>
                        <a href="<?= baseUrl('admin/produtos') ?>" style="color:var(--color-purple);">Edite um produto e ative a opção "Pronta Entrega".</a>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <?php $lowStock = (int)$p['stock_quantity'] <= 3 && (int)$p['stock_quantity'] > 0; ?>
                    <tr <?= !$p['is_active'] ? 'style="opacity:.55;"' : '' ?>>
                        <td>
                            <strong><?= e($p['name']) ?></strong>
                            <?php if (!$p['is_active']): ?>
                                <span class="badge" style="margin-left:4px;">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td><?= e($p['category_name'] ?? '—') ?></td>
                        <td><?= $p['price_from'] ? formatPrice((float)$p['price_from']) : '—' ?></td>
                        <td>
                            <?php if ((int)$p['stock_quantity'] === 0): ?>
                                <span class="badge" style="color:var(--color-error);">Sem estoque</span>
                            <?php elseif ($lowStock): ?>
                                <span class="badge badge-featured"><?= (int)$p['stock_quantity'] ?> un. — Últimas!</span>
                            <?php else: ?>
                                <span style="color:var(--color-success); font-weight:600;"><?= (int)$p['stock_quantity'] ?> un.</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($p['is_active'] && $p['stock_quantity'] > 0): ?>
                                <span class="badge badge-new">Visível</span>
                            <?php else: ?>
                                <span class="badge">Oculto</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display:flex; gap:var(--space-2); align-items:center; flex-wrap:wrap;">
                                <!-- Ajustar estoque inline -->
                                <form method="POST" action="<?= baseUrl('admin/produtos/estoque/' . $p['id']) ?>"
                                      style="display:flex; gap:4px; align-items:center;">
                                    <?= csrfField() ?>
                                    <input type="number" name="stock_quantity" min="0"
                                           value="<?= (int)$p['stock_quantity'] ?>"
                                           style="width:70px; padding:4px 8px; font-size:var(--text-sm); background:var(--color-bg-secondary); border:1px solid var(--color-border); border-radius:var(--radius-sm); color:var(--color-text-primary);">
                                    <button type="submit" class="btn btn-ghost btn-sm" title="Salvar estoque">✓</button>
                                </form>
                                <!-- Zerar estoque -->
                                <form method="POST" action="<?= baseUrl('admin/produtos/estoque/' . $p['id']) ?>"
                                      onsubmit="return confirm('Zerar estoque deste produto?')" style="display:inline;">
                                    <?= csrfField() ?>
                                    <input type="hidden" name="stock_quantity" value="0">
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--color-error);" title="Zerar estoque">✕ Zerar</button>
                                </form>
                                <!-- Editar produto completo -->
                                <a href="<?= baseUrl('admin/produtos/editar/' . $p['id']) ?>" class="btn btn-ghost btn-sm">Editar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
<div class="pagination" style="margin-top:var(--space-6);">
    <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
        <?php if ($i == $pagination['current_page']): ?>
            <span class="active"><?= $i ?></span>
        <?php else: ?>
            <a href="?page=<?= $i ?><?= $search ? '&q=' . urlencode($search) : '' ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>
</div>
<?php endif; ?>
