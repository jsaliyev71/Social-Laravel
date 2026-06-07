document.addEventListener('click', (e) => {
    const btn = e.target.closest('.dropdown-btn');
    const menuClick = e.target.closest('.dropdownMenu');

    const openMenu = document.querySelector('.dropdownMenu.show');

    if (menuClick) return;

    if (btn) {
        const container = btn.closest('.dropdownContainer');
        const menu = container.querySelector('.dropdownMenu');

        if (openMenu && openMenu !== menu) {
            openMenu.classList.remove('show');
        }

        menu.classList.toggle('show');
        return;
    }

    if (openMenu) {
        openMenu.classList.remove('show');
    }
});