<x-layouts.app>
    <h1>Tweak Filament</h1>

    <main>
        <aside>
            <label for="preset">
                Preset
                <select name="preset" id="preset">
                    <option value="default">Default</option>
                    <option value="dark">Dark</option>
                    <option value="light">Light</option>
                </select>
            </label>
            <form action="">
                <label>
                    Font-Family
                    <select name="fontFamily">
                        <option value="monospace">Monospace</option>
                        <option value="sans-serif">Sans-Serif</option>
                        <option value="serif">Serif</option>
                    </select>
                </label>

                <label>
                    Letter Spacing
                    <input
                        type="range"
                        name="letterSpacing"
                        min="0.0"
                        max="0.1"
                        value="0.0"
                        step="0.005"
                        data-unit="em"
                    >
                </label>

                <label>
                    Primary Color
                    <select name="baseColor">
                        <option value="oklch(0.2598 0.0306 262.6666)">Blue</option>
                        <option value="black">black</option>
                    </select>
                </label>

                <label>
                    Card Color
                    <select name="cardColor">
                        <option value="oklch(0.2598 0.0306 262.6666)">Blue</option>
                        <option value="black">black</option>
                    </select>
                </label>

                <label>
                    Spacing
                    <input
                        type="range"
                        name="spacing"
                        min="0.2"
                        max="0.275"
                        value="0.25"
                        step="0.005"
                        data-unit="rem"
                    >
                </label>

                <label>
                    Rounding
                    <input
                        type="range"
                        name="rounding"
                        min="0"
                        max="2"
                        value="0.5"
                        step="0.1"
                        data-unit="rem"
                    >
                </label>
            </form>
        </aside>
        <div class="embed">
            <iframe src="https://tweakfilament.test/admin"></iframe>
        </div>

        <script>
            const presets = {
                default: {
                    fontFamily: 'sans-serif',
                    letterSpacing: '0.0em',
                    baseColor: 'oklch(0.2598 0.0306 262.6666)',
                    cardColor: 'oklch(0.2598 0.0306 262.6666)',
                    spacing: '0.25rem',
                    rounding: '0.5rem',
                },
                dark: {
                    fontFamily: 'serif',
                    letterSpacing: '0.005em',
                    baseColor: 'black',
                    cardColor: 'black',
                    spacing: '0.2rem',
                    rounding: '0.25rem',
                },
                light: {
                    fontFamily: 'monospace',
                    letterSpacing: '0.01em',
                    baseColor: 'oklch(0.2598 0.0306 262.6666)',
                    cardColor: 'oklch(0.2598 0.0306 262.6666)',
                    spacing: '0.275rem',
                    rounding: '2rem',
                }
            };
            document.querySelector('#preset').addEventListener('change', (event) => {
                const preset = presets[event.target.value];

                if (preset) {
                    console.log('Applying preset:', preset);

                    for (const [key, value] of Object.entries(preset)) {
                        const input = document.querySelector(`input[name="${key}"]`);

                        if (input) {
                            input.value = value;
                        } else {
                            const select = document.querySelector(`select[name="${key}"]`);

                            if (select) {
                                select.value = value;
                            }
                        }
                    }

                    const style = document.querySelector('iframe').contentDocument.querySelector('style#custom-theme');
                    style.textContent = getTheme();
                }
            });

            function getTheme() {
                const form = document.querySelector('form');
                const formValues = new FormData(form);


                const config = {};

                for (const element of form.elements) {
                    if (!element.name) continue;

                    let value = formValues.get(element.name);
                    const unit = element.getAttribute && element.getAttribute('data-unit');

                    if (unit && value !== null) {
                        value = value + unit;
                    }

                    config[element.name] = value;
                }

                console.log('Config:', config);

                return `
                    :root {
                        ${Object.entries(config)
                                .map(([key, value]) => `--${key.replace(/[A-Z]/g, m => '-' + m.toLowerCase())}: ${value};`)
                                .join('\n            ')}
                    }

                    @layer custom-theme {
                        :root {
                            ${Object.entries(config)
                                .map(([key, value]) => `--${key.replace(/[A-Z]/g, m => '-' + m.toLowerCase())}: ${value};`)
                                .join('\n            ')}
                        }
                    }
                `;
            }

            // Initial theme application
            const iframe = document.querySelector('iframe');

            iframe.onload = () => {
                const style = document.createElement('style');
                style.id = 'custom-theme';
                style.textContent = getTheme();

                iframe.contentDocument.head.appendChild(style);
            };

            // Reapply styles when form changes
            document.querySelector('form').addEventListener('input', (event) => {
                const style = document.querySelector('iframe').contentDocument.querySelector('style#custom-theme');
                style.textContent = getTheme();
            });
        </script>
    </main>
</x-layouts.app>
