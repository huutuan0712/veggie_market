/**
 * Product Page JavaScript - Refactored and Cleaned
 */

class ProductPageManager {
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
        this.cart = new CartManager(this.csrfToken);
        this.tabs = new TabManager();
        this.ratings = new RatingManager(this.csrfToken);
    }
}

class CartManager {
    constructor(csrfToken) {
        this.csrfToken = csrfToken;
        this.initializeElements();
        this.bindEvents();
    }

    initializeElements() {
        this.elements = {
            decreaseBtn: document.getElementById('decreaseQty'),
            increaseBtn: document.getElementById('increaseQty'),
            quantityInput: document.getElementById('quantity'),
            addToCartBtn: document.getElementById('addToCartBtn'),
            cartCount: document.getElementById('cart-count')
        };
    }

    bindEvents() {
        this.elements.decreaseBtn?.addEventListener('click', () => this.decreaseQuantity());
        this.elements.increaseBtn?.addEventListener('click', () => this.increaseQuantity());
        this.elements.addToCartBtn?.addEventListener('click', (e) => this.addToCart(e));
    }

    decreaseQuantity() {
        const qty = parseInt(this.elements.quantityInput.value);
        if (qty > 1) {
            this.elements.quantityInput.value = qty - 1;
        }
    }

    increaseQuantity() {
        const qty = parseInt(this.elements.quantityInput.value);
        this.elements.quantityInput.value = qty + 1;
    }

    async addToCart(e) {
        e.preventDefault();

        const productId = this.elements.addToCartBtn.dataset.productId;
        const quantity = parseInt(this.elements.quantityInput.value);

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

            if (data.success && this.elements.cartCount && data.data.cartCount !== undefined) {
                this.elements.cartCount.textContent = data.data.cartCount;
            }
        } catch (error) {
            console.error("Cart error:", error);
        }
    }
}

class TabManager {
    constructor() {
        this.activeClass = 'border-orange-500 text-orange-600';
        this.inactiveClass = 'border-transparent text-gray-500 hover:text-gray-700';
        this.initializeElements();
        this.bindEvents();
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
        const targetTab = activeButton.getAttribute('data-tab');

        // Remove active states from all tabs
        this.tabButtons.forEach(btn => {
            btn.classList.remove(...this.activeClass.split(' '));
            btn.classList.add(...this.inactiveClass.split(' '));
        });

        // Hide all tab panes
        this.tabPanes.forEach(pane => pane.classList.add('hidden'));

        // Activate selected tab
        activeButton.classList.remove(...this.inactiveClass.split(' '));
        activeButton.classList.add(...this.activeClass.split(' '));

        // Show selected tab pane
        const targetPane = document.querySelector(`.tab-pane[data-content="${targetTab}"]`);
        targetPane?.classList.remove('hidden');
    }
}

class RatingManager {
    constructor(csrfToken) {
        this.csrfToken = csrfToken;
        this.productId = null;
        this.initializeElements();
        this.bindEvents();
    }

    initializeElements() {
        this.elements = {
            form: document.getElementById('ratingForm'),
            container: document.getElementById('reviewsContainer'),
            ratingCount: document.getElementById('rating-count'),
            averageRating: document.getElementById('average-rating'),
            averageStars: document.getElementById('average-stars'),
            ratingDistribution: document.getElementById('rating-distribution'),
            editModal: document.getElementById('editRatingModal'),
            deleteModal: document.getElementById('deleteRatingModal')
        };

        if (this.elements.form) {
            this.productId = this.elements.form.querySelector('[name="product_id"]')?.value;
        }
    }

    bindEvents() {
        if (this.elements.form) {
            this.elements.form.addEventListener('submit', (e) => this.submitRating(e));
            this.loadRatings();
        }

        // Event delegation for dynamic content
        document.addEventListener('click', (e) => this.handleDynamicEvents(e));
    }

    async loadRatings() {
        if (!this.productId) return;

        try {
            const response = await fetch(`/ratings/${this.productId}`, {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });

            const result = await response.json();
            this.renderRatings(result);
        } catch (error) {
            console.error('Error loading ratings:', error);
        }
    }

    renderRatings(result) {
        if (!result.success || !result.data) return;

        const { ratings, averageRating, totalRatings, ratingDistribution, ratingCount } = result.data;

        // Update rating count
        if (this.elements.ratingCount) {
            this.elements.ratingCount.innerHTML = `${ratingCount} đánh giá`;
        }

        // Render reviews
        this.renderReviews(ratings);

        // Update average rating display
        this.updateAverageRating(averageRating, totalRatings);

        // Update rating distribution
        this.updateRatingDistribution(ratingDistribution);
    }

