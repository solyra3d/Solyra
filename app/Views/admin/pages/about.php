<!-- Editar Sobre -->
<div class="admin-section">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: var(--space-6);">
        <a href="<?= baseUrl('admin/paginas') ?>" class="btn btn-ghost">&larr; Voltar</a>
    </div>

    <form action="<?= baseUrl('admin/paginas/sobre') ?>" method="POST" enctype="multipart/form-data" class="admin-form">
        <?= csrfField() ?>

        <?php foreach ($sections as $sectionKey => $section): ?>
            <div class="admin-settings-group">
                <h3 class="admin-settings-title"><?= e($section['label']) ?></h3>
                <div class="admin-form-grid">
                    <?php foreach ($section['fields'] as $fieldKey => $field): ?>
                        <div class="form-group" <?= $field['type'] === 'textarea' ? 'style="grid-column: 1 / -1;"' : '' ?>>
                            <label for="<?= $sectionKey ?>_<?= $fieldKey ?>" class="form-label"><?= e($field['label']) ?></label>
                            <?php if ($field['type'] === 'textarea'): ?>
                                <textarea id="<?= $sectionKey ?>_<?= $fieldKey ?>" name="<?= $sectionKey ?>[<?= $fieldKey ?>]" class="form-control" rows="3"><?= e($contents[$sectionKey][$fieldKey] ?? '') ?></textarea>
                            <?php else: ?>
                                <input type="text" id="<?= $sectionKey ?>_<?= $fieldKey ?>" name="<?= $sectionKey ?>[<?= $fieldKey ?>]" class="form-control" value="<?= e($contents[$sectionKey][$fieldKey] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Upload de imagem da página Sobre -->
        <div class="admin-settings-group">
            <h3 class="admin-settings-title">Imagem do Sobre</h3>
            <div class="form-group">
                <?php $currentImage = $contents['content']['image'] ?? ''; ?>
                <?php if ($currentImage): ?>
                    <div style="margin-bottom: var(--space-3);">
                        <img src="<?= e(baseUrl($currentImage)) ?>" alt="Imagem Sobre" style="max-width:200px; border-radius:8px; border: 1px solid var(--color-border);">
                    </div>
                <?php endif; ?>
                <input type="file" name="about_image" class="form-control" accept="image/*">
                <small style="color: var(--color-text-muted); margin-top: 4px; display: block;">Imagem que aparece na seção "Quem Somos"</small>
            </div>
        </div>

        <div class="admin-form-actions" style="position:sticky; bottom:0; background:var(--color-bg); padding:var(--space-4) 0; border-top: 1px solid var(--color-border);">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="<?= baseUrl('admin/paginas') ?>" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
