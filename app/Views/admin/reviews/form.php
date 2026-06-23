<?php $isEdit = !empty($review); ?>
<form action="<?= baseUrl($isEdit ? 'admin/avaliacoes/editar/' . $review['id'] : 'admin/avaliacoes/criar') ?>" method="POST" enctype="multipart/form-data" class="admin-form">
    <?= csrfField() ?>

    <div class="admin-form-grid">
        <div class="form-group">
            <label for="client_name" class="form-label">Nome do Cliente *</label>
            <input type="text" id="client_name" name="client_name" class="form-control" value="<?= e($isEdit ? $review['client_name'] : '') ?>" required>
        </div>
        <div class="form-group">
            <label for="company" class="form-label">Empresa</label>
            <input type="text" id="company" name="company" class="form-control" value="<?= e($isEdit ? ($review['company'] ?? '') : '') ?>" placeholder="Nome da empresa (opcional)">
        </div>
    </div>

    <div class="form-group">
        <label for="text" class="form-label">Texto da Avaliação *</label>
        <textarea id="text" name="text" class="form-control" rows="4" required placeholder="Depoimento do cliente..."><?= e($isEdit ? $review['text'] : '') ?></textarea>
    </div>

    <div class="admin-form-grid">
        <div class="form-group">
            <label for="rating" class="form-label">Nota (1-5 estrelas)</label>
            <select id="rating" name="rating" class="form-control form-select">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                    <option value="<?= $i ?>" <?= ($isEdit && $review['rating'] == $i) ? 'selected' : ($i == 5 && !$isEdit ? 'selected' : '') ?>>
                        <?= str_repeat('★', $i) . str_repeat('☆', 5 - $i) ?> (<?= $i ?>)
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group" style="display:flex; align-items:flex-end; padding-bottom: .5rem;">
            <label class="flex gap-2" style="align-items:center; cursor:pointer;">
                <label class="toggle-switch">
                    <input type="checkbox" name="is_active" value="1" <?= (!$isEdit || $review['is_active']) ? 'checked' : '' ?>>
                    <span class="toggle-slider"></span>
                </label>
                <span>Ativa (visível no site)</span>
            </label>
        </div>
    </div>

    <!-- Avatar -->
    <div class="form-group">
        <label class="form-label">Foto do Cliente (opcional)</label>

        <?php if ($isEdit && $review['avatar']): ?>
            <div class="admin-images-grid mb-4">
                <div class="admin-image-item" style="width:80px; height:80px;">
                    <img src="<?= baseUrl($review['avatar']) ?>" alt="<?= e($review['client_name']) ?>" style="border-radius:50%;">
                </div>
            </div>
        <?php endif; ?>

        <div class="admin-upload-area" onclick="document.getElementById('review-avatar').click()" style="max-width:300px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            <p style="font-size:.85rem;"><?= $isEdit && $review['avatar'] ? 'Substituir foto' : 'Upload de foto' ?></p>
        </div>
        <input type="file" id="review-avatar" name="avatar" accept="image/jpeg,image/png,image/webp" style="display:none;">
    </div>

    <!-- Actions -->
    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar Alterações' : 'Criar Avaliação' ?></button>
        <a href="<?= baseUrl('admin/avaliacoes') ?>" class="btn btn-ghost">Cancelar</a>
    </div>
</form>
