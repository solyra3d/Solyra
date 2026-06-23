<!-- Breadcrumb -->
<section style="padding-top: calc(var(--navbar-height) + var(--space-6));">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= baseUrl() ?>">Home</a>
            <span class="separator">/</span>
            <?php if ($currentCategory): ?>
                <a href="<?= baseUrl('catalogo') ?>">Catálogo</a>
                <span class="separator">/</span>
                <span class="current"><?= e($currentCategory['name']) ?></span>
            <?php else: ?>
                <span class="current">Catálogo</span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Catalog Section -->
<section class="section" style="padding-top: var(--space-4);">
    <div class="container">
        <!-- Header -->
        <div class="catalog-header">
            <div>
                <h1 class="catalog-title">
                    <?= $currentCategory ? e($currentCategory['name']) : 'Catálogo' ?>
                </h1>
                <?php if ($currentCategory && $currentCategory['description']): ?>
                    <p class="catalog-description"><?= e($currentCategory['description']) ?></p>
                <?php endif; ?>
            </div>
            
            <!-- Search -->
            <div class="catalog-search">
                <form action="<?= baseUrl('catalogo') ?>" method="GET" class="search-form">
                    <input type="text" name="q" class="form-control" placeholder="Buscar produtos..." value="<?= e($search) ?>" id="catalog-search-input">
                    <button type="submit" class="search-btn" aria-label="Buscar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs">
            <?php foreach ($categories as $cat): ?>
                <a href="<?= baseUrl('catalogo/' . $cat['slug']) ?>" 
                   class="category-tab <?= ($currentCategory && $currentCategory['id'] == $cat['id']) ? 'active' : '' ?>">
                    <?= e($cat['name']) ?>
                </a>
            <?php endforeach; ?>
            <a href="<?= baseUrl('catalogo?all=1') ?>" class="category-tab <?= (!$currentCategory && !empty($_GET['all'])) ? 'active' : '' ?>">Todos</a>
        </div>

        <!-- Results info -->
        <?php if ($search): ?>
            <p class="catalog-results-info">
                Resultados para "<strong><?= e($search) ?></strong>" - <?= $products['total'] ?> produto(s) encontrado(s)
            </p>
        <?php endif; ?>

        <!-- Products Grid -->
        <?php if (!empty($products['items'])): ?>
            <div class="grid grid-4" id="products-grid">
                <?php foreach ($products['items'] as $product): ?>
                    <?php include ROOT_PATH . '/app/Views/partials/product-card.php'; ?>
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
                <svg width="64" height="64" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-4.86 8.86l-3 3.87L9 13.14 6 17h12l-3.86-5.14z"/></svg>
                <h3>Nenhum produto encontrado</h3>
                <p>Tente uma busca diferente ou explore nossas categorias.</p>
                <a href="<?= baseUrl('catalogo') ?>" class="btn btn-secondary">Ver Todos</a>
            </div>
        <?php endif; ?>
    </div>
</section>
