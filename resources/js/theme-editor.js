function themeEditor() {
    return {
        activeTab: 'typography',
        previewMode: 'desktop',
        currentPreset: 'default',
        history: [],
        historyIndex: -1,
        maxHistorySize: 50,
        historyTimeout: null,
        localStorageTimeout: null,
        lastSaved: null,
        isUndoRedoOperation: false,
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
            
            // Load saved state or apply default preset
            this.loadFromLocalStorage();

            // Watch form changes automatically
            this.$watch('form', () => {
                this.handleFormChange();
            }, { deep: true });

            // Watch for changes to save to localStorage (but not during undo/redo)
            this.$watch('form', () => {
                if (!this.isUndoRedoOperation) {
                    this.debouncedSaveToLocalStorage();
                }
            }, { deep: true });

            this.$watch('activeTab', () => {
                this.saveToLocalStorage();
            });

            this.$watch('previewMode', () => {
                this.saveToLocalStorage();
            });

            this.$watch('currentPreset', () => {
                this.saveToLocalStorage();
            });

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
                this.isUndoRedoOperation = true;
                this.historyIndex--;
                this.form = JSON.parse(JSON.stringify(this.history[this.historyIndex]));
                this.$nextTick(() => {
                    this.updateTheme();
                    this.isUndoRedoOperation = false;
                    this.saveToLocalStorage();
                });
            }
        },

        redo() {
            if (this.historyIndex < this.history.length - 1) {
                this.isUndoRedoOperation = true;
                this.historyIndex++;
                this.form = JSON.parse(JSON.stringify(this.history[this.historyIndex]));
                this.$nextTick(() => {
                    this.updateTheme();
                    this.isUndoRedoOperation = false;
                    this.saveToLocalStorage();
                });
            }
        },

        reset() {
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

        applyPreset(presetName, skipHistorySave = false) {
            const preset = this.presets[presetName];

            if (preset) {
                this.currentPreset = presetName;
                
                if (skipHistorySave) {
                    this.isUndoRedoOperation = true;
                }

                // Deep merge to maintain Alpine.js reactivity
                this.deepMerge(this.form, preset);

                this.$nextTick(() => {
                    this.updateTheme();
                    if (skipHistorySave) {
                        this.isUndoRedoOperation = false;
                    }
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
            if (!this.isUndoRedoOperation) {
                this.debouncedSaveToHistory();
            }
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

        loadFromLocalStorage() {
            try {
                const savedState = localStorage.getItem('filament-theme-editor-state');
                
                if (savedState) {
                    const state = JSON.parse(savedState);
                    
                    // Restore UI state
                    if (state.activeTab) this.activeTab = state.activeTab;
                    if (state.previewMode) this.previewMode = state.previewMode;
                    if (state.currentPreset) this.currentPreset = state.currentPreset;
                    
                    // Restore form data
                    if (state.form && Object.keys(state.form).length > 0) {
                        this.isUndoRedoOperation = true;
                        this.deepMerge(this.form, state.form);
                        this.$nextTick(() => {
                            this.isUndoRedoOperation = false;
                        });
                    } else {
                        this.applyPreset('default', true);
                    }
                    
                    // Restore history if available
                    if (state.history && Array.isArray(state.history) && state.history.length > 0) {
                        this.history = state.history;
                        this.historyIndex = state.historyIndex || this.history.length - 1;
                    }
                    
                    // Set last saved time
                    if (state.savedAt) {
                        this.lastSaved = new Date(state.savedAt);
                    }
                } else {
                    // No saved state, use default preset
                    this.applyPreset('default', true);
                }
            } catch (error) {
                console.error('Failed to load from localStorage:', error);
                this.applyPreset('default', true);
            }
        },

        saveToLocalStorage() {
            try {
                const now = new Date();
                const state = {
                    form: this.form,
                    activeTab: this.activeTab,
                    previewMode: this.previewMode,
                    currentPreset: this.currentPreset,
                    history: this.history,
                    historyIndex: this.historyIndex,
                    savedAt: now.toISOString()
                };
                
                localStorage.setItem('filament-theme-editor-state', JSON.stringify(state));
                this.lastSaved = now;
            } catch (error) {
                console.error('Failed to save to localStorage:', error);
            }
        },

        debouncedSaveToLocalStorage() {
            clearTimeout(this.localStorageTimeout);
            this.localStorageTimeout = setTimeout(() => {
                this.saveToLocalStorage();
            }, 300);
        },

        clearSavedState() {
            if (confirm('Are you sure you want to clear all saved data? This will reset your theme to default and cannot be undone.')) {
                localStorage.removeItem('filament-theme-editor-state');
                this.applyPreset('default');
                this.history = [];
                this.historyIndex = -1;
                this.lastSaved = null;
                this.saveToHistory();
            }
        },

        getLastSavedTime() {
            if (!this.lastSaved) return 'Never';
            return this.lastSaved.toLocaleTimeString();
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
