class LocationManager {
    constructor() {
        this.initializeElements();
        this.bindEvents();
    }

    initializeElements() {
        this.provinceSelect = document.querySelector('.province-select');
        this.districtSelect = document.querySelector('.district-select');
        this.wardSelect = document.querySelector('.ward-select');
    }

    bindEvents() {
        if (this.provinceSelect) {
            this.provinceSelect.addEventListener('change', (e) => this.handleProvinceChange(e));
        }

        if (this.districtSelect) {
            this.districtSelect.addEventListener('change', (e) => this.handleDistrictChange(e));
        }
    }

    async handleProvinceChange(e) {
        const provinceId = e.target.value;

        // Reset & disable selects
        this.districtSelect.innerHTML = '<option value="">Đang tải...</option>';
        this.wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

        if (provinceId) {
            try {
                const response = await fetch(`/get-districts/${provinceId}`);
                const data = await response.json();

                let options = '<option value="">Chọn quận/huyện</option>';
                data.forEach(d => {
                    options += `<option value="${d.id}">${d.name}</option>`;
                });
                this.districtSelect.innerHTML = options;
            } catch (err) {
                console.error('Lỗi khi tải quận/huyện:', err);
                this.districtSelect.innerHTML = '<option value="">Không thể tải dữ liệu</option>';
            }
        } else {
            this.districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
        }
    }

    async handleDistrictChange(e) {
        const districtId = e.target.value;

        this.wardSelect.innerHTML = '<option value="">Đang tải...</option>';

        if (districtId) {
            try {
                const response = await fetch(`/get-wards/${districtId}`);
                const data = await response.json();

                let options = '<option value="">Chọn phường/xã</option>';
                data.forEach(w => {
                    options += `<option value="${w.id}">${w.name}</option>`;
                });
                this.wardSelect.innerHTML = options;
            } catch (err) {
                console.error('Lỗi khi tải phường/xã:', err);
                this.wardSelect.innerHTML = '<option value="">Không thể tải dữ liệu</option>';
            }
        } else {
            this.wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
        }
    }
}
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new LocationManager());
} else {
    new LocationManager();
}
