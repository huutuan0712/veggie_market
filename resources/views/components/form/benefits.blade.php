<div id="benefits-wrapper" class="bg-white rounded-3xl shadow-lg p-8">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Lợi ích sức khỏe</h2>

    {{-- Input thêm lợi ích --}}
    <div class="flex space-x-2 mb-4">
        <input
            type="text"
            id="new-benefit-input"
            placeholder="Nhập lợi ích sức khỏe..."
            class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
        />
        <button
            type="button"
            id="add-benefit-btn"
            class="bg-orange-500 text-white px-4 py-3 rounded-xl hover:bg-orange-600 transition-colors"
        >
            +
        </button>
    </div>

    {{-- Danh sách lợi ích --}}
    <div id="benefits-list" class="space-y-2">
        @foreach (old('benefits', $product->benefits ?? []) as $benefit)
            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-xl">
                <span class="text-gray-700">{{ $benefit }}</span>
                <button type="button" class="remove-benefit text-red-500 hover:text-red-600 transition-colors">
                    &times;
                </button>
                <input type="hidden" name="benefits[]" value="{{ $benefit }}">
            </div>
        @endforeach
    </div>
</div>

{{-- JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('new-benefit-input');
        const addBtn = document.getElementById('add-benefit-btn');
        const list = document.getElementById('benefits-list');

        function createBenefitElement(value) {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-xl';

            const span = document.createElement('span');
            span.className = 'text-gray-700';
            span.textContent = value;

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'remove-benefit text-red-500 hover:text-red-600 transition-colors';
            button.innerHTML = '&times;';
            button.onclick = () => wrapper.remove();

            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'benefits[]';
            hidden.value = value;

            wrapper.appendChild(span);
            wrapper.appendChild(button);
            wrapper.appendChild(hidden);

            return wrapper;
        }

        addBtn.addEventListener('click', function () {
            const value = input.value.trim();
            if (value !== '') {
                const newItem = createBenefitElement(value);
                list.appendChild(newItem);
                input.value = '';
            }
        });

        // Handle Enter key
        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addBtn.click();
            }
        });

        // Init remove buttons on server-rendered items
        document.querySelectorAll('.remove-benefit').forEach(btn => {
            btn.addEventListener('click', function () {
                this.closest('div').remove();
            });
        });
    });
</script>
