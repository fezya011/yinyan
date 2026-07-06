const sidebar = document.getElementById('adminSidebar');
const overlay = document.getElementById('sidebarOverlay');
const toggleBtn = document.getElementById('sidebarToggle');

function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}
function toggleSidebar() {
    sidebar.classList.contains('open') ? closeSidebar() : (sidebar.classList.add('open'), overlay.classList.add('active'), document.body.style.overflow = 'hidden');
}

toggleBtn?.addEventListener('click', toggleSidebar);
overlay?.addEventListener('click', closeSidebar);
document.addEventListener('keydown', e => { if (e.key === 'Escape' && sidebar.classList.contains('open')) closeSidebar(); });
window.addEventListener('resize', () => { if (window.innerWidth > 768) closeSidebar(); });
