<!-- Typography Tab -->
<div x-show="activeTab === 'typography'" class="space-y-6">
    <form id="theme-form" class="space-y-4">
        <x-editor.details id="base" :open="true">
            <x-slot:title>Base Text</x-slot>

            <x-field name="typography.base.fontFamily">
                <x-label>Font Family</x-label>

                <x-font-selector />
            </x-field>

            <x-field name="typography.base.letterSpacing">
                <x-label>Letter Spacing</x-label>

                <x-slider
                    min="-0.25"
                    max="0.25"
                    step="0.005"
                    unit="em"
                />
            </x-field>
        </x-editor.details>

        <x-editor.details id="headline" :open="true">
            <x-slot:title>Headline</x-slot>

            <x-field name="typography.headline.fontFamily">
                <x-label>Font Family</x-label>

                <x-font-selector />
            </x-field>

            <x-field name="typography.headline.letterSpacing">
                <x-label>Letter Spacing</x-label>

                <x-slider
                    min="-0.25"
                    max="0.25"
                    step="0.005"
                    unit="em"
                />
            </x-field>
        </x-editor.details>
    </form>
</div>
