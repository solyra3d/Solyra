<!-- Editar Footer e Contato -->
<div class="admin-section">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: var(--space-6);">
        <a href="<?= baseUrl('admin/paginas') ?>" class="btn btn-ghost">&larr; Voltar</a>
    </div>

    <form action="<?= baseUrl('admin/paginas/footer') ?>" method="POST" class="admin-form">
        <?= csrfField() ?>

        <!-- Footer -->
        <?php foreach ($sections as $sectionKey => $section): ?>
            <div class="admin-settings-group">
                <h3 class="admin-settings-title"><?= e($section['label']) ?></h3>
                <div class="admin-form-grid">
                    <?php foreach ($section['fields'] as $fieldKey => $field): ?>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="footer_<?= $fieldKey ?>" class="form-label"><?= e($field['label']) ?></label>
                            <textarea id="footer_<?= $fieldKey ?>" name="<?= $sectionKey ?>[<?= $fieldKey ?>]" class="form-control" rows="3"><?= e($contents[$sectionKey][$fieldKey] ?? '') ?></textarea>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Contato -->
        <?php foreach ($contactSections as $sectionKey => $section): ?>
            <div class="admin-settings-group">
                <h3 class="admin-settings-title"><?= e($section['label']) ?></h3>
                <div class="admin-form-grid">
                    <?php foreach ($section['fields'] as $fieldKey => $field): ?>
                        <div class="form-group">
                            <label for="contact_<?= $fieldKey ?>" class="form-label"><?= e($field['label']) ?></label>
                            <input type="text" id="contact_<?= $fieldKey ?>" name="contact_hero[<?= $fieldKey ?>]" class="form-control" value="<?= e($contactContents[$sectionKey][$fieldKey] ?? '') ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="admin-form-actions" style="position:sticky; bottom:0; background:var(--color-bg); padding:var(--space-4) 0; border-top: 1px solid var(--color-border);">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="<?= baseUrl('admin/paginas') ?>" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>
