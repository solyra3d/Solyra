<!-- Schema.org Product -->
<?= schemaProduct($product, $product['images'] ?? []) ?>

<!-- Breadcrumb -->
<section style="padding-top: calc(var(--navbar-height) + var(--space-6));">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= baseUrl() ?>">Home</a>
            <span class="separator">/</span>
            <a href="<?= baseUrl('catalogo') ?>">Catálogo</a>
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
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <?php if (!empty($product['category_name'])): ?>
                    <span class="product-info-category"><?= e($product['category_name']) ?></span>
                <?php endif; ?>
                
                <h1 class="product-info-title"><?= e($product['name']) ?></h1>
                
                <?php if (!empty($product['short_description'])): ?>
                    <p class="product-info-short"><?= e($product['short_description']) ?></p>
                <?php endif; ?>

                <?php if (!empty($product['price_from']) && $product['price_from'] > 0): ?>
                    <div class="product-info-price">
                        <span class="price-label">A partir de</span>
                        <span class="price-value"><?= formatPrice((float)$product['price_from']) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="product-actions">
                    <a href="<?= whatsappProductLink(setting('site_whatsapp'), $product['name']) ?>" target="_blank" class="btn btn-whatsapp btn-lg">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        Solicitar Orçamento
                    </a>
                    <a href="<?= whatsappLink(setting('site_whatsapp'), 'Olá! Tenho uma dúvida sobre o produto: ' . $product['name']) ?>" target="_blank" class="btn btn-secondary btn-lg">
                        Tirar Dúvida
                    </a>
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

                <!-- Badges -->
                <div class="product-badges">
                    <?php if ($product['is_new']): ?>
                        <span class="badge badge-new">Novo</span>
                    <?php endif; ?>
                    <?php if ($product['is_featured']): ?>
                        <span class="badge badge-featured">Destaque</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if (!empty($related)): ?>
<section class="section" style="background: var(--color-bg-secondary);">
    <div class="container">
        <div class="section-header">
            <h2>Produtos Relacionados</h2>
            <div class="accent-line"></div>
        </div>
        
        <div class="grid grid-4">
            <?php foreach ($related as $product): ?>
                <?php include ROOT_PATH . '/app/Views/partials/product-card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

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
