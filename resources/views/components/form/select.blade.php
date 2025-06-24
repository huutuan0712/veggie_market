@props(['name', 'label' => '', 'options' => [], 'value' => '', 'required' => false])
<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }} {{ $required ? '*' : '' }}
        </label>
    @endif
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white']) }}
    >
        @foreach ($options as $option)
            <option value="{{ $option->id }}" {{ $option == old($name, $value) ? 'selected' : '' }}>{{ $option->name }}</option>
        @endforeach
    </select>
</div>
