
<!-- Colors Tab -->
<div x-show="activeTab === 'colors'" class="space-y-6">
    <!-- Theme Mode Indicator -->
    <div class="bg-gray-800 p-3 rounded-lg border border-gray-700">
        <span class="text-sm font-medium text-gray-300">
            Editing <span x-text="themeMode" class="capitalize font-bold text-white"></span> Mode Colors
        </span>
        <div class="mt-1 text-xs text-gray-400">
            Switch mode using the toggle above to edit different color schemes
        </div>
    </div>

    <x-editor.details id="baseColors" :open="true">
        <x-slot:title>Base Colors</x-slot>

        <x-field name="colors[themeMode].base">
            <x-label>Base</x-label>

            <x-hue-slider />
        </x-field>

        <x-field name="colors[themeMode].primary">
            <x-label>Primary</x-label>

            <x-hue-slider />
        </x-field>

        <x-field name="colors[themeMode].info">
            <x-label>Info</x-label>

            <x-hue-slider />
        </x-field>

        <x-field name="colors[themeMode].success">
            <x-label>Success</x-label>

            <x-hue-slider />
        </x-field>

        <x-field name="colors[themeMode].warning">
            <x-label>Warning</x-label>

            <x-hue-slider />
        </x-field>

        <x-field name="colors[themeMode].danger">
            <x-label>Danger</x-label>

            <x-hue-slider />
        </x-field>
    </x-editor.details>

    <x-editor.details
        id="cardColors"
        :open="true"
    >
        <x-slot:title>Card Color</x-slot>

        <div class="space-y-2">
            <x-field name="colors[themeMode].card.background">
                <x-label>Background</x-label>

                <x-color />
            </x-field>
        </div>
    </x-editor.details>

    <x-editor.details
        id="topbarColors"
        :open="true"
    >
        <x-slot:title>Topbar Color</x-slot>

        <div class="space-y-2">
            <x-field name="colors[themeMode].topbar.background">
                <x-label>Background</x-label>

                <x-color />
            </x-field>
        </div>
    </x-editor.details>

    <x-editor.details
        id="sidebarColors"
        :open="true"
    >
        <x-slot:title>Sidebar Colors</x-slot>

        <div class="space-y-2">
            <x-field name="colors[themeMode].sidebar.background">
                <x-label>Background</x-label>

                <x-color />
            </x-field>

            <x-field name="colors[themeMode].sidebar.text">
                <x-label>Text</x-label>

                <x-color />
            </x-field>

            <x-field name="colors[themeMode].sidebar.primaryBackground">
                <x-label>Primary Background</x-label>

                <x-color />
            </x-field>

            <x-field name="colors[themeMode].sidebar.primaryText">
                <x-label>Primary Text</x-label>

                <x-color />
            </x-field>

            <x-field name="colors[themeMode].sidebar.accentBackground">
                <x-label>Accent Background</x-label>

                <x-color />
            </x-field>

            <x-field name="colors[themeMode].sidebar.accentText">
                <x-label>Accent Text</x-label>

                <x-color />
            </x-field>
        </div>
    </x-editor.details>
</div>
