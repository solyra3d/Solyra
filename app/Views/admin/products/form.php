<?php $isEdit = !empty($product); ?>
<form action="<?= baseUrl($isEdit ? 'admin/produtos/editar/' . $product['id'] : 'admin/produtos/criar') ?>" method="POST" enctype="multipart/form-data" class="admin-form">
    <?= csrfField() ?>

    <div class="admin-form-grid">
        <div class="form-group">
            <label for="product-name" class="form-label">Nome do Produto *</label>
            <input type="text" id="product-name" name="name" class="form-control" value="<?= e($isEdit ? $product['name'] : '') ?>" required>
        </div>
        <div class="form-group">
            <label for="product-slug" class="form-label">Slug (URL)</label>
            <input type="text" id="product-slug" name="slug" class="form-control" value="<?= e($isEdit ? $product['slug'] : '') ?>" placeholder="Gerado automaticamente">
        </div>
    </div>

    <div class="admin-form-grid">
        <div class="form-group">
            <label for="category_id" class="form-label">Categoria *</label>
            <select id="category_id" name="category_id" class="form-control form-select" required>
                <option value="">Selecione...</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($isEdit && $product['category_id'] == $cat['id']) || (!$isEdit && !empty($preselectedCategory) && $preselectedCategory == $cat['id']) ? 'selected' : '' ?>>
                        <?= e($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="price_from" class="form-label">Preço a partir de (R$)</label>
            <input type="number" id="price_from" name="price_from" class="form-control" step="0.01" min="0" value="<?= e($isEdit ? ($product['price_from'] ?? '') : '') ?>" placeholder="0.00">
        </div>
    </div>

    <div class="form-group">
        <label for="short_description" class="form-label">Descrição Curta</label>
        <input type="text" id="short_description" name="short_description" class="form-control" maxlength="500" value="<?= e($isEdit ? ($product['short_description'] ?? '') : '') ?>" placeholder="Resumo do produto (exibido nos cards)">
    </div>

    <div class="form-group">
        <label for="description" class="form-label">Descrição Completa</label>
        <textarea id="description" name="description" class="form-control" rows="6" placeholder="Descrição detalhada do produto..."><?= e($isEdit ? ($product['description'] ?? '') : '') ?></textarea>
    </div>

    <!-- Toggles -->
    <div class="flex gap-6 mb-8">
        <label class="flex gap-2" style="align-items:center; cursor:pointer;">
            <label class="toggle-switch">
                <input type="checkbox" name="is_active" value="1" <?= (!$isEdit || $product['is_active']) ? 'checked' : '' ?>>
                <span class="toggle-slider"></span>
            </label>
            <span>Ativo</span>
        </label>
        <label class="flex gap-2" style="align-items:center; cursor:pointer;">
            <label class="toggle-switch">
                <input type="checkbox" name="is_featured" value="1" <?= ($isEdit && $product['is_featured']) ? 'checked' : '' ?>>
                <span class="toggle-slider"></span>
            </label>
            <span>Destaque</span>
        </label>
        <label class="flex gap-2" style="align-items:center; cursor:pointer;">
            <label class="toggle-switch">
                <input type="checkbox" name="is_new" value="1" <?= ($isEdit && $product['is_new']) ? 'checked' : '' ?>>
                <span class="toggle-slider"></span>
            </label>
            <span>Novo</span>
        </label>
    </div>

    <!-- Imagens -->
    <div class="form-group">
        <label class="form-label">Imagens do Produto</label>
        
        <?php if (!empty($images)): ?>
            <div class="admin-images-grid mb-4">
                <?php foreach ($images as $img): ?>
                    <div class="admin-image-item">
                        <img src="<?= e(baseUrl($img['image_path'])) ?>" alt="Produto">
                        <button type="button" class="delete-btn" style="position:absolute;top:4px;right:4px;"
                                onclick="deleteImage('/admin/produtos/imagem-deletar/<?= $img['id'] ?>')">&times;</button>
                        <?php if ($img['is_cover']): ?>
                            <span class="badge badge-gold" style="position:absolute;bottom:4px;left:4px;font-size:10px;">Capa</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="admin-upload-area" onclick="document.getElementById('product-images').click()">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z"/></svg>
            <p>Clique ou arraste imagens aqui (JPG, PNG, WEBP - máx 5MB)</p>
        </div>
        <input type="file" id="product-images" name="images[]" multiple accept="image/jpeg,image/png,image/webp" style="display:none;">
        <div id="image-preview" class="admin-images-grid"></div>
    </div>

    <!-- SEO -->
    <details style="margin-top: var(--space-6);">
        <summary style="cursor:pointer; font-weight:600; margin-bottom: var(--space-4);">SEO (Opcional)</summary>
        <div class="admin-form-grid">
            <div class="form-group">
                <label for="seo_title" class="form-label">SEO Title</label>
                <input type="text" id="seo_title" name="seo_title" class="form-control" maxlength="200" value="<?= e($isEdit ? ($product['seo_title'] ?? '') : '') ?>">
            </div>
            <div class="form-group">
                <label for="seo_description" class="form-label">SEO Description</label>
                <input type="text" id="seo_description" name="seo_description" class="form-control" maxlength="300" value="<?= e($isEdit ? ($product['seo_description'] ?? '') : '') ?>">
            </div>
        </div>
    </details>

    <!-- Actions -->
    <div class="admin-form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar Alterações' : 'Criar Produto' ?></button>
        <?php
            $backUrl = baseUrl('admin/produtos');
            if ($isEdit && !empty($product['category_id'])) {
                $backUrl = baseUrl('admin/produtos/categoria/' . $product['category_id']);
            } elseif (!$isEdit && !empty($preselectedCategory)) {
                $backUrl = baseUrl('admin/produtos/categoria/' . $preselectedCategory);
            }
        ?>
        <a href="<?= $backUrl ?>" class="btn btn-ghost">Cancelar</a>
    </div>
</form>

<script>
function deleteImage(url) {
    if (!confirm('Remover esta imagem?')) return;
    fetch(url, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: '_csrf_token=<?= csrfToken() ?>'
    }).then(function(r) {
        if (r.ok || r.redirected) { location.reload(); }
        else { alert('Erro ao remover imagem. Tente novamente.'); }
    }).catch(function() { alert('Erro de conexão.'); });
}
</script>
