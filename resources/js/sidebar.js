document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('closeSidebar');

    if (!sidebar) return;

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');

        if (overlay) {
            overlay.classList.remove('hidden');
        }
    }

    function closeSidebar() {
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');

        if (overlay) {
            overlay.classList.add('hidden');
        }
    }

    // Hamburger
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });
    }

    // Tombol X
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            closeSidebar();
        });
    }

    // Klik area luar sidebar
    if (overlay) {
        overlay.addEventListener('click', function () {
            closeSidebar();
        });
    }

    // Kondisi awal
    if (window.innerWidth >= 1024) {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');

        if (overlay) {
            overlay.classList.add('hidden');
        }
    } else {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');

        if (overlay) {
            overlay.classList.add('hidden');
        }
    }

    // Saat resize
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');

            if (overlay) {
                overlay.classList.add('hidden');
            }
        } else {
            closeSidebar();
        }
    });
});