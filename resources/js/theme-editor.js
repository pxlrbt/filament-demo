function themeEditor() {
    return {
        activeTab: 'typography',
        previewMode: 'desktop',
        themeMode: 'dark',
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
            circularRounding: 'rem',

            offsetX: 'em',
            offsetY: 'em',
            blur: 'em',
            spread: 'em'
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
                    dark: {
                        base: "#18181b",
                        primary: '#2563eb',
                        info: '#38bdf8',      // Tailwind sky-400
                        success: '#16a34a',   // Tailwind cyan-400
                        warning: '#facc15',   // Tailwind yellow-400
                        danger: '#f87171',    // Tailwind red-400

                        topbar: {
                            background: '#1e293b',
                            text: '#ffffff'
                        },

                        card: {
                            background: '#1e293b',
                            text: '#ffffff'
                        },

                        sidebar: {
                            background: '#18181b',
                            text: '#e0e7ef',
                            primaryBackground: '#2563eb',
                            primaryText: '#ffffff',
                            accentBackground: '#10b981',
                            accentText: '#ffffff'
                        },

                        shadow: '#000000cc'
                    },

                    light: {
                        base: '#ffffff',
                        primary: '#2563eb',
                        info: '#38bdf8',      // Tailwind sky-400
                        success: '#16a34a',   // Tailwind cyan-400
                        warning: '#facc15',   // Tailwind yellow-400
                        danger: '#f87171',    // Tailwind red-400

                        card: {
                            background: '#f8fafc',
                            text: '#1e293b'
                        },

                        topbar: {
                            background: '#f8fafc',
                            text: '#1e293b'
                        },

                        sidebar: {
                            background: '#f1f5f9',
                            text: '#334155',
                            primaryBackground: '#2563eb',
                            primaryText: '#ffffff',
                            accentBackground: '#10b981',
                            accentText: '#ffffff'
                        },

                        shadow: '#000000cc'
                    }
                },

                layout: {
                    spacing: 0.25,
                    rounding: 0.5,
                    circularRounding: 5,

                    shadow: {
                        offsetX: 0,
                        offsetY: 0,
                        blur: 0,
                        spread: 0,
                    }
                }
            }
        },

        fonts: [
            // Most Popular Sans-Serif
            'Inter', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Source Sans Pro',
            'Raleway', 'PT Sans', 'Nunito', 'Ubuntu', 'Poppins', 'Fira Sans',
            'Work Sans', 'Rubik', 'DM Sans', 'Manrope', 'Space Grotesk',
            'Roboto Condensed', 'Noto Sans', 'IBM Plex Sans', 'Barlow', 'Lexend',
            'Plus Jakarta Sans', 'Outfit', 'Figtree', 'Red Hat Display', 'Be Vietnam Pro',
            'Satoshi', 'Epilogue', 'Sora', 'Albert Sans', 'Onest', 'Geist Sans',

            // Classic Sans-Serif
            'Helvetica Neue', 'Arial', 'Verdana', 'Tahoma', 'Geneva', 'Lucida Grande',
            'Trebuchet MS', 'Century Gothic', 'Futura', 'Avant Garde', 'Optima',

            // Extended Sans-Serif Collection
            'Archivo', 'Asap', 'Assistant', 'Cabin', 'Catamaran', 'Chakra Petch',
            'Clear Sans', 'Commissioner', 'Concourse', 'Cousine', 'Dancing Script',
            'Dosis', 'Exo', 'Exo 2', 'Familjen Grotesk', 'Fira Code', 'Golos Text',
            'Hind', 'Hind Siliguri', 'Hind Madurai', 'Hind Guntur', 'Hind Vadodara',
            'Josefin Sans', 'Jost', 'Karla', 'League Spartan', 'Libre Franklin',
            'Mukti', 'Noto Sans JP', 'Noto Sans KR', 'Overpass', 'Oxygen',
            'PT Sans Caption', 'Public Sans', 'Quicksand', 'Readex Pro', 'Roboto Flex',
            'Schibsted Grotesk', 'Sen', 'Signika', 'Signika Negative', 'Spartan',
            'Titillium Web', 'Urbanist', 'Varela Round', 'Yanone Kaffeesatz',

            // Serif Fonts
            'Lora', 'Merriweather', 'Playfair Display', 'PT Serif', 'IBM Plex Serif',
            'Crimson Text', 'Libre Baskerville', 'Cormorant Garamond', 'EB Garamond',
            'Vollkorn', 'Bitter', 'Cardo', 'Crimson Pro', 'Domine', 'Frank Ruhl Libre',
            'Gelasio', 'Gowun Batang', 'Inria Serif', 'Literata', 'Lora', 'Neuton',
            'Noto Serif', 'Old Standard TT', 'Petrona', 'Poly', 'Proza Libre',
            'Roboto Slab', 'Rokkitt', 'Rufina', 'Slabo 27px', 'Spectral',
            'Sura', 'Tinos', 'Unna', 'Vesper Libre', 'Volkhov', 'Zilla Slab',

            // Display & Decorative
            'Abril Fatface', 'Bebas Neue', 'Righteous', 'Fredoka One', 'Archivo Black',
            'Anton', 'Fjalla One', 'Alfa Slab One', 'Bungee', 'Comfortaa',
            'Creepster', 'Fredoka', 'Kalam', 'Lobster', 'Monoton', 'Pacifico',
            'Permanent Marker', 'Shadows Into Light', 'Sigmar One', 'Ultra',

            // Monospace/Code Fonts
            'Source Code Pro', 'Fira Code', 'JetBrains Mono', 'Cascadia Code',
            'Victor Mono', 'Space Mono', 'Roboto Mono', 'Ubuntu Mono', 'Inconsolata',
            'Anonymous Pro', 'Courier Prime', 'Cutive Mono', 'Nova Mono', 'Overpass Mono',
            'PT Mono', 'Red Hat Mono', 'Share Tech Mono', 'Syne Mono',

            // Handwriting & Script
            'Dancing Script', 'Great Vibes', 'Kaushan Script', 'Lobster Two',
            'Pacifico', 'Sacramento', 'Satisfy', 'Shadows Into Light Two',
            'Amatic SC', 'Caveat', 'Courgette', 'Handlee', 'Indie Flower',
            'Kalam', 'Marck Script', 'Nanum Pen Script', 'Patrick Hand',
            'Permanent Marker', 'Reenie Beanie', 'Rock Salt', 'Schoolbell',

            // International & Multi-language
            'Noto Sans Arabic', 'Noto Sans Bengali', 'Noto Sans Chinese',
            'Noto Sans Devanagari', 'Noto Sans Greek', 'Noto Sans Hebrew',
            'Noto Sans Thai', 'Noto Sans Tamil', 'Noto Sans Telugu',
            'Cairo', 'Amiri', 'Scheherazade New', 'IBM Plex Sans Arabic',
            'Tajawal', 'Almarai', 'Changa', 'El Messiri', 'Harmattan',
            'Katibeh', 'Lalezar', 'Lateef', 'Mada', 'Markazi Text',
            'Mirza', 'Rakkas', 'Reem Kufi', 'Vibes',

            // Condensed & Extended
            'Barlow Condensed', 'Barlow Semi Condensed', 'Fira Sans Condensed',
            'Fira Sans Extra Condensed', 'Oswald', 'PT Sans Narrow', 'Roboto Condensed',
            'Source Sans Pro', 'Ubuntu Condensed', 'Yanone Kaffeesatz',
            'Abel', 'Advent Pro', 'Armata', 'Cuprum', 'Economica', 'Electrolize',
            'Exo', 'Gruppo', 'Jura', 'Magra', 'Michroma', 'Orbitron', 'Poiret One',
            'Pontano Sans', 'Questrial', 'Ruda', 'Strait', 'Syncopate', 'Telex',

            // Geometric & Modern
            'Comfortaa', 'Geometric', 'Century Gothic', 'Futura PT', 'Proxima Nova',
            'Avenir', 'Gotham', 'Brandon Grotesque', 'Circular', 'Helvetica Now',
            'San Francisco', 'Product Sans', 'Google Sans', 'YouTube Sans',
            'Airbnb Cereal', 'Spotify Circular', 'Netflix Sans', 'Uber Move'
        ],

        init() {
            // Initialize form as empty object first
            this.form = {};

            // Store global reference for font selectors
            window.themeEditorInstance = this;

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

            this.$watch('themeMode', () => {
                this.updateThemeClass();
                this.updateTheme();
                this.saveToLocalStorage();
            });

            this.$watch('currentPreset', () => {
                this.saveToLocalStorage();
            });

            this.$nextTick(() => {
                this.loadGoogleFonts();
                this.setupIframe();
                this.setupKeyboardShortcuts();
                this.updateThemeClass();
                this.saveToHistory();
            });
        },

        toggleThemeMode() {
            this.themeMode = this.themeMode === 'dark' ? 'light' : 'dark';
        },

        updateThemeClass() {
            const iframe = document.querySelector('iframe');

            if (iframe && iframe.contentDocument) {
                const html = iframe.contentDocument.documentElement

                if (this.themeMode === 'dark') {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            }
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

        loadGoogleFont(fontName) {
            if (!fontName) return;

            const fontId = `google-font-${fontName.replace(/\s+/g, '-').toLowerCase()}`;

            // Check if font is already loaded
            if (document.getElementById(fontId)) return;

            const link = document.createElement('link');
            link.id = fontId;
            link.href = `https://fonts.googleapis.com/css2?family=${fontName.replace(' ', '+')}:wght@300;400;500;600;700&display=swap`;
            link.rel = 'stylesheet';

            document.head.appendChild(link);

            // Also inject into iframe if it exists
            this.injectFontIntoIframe(fontName);
        },

        injectFontIntoIframe(fontName) {
            const iframe = document.querySelector('iframe');

            if (!iframe || !iframe.contentDocument) return;

            const fontId = `google-font-${fontName.replace(/\s+/g, '-').toLowerCase()}`;

            // Check if font is already loaded in iframe
            if (iframe.contentDocument.getElementById(fontId)) return;

            const link = document.createElement('link');
            link.id = fontId;
            link.href = `https://fonts.googleapis.com/css2?family=${fontName.replace(' ', '+')}:wght@300;400;500;600;700&display=swap`;
            link.rel = 'stylesheet';

            iframe.contentDocument.head.appendChild(link);
        },

        injectFontsIntoIframe() {
            const iframe = document.querySelector('iframe');

            if (!iframe || !iframe.contentDocument) return;

            // Check if Google Fonts link already exists in iframe
            let existingLink = iframe.contentDocument.querySelector('link#google-fonts');

            if (!existingLink) {
                existingLink = document.createElement('link');
                existingLink.id = 'google-fonts';
                existingLink.rel = 'stylesheet';
                iframe.contentDocument.head.appendChild(existingLink);
            }

            // Get unique fonts from current form data
            const currentFonts = new Set();

            if (this.form.typography?.base?.fontFamily) {
                currentFonts.add(this.form.typography.base.fontFamily);
            }
            if (this.form.typography?.headline?.fontFamily) {
                currentFonts.add(this.form.typography.headline.fontFamily);
            }

            // If no fonts in form, fall back to all fonts
            const fontsToLoad = currentFonts.size > 0 ? Array.from(currentFonts) : this.fonts;

            // Update the Google Fonts URL
            existingLink.href = 'https://fonts.googleapis.com/css2?family=' +
                               fontsToLoad.map(font => font.replace(' ', '+')).join('&family=') +
                               '&display=swap';
        },

        setupIframe() {
            const iframe = document.querySelector('iframe');

            if (iframe) {
                iframe.onload = () => {
                    this.updateThemeClass();
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

            // Inject Google Fonts CSS into iframe
            this.injectFontsIntoIframe();

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
                    if (state.themeMode) this.themeMode = state.themeMode;
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
                    themeMode: this.themeMode,
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

        getCurrentConfiguration() {
            return {
                form: JSON.parse(JSON.stringify(this.form)),
                presets: this.presets,
                activeTab: this.activeTab,
                previewMode: this.previewMode,
                themeMode: this.themeMode,
                currentPreset: this.currentPreset,
                css: this.generateCSS()
            };
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

            function generateColorMappings(vars) {
                const lightMappings = {};
                const darkMappings = {};

                // Generate mappings for light mode (default)
                Object.keys(vars).forEach(key => {
                    if (key.startsWith('--colors-light-')) {
                        key = key.replace('--colors-light-', '');
                        const unprefixed = '--colors-' + key;
                        const lightPrefixed = '--colors-light-' + key;
                        const darkPrefixed = '--colors-dark-' + key;

                        darkMappings[unprefixed] = `var(${darkPrefixed})`;
                        lightMappings[unprefixed] = `var(${lightPrefixed})`;
                    }
                });

                return [lightMappings, darkMappings];
            }

            const cssVars = flattenToCssVars(this.form);
            const [lightMappings, darkMappings] = generateColorMappings(cssVars);

            const css = `
                :root, body {
                    ${Object.entries(cssVars)
                        .map(([key, value]) => `${key}: ${value};`)
                        .join('\n                    ')}

                    /* Default to light mode */
                    ${Object.entries(lightMappings)
                        .map(([key, value]) => `${key}: ${value};`)
                        .join('\n                    ')}

                    --l-50: 0.97717647058824;
                    --c-50: 0.01395454545455;
                    --l-100: 0.95035294117647;
                    --c-100: 0.03272727272727;
                    --l-200: 0.90547058823529;
                    --c-200: 0.06318181818182;
                    --l-300: 0.84047058823529;
                    --c-300: 0.10604545454546;
                    --l-400: 0.75352941176471;
                    --c-400: 0.15027272727273;
                    --l-500: 0.68270588235294;
                    --c-500: 0.17009090909091;
                    --l-600: 0.59782352941176;
                    --c-600: 0.16913636363636;
                    --l-700: 0.51494117647059;
                    --c-700: 0.14940909090909;
                    --l-800: 0.44611764705882;
                    --c-800: 0.12331818181818;
                    --l-900: 0.39458823529412;
                    --c-900: 0.09963636363636;
                    --l-950: 0.27788235294118;
                    --c-950: 0.07136363636364;

                    --danger-50: oklch(from var(--colors-danger) var(--l-50) var(--c-50) h);
                    --danger-100: oklch(from var(--colors-danger) var(--l-100) var(--c-100) h);
                    --danger-200: oklch(from var(--colors-danger) var(--l-200) var(--c-200) h);
                    --danger-300: oklch(from var(--colors-danger) var(--l-300) var(--c-300) h);
                    --danger-400: oklch(from var(--colors-danger) var(--l-400) var(--c-400) h);
                    --danger-500: oklch(from var(--colors-danger) var(--l-500) var(--c-500) h);
                    --danger-600: oklch(from var(--colors-danger) var(--l-600) var(--c-600) h);
                    --danger-700: oklch(from var(--colors-danger) var(--l-700) var(--c-700) h);
                    --danger-800: oklch(from var(--colors-danger) var(--l-800) var(--c-800) h);
                    --danger-900: oklch(from var(--colors-danger) var(--l-900) var(--c-900) h);
                    --danger-950: oklch(from var(--colors-danger) var(--l-950) var(--c-950) h);

                    --warning-50: oklch(from var(--colors-warning) var(--l-50) var(--c-50) h);
                    --warning-100: oklch(from var(--colors-warning) var(--l-100) var(--c-100) h);
                    --warning-200: oklch(from var(--colors-warning) var(--l-200) var(--c-200) h);
                    --warning-300: oklch(from var(--colors-warning) var(--l-300) var(--c-300) h);
                    --warning-400: oklch(from var(--colors-warning) var(--l-400) var(--c-400) h);
                    --warning-500: oklch(from var(--colors-warning) var(--l-500) var(--c-500) h);
                    --warning-600: oklch(from var(--colors-warning) var(--l-600) var(--c-600) h);
                    --warning-700: oklch(from var(--colors-warning) var(--l-700) var(--c-700) h);
                    --warning-800: oklch(from var(--colors-warning) var(--l-800) var(--c-800) h);
                    --warning-900: oklch(from var(--colors-warning) var(--l-900) var(--c-900) h);
                    --warning-950: oklch(from var(--colors-warning) var(--l-950) var(--c-950) h);

                    --info-50: oklch(from var(--colors-info) var(--l-50) var(--c-50) h);
                    --info-100: oklch(from var(--colors-info) var(--l-100) var(--c-100) h);
                    --info-200: oklch(from var(--colors-info) var(--l-200) var(--c-200) h);
                    --info-300: oklch(from var(--colors-info) var(--l-300) var(--c-300) h);
                    --info-400: oklch(from var(--colors-info) var(--l-400) var(--c-400) h);
                    --info-500: oklch(from var(--colors-info) var(--l-500) var(--c-500) h);
                    --info-600: oklch(from var(--colors-info) var(--l-600) var(--c-600) h);
                    --info-700: oklch(from var(--colors-info) var(--l-700) var(--c-700) h);
                    --info-800: oklch(from var(--colors-info) var(--l-800) var(--c-800) h);
                    --info-900: oklch(from var(--colors-info) var(--l-900) var(--c-900) h);
                    --info-950: oklch(from var(--colors-info) var(--l-950) var(--c-950) h);

                    --success-50: oklch(from var(--colors-success) var(--l-50) var(--c-50) h);
                    --success-100: oklch(from var(--colors-success) var(--l-100) var(--c-100) h);
                    --success-200: oklch(from var(--colors-success) var(--l-200) var(--c-200) h);
                    --success-300: oklch(from var(--colors-success) var(--l-300) var(--c-300) h);
                    --success-400: oklch(from var(--colors-success) var(--l-400) var(--c-400) h);
                    --success-500: oklch(from var(--colors-success) var(--l-500) var(--c-500) h);
                    --success-600: oklch(from var(--colors-success) var(--l-600) var(--c-600) h);
                    --success-700: oklch(from var(--colors-success) var(--l-700) var(--c-700) h);
                    --success-800: oklch(from var(--colors-success) var(--l-800) var(--c-800) h);
                    --success-900: oklch(from var(--colors-success) var(--l-900) var(--c-900) h);
                    --success-950: oklch(from var(--colors-success) var(--l-950) var(--c-950) h);

                    --primary-50: oklch(from var(--colors-primary) var(--l-50) var(--c-50) h);
                    --primary-100: oklch(from var(--colors-primary) var(--l-100) var(--c-100) h);
                    --primary-200: oklch(from var(--colors-primary) var(--l-200) var(--c-200) h);
                    --primary-300: oklch(from var(--colors-primary) var(--l-300) var(--c-300) h);
                    --primary-400: oklch(from var(--colors-primary) var(--l-400) var(--c-400) h);
                    --primary-500: oklch(from var(--colors-primary) var(--l-500) var(--c-500) h);
                    --primary-600: oklch(from var(--colors-primary) var(--l-600) var(--c-600) h);
                    --primary-700: oklch(from var(--colors-primary) var(--l-700) var(--c-700) h);
                    --primary-800: oklch(from var(--colors-primary) var(--l-800) var(--c-800) h);
                    --primary-900: oklch(from var(--colors-primary) var(--l-900) var(--c-900) h);
                    --primary-950: oklch(from var(--colors-primary) var(--l-950) var(--c-950) h);

                    --secondary-50: oklch(from var(--colors-secondary) var(--l-50) var(--c-50) h);
                    --secondary-100: oklch(from var(--colors-secondary) var(--l-100) var(--c-100) h);
                    --secondary-200: oklch(from var(--colors-secondary) var(--l-200) var(--c-200) h);
                    --secondary-300: oklch(from var(--colors-secondary) var(--l-300) var(--c-300) h);
                    --secondary-400: oklch(from var(--colors-secondary) var(--l-400) var(--c-400) h);
                    --secondary-500: oklch(from var(--colors-secondary) var(--l-500) var(--c-500) h);
                    --secondary-600: oklch(from var(--colors-secondary) var(--l-600) var(--c-600) h);
                    --secondary-700: oklch(from var(--colors-secondary) var(--l-700) var(--c-700) h);
                    --secondary-800: oklch(from var(--colors-secondary) var(--l-800) var(--c-800) h);
                    --secondary-900: oklch(from var(--colors-secondary) var(--l-900) var(--c-900) h);
                    --secondary-950: oklch(from var(--colors-secondary) var(--l-950) var(--c-950) h);

                    --gray-50: oklch(from var(--colors-base) var(--l-50) var(--c-50) h);
                    --gray-100: oklch(from var(--colors-base) var(--l-100) var(--c-100) h);
                    --gray-200: oklch(from var(--colors-base) var(--l-200) var(--c-200) h);
                    --gray-300: oklch(from var(--colors-base) var(--l-300) var(--c-300) h);
                    --gray-400: oklch(from var(--colors-base) var(--l-400) var(--c-400) h);
                    --gray-500: oklch(from var(--colors-base) var(--l-500) var(--c-500) h);
                    --gray-600: oklch(from var(--colors-base) var(--l-600) var(--c-600) h);
                    --gray-700: oklch(from var(--colors-base) var(--l-700) var(--c-700) h);
                    --gray-800: oklch(from var(--colors-base) var(--l-800) var(--c-800) h);
                    --gray-900: oklch(from var(--colors-base) var(--l-900) var(--c-900) h);
                    --gray-950: oklch(from var(--colors-base) var(--l-950) var(--c-950) h);
                }

                .dark body {
                    /* Dark mode overrides */
                    ${Object.entries(darkMappings)
                        .map(([key, value]) => `${key}: ${value};`)
                        .join('\n                    ')}
                }
            `;

            console.log('Generated CSS:', css);
            return css;
        }
    }
}

window.themeEditor = themeEditor;

function fontSelector(fieldName) {
    return {
        isOpen: false,
        search: '',
        fieldName: fieldName,
        preloadedFonts: new Set(),

        init() {
            // Find the parent theme editor component
            this.themeEditor = this.$el.closest('[x-data*="themeEditor"]')?.__x?.$data;

            // If themeEditor is not found, try to get it from window
            if (!this.themeEditor && window.themeEditorInstance) {
                this.themeEditor = window.themeEditorInstance;
            }

            // Load fonts when the current value changes
            this.$watch('currentValue', (newValue) => {
                if (newValue && this.themeEditor && typeof this.themeEditor.loadGoogleFont === 'function') {
                    this.themeEditor.loadGoogleFont(newValue);
                }
            });

            // Preload current font if it exists
            if (this.currentValue) {
                this.preloadFont(this.currentValue);
            }
        },

        get fonts() {
            // Use themeEditor fonts if available, otherwise return fallback
            return this.themeEditor?.fonts || [
                // Most Popular Sans-Serif
                'Inter', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Source Sans Pro',
                'Raleway', 'PT Sans', 'Nunito', 'Ubuntu', 'Poppins', 'Fira Sans',
                'Work Sans', 'Rubik', 'DM Sans', 'Manrope', 'Space Grotesk',
                'Roboto Condensed', 'Noto Sans', 'IBM Plex Sans', 'Barlow', 'Lexend',
                'Plus Jakarta Sans', 'Outfit', 'Figtree', 'Red Hat Display', 'Be Vietnam Pro',
                'Satoshi', 'Epilogue', 'Sora', 'Albert Sans', 'Onest', 'Geist Sans',

                // Extended Sans-Serif Collection
                'Archivo', 'Asap', 'Assistant', 'Cabin', 'Catamaran', 'Chakra Petch',
                'Clear Sans', 'Commissioner', 'Concourse', 'Cousine', 'Dancing Script',
                'Dosis', 'Exo', 'Exo 2', 'Familjen Grotesk', 'Fira Code', 'Golos Text',
                'Hind', 'Hind Siliguri', 'Hind Madurai', 'Hind Guntur', 'Hind Vadodara',
                'Josefin Sans', 'Jost', 'Karla', 'League Spartan', 'Libre Franklin',
                'Mukti', 'Noto Sans JP', 'Noto Sans KR', 'Overpass', 'Oxygen',
                'PT Sans Caption', 'Public Sans', 'Quicksand', 'Readex Pro', 'Roboto Flex',
                'Schibsted Grotesk', 'Sen', 'Signika', 'Signika Negative', 'Spartan',
                'Titillium Web', 'Urbanist', 'Varela Round', 'Yanone Kaffeesatz',

                // Serif Fonts
                'Lora', 'Merriweather', 'Playfair Display', 'PT Serif', 'IBM Plex Serif',
                'Crimson Text', 'Libre Baskerville', 'Cormorant Garamond', 'EB Garamond',
                'Vollkorn', 'Bitter', 'Cardo', 'Crimson Pro', 'Domine', 'Frank Ruhl Libre',
                'Gelasio', 'Gowun Batang', 'Inria Serif', 'Literata', 'Lora', 'Neuton',
                'Noto Serif', 'Old Standard TT', 'Petrona', 'Poly', 'Proza Libre',
                'Roboto Slab', 'Rokkitt', 'Rufina', 'Slabo 27px', 'Spectral',
                'Sura', 'Tinos', 'Unna', 'Vesper Libre', 'Volkhov', 'Zilla Slab',

                // Display & Decorative
                'Abril Fatface', 'Bebas Neue', 'Righteous', 'Fredoka One', 'Archivo Black',
                'Anton', 'Fjalla One', 'Alfa Slab One', 'Bungee', 'Comfortaa',
                'Creepster', 'Fredoka', 'Kalam', 'Lobster', 'Monoton', 'Pacifico',
                'Permanent Marker', 'Shadows Into Light', 'Sigmar One', 'Ultra',

                // Monospace/Code Fonts
                'Source Code Pro', 'Fira Code', 'JetBrains Mono', 'Cascadia Code',
                'Victor Mono', 'Space Mono', 'Roboto Mono', 'Ubuntu Mono', 'Inconsolata',
                'Anonymous Pro', 'Courier Prime', 'Cutive Mono', 'Nova Mono', 'Overpass Mono',
                'PT Mono', 'Red Hat Mono', 'Share Tech Mono', 'Syne Mono',

                // Handwriting & Script
                'Dancing Script', 'Great Vibes', 'Kaushan Script', 'Lobster Two',
                'Pacifico', 'Sacramento', 'Satisfy', 'Shadows Into Light Two',
                'Amatic SC', 'Caveat', 'Courgette', 'Handlee', 'Indie Flower',
                'Kalam', 'Marck Script', 'Nanum Pen Script', 'Patrick Hand',
                'Permanent Marker', 'Reenie Beanie', 'Rock Salt', 'Schoolbell'
            ];
        },

        get currentValue() {
            if (!this.themeEditor?.form) return '';
            const path = this.fieldName.split('.');
            let current = this.themeEditor.form;
            for (const key of path) {
                current = current?.[key];
            }
            return current || '';
        },

        set currentValue(value) {
            if (!this.themeEditor?.form) return;
            const path = this.fieldName.split('.');
            let current = this.themeEditor.form;
            for (let i = 0; i < path.length - 1; i++) {
                if (!current[path[i]]) {
                    current[path[i]] = {};
                }
                current = current[path[i]];
            }
            current[path[path.length - 1]] = value;

            // Trigger theme update after setting value
            if (this.themeEditor && typeof this.themeEditor.handleFormChange === 'function') {
                this.themeEditor.handleFormChange();
            }
        },

        selectFont(font) {
            this.currentValue = font;
            this.isOpen = false;

            // Load the selected font immediately
            this.preloadFont(font);

            if (this.themeEditor && typeof this.themeEditor.loadGoogleFont === 'function') {
                this.themeEditor.loadGoogleFont(font);
            }
        },

        preloadFont(fontName) {
            if (!fontName || this.preloadedFonts.has(fontName)) return;

            this.preloadedFonts.add(fontName);

            // Create a preload link for better performance
            const preloadLink = document.createElement('link');
            preloadLink.rel = 'preload';
            preloadLink.as = 'style';
            preloadLink.href = `https://fonts.googleapis.com/css2?family=${fontName.replace(' ', '+')}:wght@300;400;500;600;700&display=swap`;

            document.head.appendChild(preloadLink);

            // Then load the actual stylesheet
            setTimeout(() => {
                if (this.themeEditor && typeof this.themeEditor.loadGoogleFont === 'function') {
                    this.themeEditor.loadGoogleFont(fontName);
                }
            }, 100);
        }
    }
}

window.fontSelector = fontSelector;
window.themeEditor = themeEditor;
