<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title">Pronta <span class="text-gradient">Entrega</span></h1>
        <p class="page-hero-desc">Produtos prontos para envio imediato. Sem espera, sem encomenda.</p>
    </div>
</section>

<!-- Products -->
<section class="section">
    <div class="container">
        <!-- Search -->
        <div class="catalog-header">
            <div>
                <p class="catalog-description"><?= $products['total'] ?> produto(s) disponível(is)</p>
            </div>
            <div class="catalog-search">
                <form action="<?= baseUrl('pronta-entrega') ?>" method="GET" class="search-form">
                    <input type="text" name="q" class="form-control" placeholder="Buscar..." value="<?= e($search) ?>">
                    <button type="submit" class="search-btn" aria-label="Buscar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Grid -->
        <?php if (!empty($products['items'])): ?>
            <div class="grid grid-4">
                <?php foreach ($products['items'] as $product): ?>
                    <article class="product-card reveal">
                        <a href="<?= baseUrl('pronta-entrega/' . $product['slug']) ?>" class="product-card-image">
                            <?php if (!empty($product['cover_image'])): ?>
                                <img src="<?= e(baseUrl($product['cover_image'])) ?>" alt="<?= e($product['name']) ?>" loading="lazy">
                            <?php else: ?>
                                <div class="product-card-placeholder">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                </div>
                            <?php endif; ?>
                            <div class="product-card-badges">
                                <span class="badge badge-new">Pronta Entrega</span>
                                <?php if ($product['stock_quantity'] <= 3): ?>
                                    <span class="badge badge-featured">Últimas unidades</span>
                                <?php endif; ?>
                            </div>
                        </a>
                        <div class="product-card-body">
                            <?php if (!empty($product['category_name'])): ?>
                                <span class="product-card-category"><?= e($product['category_name']) ?></span>
                            <?php endif; ?>
                            <h3 class="product-card-title"><?= e($product['name']) ?></h3>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--space-2);">
                                <span class="product-card-price"><?= formatPrice((float)$product['price']) ?></span>
                                <span style="font-size: var(--text-xs); color: var(--color-text-muted);"><?= (int)$product['stock_quantity'] ?> em estoque</span>
                            </div>
                            <div class="product-card-actions">
                                <a href="<?= baseUrl('pronta-entrega/' . $product['slug']) ?>" class="btn btn-primary btn-sm">Comprar</a>
                                <a href="<?= whatsappProductLink(setting('site_whatsapp'), $product['name']) ?>" target="_blank" class="btn btn-whatsapp btn-sm">WhatsApp</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($products['total_pages'] > 1): ?>
                <div class="pagination">
                    <?php if ($products['has_prev']): ?>
                        <a href="?page=<?= $products['current_page'] - 1 ?><?= $search ? '&q=' . urlencode($search) : '' ?>">&#8592;</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $products['total_pages']; $i++): ?>
                        <?php if ($i == $products['current_page']): ?>
                            <span class="active"><?= $i ?></span>
                        <?php else: ?>
                            <a href="?page=<?= $i ?><?= $search ? '&q=' . urlencode($search) : '' ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($products['has_next']): ?>
                        <a href="?page=<?= $products['current_page'] + 1 ?><?= $search ? '&q=' . urlencode($search) : '' ?>">&#8594;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="catalog-empty">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
                <h3>Nenhum produto disponível no momento</h3>
                <p>Novos produtos serão adicionados em breve. Explore nosso catálogo!</p>
                <a href="<?= baseUrl('catalogo') ?>" class="btn btn-secondary">Ver Catálogo</a>
            </div>
        <?php endif; ?>
    </div>
</section>
