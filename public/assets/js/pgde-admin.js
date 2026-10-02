(() => {
    const body = document.body;
    const desktopQuery = window.matchMedia('(min-width: 992px)');
    const storageKey = 'pgde-admin-sidebar-collapsed';
    const sidebar = document.getElementById('pgdeAdminSidebar');
    const toggles = document.querySelectorAll('[data-admin-sidebar-toggle]');
    const closeButtons = document.querySelectorAll('[data-admin-sidebar-close]');
    const settingsToggles = document.querySelectorAll('[data-admin-settings-toggle]');

    const updateControls = () => {
        const expanded = desktopQuery.matches
            ? !body.classList.contains('pgde-sidebar-collapsed')
            : body.classList.contains('pgde-sidebar-open');
        if (sidebar) {
            const hidden = !desktopQuery.matches && !expanded;
            sidebar.setAttribute('aria-hidden', String(hidden));
            sidebar.inert = hidden;
        }
        toggles.forEach((button) => {
            button.setAttribute('aria-expanded', String(expanded));
            button.setAttribute('aria-label', desktopQuery.matches
                ? (expanded ? 'Réduire le menu' : 'Agrandir le menu')
                : (expanded ? 'Fermer le menu' : 'Ouvrir le menu'));
            const label = button.querySelector('.pgde-admin-collapse-text');
            if (label) {
                label.textContent = desktopQuery.matches
                    ? (expanded ? 'Réduire le menu' : 'Agrandir le menu')
                    : (expanded ? 'Fermer le menu' : 'Ouvrir le menu');
            }
        });
    };

    const setDesktopCollapsed = (collapsed) => {
        body.classList.toggle('pgde-sidebar-collapsed', collapsed);
        try { localStorage.setItem(storageKey, collapsed ? 'true' : 'false'); } catch (_) {}
    };

    try {
        if (desktopQuery.matches && localStorage.getItem(storageKey) === 'true') {
            body.classList.add('pgde-sidebar-collapsed');
        }
    } catch (_) {}

    toggles.forEach((button) => button.addEventListener('click', () => {
        if (desktopQuery.matches) {
            setDesktopCollapsed(!body.classList.contains('pgde-sidebar-collapsed'));
        } else {
            body.classList.toggle('pgde-sidebar-open');
        }
        updateControls();
    }));

    settingsToggles.forEach((button) => button.addEventListener('click', () => {
        const expanded = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', String(!expanded));
        const submenu = document.getElementById(button.getAttribute('aria-controls'));
        if (submenu) submenu.classList.toggle('is-open', !expanded);
    }));

    closeButtons.forEach((button) => button.addEventListener('click', () => {
        body.classList.remove('pgde-sidebar-open');
        updateControls();
    }));

    document.querySelectorAll('a.pgde-admin-nav-link').forEach((link) => link.addEventListener('click', () => {
        if (!desktopQuery.matches) body.classList.remove('pgde-sidebar-open');
        updateControls();
    }));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            body.classList.remove('pgde-sidebar-open');
            updateControls();
        }
    });

    desktopQuery.addEventListener('change', () => {
        body.classList.remove('pgde-sidebar-open');
        if (desktopQuery.matches) {
            try { body.classList.toggle('pgde-sidebar-collapsed', localStorage.getItem(storageKey) === 'true'); } catch (_) {}
        }
        updateControls();
    });

    updateControls();
})();
