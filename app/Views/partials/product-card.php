<article class="product-card reveal">
    <a href="<?= baseUrl('produto/' . $product['slug']) ?>" class="product-card-image">
        <?php if (!empty($product['cover_image'])): ?>
            <img src="<?= e(baseUrl($product['cover_image'])) ?>" alt="<?= e($product['name']) ?>" loading="lazy">
        <?php else: ?>
            <div class="product-card-placeholder">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
            </div>
        <?php endif; ?>
        
        <div class="product-card-badges">
            <?php if (!empty($product['is_new'])): ?>
                <span class="badge badge-new">Novo</span>
            <?php endif; ?>
            <?php if (!empty($product['is_featured'])): ?>
                <span class="badge badge-featured">Destaque</span>
            <?php endif; ?>
        </div>
        
        <div class="product-card-overlay">
            <span class="btn btn-sm btn-primary">Ver Detalhes</span>
        </div>
    </a>
    
    <div class="product-card-body">
        <?php if (!empty($product['category_name'])): ?>
            <span class="product-card-category"><?= e($product['category_name']) ?></span>
        <?php endif; ?>
        <h3 class="product-card-title"><?= e($product['name']) ?></h3>
        <?php if (!empty($product['price_from']) && $product['price_from'] > 0): ?>
            <span class="product-card-price">A partir de <?= formatPrice((float)$product['price_from']) ?></span>
        <?php else: ?>
            <span class="product-card-price">Sob consulta</span>
        <?php endif; ?>
        
        <div class="product-card-actions">
            <a href="<?= baseUrl('produto/' . $product['slug']) ?>" class="btn btn-ghost btn-sm">Ver Mais</a>
            <a href="<?= whatsappProductLink(setting('site_whatsapp'), $product['name']) ?>" target="_blank" class="btn btn-whatsapp btn-sm">Orçamento</a>
        </div>
    </div>
</article>
