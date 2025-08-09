

<!-- Layout Tab -->
<div x-show="activeTab === 'layout'" class="space-y-6">
    <x-editor.details id="layout" open>
        <x-slot:title>Layout</x-slot>

        <x-field name="layout.spacing">
            <x-label>Spacing</x-label>

            <x-slider
                min="0.2"
                max="0.275"
                step="0.005"
                unit="rem"
            />
        </x-field>

        <x-field name="layout.rounding">
            <x-label>Rounding</x-label>

            <x-slider
                min="0"
                max="2"
                step="0.1"
                unit="rem"
            />
        </x-field>


        <x-field name="layout.circularRounding">
            <x-label>Circular Rounding</x-label>

            <x-slider
                min="0"
                max="4"
                step="0.1"
                unit="rem"
            />
        </x-field>
    </x-editor.details>

    <x-editor.details id="shadows" open>
        <x-slot:title>Shadows</x-slot>

        <x-field name="layout.shadow.offsetX">
            <x-label>Horizontal Offset</x-label>

            <x-slider
                min="-2"
                max="2"
                step="0.1"
                unit="em"
            />
        </x-field>

        <x-field name="layout.shadow.offsetY">
            <x-label>Vertical Offset</x-label>

            <x-slider
                min="-2"
                max="2"
                step="0.1"
                unit="em"
            />
        </x-field>

        <x-field name="layout.shadow.spread">
            <x-label>Spread</x-label>

            <x-slider
                min="-2"
                max="2"
                step="0.1"
                unit="em"
            />
        </x-field>

        <x-field name="layout.shadow.blur">
            <x-label>Blur</x-label>

            <x-slider
                min="0"
                max="2"
                step="0.1"
                unit="em"
            />
        </x-field>

        <x-field name="colors[themeMode].shadow">
            <x-label>Shadow Color</x-label>

            <x-color />
        </x-field>
    </x-editor.details>
</div>
