
<!-- Colors Tab -->
<div x-show="activeTab === 'colors'" class="space-y-6">
    <!-- Theme Mode Indicator -->
    <div class="bg-gray-800 p-3 rounded-lg border border-gray-700">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-300">
                Editing <span x-text="themeMode" class="capitalize font-bold text-white"></span> Mode Colors
            </span>
            <div class="text-xs text-gray-400">
                Switch mode using the toggle above to edit different color schemes
            </div>
        </div>
    </div>

    <x-editor.details id="primaryColor" :open="true">
        <x-slot:title>Accent Colors</x-slot>

        <div class="space-y-2">
            <x-label>Primary Background</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].primary.background"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].primary.background"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Primary Text</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].primary.text"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].primary.text"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Secondary Background</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].secondary.background"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].secondary.background"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Secondary Text</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].secondary.text"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].secondary.text"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Accent Background</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].accent.background"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].accent.background"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Accent Text</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].accent.text"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].accent.text"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
    </x-editor.details>

    <x-editor.details id="baseColor" :open="true">
        <x-slot:title>Base Color</x-slot>

        <div class="space-y-2">
            <x-label>Background Color</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].base.background"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].base.background"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Text Color</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].base.text"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].base.text"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
    </x-editor.details>

    <x-editor.details
        id="cardColors"
        :open="true"
    >
        <x-slot:title>Card Colors</x-slot>

        <div class="space-y-2">
            <x-label>Background</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].card.background"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].card.background"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Text Color</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].card.text"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].card.text"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
    </x-editor.details>

    <x-editor.details
        id="sidebarColors"
        :open="true"
    >
        <x-slot:title>Sidebar Colors</x-slot>

        <div class="space-y-2">
            <x-label>Background Color</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].sidebar.background"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].sidebar.background"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Text Color</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].sidebar.text"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].sidebar.text"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Primary Background Color</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].sidebar.primaryBackground"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].sidebar.primaryBackground"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Primary Text Color</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].sidebar.primaryText"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].sidebar.primaryText"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Accent Background Color</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].sidebar.accentBackground"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].sidebar.accentBackground"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="space-y-2">
            <x-label>Accent Text Color</x-label>
            <div class="flex items-center space-x-2">
                <input
                    x-model="form.colors[themeMode].sidebar.accentText"
                    type="color"
                    class="w-10 h-8 bg-gray-800 border border-gray-700 rounded cursor-pointer"
                >
                <input
                    x-model="form.colors[themeMode].sidebar.accentText"
                    type="text"
                    class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm font-mono text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
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
