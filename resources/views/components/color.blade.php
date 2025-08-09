@aware([
    'name'
])

<div class="flex items-center space-x-2">
    <input
        x-model="form.{{ $name }}"
        type="color"
        name="{{ $name }}"
        id="{{ $name }}"
        class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
    >
    <input
        x-model="form.{{ $name }}"
        type="text"
        class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
</div>
