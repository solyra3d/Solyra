<!-- Schema.org Product -->
<?= schemaProduct($product, $product['images'] ?? []) ?>

<!-- Breadcrumb -->
<section style="padding-top: calc(var(--navbar-height) + var(--space-6));">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= baseUrl() ?>">Home</a>
            <span class="separator">/</span>
            <a href="<?= baseUrl('pronta-entrega') ?>">Pronta Entrega</a>
            <span class="separator">/</span>
            <?php if (!empty($product['category_name'])): ?>
                <a href="<?= baseUrl('catalogo/' . $product['category_slug']) ?>"><?= e($product['category_name']) ?></a>
                <span class="separator">/</span>
            <?php endif; ?>
            <span class="current"><?= e($product['name']) ?></span>
        </div>
    </div>
</section>

<!-- Product Detail -->
<section class="section product-detail" style="padding-top: var(--space-4);">
    <div class="container">
        <div class="product-layout">
            <!-- Gallery -->
            <div class="product-gallery">
                <!-- Main Media -->
                <div class="product-gallery-main" id="gallery-main">
                    <?php if (!empty($product['video_path'])): ?>
                        <video id="gallery-main-video"
                               src="<?= e(baseUrl($product['video_path'])) ?>"
                               autoplay muted loop playsinline
                               style="width:100%;height:100%;object-fit:contain;"></video>
                        <?php if (!empty($product['images'])): ?>
                            <img src="<?= e(baseUrl($product['images'][0]['image_path'])) ?>"
                                 alt="<?= e($product['name']) ?>" id="gallery-main-img" style="display:none;">
                        <?php endif; ?>
                    <?php elseif (!empty($product['images'])): ?>
                        <img src="<?= e(baseUrl($product['images'][0]['image_path'])) ?>"
                             alt="<?= e($product['name']) ?>" id="gallery-main-img">
                    <?php else: ?>
                        <div class="product-gallery-placeholder">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Thumbnails -->
                <?php $hasVideo = !empty($product['video_path']); $hasImages = !empty($product['images']); ?>
                <?php if ($hasVideo || ($hasImages && count($product['images']) > 1)): ?>
                    <div class="product-gallery-thumbs">
                        <?php if ($hasVideo): ?>
                            <button class="gallery-thumb active" onclick="switchToVideo(this)" title="Ver vídeo 3D">
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--color-bg-secondary);border-radius:4px;">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="var(--color-primary)"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </button>
                        <?php endif; ?>
                        <?php foreach ($product['images'] as $index => $img): ?>
                            <button class="gallery-thumb <?= ($index === 0 && !$hasVideo) ? 'active' : '' ?>"
                                    onclick="switchToImage('<?= e(baseUrl($img['image_path'])) ?>', this)">
                                <img src="<?= e(baseUrl($img['image_path'])) ?>"
                                     alt="<?= e($product['name']) ?> - <?= $index + 1 ?>" loading="lazy">
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Ficha Técnica -->
                <?php
                $specs = [
                    ['icon' => '📦', 'label' => 'O que acompanha', 'value' => $product['spec_includes'] ?? null],
                    ['icon' => '📏', 'label' => 'Medidas',          'value' => $product['spec_dimensions'] ?? null],
                    ['icon' => '🎨', 'label' => 'Cores disponíveis','value' => $product['spec_colors'] ?? null],
                    ['icon' => '🖨️', 'label' => 'Material',         'value' => $product['spec_material'] ?? null],
                    ['icon' => '💡', 'label' => 'LED recomendado',  'value' => $product['spec_led'] ?? null],
                    ['icon' => '🚚', 'label' => 'Prazo de produção','value' => $product['spec_production'] ?? null],
                    ['icon' => '🛡️', 'label' => 'Garantia',         'value' => $product['spec_warranty'] ?? null],
                ];
                $activeSpecs = array_filter($specs, fn($s) => !empty($s['value']));
                ?>
                <?php if (!empty($activeSpecs)): ?>
                <div style="margin-top:var(--space-6); border-top:1px solid var(--color-border); padding-top:var(--space-5);">
                    <h4 style="font-size:var(--text-xs); font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:var(--color-text-muted); margin-bottom:var(--space-4);">Ficha Técnica</h4>
                    <div style="display:flex; flex-direction:column; gap:var(--space-2);">
                        <?php foreach ($activeSpecs as $spec): ?>
                        <div style="display:flex; align-items:flex-start; gap:var(--space-3); padding:var(--space-3) var(--space-4); background:var(--color-bg-elevated); border-radius:var(--radius-md); border:1px solid var(--color-border);">
                            <span style="font-size:1.1rem; flex-shrink:0; line-height:1.4;"><?= $spec['icon'] ?></span>
                            <div style="display:flex; flex-direction:column; gap:2px; min-width:0;">
                                <span style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.4px; color:var(--color-text-muted);"><?= $spec['label'] ?></span>
                                <span style="font-size:var(--text-sm); color:var(--color-text-primary); line-height:1.4;"><?= e($spec['value']) ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div><!-- /product-gallery -->

            <!-- Product Info -->
            <div class="product-info">
                <!-- Badges Pronta Entrega -->
                <div style="display:flex; gap:var(--space-2); margin-bottom:var(--space-3); flex-wrap:wrap;">
                    <span class="badge badge-new">Pronta Entrega</span>
                    <?php if ((int)$product['stock_quantity'] <= 3): ?>
                        <span class="badge badge-featured">Últimas <?= (int)$product['stock_quantity'] ?> unidade(s)!</span>
                    <?php else: ?>
                        <span style="font-size:var(--text-xs); color:var(--color-text-muted); align-self:center;"><?= (int)$product['stock_quantity'] ?> em estoque</span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($product['category_name'])): ?>
                    <span class="product-info-category"><?= e($product['category_name']) ?></span>
                <?php endif; ?>

                <h1 class="product-info-title"><?= e($product['name']) ?></h1>

                <?php if (!empty($product['short_description'])): ?>
                    <p class="product-info-short"><?= e($product['short_description']) ?></p>
                <?php endif; ?>

                <?php if (!empty($product['price_from']) && $product['price_from'] > 0): ?>
                    <div class="product-info-price">
                        <span class="price-label">Preço</span>
                        <span class="price-value"><?= formatPrice((float)$product['price_from']) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="product-actions">
                    <a href="<?= whatsappLink(setting('site_whatsapp'), 'Olá! Quero comprar o produto em pronta entrega: ' . $product['name']) ?>"
                       target="_blank" class="btn btn-whatsapp btn-lg">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        Comprar via WhatsApp
                    </a>
                    <a href="<?= whatsappLink(setting('site_whatsapp'), 'Olá! Tenho uma dúvida sobre o produto: ' . $product['name']) ?>"
                       target="_blank" class="btn btn-secondary btn-lg">Tirar Dúvida</a>
                </div>

                <!-- Description -->
                <?php if (!empty($product['description'])): ?>
                    <div class="product-description">
                        <h3>Descrição</h3>
                        <div class="product-description-text">
                            <?= nl2br(e($product['description'])) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Gallery JS -->
<script>
function switchToVideo(thumb) {
    var video = document.getElementById('gallery-main-video');
    var img = document.getElementById('gallery-main-img');
    if (img) img.style.display = 'none';
    if (video) { video.style.display = ''; video.play(); }
    document.querySelectorAll('.gallery-thumb').forEach(function(t) { t.classList.remove('active'); });
    thumb.classList.add('active');
}

function switchToImage(src, thumb) {
    var video = document.getElementById('gallery-main-video');
    var img = document.getElementById('gallery-main-img');
    if (video) { video.pause(); video.style.display = 'none'; }
    if (!img) {
        img = document.createElement('img');
        img.id = 'gallery-main-img';
        document.getElementById('gallery-main').appendChild(img);
    }
    img.src = src;
    img.style.display = '';
    document.querySelectorAll('.gallery-thumb').forEach(function(t) { t.classList.remove('active'); });
    thumb.classList.add('active');
}
</script>
