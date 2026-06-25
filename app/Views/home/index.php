<!-- =============================================
     HERO SECTION
     ============================================= -->
<section class="hero">
    <div class="container">
        <div class="hero-split">
            <!-- Texto à esquerda -->
            <div class="hero-content">
                <div class="hero-badge reveal">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    <?= e(pageContent('home', 'hero', 'badge', 'Impressão 3D Premium')) ?>
                </div>
                <h1 class="hero-title reveal">
                    <?= e(pageContent('home', 'hero', 'title', 'Luminárias e peças')) ?><br><span class="text-gradient"><?= e(pageContent('home', 'hero', 'title_highlight', 'que encantam')) ?></span>
                </h1>
                <p class="hero-desc reveal">
                    <?= e(pageContent('home', 'hero', 'description', 'Design exclusivo, tecnologia de ponta e acabamento impecável. Cada peça é criada para transformar ambientes.')) ?>
                </p>
                <div class="hero-actions reveal">
                    <a href="<?= baseUrl('catalogo') ?>" class="btn btn-primary btn-lg"><?= e(pageContent('home', 'hero', 'btn_primary', 'Ver Catálogo')) ?></a>
                    <a href="<?= whatsappLink(setting('site_whatsapp'), 'Olá! Gostaria de solicitar um orçamento.') ?>" target="_blank" class="btn btn-secondary btn-lg"><?= e(pageContent('home', 'hero', 'btn_secondary', 'Solicitar Orçamento')) ?></a>
                </div>
            </div>
            <!-- Imagem à direita -->
            <div class="hero-visual reveal">
                <div class="hero-glow"></div>
                <div class="hero-image-wrapper">
                    <?php $heroImg = setting('hero_image'); ?>
                    <?php if ($heroImg): ?>
                        <img src="<?= e(baseUrl($heroImg)) ?>" alt="Produto destaque SOLYRA" class="hero-product-img">
                    <?php elseif (!empty($featured) && !empty($featured[0]['cover_image'])): ?>
                        <img src="<?= e(baseUrl($featured[0]['cover_image'])) ?>" alt="Produto destaque SOLYRA" class="hero-product-img">
                    <?php else: ?>
                        <div class="hero-placeholder">
                            <svg width="200" height="200" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="50" cy="40" r="20" stroke="url(#heroGrad)" stroke-width="1.5" fill="rgba(139,92,246,0.05)"/>
                                <path d="M42 60 L50 80 L58 60" stroke="url(#heroGrad)" stroke-width="1.5" fill="none"/>
                                <defs><linearGradient id="heroGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#8B5CF6"/><stop offset="100%" stop-color="#38BDF8"/></linearGradient></defs>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =============================================
     CATEGORIAS
     ============================================= -->
<section class="section" id="categorias">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title"><?= e(pageContent('home', 'categories', 'title', 'Nossas')) ?> <span class="text-gradient"><?= e(pageContent('home', 'categories', 'title_highlight', 'Categorias')) ?></span></h2>
            <p class="section-subtitle"><?= e(pageContent('home', 'categories', 'subtitle', 'Explore nosso catálogo diversificado de produtos premium')) ?></p>
        </div>
        <div class="categories-grid reveal">
            <?php
            $iconMap = [
                'lightbulb' => '💡', 'gift' => '🎁', 'palette' => '🎨',
                'brush' => '🖌️', 'pokeball' => '⚡', 'gamepad' => '🎮',
                'briefcase' => '💼', 'trophy' => '🏆'
            ];
            ?>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= baseUrl('catalogo/' . $cat['slug']) ?>" class="category-card">
                    <div class="category-card-icon"><?= $iconMap[$cat['icon'] ?? ''] ?? '📦' ?></div>
                    <h3><?= e($cat['name']) ?></h3>
                    <p><?= (int)($cat['product_count'] ?? 0) ?> produtos</p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =============================================
     PRODUTOS EM DESTAQUE
     ============================================= -->
<?php if (!empty($featured)): ?>
<section class="section" id="destaques" style="background: var(--color-bg-secondary); border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title"><?= e(pageContent('home', 'featured', 'title', 'Produtos em')) ?> <span class="text-gradient"><?= e(pageContent('home', 'featured', 'title_highlight', 'Destaque')) ?></span></h2>
            <p class="section-subtitle"><?= e(pageContent('home', 'featured', 'subtitle', 'Os mais procurados pelos nossos clientes')) ?></p>
        </div>
        <div class="products-grid reveal">
            <?php foreach ($featured as $product): ?>
                <?php include ROOT_PATH . '/app/Views/partials/product-card.php'; ?>
            <?php endforeach; ?>
        </div>
        <div class="text-center reveal" style="margin-top: var(--space-10);">
            <a href="<?= baseUrl('catalogo') ?>" class="btn btn-secondary btn-lg">Ver Todos os Produtos</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =============================================
     PRONTA ENTREGA
     ============================================= -->
