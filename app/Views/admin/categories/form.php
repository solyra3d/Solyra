<?php $isEdit = !empty($category); ?>
<form action="<?= baseUrl($isEdit ? 'admin/categorias/editar/' . $category['id'] : 'admin/categorias/criar') ?>" method="POST" enctype="multipart/form-data" class="admin-form">
    <?= csrfField() ?>

    <div class="admin-form-grid">
        <div class="form-group">
            <label for="cat-name" class="form-label">Nome da Categoria *</label>
            <input type="text" id="cat-name" name="name" class="form-control" value="<?= e($isEdit ? $category['name'] : '') ?>" required>
        </div>
        <div class="form-group">
            <label for="cat-slug" class="form-label">Slug (URL)</label>
            <input type="text" id="cat-slug" name="slug" class="form-control" value="<?= e($isEdit ? $category['slug'] : '') ?>" placeholder="Gerado automaticamente">
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="form-label">Descrição</label>
        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Descrição da categoria..."><?= e($isEdit ? ($category['description'] ?? '') : '') ?></textarea>
    </div>

    <div class="admin-form-grid">
        <div class="form-group">
            <label for="icon" class="form-label">Ícone (emoji ou classe)</label>
            <input type="text" id="icon" name="icon" class="form-control" value="<?= e($isEdit ? ($category['icon'] ?? '') : '') ?>" placeholder="Ex: 🎁 ou icon-gift">
        </div>
        <div class="form-group">
            <label for="order_position" class="form-label">Posição de Ordenação</label>
            <input type="number" id="order_position" name="order_position" class="form-control" min="0" value="<?= e($isEdit ? $category['order_position'] : '0') ?>">
        </div>
    </div>

    <!-- Toggle Ativo -->
    <div class="flex gap-6 mb-8">
        <label class="flex gap-2" style="align-items:center; cursor:pointer;">
            <label class="toggle-switch">
                <input type="checkbox" name="is_active" value="1" <?= (!$isEdit || $category['is_active']) ? 'checked' : '' ?>>
                <span class="toggle-slider"></span>
            </label>
            <span>Ativa</span>
        </label>
    </div>

    <!-- Imagem -->
    <div class="form-group">
        <label class="form-label">Imagem da Categoria</label>

        <?php if ($isEdit && $category['image']): ?>
            <div class="admin-images-grid mb-4">
                <div class="admin-image-item">
                    <img src="<?= baseUrl($category['image']) ?>" alt="<?= e($category['name']) ?>">
                </div>
            </div>
        <?php endif; ?>

        <div class="admin-upload-area" onclick="document.getElementById('cat-image').click()">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z"/></svg>
            <p><?= $isEdit && $category['image'] ? 'Clique para substituir a imagem' : 'Clique ou arraste uma imagem' ?></p>
        </div>
        <input type="file" id="cat-image" name="image" accept="image/jpeg,image/png,image/webp" style="display:none;">
    </div>

    <!-- Actions -->
    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar Alterações' : 'Criar Categoria' ?></button>
        <a href="<?= baseUrl('admin/categorias') ?>" class="btn btn-ghost">Cancelar</a>
    </div>
</form>