    renderReviews(ratings) {
        if (!this.elements.container) return;

        if (!ratings || ratings.length === 0) {
            this.elements.container.innerHTML = '<p class="text-gray-500 italic">Chưa có đánh giá nào cho sản phẩm này.</p>';
            return;
        }

        this.elements.container.innerHTML = ratings.map(review => this.createReviewHTML(review)).join('');
    }

    createReviewHTML(review) {
        const stars = this.generateStarsHTML(review.rating);
        const userAvatar = review.userAvatar || 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=100';

        return `
            <div class="list-rating p-6">
                <div class="flex items-start space-x-4">
                    <img src="${userAvatar}" alt="${review.userName || 'Người dùng'}" class="w-12 h-12 rounded-full object-cover">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h5 class="font-semibold text-gray-900">${review.userName || 'Người dùng'}</h5>
                                <div class="flex items-center space-x-2">
                                    <div class="flex items-center space-x-1">${stars}</div>
                                    <span class="text-gray-500 text-sm">${review.date || ''}</span>
                                </div>
                            </div>
                            ${this.createDropdownMenu(review)}
                        </div>
                        <p class="text-gray-600 mb-4">${review.comment || ''}</p>
                        <div class="flex items-center space-x-4">
                            <button class="flex items-center space-x-1 text-gray-500 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3"/>
                                </svg>
                                <span class="text-sm">Thích (${review.helpful || 0})</span>
                            </button>
                            <button class="reply-btn flex items-center space-x-1 text-orange-600 hover:text-orange-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 14l-4 -4l4 -4"/><path d="M5 10h11a4 4 0 1 1 0 8h-1"/>
                                </svg>
                                <span class="text-sm">Trả lời</span>
                            </button>
                        </div>
                    </div>
                </div>
                ${this.createReplyForm(review.id)}
                <div class="replies mt-4 ml-12 space-y-2"></div>
            </div>
        `;
    }

    generateStarsHTML(rating) {
        return Array.from({ length: 5 }).map((_, i) => {
            const color = i < rating ? 'text-yellow-400 fill-current' : 'text-gray-300';
            return `
                <svg class="h-4 w-4 ${color}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.284 3.943h4.14c.969 0 1.371 1.24.588 1.81l-3.356 2.44 1.285 3.943c.3.921-.755 1.688-1.539 1.118L10 13.348l-3.356 2.44c-.784.57-1.838-.197-1.539-1.118l1.285-3.943-3.356-2.44c-.783-.57-.38-1.81.588-1.81h4.14l1.284-3.943z"/>
                </svg>
            `;
        }).join('');
    }

    createDropdownMenu(review) {
        return `
            <div class="dropdown">
                <div tabindex="0" class="btn btn-ghost btn-sm px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                    </svg>
                </div>
                <ul tabindex="0" class="menu dropdown-content bg-base-100 rounded-box z-10 w-52 p-2 shadow-sm">
                    <li>
                        <span class="edit-rating-btn" data-rating-id="${review.id}" data-comment="${review.comment || ''}" data-stars="${review.rating}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/>
                            </svg>
                            Sửa
                        </span>
                    </li>
                    <li>
                        <a href="#" class="delete-rating-btn" data-rating-id="${review.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                            Xóa
                        </a>
                    </li>
                </ul>
            </div>
        `;
    }

    createReplyForm(reviewId) {
        return `
            <div class="reply-form hidden bg-gray-50 rounded-lg p-4 mt-4">
                <textarea class="textarea textarea-bordered w-full" placeholder="Nhập câu trả lời của bạn..."></textarea>
                <div class="mt-2 flex justify-end space-x-2">
                    <button class="submit-reply btn bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300" data-parent-id="${reviewId}">Gửi</button>
                </div>
            </div>
        `;
    }

    updateAverageRating(average, total) {
        if (this.elements.averageRating) {
            this.elements.averageRating.textContent = (average || 0).toFixed(1);
        }

        if (this.elements.averageStars) {
            this.elements.averageStars.innerHTML = this.generateStarsHTML(Math.floor(average || 0));
        }

        if (this.elements.ratingCount) {
            this.elements.ratingCount.textContent = `(${total || 0}) đánh giá`;
        }
    }

