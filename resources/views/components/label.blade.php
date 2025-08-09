@aware(['name'])

<div class="flex items-center justify-between">
    <label
        {{ $attributes->class(['block text-sm font-medium text-gray-300']) }}
        for="{{ $name }}"
    >
        {{ $slot }}
    </label>

    <button
        type="button"
        @click="resetFieldToPresetDefault('{{ $name }}')"
        class="text-xs text-gray-400 hover:text-gray-200 transition-colors px-2 py-1 rounded"
        title="Reset to preset default"
    >
        Reset
    </button>
</div>
