<x-layouts.app>
    <div x-data="themeEditor()">
        <div class="flex h-[calc(100vh-6rem)] px-6 mb-16">

            <x-editor.sidebar />

            <!-- Preview Section -->
            <main class="flex-1 flex flex-col bg-gray-900">
                <div class="flex items-center justify-between p-2 bg-gray-900 border-b border-gray-800">
                    <h3 class="text-lg font-semibold text-white">Live Preview</h3>

                    <div class="flex items-center space-x-2">
                        <!-- Theme Mode Toggle -->
                        <div class="flex items-center space-x-1 bg-gray-800 p-1 rounded-lg border border-gray-700">
                            <button
                                @click="toggleThemeMode()"
                                :class="themeMode === 'dark' ? 'bg-gray-700 text-white shadow-sm' : 'text-gray-400 hover:text-gray-300 hover:bg-gray-700'"
                                class="p-2 rounded-md transition-all"
                                title="Dark mode"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9.37 5.51c-.18.64-.27 1.31-.27 1.99 0 4.08 3.32 7.4 7.4 7.4.68 0 1.35-.09 1.99-.27C17.45 17.19 14.93 19 12 19c-3.86 0-7-3.14-7-7 0-2.93 1.81-5.45 4.37-6.49zM12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
                                </svg>
                            </button>
                            <button
                                @click="toggleThemeMode()"
                                :class="themeMode === 'light' ? 'bg-gray-700 text-white shadow-sm' : 'text-gray-400 hover:text-gray-300 hover:bg-gray-700'"
                                class="p-2 rounded-md transition-all"
                                title="Light mode"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.5 12C17.5 8.96 15.04 6.5 12 6.5S6.5 8.96 6.5 12s2.46 5.5 5.5 5.5 5.5-2.46 5.5-5.5zM12 4.5c.28 0 .5-.22.5-.5V2c0-.28-.22-.5-.5-.5s-.5.22-.5.5v2c0 .28.22.5.5.5zm7.07 2.43c.2-.2.2-.51 0-.71l-1.41-1.41c-.2-.2-.51-.2-.71 0-.2.2-.2.51 0 .71l1.41 1.41c.2.2.51.2.71 0zM22 11.5h-2c-.28 0-.5.22-.5.5s.22.5.5.5h2c.28 0 .5-.22.5-.5s-.22-.5-.5-.5zm-1.93 7.07l-1.41-1.41c-.2-.2-.51-.2-.71 0-.2.2-.2.51 0 .71l1.41 1.41c.2.2.51.2.71 0s.2-.51 0-.71zM12 19.5c-.28 0-.5.22-.5.5v2c0 .28.22.5.5.5s.5-.22.5-.5v-2c0-.28-.22-.5-.5-.5zM4.93 18.57c-.2-.2-.51-.2-.71 0l-1.41 1.41c-.2.2-.2.51 0 .71s.51.2.71 0l1.41-1.41c.2-.2.2-.51 0-.71zM2 11.5h2c.28 0 .5.22.5.5s-.22.5-.5.5H2c-.28 0-.5-.22-.5-.5s.22-.5.5-.5zm2.93-6.07l1.41-1.41c.2-.2.2-.51 0-.71s-.51-.2-.71 0L4.22 4.72c-.2.2-.2.51 0 .71s.51.2.71 0z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- History Controls -->
                        <div class="flex items-center space-x-1 bg-gray-800 p-1 rounded-lg border border-gray-700">
                            <button
                                @click="undo()"
                                :disabled="!canUndo()"
                                :class="canUndo() ? 'text-gray-300 hover:text-white hover:bg-gray-700' : 'text-gray-600 cursor-not-allowed'"
                                class="p-2 rounded-md transition-all"
                                title="Undo (⌘Z)"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.5 8c-2.65 0-5.05.99-6.9 2.6L2 7v9h9l-3.62-3.62c1.39-1.16 3.16-1.88 5.12-1.88 3.54 0 6.55 2.31 7.6 5.5l2.37-.78C21.08 11.03 17.15 8 12.5 8z"/>
                                </svg>
                            </button>
                            <button
                                @click="redo()"
                                :disabled="!canRedo()"
                                :class="canRedo() ? 'text-gray-300 hover:text-white hover:bg-gray-700' : 'text-gray-600 cursor-not-allowed'"
                                class="p-2 rounded-md transition-all"
                                title="Redo (⌘⇧Z)"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.4 10.6C16.55 8.99 14.15 8 11.5 8c-4.65 0-8.58 3.03-9.96 7.22L3.9 15.5c1.05-3.19 4.05-5.5 7.6-5.5 1.95 0 3.73.72 5.12 1.88L13 15h9V6l-3.6 4.6z"/>
                                </svg>
                            </button>
                            <button
                                @click="reset()"
                                class="p-2 rounded-md transition-all text-gray-300 hover:text-white hover:bg-gray-700"
                                title="Reset to preset"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Preview Mode Controls -->
                        <div class="flex items-center space-x-1 bg-gray-800 p-1 rounded-lg border border-gray-700">
                            <button
                                :class="previewMode === 'desktop' ? 'bg-gray-700 text-white shadow-sm' : 'text-gray-400 hover:text-gray-300 hover:bg-gray-700'"
                                @click="previewMode = 'desktop'"
                                class="p-2 rounded-md transition-all"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7l-2 3v1h8v-1l-2-3h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 12H3V4h18v10z"/>
                                </svg>
                            </button>
                            <button
                                :class="previewMode === 'tablet' ? 'bg-gray-700 text-white shadow-sm' : 'text-gray-400 hover:text-gray-300 hover:bg-gray-700'"
                                @click="previewMode = 'tablet'"
                                class="p-2 rounded-md transition-all"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex-1 flex items-center justify-center py-6 bg-gray-850">
                    <div :class="previewMode === 'desktop' ? 'w-full h-full' : 'h-full max-w-4xl aspect-9/16'" class="transition-all duration-300">
                        <iframe
                            src="https://tweakfilament.test/admin"
                            class="w-full h-full border border-gray-700 rounded-lg shadow-2xl bg-white"
                        ></iframe>
                    </div>
                </div>
            </main>
        </div>

        @vite('resources/js/theme-editor.js')
    </div>
</x-layouts.app>
