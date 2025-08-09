

<!-- Layout Tab -->
<div x-show="activeTab === 'layout'" class="space-y-6">
    <x-editor.details open>
        <x-slot:title>Spacing</x-slot>

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
            <x-label>Border Radius</x-label>

            <x-slider
                min="0"
                max="2"
                step="0.1"
                unit="rem"
            />
        </x-field>
    </x-editor.details>
</div>
