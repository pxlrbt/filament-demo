<div x-show="activeTab === 'presets'" class="space-y-6">
    <x-editor.details
        id="quick-start"
        :open="true"
    >
        <x-slot:title>Quick Start</x-slot>

        <div class="space-y-2">
            <template x-for="(preset, name) in presets" :key="name">
                <button
                    @click="applyPreset(name)"
                    :class="currentPreset === name ? 'bg-gray-700 border-gray-600 ring-1 ring-blue-500' : 'bg-gray-800 border-gray-700 hover:bg-gray-700'"
                    class="w-full flex items-center p-3 border rounded-lg transition-all group"
                >
                    <div class="flex-shrink-0 w-8 h-8 bg-gray-700 border border-gray-600 rounded-md flex items-center justify-center overflow-hidden">
                        <div class="flex gap-0.5">
                            <span :style="`background-color: ${preset.baseColor}`" class="w-2 h-2 rounded-sm"></span>
                            <span :style="`background-color: ${preset.cardColor}`" class="w-2 h-2 rounded-sm"></span>
                        </div>
                    </div>
                    <div class="ml-3 text-left">
                        <h4 class="text-sm font-medium text-white" x-text="name.charAt(0).toUpperCase() + name.slice(1)"></h4>
                        <p class="text-xs text-gray-400" x-text="preset.description || 'Custom preset'"></p>
                    </div>
                </button>
            </template>
        </div>
    </x-editor.details>

    <x-editor.details id="session-management">
        <x-slot:title>Session Management</x-slot>

        <div class="space-y-3">
            <div class="flex items-center justify-between p-2 bg-gray-800 rounded-lg border border-gray-700">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-300">Auto-save enabled</span>
                </div>
                <span class="text-xs text-gray-500" x-text="'Last saved: ' + getLastSavedTime()"></span>
            </div>

            <button
                @click="clearSavedState()"
                class="w-full flex items-center justify-center space-x-2 p-3 bg-red-900/20 border border-red-700/50 rounded-lg text-red-400 hover:bg-red-900/30 hover:border-red-600 transition-all"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z"/>
                </svg>
                <span class="text-sm font-medium">Clear All Saved Data</span>
            </button>
        </div>
    </x-editor.details>
</div>
