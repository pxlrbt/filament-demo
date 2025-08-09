<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @vite('resources/css/app.css')
    </head>

    <body class="antialiased bg-gray-900">
        <header class="relative z-10">
            <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
                <div class="flex lg:flex-1">
                    <a href="/" class="-m-1.5 p-1.5 font-bold text-white flex items-center gap-2">
                        <div class="flex items-center">
                            <span class="text-xl">Filament</span>
                            <span class="ml-1 px-2 py-1 text-xs font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-full shadow-sm">Studio</span>
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

                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="/" class="text-sm/6 font-semibold text-white">Home</a>
                    <a href="/editor" class="text-sm/6 font-semibold text-white">Editor</a>
                    <a href="/#faq" class="text-sm/6 font-semibold text-white">FAQ</a>
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
                                        <span class="ml-1 px-2 py-1 text-xs font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-full shadow-sm">Studio</span>
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
                                        <a href="#"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Product</a>
                                        <a href="#"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Features</a>
                                        <a href="#"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Marketplace</a>
                                        <a href="#"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Company</a>
                                    </div>
                                    <div class="py-6">
                                        <a href="#"
                                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Log
                                            in</a>
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

        <main class="px-2">
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
                    <div class="flex items-center space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.083.346-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.748-1.378 0 0-.599 2.282-.744 2.84-.282 1.084-1.064 2.456-1.549 3.235C9.584 23.815 10.77 24.001 12.017 24.001c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
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
