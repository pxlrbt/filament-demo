@aware([
    'name'
])

<div class="flex items-center space-x-2">
    <div
        class="rounded-md overflow-hidden cursor-pointer border border-gray-700"
        style="background: repeating-conic-gradient(#e5e7eb 0% 25%, #fff 0% 50%) 50% / 16px 16px;"
    >
        <label
            class="block size-10"
            :style="'background:' + form.{{ $name }} "
        >
            <input
                x-model="form.{{ $name }}"
                type="color"
                name="{{ $name }}"
                id="{{ $name }}"
                class="w-10 h-8 bg-gray-800 invisible"
            >
        </label>
    </div>

    <div class="relative flex-1">
        <input
            x-model="form.{{ $name }}"
            type="text"
            class="w-full px-3 py-2 pr-10 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >

        <button
            type="button"
            @click="form.{{ $name }} = '#ffffff00'"
            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-200 transition-colors"
            title="Clear to white"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
