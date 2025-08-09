<x-layouts.app>
    <div x-data="themeEditor()">
        <div class="flex h-[calc(100vh-73px)]">

            <x-editor.sidebar />

            <!-- Preview Section -->
            <main class="flex-1 flex flex-col bg-gray-900">
                <div class="flex items-center justify-between p-2 bg-gray-900 border-b border-gray-800">
                    <h3 class="text-lg font-semibold text-white">Live Preview</h3>
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
                <div class="flex-1 flex items-center justify-center p-6 bg-gray-850">
                    <div :class="previewMode === 'desktop' ? 'w-full h-full' : 'w-full max-w-4xl h-4/5'" class="transition-all duration-300">
                        <iframe
                            src="https://tweakfilament.test/admin"
                            class="w-full h-full border border-gray-700 rounded-lg shadow-2xl bg-white"
                        ></iframe>
                    </div>
                </div>
            </main>
        </div>

        <script>
            function themeEditor() {
                return {
                    activeTab: 'typography',
                    previewMode: 'desktop',
                    currentPreset: 'default',
                    units: {
                        letterSpacing: 'em',
                        spacing: 'rem',
                        rounding: 'rem',
                    },
                    form: {},

                    presets: {
                        default: {
                            typography: {
                                base: {
                                    fontFamily: 'Inter',
                                    letterSpacing: 0,
                                    lineHeight: 1.6
                                },
                                headline: {
                                    fontFamily: 'Inter',
                                    letterSpacing: 0,
                                    lineHeight: 1.3
                                }
                            },
                            colors: {
                                primary: {
                                    background: '#2563eb', // dezentes Blau für Akzente
                                    text: '#ffffff'
                                },
                                secondary: {
                                    background: '#334155', // dunkles Grau-Blau für sekundäre Elemente
                                    text: '#e0e7ef'
                                },
                                accent: {
                                    background: '#10b981', // minimalistisches Grün für Highlights
                                    text: '#ffffff'
                                },
                                base: {
                                    background: '#18181b', // fast schwarzer Hintergrund
                                    text: '#f4f4f5'
                                },
                                card: {
                                    background: '#23272f', // abgesetzte Kartenfarbe
                                    text: '#f4f4f5'
                                },
                                sidebar: {
                                    background: '#18181b',
                                    text: '#e0e7ef',
                                    primaryBackground: '#2563eb',
                                    primaryText: '#ffffff',
                                    accentBackground: '#10b981',
                                    accentText: '#ffffff'
                                }
                            },
                            layout: {
                                spacing: 0.25,
                                rounding: 0.5,
                            }
                        }
                    },

                    fonts: [
                        'Inter', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Source Sans Pro',
                        'Raleway', 'PT Sans', 'Lora', 'Merriweather', 'Playfair Display',
                        'Oswald', 'Nunito', 'Ubuntu', 'Poppins', 'Mukti', 'Fira Sans',
                        'Work Sans', 'Rubik', 'DM Sans', 'Manrope', 'Space Grotesk'
                    ],

                    init() {
                        this.$nextTick(() => {
                            this.applyPreset('default');
                            this.loadGoogleFonts();
                            this.setupIframe();
                        });
                    },

                    loadGoogleFonts() {
                        const link = document.createElement('link');

                        link.href = 'https://fonts.googleapis.com/css2?family=' +
                                   this.fonts.map(font => font.replace(' ', '+')).join('&family=') +
                                   '&display=swap';
                        link.rel = 'stylesheet';

                        document.head.appendChild(link);
                    },

                    setupIframe() {
                        const iframe = document.querySelector('iframe');

                        if (iframe) {
                            iframe.onload = () => {
                                this.updateTheme();
                            };
                        }
                    },

                    applyPreset(presetName) {
                        const preset = this.presets[presetName];

                        if (preset) {
                            this.currentPreset = presetName;
                            this.form = { ...preset };
                            this.$nextTick(() => {
                                this.updateTheme();
                            });
                        }
                    },

                    updateFont(fontName) {
                        this.form.fontFamily = fontName;
                        this.updateTheme();
                    },

                    updateTheme() {
                        const iframe = document.querySelector('iframe');

                        if (!iframe || !iframe.contentDocument) return;

                        let style = iframe.contentDocument.querySelector('style#custom-theme');

                        if (!style) {
                            style = document.createElement('style');
                            style.id = 'custom-theme';
                            iframe.contentDocument.head.appendChild(style);
                        }

                        style.textContent = this.generateCSS();
                    },

                    exportTheme() {
                        const theme = {
                            name: 'Custom Theme',
                            variables: this.form,
                            css: this.generateCSS()
                        };

                        const blob = new Blob([JSON.stringify(theme, null, 2)], { type: 'application/json' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'filament-theme.json';
                        a.click();
                        URL.revokeObjectURL(url);
                    },

                    saveTheme() {
                        localStorage.setItem('filament-theme', JSON.stringify(this.form));
                        alert('Theme saved successfully!');
                    },

                    generateCSS() {
                        const self = this;

                        function flattenToCssVars(obj, prefix = []) {
                            if (typeof obj !== 'object' || obj === null || Array.isArray(obj)) {
                                return {};
                            }

                            let vars = {};

                            for (const [key, value] of Object.entries(obj)) {
                                const newPrefix = [...prefix, key];

                                if (typeof value === 'object' && value !== null && ! Array.isArray(value)) {
                                    Object.assign(vars, flattenToCssVars(value, newPrefix));

                                    continue;
                                }

                                const varName = '--' + newPrefix.join('-');

                                vars[varName] = (key in self.units)
                                    ? `${value}${self.units[key]}`
                                    : value;
                            }

                            return vars;
                        }

                        const cssVars = flattenToCssVars(this.form);

                        return `
                            :root {
                                ${Object.entries(cssVars)
                                    .map(([key, value]) => `${key}: ${value};`)
                                    .join('\n    ')}
                            }
                        `;
                    }
                }
            }
        </script>
    </div>
</x-layouts.app>
