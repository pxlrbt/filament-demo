@aware([
    'name'
])

<select
    x-model="form.{{ $name }}"
    @change="handleFormChange()"
    name="{{ $name }}"
    id="{{ $name }}"
    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
>
    {{ $slot }}
</select>