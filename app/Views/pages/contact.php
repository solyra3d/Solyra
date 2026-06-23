<!-- Contato Section -->
<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title"><?= e(pageContent('contact', 'hero', 'title', 'Fale')) ?> <span class="text-gradient"><?= e(pageContent('contact', 'hero', 'title_highlight', 'Conosco')) ?></span></h1>
        <p class="page-hero-desc"><?= e(pageContent('contact', 'hero', 'subtitle', 'Estamos prontos para atender você. Escolha o canal de sua preferência.')) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <!-- Info -->
            <div class="contact-info">
                <h2 class="section-title" style="font-size: var(--text-xl);">Informações de Contato</h2>

                <div class="contact-item">
                    <div class="contact-item-icon">📱</div>
                    <div>
                        <strong>WhatsApp</strong>
                        <p><?= setting('site_whatsapp', '(11) 99999-9999') ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-item-icon">✉️</div>
                    <div>
                        <strong>E-mail</strong>
                        <p><?= setting('site_email', 'contato@solyra.com.br') ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-item-icon">📍</div>
                    <div>
                        <strong>Endereço</strong>
                        <p><?= setting('site_address', 'São Paulo, SP') ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-item-icon">🕐</div>
                    <div>
                        <strong>Horário de Atendimento</strong>
                        <p><?= setting('site_hours', 'Seg a Sex: 9h às 18h') ?></p>
                    </div>
                </div>

                <!-- Redes Sociais -->
                <div class="contact-socials">
                    <h3 style="font-size: var(--text-sm); color: var(--color-text-muted); margin-bottom: var(--space-3);">REDES SOCIAIS</h3>
                    <div class="flex gap-3">
                        <?php if ($instagram = setting('social_instagram')): ?>
                            <a href="<?= e($instagram) ?>" target="_blank" class="contact-social-link" title="Instagram">📸</a>
                        <?php endif; ?>
                        <?php if ($facebook = setting('social_facebook')): ?>
                            <a href="<?= e($facebook) ?>" target="_blank" class="contact-social-link" title="Facebook">👍</a>
                        <?php endif; ?>
                        <?php if ($tiktok = setting('social_tiktok')): ?>
                            <a href="<?= e($tiktok) ?>" target="_blank" class="contact-social-link" title="TikTok">🎵</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- CTA WhatsApp -->
            <div class="contact-cta-card">
                <div class="contact-cta-icon">💬</div>
                <h3>Atendimento Rápido via WhatsApp</h3>
                <p>O jeito mais fácil e rápido de falar com a gente. Resposta em minutos!</p>
                <a href="<?= whatsappLink(setting('site_whatsapp'), 'Olá! Vim pelo site da SOLYRA e gostaria de mais informações.') ?>" target="_blank" class="btn btn-primary btn-lg" style="width:100%; margin-top: var(--space-4);">
                    Iniciar Conversa no WhatsApp
                </a>
                <p style="font-size: var(--text-xs); color: var(--color-text-muted); margin-top: var(--space-3);">
                    Atendimento <?= setting('site_hours', 'Seg a Sex: 9h às 18h') ?>
                </p>
            </div>
        </div>
    </div>
</section>
