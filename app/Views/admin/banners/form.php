<?php $isEdit = !empty($banner); ?>
<form action="<?= baseUrl($isEdit ? 'admin/banners/editar/' . $banner['id'] : 'admin/banners/criar') ?>" method="POST" enctype="multipart/form-data" class="admin-form">
    <?= csrfField() ?>

    <div class="form-group">
        <label for="banner-title" class="form-label">Título *</label>
        <input type="text" id="banner-title" name="title" class="form-control" value="<?= e($isEdit ? $banner['title'] : '') ?>" required>
    </div>

    <div class="form-group">
        <label for="subtitle" class="form-label">Subtítulo</label>
        <input type="text" id="subtitle" name="subtitle" class="form-control" maxlength="300" value="<?= e($isEdit ? ($banner['subtitle'] ?? '') : '') ?>" placeholder="Texto secundário do banner">
    </div>

    <div class="admin-form-grid">
        <div class="form-group">
            <label for="button_text" class="form-label">Texto do Botão</label>
            <input type="text" id="button_text" name="button_text" class="form-control" maxlength="50" value="<?= e($isEdit ? ($banner['button_text'] ?? 'Saiba Mais') : 'Saiba Mais') ?>">
        </div>
        <div class="form-group">
            <label for="button_link" class="form-label">Link do Botão</label>
            <input type="text" id="button_link" name="button_link" class="form-control" value="<?= e($isEdit ? ($banner['button_link'] ?? '') : '') ?>" placeholder="/catalogo ou URL completa">
        </div>
    </div>

    <div class="admin-form-grid">
        <div class="form-group">
            <label for="order_position" class="form-label">Posição de Ordenação</label>
            <input type="number" id="order_position" name="order_position" class="form-control" min="0" value="<?= e($isEdit ? $banner['order_position'] : '0') ?>">
        </div>
        <div class="form-group" style="display:flex; align-items:flex-end; padding-bottom: .5rem;">
            <label class="flex gap-2" style="align-items:center; cursor:pointer;">
                <label class="toggle-switch">
                    <input type="checkbox" name="is_active" value="1" <?= (!$isEdit || $banner['is_active']) ? 'checked' : '' ?>>
                    <span class="toggle-slider"></span>
                </label>
                <span>Ativo</span>
            </label>
        </div>
    </div>

    <!-- Imagem -->
    <div class="form-group">
        <label class="form-label">Imagem do Banner * <small>(Recomendado: 1920x600px)</small></label>

        <?php if ($isEdit && $banner['image_path']): ?>
            <div class="admin-images-grid mb-4">
                <div class="admin-image-item" style="max-width:400px;">
                    <img src="<?= baseUrl($banner['image_path']) ?>" alt="<?= e($banner['title']) ?>" style="width:100%; border-radius:8px;">
                </div>
            </div>
        <?php endif; ?>

        <div class="admin-upload-area" onclick="document.getElementById('banner-image').click()">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z"/></svg>
            <p><?= $isEdit ? 'Clique para substituir a imagem' : 'Clique para selecionar a imagem do banner' ?></p>
        </div>
        <input type="file" id="banner-image" name="image_path" accept="image/jpeg,image/png,image/webp" style="display:none;" <?= $isEdit ? '' : 'required' ?>>
    </div>

    <!-- Actions -->
    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar Alterações' : 'Criar Banner' ?></button>
        <a href="<?= baseUrl('admin/banners') ?>" class="btn btn-ghost">Cancelar</a>
    </div>
</form>
