<!-- Sobre Section -->
<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title"><?= e(pageContent('about', 'hero', 'title', 'Sobre a')) ?> <span class="text-gradient"><?= e(pageContent('about', 'hero', 'title_highlight', 'SOLYRA')) ?></span></h1>
        <p class="page-hero-desc"><?= e(pageContent('about', 'hero', 'subtitle', 'Transformando ideias em experiências únicas através de brindes personalizados, luminárias decorativas e peças exclusivas.')) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="about-grid">
            <div class="about-content">
                <h2 class="section-title"><?= e(pageContent('about', 'content', 'title', 'Quem Somos')) ?></h2>
                <p><?= e(pageContent('about', 'content', 'paragraph1', 'A SOLYRA nasceu da paixão por criar produtos únicos que encantam e surpreendem.')) ?></p>
                <p><?= e(pageContent('about', 'content', 'paragraph2', 'Cada produto é desenvolvido com atenção aos detalhes, utilizando tecnologia de ponta e materiais de alta qualidade.')) ?></p>
                <p><?= e(pageContent('about', 'content', 'paragraph3', 'Nossa missão é oferecer soluções criativas e inovadoras que fortaleçam marcas, celebrem momentos especiais e transformem ambientes.')) ?></p>
            </div>
            <div class="about-image">
                <?php $aboutImage = pageContent('about', 'content', 'image'); ?>
                <?php if ($aboutImage): ?>
                    <img src="<?= e(baseUrl($aboutImage)) ?>" alt="SOLYRA" style="width:100%; border-radius:12px; object-fit:cover;">
                <?php else: ?>
                    <div class="about-image-placeholder">
                        <span class="text-gradient" style="font-size: 4rem;">✦</span>
                        <p>Criatividade & Inovação</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Diferenciais (Dinâmico) -->
        <?php if (!empty($aboutFeatures)): ?>
        <div class="about-features">
            <?php foreach ($aboutFeatures as $feature): ?>
                <div class="about-feature">
                    <div class="about-feature-icon"><?= $feature['icon'] ?></div>
                    <h3><?= e($feature['title']) ?></h3>
                    <p><?= e($feature['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Galeria da Empresa -->
<?php if (!empty($gallery)): ?>
<section class="section" style="background: var(--color-bg-secondary); border-top: 1px solid var(--color-border);">
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

<!-- YouTube Video -->
<?php $youtubeUrl = setting('site_youtube'); ?>
<?php if ($youtubeUrl): ?>
<section class="section">
    <div class="container">
        <div class="text-center reveal">
            <h2 class="section-title">Veja em <span class="text-gradient">Ação</span></h2>
        </div>
        <div class="reveal" style="max-width: 800px; margin: 0 auto;">
            <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius: 12px; border: 1px solid var(--color-border);">
                <?php
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

<!-- CTA -->
<section class="section section-cta">
    <div class="container text-center">
        <h2><?= e(pageContent('about', 'cta', 'title', 'Pronto para criar algo incrível?')) ?></h2>
        <p style="color: var(--color-text-muted); margin-bottom: var(--space-6);"><?= e(pageContent('about', 'cta', 'description', 'Entre em contato e vamos transformar sua ideia em realidade.')) ?></p>
        <a href="<?= whatsappLink(setting('site_whatsapp'), 'Olá! Gostaria de saber mais sobre os produtos da SOLYRA.') ?>" target="_blank" class="btn btn-primary btn-lg">
            <?= e(pageContent('about', 'cta', 'btn_text', 'Falar no WhatsApp')) ?>
        </a>
    </div>
</section>