<?php if (!empty($readyProducts)): ?>
<section class="section" id="pronta-entrega">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title"><?= e(pageContent('home', 'ready', 'title', 'Pronta')) ?> <span class="text-gradient"><?= e(pageContent('home', 'ready', 'title_highlight', 'Entrega')) ?></span></h2>
            <p class="section-subtitle"><?= e(pageContent('home', 'ready', 'subtitle', 'Produtos prontos para envio imediato. Sem espera!')) ?></p>
        </div>
        <div class="grid grid-4 reveal">
            <?php foreach ($readyProducts as $rp): ?>
                <article class="product-card">
                    <a href="<?= baseUrl('pronta-entrega/' . $rp['slug']) ?>" class="product-card-image">
                        <?php if (!empty($rp['cover_image'])): ?>
                            <img src="<?= e(baseUrl($rp['cover_image'])) ?>" alt="<?= e($rp['name']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="product-card-placeholder">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                            </div>
                        <?php endif; ?>
                        <div class="product-card-badges"><span class="badge badge-new">Pronta Entrega</span></div>
                    </a>
                    <div class="product-card-body">
                        <h3 class="product-card-title"><?= e($rp['name']) ?></h3>
                        <span class="product-card-price"><?= formatPrice((float)$rp['price']) ?></span>
                        <div class="product-card-actions">
                            <a href="<?= baseUrl('pronta-entrega/' . $rp['slug']) ?>" class="btn btn-primary btn-sm">Comprar</a>
                            <a href="<?= whatsappProductLink(setting('site_whatsapp'), $rp['name']) ?>" target="_blank" class="btn btn-whatsapp btn-sm">WhatsApp</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="text-center reveal" style="margin-top: var(--space-10);">
            <a href="<?= baseUrl('pronta-entrega') ?>" class="btn btn-secondary btn-lg">Ver Todos Pronta Entrega</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =============================================
     PROCESSO DE PRODUÇÃO (Dinâmico)
     ============================================= -->
