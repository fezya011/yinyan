// resources/js/admin/categories/form.js
function updatePreview() {
    const name = document.getElementById('name')?.value || 'Название категории';
    const slug = document.getElementById('slug')?.value || 'slug';
    const icon = document.getElementById('icon')?.value || '📁';
    const tag = document.getElementById('tag_prefix')?.value || 'Префикс тега';
    const desc = document.getElementById('description')?.value || 'Описание категории будет здесь';
    const isActive = document.getElementById('is_active')?.checked;

    const previewName = document.getElementById('previewName');
    const previewSlug = document.getElementById('previewSlug');
    const previewIcon = document.getElementById('previewIcon');
    const previewTag = document.getElementById('previewTag');
    const previewDesc = document.getElementById('previewDesc');
    const statusDot = document.getElementById('previewStatusDot');
    const statusText = document.getElementById('previewStatusText');

    if (previewName) previewName.textContent = name;
    if (previewSlug) previewSlug.textContent = slug;
    if (previewIcon) previewIcon.textContent = icon;
    if (previewTag) previewTag.textContent = tag || 'Префикс тега';
    if (previewDesc) previewDesc.textContent = desc || 'Описание категории будет здесь';

    if (statusDot && statusText) {
        if (isActive) {
            statusDot.className = 'dot active';
            statusText.textContent = 'Активна';
        } else {
            statusDot.className = 'dot inactive';
            statusText.textContent = 'Неактивна';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
});
