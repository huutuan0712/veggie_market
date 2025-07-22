class ProductManager {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.init();
    }

    init()
    {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded',()=> this.initializeComponents())
        } else {
            this.initializeComponents();
        }
    }

    initializeComponents()
    {
        this.wishlist = new WishListManager(this.csrfToken);
    }
}
class WishListManager {
    constructor(csrfToken) {
        this.csrfToken = csrfToken;
        this.initializeElements();
        this.bindEvents();
    }

    initializeElements()
    {
        this.badge = document.getElementById('farovites-count');
        this.buttons = document.querySelectorAll('[data-favorite-btn]');
    }

    bindEvents() {
        this.buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                const productId = button.getAttribute('data-product-id');
                this.toggleFavorite(productId, button);
            })
        })
    }

    toggleFavorite(productId, btnElement)
    {
        fetch('/wishlist/toggle',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN' : this.csrfToken
            },
            body: JSON.stringify({product_id: productId})
        })
            .then(response => response.json())
            .then(data => {
                if (this.badge) {
                    this.badge.textContent = data.count;
                }
                if (btnElement) {
                    btnElement.classList.toggle('bg-red-500');
                    btnElement.classList.toggle('text-white');
                    btnElement.classList.toggle('hover:bg-red-600');
                    btnElement.classList.toggle('bg-white/90');
                    btnElement.classList.toggle('text-gray-600');
                    btnElement.classList.toggle('hover:bg-white');
                    btnElement.classList.toggle('hover:text-red-500');
                }
            })
            .catch(error => console.log('Error:', error))
    }
}
new ProductManager();
