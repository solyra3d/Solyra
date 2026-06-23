<!-- Gallery Admin -->
<div class="admin-section">
    <!-- Upload Form -->
    <form action="<?= baseUrl('admin/galeria') ?>" method="POST" enctype="multipart/form-data" class="admin-form" style="margin-bottom: var(--space-8);">
        <?= csrfField() ?>
        <div class="admin-settings-group">
            <h3 class="admin-settings-title">Adicionar Fotos</h3>
            <div class="form-group">
                <input type="file" name="photos[]" class="form-control" accept="image/*" multiple required>
                <small style="color: var(--color-text-muted); margin-top: 4px; display: block;">Selecione uma ou mais fotos. Formatos: JPG, PNG, WEBP.</small>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </form>

    <!-- Gallery Grid -->
    <h3 class="admin-section-title">Fotos da Galeria (<?= count($photos) ?>)</h3>

    <?php if (empty($photos)): ?>
        <p style="text-align:center; color: var(--color-text-muted); padding: var(--space-8);">Nenhuma foto na galeria.</p>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: var(--space-4);">
            <?php foreach ($photos as $photo): ?>
                <div style="position:relative; border-radius: 8px; overflow:hidden; border: 1px solid var(--color-border);">
                    <img src="<?= e(baseUrl($photo['image_path'])) ?>" alt="<?= e($photo['caption']) ?>" style="width:100%; aspect-ratio:1; object-fit:cover;" loading="lazy">
                    <?php if ($photo['caption']): ?>
                        <div style="padding: var(--space-2); font-size: var(--text-xs); color: var(--color-text-muted);"><?= e($photo['caption']) ?></div>
                    <?php endif; ?>
                    <form action="<?= baseUrl('admin/galeria/deletar/' . $photo['id']) ?>" method="POST" style="position:absolute; top:8px; right:8px;">
                        <?= csrfField() ?>
                        <button type="submit" onclick="return confirm('Remover esta foto?')" style="background:rgba(0,0,0,0.7); color:#fff; border:none; border-radius:50%; width:28px; height:28px; cursor:pointer; font-size:16px;">&times;</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
