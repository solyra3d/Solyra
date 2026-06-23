<?php $isEdit = !empty($item); ?>

<form action="<?= baseUrl('admin/portfolio/' . ($isEdit ? 'editar/' . $item['id'] : 'criar')) ?>" method="POST" enctype="multipart/form-data">
    <?= csrfField() ?>

    <div class="admin-form-grid">
        <div class="form-group">
            <label class="form-label">Título *</label>
            <input type="text" name="title" class="form-control" value="<?= e($item['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label class="form-label">Categoria</label>
            <input type="text" name="category" class="form-control" value="<?= e($item['category'] ?? '') ?>" placeholder="Ex: Luminária, Brinde, Decoração">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Descrição</label>
        <textarea name="description" class="form-control" rows="4"><?= e($item['description'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label class="form-label">Imagem de capa</label>
        <input type="file" name="cover_image" class="form-control" accept="image/*">
        <?php if (!empty($item['cover_image'])): ?>
            <img src="<?= e(baseUrl($item['cover_image'])) ?>" alt="Capa" style="height:80px; margin-top: var(--space-2); border-radius: var(--radius-md);">
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label class="form-label">Imagens adicionais</label>
        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
        <?php if ($isEdit && !empty($item['images'])): ?>
            <div style="display: flex; gap: var(--space-2); margin-top: var(--space-2); flex-wrap: wrap;">
                <?php foreach ($item['images'] as $img): ?>
                    <div style="position: relative;">
                        <img src="<?= e(baseUrl($img['image_path'])) ?>" alt="" style="height:60px; border-radius: var(--radius-md);">
                        <form action="<?= baseUrl('admin/portfolio/imagem-deletar/' . $img['id']) ?>" method="POST" style="position:absolute; top:-5px; right:-5px;">
                            <?= csrfField() ?>
                            <button type="submit" style="background:var(--color-error); color:#fff; border:none; border-radius:50%; width:20px; height:20px; font-size:12px; cursor:pointer;">&times;</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="admin-form-grid">
        <div class="form-group">
            <label class="form-label">Ordem</label>
            <input type="number" name="order_position" class="form-control" min="0" value="<?= e($item['order_position'] ?? '0') ?>">
        </div>
        <div class="form-group">
            <label class="form-label">
                <input type="checkbox" name="is_active" value="1" <?= ($item['is_active'] ?? 1) ? 'checked' : '' ?>>
                Ativo
            </label>
        </div>
    </div>

    <div style="margin-top: var(--space-6);">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Atualizar' : 'Cadastrar' ?></button>
        <a href="<?= baseUrl('admin/portfolio') ?>" class="btn btn-ghost">Cancelar</a>
    </div>
</form>
