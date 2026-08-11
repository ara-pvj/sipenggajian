document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('closeSidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (!sidebar) return;
    
    // Toggle sidebar
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (sidebar.classList.contains('sidebar-open')) {
                // Tutup
                sidebar.classList.remove('sidebar-open');
                sidebar.classList.add('sidebar-closed');
                if (overlay) overlay.classList.add('hidden');
                if (mainContent && window.innerWidth < 1024) {
                    mainContent.style.marginLeft = '0';
                }
            } else {
                // Buka
                sidebar.classList.remove('sidebar-closed');
                sidebar.classList.add('sidebar-open');
                if (overlay) overlay.classList.remove('hidden');
                if (mainContent && window.innerWidth >= 1024) {
                    mainContent.style.marginLeft = sidebar.offsetWidth + 'px';
                }
            }
        });
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            sidebar.classList.remove('sidebar-open');
            sidebar.classList.add('sidebar-closed');
            if (overlay) overlay.classList.add('hidden');
            if (mainContent && window.innerWidth < 1024) {
                mainContent.style.marginLeft = '0';
            }
        });
    }
    
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('sidebar-open');
            sidebar.classList.add('sidebar-closed');
            overlay.classList.add('hidden');
            if (mainContent && window.innerWidth < 1024) {
                mainContent.style.marginLeft = '0';
            }
        });
    }
    
    // Init - untuk desktop sidebar terbuka
    if (window.innerWidth >= 1024) {
        sidebar.classList.add('sidebar-open');
        sidebar.classList.remove('sidebar-closed');
        if (mainContent) {
            mainContent.style.marginLeft = sidebar.offsetWidth + 'px';
        }
    } else {
        sidebar.classList.add('sidebar-closed');
        sidebar.classList.remove('sidebar-open');
        if (mainContent) {
            mainContent.style.marginLeft = '0';
        }
    }
    
    // Handle resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            sidebar.classList.add('sidebar-open');
            sidebar.classList.remove('sidebar-closed');
            if (overlay) overlay.classList.add('hidden');
            if (mainContent) {
                mainContent.style.marginLeft = sidebar.offsetWidth + 'px';
            }
        } else {
            if (!sidebar.classList.contains('sidebar-open')) {
                sidebar.classList.add('sidebar-closed');
                sidebar.classList.remove('sidebar-open');
            }
            if (mainContent) {
                mainContent.style.marginLeft = '0';
            }
        }
    });
});