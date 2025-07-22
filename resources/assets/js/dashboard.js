class DashboardManager {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initializeComponents());
        } else {
            this.initializeComponents();
        }
    }

    initializeComponents() {
        new ProductManager(this.csrfToken);
        new CategoryManager(this.csrfToken);
        new TabManager()
    }
}

class BaseManager {
    constructor(csrfToken) {
        this.csrfToken = csrfToken;
    }

    toggleModal(modal, show) {
        modal.classList.toggle('hidden', !show);
        modal.classList.toggle('flex', show);
    }
}

class TabManager {
    constructor() {
        this.activeClass = ['border-orange-500', 'text-orange-600'];
        this.inactiveClass = ['border-transparent', 'text-gray-500', 'hover:text-gray-700'];
        this.initializeElements();
        this.bindEvents();

        // Kích hoạt tab đầu tiên nếu chưa có tab active
        this.ensureActiveTab();
    }

    initializeElements() {
        this.tabButtons = document.querySelectorAll('.tab-btn');
        this.tabPanes = document.querySelectorAll('.tab-pane');
    }

    bindEvents() {
        this.tabButtons.forEach(button => {
            button.addEventListener('click', () => this.switchTab(button));
        });
    }

    switchTab(activeButton) {
        const targetTab = activeButton.dataset.tab;
        if (!targetTab) return;

        // Reset tất cả tab buttons
        this.tabButtons.forEach(btn => {
            btn.classList.remove(...this.activeClass);
            btn.classList.add(...this.inactiveClass);
        });

        // Reset tất cả panes
        this.tabPanes.forEach(pane => pane.classList.add('hidden'));

        // Active tab được click
        activeButton.classList.remove(...this.inactiveClass);
        activeButton.classList.add(...this.activeClass);

        // Show content tương ứng
        const targetPane = document.querySelector(`.tab-pane[data-content="${targetTab}"]`);
        targetPane?.classList.remove('hidden');
    }

    ensureActiveTab() {
        const hasActive = [...this.tabButtons].some(btn =>
            btn.classList.contains(this.activeClass[0])
        );
        if (!hasActive && this.tabButtons.length > 0) {
            this.switchTab(this.tabButtons[0]); // Active tab đầu tiên
        }
    }
}


class ProductManager extends BaseManager {
    constructor(csrfToken) {
        super(csrfToken);
        this.initializeElements();
        this.bindEvents();
    }

    initializeElements() {
        this.modal = document.getElementById('deleteProductModal');
        this.deleteForm = document.getElementById('deleteProductForm');
        this.buttons = document.querySelectorAll('[data-product-btn]');
        this.btnClose = document.getElementById('btn-close-product');
    }

    bindEvents() {
        this.buttons.forEach(button => {
            button.addEventListener('click', () => {
                const productId = button.dataset.productId;
                this.handleConfirmDelete(productId);
            });
        });

        this.btnClose?.addEventListener('click', () => this.handleCloseModal());
    }

    handleConfirmDelete(productId) {
        this.deleteForm.action = `/products/${productId}`;
        this.toggleModal(this.modal, true);
    }

    handleCloseModal() {
        this.toggleModal(this.modal, false);
    }
}

class CategoryManager extends BaseManager {
    constructor(csrfToken) {
        super(csrfToken);
        this.initializeElements();
        this.bindEvents();
    }

    initializeElements() {
        this.deleteForm = document.getElementById('deleteCategoryForm');
        this.modal = document.getElementById('deleteCategoryModal');
        this.buttons = document.querySelectorAll('[data-category-btn]');
        this.btnClose = document.getElementById('btn-close-category');
    }

    bindEvents() {
        this.buttons.forEach(button => {
            button.addEventListener('click', () => {
                const categoryId = button.dataset.categoryId;
                this.handleConfirmDelete(categoryId);
            });
        });

        this.btnClose?.addEventListener('click', () => this.handleCloseModal());
    }

    handleConfirmDelete(categoryId) {
        this.deleteForm.action = `/categories/${categoryId}`;
        this.toggleModal(this.modal, true);
    }

    handleCloseModal() {
        this.toggleModal(this.modal, false);
    }
}

new DashboardManager();
