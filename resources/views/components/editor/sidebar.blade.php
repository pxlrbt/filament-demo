<!-- Sidebar -->
<aside class="w-80 mr-8 flex flex-col text-white">
    <!-- Tab Navigation -->
    <nav class="flex rounded-sm  p-1 gap-1">
        <button
            :class="activeTab === 'presets' ? 'bg-gray-700 text-white shadow-sm' : 'text-gray-400 hover:text-gray-300 hover:bg-gray-700'"
            @click="activeTab = 'presets'"
            class="flex-1 flex flex-col items-center py-2 px-3 text-xs font-medium rounded-md transition-all"
        >
            <svg class="w-4 h-4 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            Presets
        </button>

        <button
            :class="activeTab === 'typography' ? 'bg-gray-700 text-white shadow-sm' : 'text-gray-400 hover:text-gray-300 hover:bg-gray-700'"
            @click="activeTab = 'typography'"
            class="flex-1 flex flex-col items-center py-2 px-3 text-xs font-medium rounded-md transition-all"
        >
            <svg class="w-4 h-4 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M5 4v3h5.5v12h3V7H19V4z"/>
            </svg>
            Typography
        </button>

        <button
            :class="activeTab === 'colors' ? 'bg-gray-700 text-white shadow-sm' : 'text-gray-400 hover:text-gray-300 hover:bg-gray-700'"
            @click="activeTab = 'colors'"
            class="flex-1 flex flex-col items-center py-2 px-3 text-xs font-medium rounded-md transition-all"
        >
            <svg class="w-4 h-4 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 9 6.5 9 8 9.67 8 10.5 7.33 12 6.5 12zm3-4C8.67 8 8 7.33 8 6.5S8.67 5 9.5 5s1.5.67 1.5 1.5S10.33 8 9.5 8zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 5 14.5 5s1.5.67 1.5 1.5S15.33 8 14.5 8zm3 4c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
            </svg>
            Colors
        </button>

        <button
            :class="activeTab === 'layout' ? 'bg-gray-700 text-white shadow-sm' : 'text-gray-400 hover:text-gray-300 hover:bg-gray-700'"
            @click="activeTab = 'layout'"
            class="flex-1 flex flex-col items-center py-2 px-3 text-xs font-medium rounded-md transition-all"
        >
            <svg class="w-4 h-4 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
            Layout
        </button>
    </nav>

    <!-- Tab Content -->
    <div class="flex-1 overflow-y-auto mt-2 text-white">
        <!-- Presets Tab -->

        <x-editor.tabs.presets />
        <x-editor.tabs.typography />
        <x-editor.tabs.colors />
        <x-editor.tabs.layout />
    </div>
</aside>
