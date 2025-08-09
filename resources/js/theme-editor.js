function themeEditor() {
    return {
        activeTab: 'typography',
        previewMode: 'desktop',
        currentPreset: 'default',
        history: [],
        historyIndex: -1,
        maxHistorySize: 50,
        historyTimeout: null,
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
                        background: '#2563eb',
                        text: '#ffffff'
                    },
                    secondary: {
                        background: '#334155',
                        text: '#e0e7ef'
                    },
                    accent: {
                        background: '#10b981',
                        text: '#ffffff'
                    },
                    base: {
                        background: '#18181b',
                        text: '#f4f4f5'
                    },
                    card: {
                        background: '#23272f',
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
            // Initialize form as empty object first
            this.form = {};
            this.applyPreset('default');

            this.$nextTick(() => {
                this.loadGoogleFonts();
                this.setupIframe();
                this.setupKeyboardShortcuts();
                this.saveToHistory();
            });
        },

        setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                if ((e.metaKey || e.ctrlKey) && e.key === 'z' && !e.shiftKey) {
                    e.preventDefault();
                    this.undo();
                } else if ((e.metaKey || e.ctrlKey) && e.key === 'z' && e.shiftKey) {
                    e.preventDefault();
                    this.redo();
                }
            });
        },

        saveToHistory() {
            const currentState = JSON.parse(JSON.stringify(this.form));

            if (this.historyIndex < this.history.length - 1) {
                this.history = this.history.slice(0, this.historyIndex + 1);
            }

            this.history.push(currentState);
            this.historyIndex = this.history.length - 1;

            if (this.history.length > this.maxHistorySize) {
                this.history.shift();
                this.historyIndex--;
            }
        },

        undo() {
            if (this.historyIndex > 0) {
                this.historyIndex--;
                this.form = JSON.parse(JSON.stringify(this.history[this.historyIndex]));
                this.$nextTick(() => {
                    this.updateTheme();
                });
            }
        },

        redo() {
            if (this.historyIndex < this.history.length - 1) {
                this.historyIndex++;
                this.form = JSON.parse(JSON.stringify(this.history[this.historyIndex]));
                this.$nextTick(() => {
                    this.updateTheme();
                });
            }
        },

        reset() {
            console.log('resetting to preset:', this.currentPreset);

            this.applyPreset(this.currentPreset);
            this.saveToHistory();
        },

        canUndo() {
            return this.historyIndex > 0;
        },

        canRedo() {
            return this.historyIndex < this.history.length - 1;
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
                
                // Deep merge to maintain Alpine.js reactivity
                this.deepMerge(this.form, preset);

                this.$nextTick(() => {
                    this.updateTheme();
                });
            }
        },

        deepMerge(target, source) {
            // Clear existing properties first
            Object.keys(target).forEach(key => {
                if (typeof target[key] === 'object' && target[key] !== null && !Array.isArray(target[key])) {
                    // Keep the object reference but clear its properties
                    Object.keys(target[key]).forEach(subKey => delete target[key][subKey]);
                } else {
                    delete target[key];
                }
            });

            // Then merge in the new values
            for (const [key, value] of Object.entries(source)) {
                if (typeof value === 'object' && value !== null && !Array.isArray(value)) {
                    if (!target[key] || typeof target[key] !== 'object') {
                        target[key] = {};
                    }
                    this.deepMerge(target[key], value);
                } else {
                    target[key] = value;
                }
            }
        },

        handleFormChange() {
            this.updateTheme();
            this.debouncedSaveToHistory();
        },

        debouncedSaveToHistory() {
            clearTimeout(this.historyTimeout);
            this.historyTimeout = setTimeout(() => {
                this.saveToHistory();
            }, 500);
        },

        updateFont(fontName) {
            this.form.fontFamily = fontName;
            this.handleFormChange();
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

window.themeEditor = themeEditor;
