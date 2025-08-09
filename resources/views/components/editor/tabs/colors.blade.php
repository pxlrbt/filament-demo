
<!-- Colors Tab -->
<div x-show="activeTab === 'colors'" class="space-y-6">
    <x-editor.details id="primaryColor" :open="true">
        <x-slot:title>Accent Colors</x-slot>

        <x-field name="colors.primary.background">
            <x-label>Primary Background</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.primary.text">
            <x-label>Primary Text</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.secondary.background">
            <x-label>Secondary Background</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.secondary.text">
            <x-label>Secondary Text</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.accent.background">
            <x-label>Accent Background</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.accent.text">
            <x-label>Accent Text</x-label>

            <x-color />
        </x-field>
    </x-editor.details>

    <x-editor.details id="baseColor" :open="true">
        <x-slot:title>Base Color</x-slot>

        <x-field name="colors.base.background">
            <x-label>Background Color</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.base.text">
            <x-label>Text Color</x-label>

            <x-color />
        </x-field>
    </x-editor.details>

    <x-editor.details
        id="cardColors"
        :open="true"
    >
        <x-slot:title>Card Colors</x-slot>

        <x-field name="colors.card.background">
            <x-label>Background</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.card.text">
            <x-label>Text Color</x-label>

            <x-color />
        </x-field>
    </x-editor.details>

    <x-editor.details
        id="sidebarColors"
        :open="true"
    >
        <x-slot:title>Sidebar Colors</x-slot>

        <x-field name="colors.sidebar.background">
            <x-label>Background Color</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.sidebar.text">
            <x-label>Text Color</x-label>

            <x-color />
        </x-field>


        <x-field name="colors.sidebar.primaryBackground">
            <x-label>Primary Background Color</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.sidebar.primaryText">
            <x-label>Primary Text Color</x-label>

            <x-color />
        </x-field>


        <x-field name="colors.sidebar.accentBackground">
            <x-label>Accent Background Color</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.sidebar.accentText">
            <x-label>Accent Text Color</x-label>

            <x-color />
        </x-field>
    </x-editor.details>

{{--
    <x-editor.details
        id="destructiveColors"
        :open="true"
    >
        <x-slot:title>Destructive Colors</x-slot>

        <x-field name="colors.destructive.background">
            <x-label>Background Color</x-label>

            <x-color />
        </x-field>

        <x-field name="colors.destructive.text">
            <x-label>Text Color</x-label>

            <x-color />
        </x-field>
    </x-editor.details> --}}
</div>
