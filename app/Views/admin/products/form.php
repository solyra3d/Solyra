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

    <!-- Pronta Entrega -->
    <div class="form-group" style="margin-top:var(--space-4); padding:var(--space-5); background:var(--color-bg-elevated); border-radius:var(--radius-lg); border:1px solid var(--color-border);">
        <div class="flex gap-2" style="align-items:center; margin-bottom:var(--space-4);">
            <label class="toggle-switch">
                <input type="checkbox" name="is_ready_delivery" id="ready-delivery-toggle" value="1"
                       <?= ($isEdit && !empty($product['is_ready_delivery'])) ? 'checked' : '' ?>
                       onchange="document.getElementById('stock-field').style.display=this.checked?'block':'none'">
                <span class="toggle-slider"></span>
            </label>
            <span style="font-weight:600;">📦 Disponível para Pronta Entrega</span>
        </div>
        <div id="stock-field" style="display:<?= ($isEdit && !empty($product['is_ready_delivery'])) ? 'block' : 'none' ?>;">
            <label class="form-label">Quantidade em estoque *</label>
            <input type="number" name="stock_quantity" class="form-control" min="0" style="max-width:180px;"
                   value="<?= e($isEdit ? (int)($product['stock_quantity'] ?? 0) : 0) ?>"
                   placeholder="0">
            <small style="color:var(--color-text-muted); margin-top:4px; display:block;">Quando chegar a 0, sai automaticamente da Pronta Entrega.</small>
        </div>
    </div>

    <!-- Especificações Técnicas -->
    <details open style="margin-top: var(--space-6); background: var(--color-bg-elevated); border-radius: var(--radius-lg); padding: var(--space-6); border: 1px solid var(--color-border);">
        <summary style="cursor:pointer; font-weight:700; font-size:var(--text-base); margin-bottom: var(--space-5); list-style:none; display:flex; align-items:center; gap:var(--space-2);">
            📋 Ficha Técnica
            <span style="font-size:var(--text-xs); font-weight:400; color:var(--color-text-muted);">(aparece abaixo das fotos na página do produto)</span>
        </summary>
        <div class="admin-form-grid">
            <div class="form-group">
                <label class="form-label">📦 O que acompanha</label>
                <input type="text" name="spec_includes" class="form-control" placeholder="Ex: 1 porta-velas + vela LED"
                       value="<?= e($isEdit ? ($product['spec_includes'] ?? '') : '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">📏 Medidas</label>
                <input type="text" name="spec_dimensions" class="form-control" placeholder="Ex: 20 cm alt. × 8 cm larg."
                       value="<?= e($isEdit ? ($product['spec_dimensions'] ?? '') : '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">🎨 Cores disponíveis</label>
                <input type="text" name="spec_colors" class="form-control" placeholder="Ex: Branco, Preto, Verde"
                       value="<?= e($isEdit ? ($product['spec_colors'] ?? '') : '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">🖨️ Material</label>
                <input type="text" name="spec_material" class="form-control" placeholder="Ex: PETG Premium"
                       value="<?= e($isEdit ? ($product['spec_material'] ?? '') : '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">💡 LED recomendado</label>
                <input type="text" name="spec_led" class="form-control" placeholder="Ex: Vela LED 3W bivolt"
                       value="<?= e($isEdit ? ($product['spec_led'] ?? '') : '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">🚚 Prazo de produção</label>
                <input type="text" name="spec_production" class="form-control" placeholder="Ex: 5 a 7 dias úteis"
                       value="<?= e($isEdit ? ($product['spec_production'] ?? '') : '') ?>">
            </div>
        </div>
        <div class="form-group" style="margin-top:var(--space-4);">
            <label class="form-label">🛡️ Garantia</label>
            <input type="text" name="spec_warranty" class="form-control" placeholder="Ex: 30 dias contra defeitos de fabricação"
                   value="<?= e($isEdit ? ($product['spec_warranty'] ?? '') : '') ?>">
        </div>
    </details>

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
                        <?php else: ?>
                            <form method="POST" action="<?= baseUrl('admin/produtos/imagem-capa/' . $img['id']) ?>" style="position:absolute;bottom:4px;left:4px;">
                                <?= csrfField() ?>
                                <button type="submit" style="font-size:10px;padding:2px 7px;background:var(--color-surface);border:1px solid var(--color-border);border-radius:4px;color:var(--color-text-muted);cursor:pointer;">Definir Capa</button>
                            </form>
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

    <!-- Vídeo 3D -->
    <div class="form-group" style="margin-top: var(--space-6);">
        <label class="form-label">Vídeo 3D do Produto <span style="font-weight:400;color:var(--color-text-muted);">(MP4 ou WebM — máx 50MB)</span></label>

        <?php if ($isEdit && !empty($product['video_path'])): ?>
            <div style="margin-bottom:var(--space-4); position:relative; display:inline-block;">
                <video src="<?= e(baseUrl($product['video_path'])) ?>" autoplay muted loop playsinline
                       style="max-width:280px; border-radius:8px; display:block;"></video>
                <button type="button" class="delete-btn" style="position:absolute;top:4px;right:4px;"
                        onclick="deleteVideo('/admin/produtos/video-deletar/<?= $product['id'] ?>')">&times;</button>
            </div>
        <?php endif; ?>

        <div class="admin-upload-area" onclick="document.getElementById('product-video').click()">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
            <p><?= ($isEdit && !empty($product['video_path'])) ? 'Substituir vídeo atual' : 'Clique para fazer upload do vídeo' ?></p>
        </div>
        <input type="file" id="product-video" name="video" accept="video/mp4,video/webm,video/quicktime" style="display:none;" onchange="previewVideo(this)">
        <div id="video-preview" style="display:none; margin-top:var(--space-3);">
            <video id="video-preview-player" autoplay muted loop playsinline style="max-width:280px; border-radius:8px;"></video>
        </div>
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
function previewVideo(input) {
    if (input.files && input.files[0]) {
        var player = document.getElementById('video-preview-player');
        player.src = URL.createObjectURL(input.files[0]);
        document.getElementById('video-preview').style.display = 'block';
    }
}

function deleteVideo(url) {
    if (!confirm('Remover o vídeo deste produto?')) return;
    fetch(url, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: '_csrf_token=<?= csrfToken() ?>'
    }).then(function(r) {
        if (r.ok || r.redirected) { location.reload(); }
        else { alert('Erro ao remover vídeo.'); }
    }).catch(function() { alert('Erro de conexão.'); });
}

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
