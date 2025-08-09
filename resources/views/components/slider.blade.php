@aware([
    'name'
])
@props([
    'min' => 0,
    'max' => 1,
    'step' => 0.1,
    'unit' => ''
])

<div class="flex flex-col items-end gap-2 mb-4">
    <div class="flex items-center space-x-1 min-w-20">
        <input
            x-model="form.{{ $name }}"
            @input="updateTheme"
            type="number"
            step="{{ $step }}"
            min="{{ $min }}"
            max="{{ $max }}"
            class="w-16 px-2 py-1 text-xs text-center bg-gray-800 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <span class="text-xs text-gray-500 font-medium">{{ $unit }}</span>
    </div>

    <input
        x-model="form.{{ $name }}"
        @input="updateTheme"
        type="range"
        name="{{ $name }}"
        id="{{ $name }}"
        min="{{ $min }}"
        max="{{ $max }}"
        step="{{ $step }}"
        class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer slider-thumb"
    >
</div>
