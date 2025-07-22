class HeaderMenuManager {
    constructor() {
        this.initializeElements();
        this.bindEvents();
    }

    initializeElements() {
        this.toggleButton = document.getElementById('mobileMenuToggle');
        this.menu = document.getElementById('mobileNav');
        this.menuIcon = document.getElementById('menuIcon');
        this.closeIcon = document.getElementById('closeIcon');
    }

    bindEvents() {
        this.toggleButton?.addEventListener('click', () => this.toggleMenu());
    }

    toggleMenu() {
        this.menu?.classList.toggle('hidden');
        this.menuIcon?.classList.toggle('hidden');
        this.closeIcon?.classList.toggle('hidden');
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new HeaderMenuManager());
} else {
    new HeaderMenuManager();
}
