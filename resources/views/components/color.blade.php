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

    <input
        x-model="form.{{ $name }}"
        type="text"
        class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
</div>
