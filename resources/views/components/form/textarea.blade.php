@props(['name', 'label' => '', 'rows' => 3, 'value' => '', 'required' => false])
<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }} {{ $required ? '*' : '' }}
        </label>
    @endif
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
    {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent']) }}
  >{{ old($name, $value) }}</textarea>
</div>
