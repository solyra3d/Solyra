<?php $isEdit = !empty($card); ?>
<!-- Card Form -->
<div class="admin-section">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: var(--space-6);">
        <a href="<?= baseUrl('admin/cards/' . $section) ?>" class="btn btn-ghost">&larr; Voltar</a>
    </div>

    <form action="<?= baseUrl($isEdit ? 'admin/cards/editar/' . $card['id'] : 'admin/cards/' . $section . '/criar') ?>" method="POST" class="admin-form">
        <?= csrfField() ?>

        <div class="admin-settings-group">
            <h3 class="admin-settings-title"><?= $isEdit ? 'Editar Card' : 'Novo Card' ?></h3>
            <div class="admin-form-grid">
                <div class="form-group">
                    <label for="icon" class="form-label">Ícone (emoji)</label>
                    <input type="text" id="icon" name="icon" class="form-control" value="<?= e($isEdit ? $card['icon'] : '') ?>" placeholder="💡 🎨 ⚡ 📦" style="font-size:1.5rem;">
                    <small style="color: var(--color-text-muted);">Cole um emoji aqui</small>
                </div>

                <div class="form-group">
                    <label for="order_position" class="form-label">Ordem</label>
                    <input type="number" id="order_position" name="order_position" class="form-control" value="<?= e($isEdit ? $card['order_position'] : '0') ?>" min="0">
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="title" class="form-label">Título *</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= e($isEdit ? $card['title'] : '') ?>" required>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea id="description" name="description" class="form-control" rows="3"><?= e($isEdit ? $card['description'] : '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="is_active" value="1" <?= (!$isEdit || $card['is_active']) ? 'checked' : '' ?>>
                        Ativo
                    </label>
                </div>
            </div>
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar Alterações' : 'Criar Card' ?></button>
            <a href="<?= baseUrl('admin/cards/' . $section) ?>" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
