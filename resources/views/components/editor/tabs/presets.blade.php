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
</div>
