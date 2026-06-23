<?php $isEdit = !empty($product); ?>

<form action="<?= baseUrl('admin/pronta-entrega/' . ($isEdit ? 'editar/' . $product['id'] : 'criar')) ?>" method="POST" enctype="multipart/form-data">
    <?= csrfField() ?>

    <div class="admin-form-grid">
        <div class="form-group">
            <label class="form-label">Nome *</label>
            <input type="text" name="name" class="form-control" value="<?= e($product['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label class="form-label">Categoria</label>
            <select name="category_id" class="form-control form-select">
                <option value="">Sem categoria</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (($product['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Descrição curta</label>
        <input type="text" name="short_description" class="form-control" value="<?= e($product['short_description'] ?? '') ?>" maxlength="500">
    </div>

    <div class="form-group">
        <label class="form-label">Descrição completa</label>
        <textarea name="description" class="form-control" rows="5"><?= e($product['description'] ?? '') ?></textarea>
    </div>

    <div class="admin-form-grid">
        <div class="form-group">
            <label class="form-label">Preço (R$) *</label>
            <input type="number" name="price" class="form-control" step="0.01" min="0" value="<?= e($product['price'] ?? '0.00') ?>" required>
        </div>
        <div class="form-group">
            <label class="form-label">Quantidade em estoque *</label>
            <input type="number" name="stock_quantity" class="form-control" min="0" value="<?= e($product['stock_quantity'] ?? '1') ?>" required>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Imagem de capa</label>
        <input type="file" name="cover_image" class="form-control" accept="image/*">
        <?php if (!empty($product['cover_image'])): ?>
            <img src="<?= e(baseUrl($product['cover_image'])) ?>" alt="Capa" style="height:80px; margin-top: var(--space-2); border-radius: var(--radius-md);">
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label class="form-label">Imagens adicionais</label>
        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
        <?php if ($isEdit && !empty($product['images'])): ?>
            <div style="display: flex; gap: var(--space-2); margin-top: var(--space-2); flex-wrap: wrap;">
                <?php foreach ($product['images'] as $img): ?>
                    <div style="position: relative;">
                        <img src="<?= e(baseUrl($img['image_path'])) ?>" alt="" style="height:60px; border-radius: var(--radius-md);">
                        <form action="<?= baseUrl('admin/pronta-entrega/imagem-deletar/' . $img['id']) ?>" method="POST" style="position:absolute; top:-5px; right:-5px;">
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
            <label class="form-label">
                <input type="checkbox" name="is_featured" value="1" <?= ($product['is_featured'] ?? 0) ? 'checked' : '' ?>>
                Destaque
            </label>
        </div>
        <div class="form-group">
            <label class="form-label">
                <input type="checkbox" name="is_active" value="1" <?= ($product['is_active'] ?? 1) ? 'checked' : '' ?>>
                Ativo
            </label>
        </div>
    </div>

    <div style="margin-top: var(--space-6);">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Atualizar' : 'Cadastrar' ?></button>
        <a href="<?= baseUrl('admin/pronta-entrega') ?>" class="btn btn-ghost">Cancelar</a>
    </div>
</form>
