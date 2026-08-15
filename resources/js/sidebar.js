document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('closeSidebar');

    if (!sidebar) return;

    function openSidebar() {
        sidebar.style.transform = 'translateX(0)';

        if (overlay) {
            overlay.classList.remove('hidden');
        }
    }

    function closeSidebar() {
        sidebar.style.transform = 'translateX(-100%)';

        if (overlay) {
            overlay.classList.add('hidden');
        }
    }

    // Kondisi awal
    if (window.innerWidth >= 1024) {
        openSidebar();
    } else {
        closeSidebar();
    }

    // Hamburger
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (window.innerWidth < 1024) {
                const isOpen = sidebar.style.transform === 'translateX(0px)' ||
                               sidebar.style.transform === 'translateX(0)';

                if (isOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }
        });
    }

    // Tombol X
    if (closeBtn) {
        closeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            closeSidebar();
        });
    }

    // Klik overlay
    if (overlay) {
        overlay.addEventListener('click', function () {
            closeSidebar();
        });
    }

    // Resize
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) {
            openSidebar();
        } else {
            closeSidebar();
        }
    });
});