    updateRatingDistribution(distribution) {
        if (!this.elements.ratingDistribution || !distribution) return;

        this.elements.ratingDistribution.innerHTML = distribution.map(item => `
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600 w-8">${item.rating}★</span>
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-400 h-2 rounded-full" style="width: ${item.percentage}%"></div>
                </div>
                <span class="text-sm text-gray-600 w-8">${item.count}</span>
            </div>
        `).join('');
    }

    async submitRating(e) {
        e.preventDefault();

        const formData = new FormData(this.elements.form);
        const rating = formData.get('rating');
        const comment = formData.get('comment');

        if (!rating) {
            alert('Vui lòng chọn số sao đánh giá');
            return;
        }

        try {
            const response = await fetch("/ratings", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    product_id: this.productId,
                    rating: parseInt(rating),
                    comment: comment
                })
            });

            const result = await response.json();

            if (response.ok && result.success) {
                this.loadRatings();
                this.elements.form.reset();

                if (this.elements.ratingCount && result.data.ratingCount) {
                    this.elements.ratingCount.innerHTML = `${result.data.ratingCount} đánh giá`;
                }
            } else {
                alert('❌ Lỗi: ' + (result.message || 'Đã xảy ra lỗi.'));
            }
        } catch (error) {
            console.error('Submit rating error:', error);
            alert('❌ Không thể gửi đánh giá. Vui lòng thử lại.');
        }
    }

    handleDynamicEvents(e) {
        // Handle reply button
        if (e.target.closest('.reply-btn')) {
            this.handleReplyClick(e);
        }

        // Handle edit rating button
        if (e.target.closest('.edit-rating-btn')) {
            this.handleEditClick(e);
        }

        // Handle delete rating button
        if (e.target.closest('.delete-rating-btn')) {
            this.handleDeleteClick(e);
        }

        // Handle submit reply button
        if (e.target.closest('.submit-reply')) {
            this.handleSubmitReply(e);
        }
    }

    handleReplyClick(e) {
        const parentDiv = e.target.closest('.list-rating');
        const replyForm = parentDiv?.querySelector('.reply-form');
        replyForm?.classList.toggle('hidden');
    }

    handleEditClick(e) {
        const button = e.target.closest('.edit-rating-btn');
        const { ratingId, comment, stars } = button.dataset;

        // Show edit modal with populated data
        this.showEditModal(ratingId, comment, stars);
    }

    async handleDeleteClick(e) {
        e.preventDefault();
        const button = e.target.closest('.delete-rating-btn');
        const ratingId = button.dataset.ratingId;

        if (!confirm('Bạn có chắc muốn xóa đánh giá này?')) return;

        await this.deleteRating(ratingId);
    }

    async handleSubmitReply(e) {
        const button = e.target.closest('.submit-reply');
        const parentId = button.dataset.parentId;
        const replyForm = button.closest('.reply-form');
        const textarea = replyForm.querySelector('textarea');
        const content = textarea.value.trim();

        if (!content) {
            alert('Vui lòng nhập nội dung trả lời');
            return;
        }

        try {
            const response = await fetch('/ratings/reply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    parent_id: parentId,
                    content: content
                })
            });

            const data = await response.json();

            if (data.success && data.reply) {
                textarea.value = '';
                replyForm.classList.add('hidden');

                // Add reply to UI
                const repliesContainer = button.closest('.list-rating').querySelector('.replies');
                if (repliesContainer) {
                    repliesContainer.insertAdjacentHTML('beforeend', `
                        <div class="ml-12 mt-2 text-gray-700 bg-gray-100 p-3 rounded-lg">
                            <strong>${data.reply.user_name}</strong>: ${data.reply.content}
                        </div>
                    `);
                }
            }
        } catch (error) {
            console.error('Reply submission error:', error);
        }
    }

    showEditModal(ratingId, comment, stars) {
        const modal = this.elements.editModal;
        const editRatingId = document.getElementById('editRatingId');
        const editComment = document.getElementById('editComment');
        const editStars = document.querySelectorAll('#editStars input[name="rating"]');

        if (editRatingId) editRatingId.value = ratingId;
        if (editComment) editComment.value = comment;

        editStars.forEach(radio => {
            radio.checked = radio.value === stars;
        });

        modal?.showModal();
    }

    async deleteRating(ratingId) {
        try {
            const response = await fetch(`/ratings/${ratingId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok && result.success) {
                this.loadRatings();
            } else {
                alert('❌ Lỗi: ' + (result.message || 'Không thể xóa đánh giá.'));
            }
        } catch (error) {
            console.error('Delete rating error:', error);
            alert('❌ Đã xảy ra lỗi khi xóa.');
        }
    }
}


// Initialize the application
const productPage = new ProductPageManager();
