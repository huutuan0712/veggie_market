class HomeManager {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.initializeElements();
        this.bindEvents();
    }

    initializeElements() {
        this.addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
        this.cartCount = document.getElementById('cart-count');
    }

    bindEvents() {
        this.addToCartButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const productId = button.dataset.id;
                const quantityInput = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
                const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
                this.addToCart(e, productId, quantity)
            })
        })
    }

    async addToCart(e, productId, quantity) {
        e.preventDefault();

        try {
            const response = await fetch("/cart", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            });

            const data = await response.json();

            if (data.success && this.cartCount && data.data.cartCount !== undefined) {
                this.cartCount.textContent = data.data.cartCount;
            }
        } catch (error) {
            console.error("Cart error:", error);
        }
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new HomeManager());
} else {
    new HomeManager();
}
