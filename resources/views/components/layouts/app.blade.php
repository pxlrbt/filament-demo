<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name') }}</title>

        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="alternate icon" href="/favicon.ico">

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @vite('resources/css/app.css')
    </head>

    <body class="antialiased bg-gray-900">
        <header class="relative z-10">
            <nav aria-label="Global" class="mx-auto flex items-center justify-between p-6">
                <div class="flex lg:flex-1">
                    <a href="/" class="-m-1.5 p-1.5 font-bold text-white flex items-center gap-2">
                        <div class="flex items-center">
                            <span class="text-xl">Filament</span>
                            <span class="ml-1 px-2 py-1 text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-full shadow-sm">Studio</span>
                            <span class="ml-2 px-2 py-1 text-xs font-mono text-gray-200 ">beta</span>
                        </div>
                    </a>
                </div>

                <div class="flex lg:hidden">
                    <button type="button" command="show-modal" commandfor="mobile-menu"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400">
                        <span class="sr-only">Open main menu</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                            aria-hidden="true" class="size-6">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

                <div class="hidden items-center lg:flex lg:gap-x-12">
                    <a href="/" class="text-sm/6 font-semibold text-white {{ request()->is('/') ? 'relative px-2 py-1 bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg shadow-sm' : 'hover:text-orange-300 transition-colors px-2 py-1' }}">Home</a>
                    <a href="/editor" class="text-sm/6 font-semibold text-white {{ request()->is('editor') ? 'relative px-2 py-1 bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg shadow-sm' : 'hover:text-orange-300 transition-colors px-2 py-1' }}">Editor</a>
                    <a href="/#faq" class="text-sm/6 font-semibold text-white hover:text-orange-300 transition-colors px-2 py-1">FAQ</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-2">
                    @if(request()->is('editor'))
                        <button
                            onclick="showBuyNowModal()"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-500 transition-colors"
                        >
                            Buy Now  →
                        </button>
                    @else
                        <a href="/editor" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-500 transition-colors">
                            Try Now  →
                        </a>
                    @endif
                </div>
            </nav>

            <el-dialog>
                <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
                    <div tabindex="0" class="fixed inset-0 focus:outline-none">
                        <el-dialog-panel
                            class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
                            <div class="flex items-center justify-between">
                                <a href="/" class="-m-1.5 p-1.5 font-bold text-white flex items-center gap-2">
                                    <div class="flex items-center">
                                        <span class="text-lg">Filament</span>
                                        <span class="ml-1 px-2 py-1 text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-full shadow-sm">Studio</span>
                                    </div>
                                </a>
                                <button type="button" command="close" commandfor="mobile-menu"
                                    class="-m-2.5 rounded-md p-2.5 text-gray-400">
                                    <span class="sr-only">Close menu</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        data-slot="icon" aria-hidden="true" class="size-6">
                                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-6 flow-root">
                                <div class="-my-6 divide-y divide-white/10">
                                    <div class="space-y-2 py-6">
                                        <a href="/"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white {{ request()->is('/') ? 'bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg' : 'hover:bg-white/5' }}">Home</a>
                                        <a href="/editor"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white {{ request()->is('editor') ? 'bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg' : 'hover:bg-white/5' }}">Editor</a>
                                        <a href="/#faq"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">FAQ</a>
                                    </div>
                                </div>
                            </div>
                        </el-dialog-panel>
                    </div>
                </dialog>
            </el-dialog>
        </header>

        <!-- Buy Now Modal -->
        @if(request()->is('editor'))
            <div id="buyNowModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-gray-900 rounded-lg p-6 w-full max-w-md">
                        <h2 class="text-xl font-semibold text-white mb-4">Purchase Theme</h2>

                        <form id="buyNowForm">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-300 mb-2">License Type</label>
                                <select name="license_type" class="w-full px-3 py-2 bg-gray-800 text-white rounded-md border border-gray-700">
                                    <option value="business">Business - €49 (1 Application)</option>
                                    <option value="unlimited">Unlimited - €149 (Unlimited Applications)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                                <input type="text" name="name" class="w-full px-3 py-2 bg-gray-800 text-white rounded-md border border-gray-700" placeholder="Your Name">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" required class="w-full px-3 py-2 bg-gray-800 text-white rounded-md border border-gray-700" placeholder="your@email.com">
                            </div>

                            <div class="flex gap-3">
                                <button type="button" onclick="hideBuyNowModal()" class="flex-1 px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-600">
                                    Cancel
                                </button>
                                <button type="submit" id="buyNowBtn" class="flex-1 px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-500">
                                    Buy Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <main>
            {{ $slot }}
        </main>


        <!-- Footer -->
        <footer class="mx-auto max-w-7xl px-6 lg:px-8 py-16 border-t border-gray-800">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-white">Product</h3>
                    <ul role="list" class="mt-4 space-y-2">
                        <li><a href="/editor" class="text-sm text-gray-400 hover:text-white transition-colors">Theme Editor</a></li>
                        <li><a href="/#features" class="text-sm text-gray-400 hover:text-white transition-colors">Features</a></li>
                        <li><a href="/#examples" class="text-sm text-gray-400 hover:text-white transition-colors">Examples</a></li>
                        <li><a href="/#pricing" class="text-sm text-gray-400 hover:text-white transition-colors">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white">Support</h3>
                    <ul role="list" class="mt-4 space-y-2">
                        {{-- <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Documentation</a></li> --}}
                        <li><a href="/#faq" class="text-sm text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Discord</a></li>
                        <li><a href="mailto:hey@denniskoch.dev" class="text-sm text-gray-400 hover:text-white transition-colors">E-Mail</a></li>
                    </ul>
                </div>
                {{-- <div>
                    <h3 class="text-sm font-semibold text-white">Company</h3>
                    <ul role="list" class="mt-4 space-y-2">
                        <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Press</a></li>
                    </ul>
                </div> --}}
                <div>
                    <h3 class="text-sm font-semibold text-white">Legal</h3>
                    <ul role="list" class="mt-4 space-y-2">
                        <li><a href="/privacy-policy" class="text-sm text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="/legal-notice" class="text-sm text-gray-400 hover:text-white transition-colors">Legal Notice</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <p class="text-sm text-gray-400">© 2024 Filament Studio. All rights reserved.</p>
                    <div class="flex items-center space-x-4 mt-4 md:mt-0">
                        <a href="https://denniskoch.dev" target="_blank" rel="noopener" class="text-gray-400 hover:text-white transition-colors" title="Website">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 1024 1024">
                                <path fill="currentColor" d="M1025.02 512c0-272.016-213.663-495.104-482.319-511.023c-5.536-.608-11.088-1.009-16.72-1.009c-1.664 0-3.328.176-4.992.224c-2.992-.048-5.968-.224-8.992-.224C229.117-.032-1.026 229.664-1.026 512s230.144 512.032 513.023 512.032c3.024 0 6-.176 9.008-.24c1.664.064 3.328.24 4.992.24c5.632 0 11.184-.4 16.72-1.009c268.64-15.92 482.304-238.976 482.303-511.023m-95.451 164.832c-17.632-5.12-61.92-16.24-140.064-25.392c6.464-44.192 10-90.896 10-139.44c0-38.256-2.208-75.343-6.288-111.008c99.008-11.824 142.384-26.72 145.296-27.745l-11.92-33.584c22.24 53.088 34.56 111.296 34.56 172.336c0 58.193-11.28 113.761-31.583 164.833zM285.488 512.001c0-35.808 2.37-70.77 6.705-104.401c51.888 4.08 113.936 7.088 186.863 7.792v222.064c-70.992.688-131.664 3.568-182.688 7.473c-7.04-42.193-10.88-86.88-10.88-132.928M542.945 68.223c78.464 22.736 145.648 131.695 175.744 276.111c-48.368 3.856-106.624 6.673-175.744 7.33zm-63.886.783V351.63c-68.368-.688-126.88-3.473-176.063-7.232C333.7 201.79 401.428 93.646 479.059 69.006m0 632.223l.001 253.743c-72.4-22.976-136.192-118.575-169.36-247.023c47.76-3.504 104.096-6.063 169.359-6.72m63.888 254.543l-.001-254.56c65.952.623 122.064 3.28 169.217 6.928c-32.608 130.128-96 226.416-169.216 247.632m-.001-318.32l.001-222.032c73.311-.688 134.991-3.776 186.191-8a845 845 0 0 1 6.496 104.592c0 46.128-3.712 90.864-10.528 133.12c-50.416-4.08-110.8-7.008-182.16-7.68m371.858-323.52c-9.664 3.008-50.063 14.48-131.023 24.032c-18.048-95.952-50.672-177.968-93.12-237.168C788.197 143.18 867.797 219.1 914.805 313.932zM358.82 90.589c-52.208 59.952-94.832 146.161-118.096 248.113c-72.48-7.856-115.921-17.089-133.312-21.281c50.72-104.64 141.04-186.752 251.408-226.832M83.637 377.182c12.32 3.344 58.913 14.941 145.553 24.525a796 796 0 0 0-7.68 110.305c0 48.273 4.368 94.721 12.24 138.688c-74.4 8.033-120.16 17.649-140.688 22.609c-19.44-50.096-30.208-104.447-30.208-161.312c0-46.96 7.312-92.256 20.783-134.815m37.457 355.166c23.264-4.944 64.912-12.464 126.592-18.928c24.288 89.712 63.792 165.616 111.136 219.968c-101.12-36.72-185.296-108.752-237.728-201.04M690.662 923.18c38.224-53.264 68.48-125.024 87.296-208.801c63.408 7.28 103.216 15.792 123.296 20.864c-48.016 83.072-121.855 149.393-210.592 187.937" />
                            </svg>
                        </a>
                        <a href="https://github.com/pxlrbt" target="_blank" rel="noopener" class="text-gray-400 hover:text-white transition-colors" title="GitHub">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 .297c-6.63 0-12 5.373-12 12c0 5.303 3.438 9.8 8.205 11.385c.6.113.82-.258.82-.577c0-.285-.01-1.04-.015-2.04c-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729c1.205.084 1.838 1.236 1.838 1.236c1.07 1.835 2.809 1.305 3.495.998c.108-.776.417-1.305.76-1.605c-2.665-.3-5.466-1.332-5.466-5.93c0-1.31.465-2.38 1.235-3.22c-.135-.303-.54-1.523.105-3.176c0 0 1.005-.322 3.3 1.23c.96-.267 1.98-.399 3-.405c1.02.006 2.04.138 3 .405c2.28-1.552 3.285-1.23 3.285-1.23c.645 1.653.24 2.873.12 3.176c.765.84 1.23 1.91 1.23 3.22c0 4.61-2.805 5.625-5.475 5.92c.42.36.81 1.096.81 2.22c0 1.606-.015 2.896-.015 3.286c0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" />
                            </svg>
                        </a>
                        <a href="https://phpc.social/@denniskoch" target="_blank" rel="me noopener" class="text-gray-400 hover:text-white transition-colors" title="Mastodon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M23.268 5.313c-.35-2.578-2.617-4.61-5.304-5.004C17.51.242 15.792 0 11.813 0h-.03c-3.98 0-4.835.242-5.288.309C3.882.692 1.496 2.518.917 5.127C.64 6.412.61 7.837.661 9.143c.074 1.874.088 3.745.26 5.611c.118 1.24.325 2.47.62 3.68c.55 2.237 2.777 4.098 4.96 4.857c2.336.792 4.849.923 7.256.38q.398-.092.786-.213c.585-.184 1.27-.39 1.774-.753a.06.06 0 0 0 .023-.043v-1.809a.05.05 0 0 0-.02-.041a.05.05 0 0 0-.046-.01a20.3 20.3 0 0 1-4.709.545c-2.73 0-3.463-1.284-3.674-1.818a5.6 5.6 0 0 1-.319-1.433a.053.053 0 0 1 .066-.054c1.517.363 3.072.546 4.632.546c.376 0 .75 0 1.125-.01c1.57-.044 3.224-.124 4.768-.422q.059-.011.11-.024c2.435-.464 4.753-1.92 4.989-5.604c.008-.145.03-1.52.03-1.67c.002-.512.167-3.63-.024-5.545m-3.748 9.195h-2.561V8.29c0-1.309-.55-1.976-1.67-1.976c-1.23 0-1.846.79-1.846 2.35v3.403h-2.546V8.663c0-1.56-.617-2.35-1.848-2.35c-1.112 0-1.668.668-1.67 1.977v6.218H4.822V8.102q0-1.965 1.011-3.12c.696-.77 1.608-1.164 2.74-1.164c1.311 0 2.302.5 2.962 1.498l.638 1.06l.638-1.06c.66-.999 1.65-1.498 2.96-1.498c1.13 0 2.043.395 2.74 1.164q1.012 1.155 1.012 3.12z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>

        @vite('resources/js/app.js')

        <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @if(request()->is('editor'))
            <script>
                function showBuyNowModal() {
                    document.getElementById('buyNowModal').classList.remove('hidden');
                }

                function hideBuyNowModal() {
                    document.getElementById('buyNowModal').classList.add('hidden');
                }

                document.getElementById('buyNowForm').addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const formData = new FormData(e.target);
                    const email = formData.get('email');
                    const name = formData.get('name');
                    const licenseType = formData.get('license_type');

                    const buyNowBtn = document.getElementById('buyNowBtn');
                    const originalText = buyNowBtn.textContent;

                    // Show loading state
                    buyNowBtn.textContent = 'Creating checkout...';
                    buyNowBtn.disabled = true;

                    // Get the current theme configuration from the theme editor
                    let configuration = {};
                    if (window.themeEditorInstance && typeof window.themeEditorInstance.getCurrentConfiguration === 'function') {
                        configuration = window.themeEditorInstance.getCurrentConfiguration();
                    } else {
                        // Fallback: try to get configuration from Alpine.js data
                        const themeEditorElement = document.querySelector('[x-data*="themeEditor"]');
                        if (themeEditorElement && themeEditorElement.__x && themeEditorElement.__x.$data) {
                            const editorData = themeEditorElement.__x.$data;
                            if (typeof editorData.getCurrentConfiguration === 'function') {
                                configuration = editorData.getCurrentConfiguration();
                            } else {
                                // Basic fallback configuration
                                configuration = {
                                    form: editorData.form || {},
                                    themeMode: editorData.themeMode || 'dark',
                                    currentPreset: editorData.currentPreset || 'default'
                                };
                            }
                        }
                    }

                    try {
                        const response = await fetch('/checkout', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                configuration: configuration,
                                license_type: licenseType,
                                email: email,
                                name: name
                            })
                        });

                        const data = await response.json();

                        if (response.ok && data.checkout_url) {
                            // Redirect to Lemon Squeezy checkout
                            window.location.href = data.checkout_url;
                        } else {
                            // Reset button
                            buyNowBtn.textContent = originalText;
                            buyNowBtn.disabled = false;

                            alert('Error creating checkout: ' + (data.error || data.message || 'Unknown error'));
                        }
                    } catch (error) {
                        // Reset button
                        buyNowBtn.textContent = originalText;
                        buyNowBtn.disabled = false;

                        alert('Error: ' + error.message);
                    }
                });

                // Close modal when clicking outside
                document.getElementById('buyNowModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideBuyNowModal();
                    }
                });
            </script>
        @endif
    </body>
</html>