<?php if (!empty($processCards)): ?>
<section class="section" id="processo" style="background: var(--color-bg-secondary); border-top: 1px solid var(--color-border);">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title"><?= e(pageContent('home', 'process', 'title', 'Como')) ?> <span class="text-gradient"><?= e(pageContent('home', 'process', 'title_highlight', 'Funciona')) ?></span></h2>
            <p class="section-subtitle"><?= e(pageContent('home', 'process', 'subtitle', 'Do pedido à entrega em passos simples')) ?></p>
        </div>
        <div class="features-grid reveal">
            <?php foreach ($processCards as $card): ?>
                <div class="feature-card">
                    <div class="feature-icon"><?= $card['icon'] ?></div>
                    <h3><?= e($card['title']) ?></h3>
                    <p><?= e($card['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =============================================
     PORTFÓLIO
     ============================================= -->
<?php if (!empty($portfolio)): ?>
<section class="section" id="portfolio">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title">Nosso <span class="text-gradient">Portfólio</span></h2>
            <p class="section-subtitle">Projetos que realizamos com excelência</p>
        </div>
        <div class="grid grid-3 reveal">
            <?php foreach ($portfolio as $item): ?>
                <div class="card" style="overflow:hidden;">
                    <?php if (!empty($item['cover_image'])): ?>
                        <img src="<?= e(baseUrl($item['cover_image'])) ?>" alt="<?= e($item['title']) ?>" style="width:100%; aspect-ratio:4/3; object-fit:cover;" loading="lazy">
                    <?php else: ?>
                        <div style="width:100%; aspect-ratio:4/3; background:var(--color-bg-elevated); display:flex; align-items:center; justify-content:center;">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="var(--color-text-muted)"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        </div>
                    <?php endif; ?>
                    <div style="padding: var(--space-5);">
                        <?php if ($item['category']): ?>
                            <span class="product-card-category"><?= e($item['category']) ?></span>
                        <?php endif; ?>
                        <h3 style="font-size: var(--text-base); font-weight: 600; margin-top: var(--space-2);"><?= e($item['title']) ?></h3>
                        <?php if ($item['description']): ?>
                            <p style="color: var(--color-text-secondary); font-size: var(--text-sm); margin-top: var(--space-2); line-height: 1.5;"><?= e(mb_substr($item['description'], 0, 100)) ?><?= mb_strlen($item['description']) > 100 ? '...' : '' ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =============================================
     DIFERENCIAIS / BENEFÍCIOS (Dinâmico)
     ============================================= -->
<?php if (!empty($differentialCards)): ?>
<section class="section" id="diferenciais" style="background: var(--color-bg-secondary); border-top: 1px solid var(--color-border);">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title"><?= e(pageContent('home', 'differentials', 'title', 'Por que escolher a')) ?> <span class="text-gradient"><?= e(pageContent('home', 'differentials', 'title_highlight', 'SOLYRA')) ?></span><?= e(pageContent('home', 'differentials', 'title_suffix', '?')) ?></h2>
            <p class="section-subtitle"><?= e(pageContent('home', 'differentials', 'subtitle', 'Tecnologia, qualidade e inovação em cada produto')) ?></p>
        </div>
        <div class="features-grid reveal">
            <?php foreach ($differentialCards as $card): ?>
                <div class="feature-card">
                    <div class="feature-icon"><?= $card['icon'] ?></div>
                    <h3><?= e($card['title']) ?></h3>
                    <p><?= e($card['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =============================================
     AVALIAÇÕES
     ============================================= -->
<?php if (!empty($reviews)): ?>
<section class="section" id="avaliacoes">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title"><?= e(pageContent('home', 'reviews', 'title', 'O que dizem nossos')) ?> <span class="text-gradient"><?= e(pageContent('home', 'reviews', 'title_highlight', 'clientes')) ?></span></h2>
            <p class="section-subtitle"><?= e(pageContent('home', 'reviews', 'subtitle', 'Depoimentos de quem já experimentou a qualidade SOLYRA')) ?></p>
        </div>
        <div class="reviews-grid reveal">
            <?php foreach ($reviews as $review): ?>
                <div class="review-card">
                    <div class="review-stars">
                        <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <?php endfor; ?>
                    </div>
                    <p class="review-text">"<?= e($review['text']) ?>"</p>
                    <div class="review-author">
                        <div class="review-avatar"><?= mb_strtoupper(mb_substr($review['client_name'], 0, 1)) ?></div>
                        <div>
                            <div class="review-author-name"><?= e($review['client_name']) ?></div>
                            <?php if ($review['company']): ?>
                                <div class="review-author-company"><?= e($review['company']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =============================================
     GALERIA DA EMPRESA
     ============================================= -->
<?php if (!empty($gallery)): ?>
<section class="section" id="galeria">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title">Nossa <span class="text-gradient">Empresa</span></h2>
            <p class="section-subtitle">Conheça nosso espaço e equipamentos</p>
        </div>
        <div class="grid grid-3 reveal" style="gap: var(--space-4);">
            <?php foreach ($gallery as $photo): ?>
                <div style="border-radius: 12px; overflow: hidden; border: 1px solid var(--color-border);">
                    <img src="<?= e(baseUrl($photo['image_path'])) ?>" alt="<?= e($photo['caption'] ?: 'SOLYRA') ?>" style="width:100%; aspect-ratio:4/3; object-fit:cover;" loading="lazy">
                    <?php if ($photo['caption']): ?>
                        <div style="padding: var(--space-3); font-size: var(--text-sm); color: var(--color-text-secondary);"><?= e($photo['caption']) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =============================================
     YOUTUBE VIDEO
     ============================================= -->
<?php $youtubeUrl = setting('site_youtube'); ?>
<?php if ($youtubeUrl): ?>
<section class="section" id="video" style="background: var(--color-bg-secondary); border-top: 1px solid var(--color-border);">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title">Veja em <span class="text-gradient">Ação</span></h2>
        </div>
        <div class="reveal" style="max-width: 800px; margin: 0 auto;">
            <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius: 12px; border: 1px solid var(--color-border);">
                <?php
                // Extrair ID do vídeo do YouTube
                $videoId = '';
                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $youtubeUrl, $matches)) {
                    $videoId = $matches[1];
                }
                ?>
                <?php if ($videoId): ?>
                    <iframe src="https://www.youtube.com/embed/<?= e($videoId) ?>" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =============================================
     CTA FINAL
     ============================================= -->
<section class="cta-section">
    <div class="container">
        <div class="reveal">
            <h2><?= e(pageContent('home', 'cta', 'title', 'Pronto para criar algo')) ?> <span class="text-gradient"><?= e(pageContent('home', 'cta', 'title_highlight', 'incrível')) ?></span><?= e(pageContent('home', 'cta', 'title_suffix', '?')) ?></h2>
            <p><?= e(pageContent('home', 'cta', 'description', 'Entre em contato e transforme sua ideia em realidade. Orçamento sem compromisso!')) ?></p>
            <div class="hero-actions" style="justify-content: center;">
                <a href="<?= whatsappLink(setting('site_whatsapp'), 'Olá! Gostaria de solicitar um orçamento personalizado.') ?>" target="_blank" class="btn btn-primary btn-lg">
                    <?= e(pageContent('home', 'cta', 'btn_primary', 'Solicitar Orçamento')) ?>
                </a>
                <a href="<?= baseUrl('catalogo') ?>" class="btn btn-secondary btn-lg"><?= e(pageContent('home', 'cta', 'btn_secondary', 'Ver Catálogo')) ?></a>
            </div>
        </div>
    </div>
</section>
