class CartPage {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.init();
    }
    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initializeComponents());
        } else {
            this.initializeComponents()
        }
    }
    initializeComponents () {
        this.cart = new CartManager(this.csrfToken);
    }
}

class CartManager {
    constructor(csrfToken) {
        this.csrfToken = csrfToken;
        this.initializeElements();
        this.bindEvents();
    }

    initializeElements() {
        this.totalElement = document.getElementById('cart-total-amount');
        this.totalCart = document.getElementById('cart-total');
        this.formUpdateQuantity = document.querySelectorAll('.cart-update-form');
        this.deleteButtons = document.querySelectorAll('.btn-delete-cart-item');
        this.cartCount =  document.querySelector('#cart-count');
    }

    bindEvents() {
        this.formUpdateQuantity.forEach(form => this.updateQuantity(form));
        this.deleteButtons.forEach(button => this.deleteCart(button));
    }

    updateQuantity(form) {
        const productId = form.dataset.id;
        const input = form.querySelector('.quantity-input');
        const btns = form.querySelectorAll('.btn-change-qty');

        btns.forEach((btn) => {
            btn.addEventListener('click', () => {
                let quantity = parseInt(input.value) || 1;
                const delta = parseInt(btn.dataset.delta);
                quantity += delta;
                if (quantity < 1) quantity = 1;
                input.value = quantity;
                this.submitUpdateCart(productId, quantity);
            });
        });

        input.addEventListener('change', () => {
            let quantity = parseInt(input.value) || 1;
            if (quantity < 1) quantity = 1;
            input.value = quantity;
            this.submitUpdateCart(productId, quantity);
        });
    }

    async submitUpdateCart(productId, quantity) {
        try {
            const response = await fetch(`/cart/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({ quantity })
            });

            const result = await response.json();

            if (response.ok && result.success) {
                const totalValue = result.data.total || 0;
                this.totalElement.innerText = totalValue + 'đ';
                this.totalCart.innerText = totalValue + 'đ';
            }
        } catch (error) {
            console.error('Cập nhật giỏ hàng lỗi:', error);
            alert('❌ Không thể cập nhật giỏ hàng. Vui lòng thử lại.');
        }
    }

    deleteCart(button) {
        button.addEventListener('click', async () => {
            const productId = button.dataset.id;
            if (confirm('Bạn có chắc muốn xoá sản phẩm này?')) {
                try {
                    const response = await fetch(`/cart/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        },
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        button.closest('.cart-item').remove();
                        this.cartCount.innerText = result.data.cartCount;
                        const totalValue = result.data.total || 0;
                        this.totalElement.innerText = totalValue + 'đ';
                        this.totalCart.innerText = totalValue + 'đ';
                        if (document.querySelectorAll('.cart-item').length === 0) {
                            location.reload();
                        }
                    }
                } catch (error) {
                    console.error('Cập nhật giỏ hàng lỗi:', error);
                    alert('❌ Không thể cập nhật giỏ hàng. Vui lòng thử lại.');
                }
            }
        });
    }
}

new CartPage();
