@aware([
    'name'
])

<div class="relative" x-data="fontSelector('{{ $name }}')" x-init="init()">
    <!-- Trigger Button -->
    <button 
        @click="isOpen = !isOpen" 
        type="button"
        class="w-full flex items-center justify-between px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        :style="currentValue ? `font-family: '${currentValue}', system-ui, -apple-system, sans-serif` : ''"
    >
        <span x-text="currentValue || 'Select font'" class="truncate"></span>
        <svg class="w-4 h-4 ml-2 transition-transform flex-shrink-0" :class="{ 'rotate-180': isOpen }" viewBox="0 0 24 24" fill="currentColor">
            <path d="m7 10 5 5 5-5z" />
        </svg>
    </button>

    <!-- Dropdown Panel -->
    <div 
        x-show="isOpen" 
        @click.away="isOpen = false" 
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute top-full left-0 right-0 mt-1 bg-gray-800 border border-gray-700 rounded-md shadow-lg z-50 max-h-64 overflow-hidden"
    >
        <!-- Search Input -->
        <div class="p-2 border-b border-gray-700">
            <input 
                x-model="search" 
                placeholder="Search fonts..."
                class="w-full px-2 py-1 bg-gray-700 border border-gray-600 rounded text-sm text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                @keydown.escape="isOpen = false"
                @keydown.enter.prevent=""
            >
        </div>

        <!-- Font Options -->
        <div class="max-h-48 overflow-y-auto">
            <template x-for="font in (search ? fonts.filter(f => f.toLowerCase().includes(search.toLowerCase())) : fonts)" :key="font">
                <button
                    @click="selectFont(font)"
                    @mouseenter="$el.style.fontFamily = `'${font}', system-ui, -apple-system, sans-serif`"
                    type="button"
                    class="w-full px-3 py-3 text-left text-sm text-gray-300 hover:bg-gray-700 transition-colors border-b border-gray-700/50 last:border-b-0 flex items-center justify-between group"
                    :class="{ 'bg-gray-700 text-white': currentValue === font }"
                >
                    <div class="flex flex-col min-w-0 flex-1">
                        <span x-text="font" class="font-medium truncate"></span>
                        <span 
                            class="text-xs text-gray-400 mt-1 truncate"
                            :style="`font-family: '${font}', system-ui, -apple-system, sans-serif`"
                            x-text="`The quick brown fox jumps over the lazy dog`"
                        ></span>
                    </div>
                    <div x-show="currentValue === font" class="text-blue-400 ml-2 flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                </button>
            </template>
            <div x-show="search && fonts.filter(f => f.toLowerCase().includes(search.toLowerCase())).length === 0" class="px-3 py-4 text-sm text-gray-500 text-center">
                <div class="flex flex-col items-center space-y-2">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0121 12c0-4.411-3.589-8-8-8s-8 3.589-8 8c0 2.152.851 4.103 2.233 5.535z"></path>
                    </svg>
                    <span>No fonts found matching "<span x-text="search" class="font-medium"></span>"</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden input for form submission -->
    <input type="hidden" :name="'{{ $name }}'" :value="currentValue">
</div>