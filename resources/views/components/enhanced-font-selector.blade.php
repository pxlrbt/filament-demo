@aware([
    'name'
])

<div class="relative" x-data="enhancedFontSelector('{{ $name }}')" x-init="init()">
    <!-- Loading indicator -->
    <div x-show="isLoading" class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm text-gray-300">
        <div class="flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>

            Loading Google Fonts...
        </div>
    </div>

    <!-- Trigger Button -->
    <button
        x-show="!isLoading"
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
        x-show="isOpen && !isLoading"
        @click.away="isOpen = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute top-full left-0 right-0 mt-1 bg-gray-800 border border-gray-700 rounded-md shadow-lg z-50 max-h-80 overflow-hidden"
    >
        <!-- Search Input -->
        <div class="p-3 border-b border-gray-700">
            <input
                x-model="search"
                x-ref="searchInput"
                placeholder="Search Google Fonts..."
                class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-sm text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                @keydown.escape="isOpen = false"
                @keydown.enter.prevent=""
                @input="searchFonts"
            >

            <!-- Category Filter Badges -->
            <div class="flex gap-0.5 mt-3 flex-wrap">
                <button
                    @click="toggleCategoryFilter('serif')"
                    type="button"
                    class="px-2 py-1 text-xs rounded-full transition-colors border flex-shrink-0"
                    :class="selectedCategories.includes('serif')
                        ? 'bg-red-700 text-red-200 border-red-600'
                        : 'bg-gray-700 text-gray-300 border-gray-600 hover:bg-gray-600'"
                >
                    Serif
                </button>
                <button
                    @click="toggleCategoryFilter('sans-serif')"
                    type="button"
                    class="px-2 py-1 text-xs rounded-full transition-colors border flex-shrink-0"
                    :class="selectedCategories.includes('sans-serif')
                        ? 'bg-blue-700 text-blue-200 border-blue-600'
                        : 'bg-gray-700 text-gray-300 border-gray-600 hover:bg-gray-600'"
                >
                    Sans
                </button>
                <button
                    @click="toggleCategoryFilter('monospace')"
                    type="button"
                    class="px-2 py-1 text-xs rounded-full transition-colors border flex-shrink-0"
                    :class="selectedCategories.includes('monospace')
                        ? 'bg-yellow-700 text-yellow-200 border-yellow-600'
                        : 'bg-gray-700 text-gray-300 border-gray-600 hover:bg-gray-600'"
                >
                    Mono
                </button>
                <button
                    @click="toggleCategoryFilter('display')"
                    type="button"
                    class="px-2 py-1 text-xs rounded-full transition-colors border flex-shrink-0"
                    :class="selectedCategories.includes('display')
                        ? 'bg-purple-700 text-purple-200 border-purple-600'
                        : 'bg-gray-700 text-gray-300 border-gray-600 hover:bg-gray-600'"
                >
                    Display
                </button>
                <button
                    @click="toggleCategoryFilter('handwriting')"
                    type="button"
                    class="px-2 py-1 text-xs rounded-full transition-colors border flex-shrink-0"
                    :class="selectedCategories.includes('handwriting')
                        ? 'bg-green-700 text-green-200 border-green-600'
                        : 'bg-gray-700 text-gray-300 border-gray-600 hover:bg-gray-600'"
                >
                    Hand
                </button>
            </div>
        </div>

        <!-- Font Options -->
        <div class="max-h-60 overflow-y-auto overflow-x-clip" x-ref="fontList">
            <template x-for="font in filteredFonts.slice(0, 50)" :key="font.family">
                <div
                    x-data="{ fontLoaded: false }"
                    x-intersect.once="loadFontWhenVisible(font.family, $el)"
                    class="font-option-container"
                >
                    <button
                        @click="selectFont(font.family)"
                        type="button"
                        class="w-full px-4 py-4 text-left text-sm text-gray-300 hover:bg-gray-700 transition-colors border-b border-gray-700/50 last:border-b-0 flex items-center justify-between"
                        :class="{ 'bg-blue-700/20 text-white': currentValue === font.family }"
                        :style="fontPreviews[font.family] ? `font-family: '${font.family}', system-ui, -apple-system, sans-serif` : ''"
                    >
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <span
                                    x-text="font.family"
                                    class="font-medium truncate"
                                    :style="fontPreviews[font.family] ? `font-family: '${font.family}', system-ui, -apple-system, sans-serif` : ''"
                                ></span>

                                <span
                                    class="text-xs px-2 py-0.5 rounded ml-2 flex-shrink-0"
                                    :class="getCategoryClass(font.category)"
                                    x-text="font.category"
                                ></span>
                            </div>

                            <div class="text-xs text-gray-400">
                                <!-- Loading indicator for font preview -->
                                <div x-show="!fontPreviews[font.family]" class="flex items-center">
                                    <div class="w-3 h-3 mr-2 border border-gray-500 border-t-transparent rounded-full animate-spin opacity-50"></div>
                                    <span>Loading preview...</span>
                                </div>

                                <!-- Actual font preview -->
                                <div
                                    x-show="fontPreviews[font.family]"
                                    class="truncate"
                                    :style="fontPreviews[font.family] ? `font-family: '${font.family}';` : ''"
                                >
                                    The quick brown fox jumps over the lazy dog
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
            </template>

            <!-- No results message -->
            <div x-show="search && filteredFonts.length === 0" class="px-4 py-8 text-sm text-gray-500 text-center">
                <div class="mb-2">
                    <svg class="w-8 h-8 mx-auto text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                No fonts found matching "<span x-text="search" class="font-medium"></span>"
                <div class="text-xs mt-1">Try searching for serif, sans-serif, monospace, or display fonts</div>
            </div>

            <!-- Show limited results notice -->
            <div x-show="filteredFonts.length > 50" class="px-4 py-2 text-xs text-gray-400 text-center border-t border-gray-700">
                Showing first 50 results. Use search to narrow down options.
            </div>
        </div>
    </div>

    <!-- Hidden input for form submission -->
    <input type="hidden" :name="'{{ $name }}'" :value="currentValue">
</div>

<script>
// Category styling helper
window.getCategoryClass = (category) => {
    const classes = {
        'serif': 'bg-red-900/30 text-red-300',
        'sans-serif': 'bg-blue-900/30 text-blue-300',
        'display': 'bg-purple-900/30 text-purple-300',
        'handwriting': 'bg-green-900/30 text-green-300',
        'monospace': 'bg-yellow-900/30 text-yellow-300'
    };
    return classes[category] || 'bg-gray-900/30 text-gray-300';
};
</script>
