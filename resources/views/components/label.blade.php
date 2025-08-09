@aware(['name'])

<label
    {{ $attributes->class(['block text-sm font-medium text-gray-300']) }}
    for="{{ $name }}"
>
    {{ $slot }}
</label>
