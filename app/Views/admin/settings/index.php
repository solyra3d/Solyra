<!-- Settings Page -->
<form action="<?= baseUrl('admin/configuracoes') ?>" method="POST" enctype="multipart/form-data" class="admin-form">
    <?= csrfField() ?>

    <?php foreach ($settingGroups as $groupName => $fields): ?>
        <div class="admin-settings-group">
            <h3 class="admin-settings-title"><?= e($groupName) ?></h3>
            <div class="admin-form-grid">
                <?php foreach ($fields as $key => $config): ?>
                    <div class="form-group" <?= in_array($config['type'], ['textarea', 'file']) ? 'style="grid-column: 1 / -1;"' : '' ?>>
                        <label for="setting-<?= $key ?>" class="form-label"><?= e($config['label']) ?></label>
                        <?php if ($config['type'] === 'textarea'): ?>
                            <textarea id="setting-<?= $key ?>" name="<?= $key ?>" class="form-control" rows="3"><?= e($settings[$key] ?? '') ?></textarea>
                        <?php elseif ($config['type'] === 'file'): ?>
                            <?php $currentFile = $settings[$key] ?? ''; $previewStyle = ($config['preview'] ?? 'circle') === 'rect' ? 'border-radius:8px; width:160px; height:100px; object-fit:cover;' : 'border-radius:50%; width:58px; height:58px; object-fit:contain;'; ?>
                            <?php if ($currentFile): ?>
                                <div style="margin-bottom: var(--space-3); display: flex; align-items: center; gap: var(--space-3);">
                                    <img src="<?= e(baseUrl($currentFile)) ?>" alt="Imagem atual" style="<?= $previewStyle ?> background: var(--color-surface); border: 2px solid var(--color-primary);">
                                    <span style="color: var(--color-text-muted); font-size: var(--text-sm);">Imagem atual</span>
                                </div>
                            <?php endif; ?>
                            <input type="file" id="setting-<?= $key ?>" name="<?= $key ?>" class="form-control" accept="image/*">
                            <?php if (($config['preview'] ?? 'circle') === 'rect'): ?>
                                <small style="color: var(--color-text-muted); margin-top: 4px; display: block;">Formatos: PNG, JPG, WEBP. Essa imagem aparece no lado direito da hero section na Home.</small>
                            <?php else: ?>
                                <small style="color: var(--color-text-muted); margin-top: 4px; display: block;">Formatos: PNG, JPG, WEBP. Recomendado: imagem quadrada para melhor resultado redondo.</small>
                            <?php endif; ?>
                        <?php else: ?>
                            <input type="<?= $config['type'] ?>" id="setting-<?= $key ?>" name="<?= $key ?>" class="form-control" value="<?= e($settings[$key] ?? '') ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Actions -->
    <div class="admin-form-actions" style="position:sticky; bottom:0; background:var(--color-bg); padding:var(--space-4) 0; border-top: 1px solid var(--color-border);">
        <button type="submit" class="btn btn-primary">Salvar Configurações</button>
    </div>
</form>
