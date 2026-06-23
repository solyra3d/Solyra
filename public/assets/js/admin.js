/**
 * SOLYRA - Admin JavaScript
 * Sidebar toggle, slug generation, image preview, confirmations
 */

(function() {
    'use strict';

    // Sidebar toggle (mobile)
    const toggleBtn = document.getElementById('toggle-sidebar');
    const sidebar = document.getElementById('admin-sidebar');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }

    // Auto-generate slug from name
    const nameInput = document.getElementById('product-name') || document.getElementById('category-name');
    const slugInput = document.getElementById('product-slug') || document.getElementById('category-slug');

    if (nameInput && slugInput) {
        let slugManuallyEdited = slugInput.value.length > 0;

        nameInput.addEventListener('input', function() {
            if (!slugManuallyEdited) {
                slugInput.value = generateSlug(this.value);
            }
        });

        slugInput.addEventListener('input', function() {
            slugManuallyEdited = this.value.length > 0;
        });
    }

    function generateSlug(text) {
        return text
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    // Delete confirmation
    document.querySelectorAll('[data-confirm]').forEach(function(el) {
        el.addEventListener('click', function(e) {
            if (!confirm(this.dataset.confirm || 'Tem certeza que deseja excluir?')) {
                e.preventDefault();
            }
        });
    });

    // Image preview on upload
    const imageInput = document.getElementById('product-images') || document.getElementById('image-input');
    const previewContainer = document.getElementById('image-preview');

    if (imageInput && previewContainer) {
        imageInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            
            Array.from(this.files).forEach(function(file) {
                if (!file.type.startsWith('image/')) return;
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'admin-image-item';
                    div.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });
    }

    // Flash message auto-dismiss
    document.querySelectorAll('.admin-flash').forEach(function(flash) {
        setTimeout(function() {
            flash.style.opacity = '0';
            flash.style.transition = 'opacity 0.3s';
            setTimeout(function() { flash.remove(); }, 300);
        }, 5000);
    });

})();
