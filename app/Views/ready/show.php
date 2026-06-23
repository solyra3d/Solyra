<!-- Breadcrumb -->
<section style="padding-top: calc(var(--navbar-height) + var(--space-6));">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= baseUrl() ?>">Home</a>
            <span class="separator">/</span>
            <a href="<?= baseUrl('pronta-entrega') ?>">Pronta Entrega</a>
            <span class="separator">/</span>
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
                <div class="product-gallery-main" id="gallery-main">
                    <?php if (!empty($product['images'])): ?>
                        <img src="<?= e(baseUrl($product['images'][0]['image_path'])) ?>" alt="<?= e($product['name']) ?>" id="gallery-main-img">
                    <?php elseif (!empty($product['cover_image'])): ?>
                        <img src="<?= e(baseUrl($product['cover_image'])) ?>" alt="<?= e($product['name']) ?>" id="gallery-main-img">
                    <?php else: ?>
                        <div class="product-gallery-placeholder">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($product['images']) && count($product['images']) > 1): ?>
                    <div class="product-gallery-thumbs">
                        <?php foreach ($product['images'] as $index => $img): ?>
                            <button class="product-gallery-thumb <?= $index === 0 ? 'active' : '' ?>"
                                    onclick="changeGalleryImage('<?= e(baseUrl($img['image_path'])) ?>', this)">
                                <img src="<?= e(baseUrl($img['image_path'])) ?>" alt="Imagem <?= $index + 1 ?>" loading="lazy">
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="product-info">
                <span class="badge badge-new" style="margin-bottom: var(--space-3);">Pronta Entrega</span>

                <h1 class="product-info-title"><?= e($product['name']) ?></h1>

                <?php if (!empty($product['short_description'])): ?>
                    <p class="product-info-short"><?= e($product['short_description']) ?></p>
                <?php endif; ?>

                <div class="product-info-price">
                    <span class="price-value"><?= formatPrice((float)$product['price']) ?></span>
                    <span class="price-label" style="display: inline; margin-left: var(--space-2);">· <?= (int)$product['stock_quantity'] ?> em estoque</span>
                </div>

                <!-- Actions -->
                <div class="product-actions">
                    <a href="<?= whatsappLink(setting('site_whatsapp'), 'Olá! Quero comprar o produto: ' . $product['name']) ?>" target="_blank" class="btn btn-whatsapp btn-lg">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        Comprar via WhatsApp
                    </a>
                    <a href="<?= whatsappLink(setting('site_whatsapp'), 'Tenho uma dúvida sobre: ' . $product['name']) ?>" target="_blank" class="btn btn-secondary btn-lg">
                        Tirar Dúvida
                    </a>
                </div>

                <!-- Description -->
                <?php if (!empty($product['description'])): ?>
                    <div class="product-description">
                        <h3>Descrição</h3>
                        <div class="product-description-text"><?= nl2br(e($product['description'])) ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
function changeGalleryImage(src, thumb) {
    document.getElementById('gallery-main-img').src = src;
    document.querySelectorAll('.product-gallery-thumb').forEach(function(t) { t.classList.remove('active'); });
    thumb.classList.add('active');
}
</script>
