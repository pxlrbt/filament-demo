<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-2xl mx-auto text-center">
            <div class="mb-8">
                <div class="w-20 h-20 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h1 class="text-4xl font-bold text-white mb-4">Payment Successful!</h1>
                <p class="text-lg text-gray-300 mb-8">
                    Thank you for your purchase! Your theme is now ready to download.
                </p>
            </div>

            <div class="bg-gray-900 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">Your Theme Code</h2>
                
                <div class="bg-gray-800 rounded-md p-4 mb-4">
                    <pre class="text-sm text-gray-300 whitespace-pre-wrap overflow-x-auto"><code>{{ $themeConfig->generateThemeCode() }}</code></pre>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button 
                        onclick="copyToClipboard()"
                        class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-500 transition-colors"
                    >
                        Copy to Clipboard
                    </button>
                    <button 
                        onclick="downloadTheme()"
                        class="px-6 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-600 transition-colors"
                    >
                        Download as File
                    </button>
                </div>
            </div>

            <div class="bg-gray-900 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-3">Purchase Details</h3>
                <div class="text-left space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-400">License Type:</span>
                        <span class="text-white capitalize">{{ $themeConfig->license_type }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Name:</span>
                        <span class="text-white">{{ $themeConfig->name ?: $themeConfig->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Email:</span>
                        <span class="text-white">{{ $themeConfig->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Purchase Token:</span>
                        <span class="text-white font-mono text-sm">{{ $themeConfig->purchase_token }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Date:</span>
                        <span class="text-white">{{ $themeConfig->created_at->format('F j, Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <a href="/editor" class="inline-flex items-center text-orange-500 hover:text-orange-400 transition-colors">
                    ← Create Another Theme
                </a>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const code = document.querySelector('pre code').textContent;
            navigator.clipboard.writeText(code).then(function() {
                alert('Theme code copied to clipboard!');
            });
        }

        function downloadTheme() {
            const code = document.querySelector('pre code').textContent;
            const blob = new Blob([code], { type: 'text/css' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'filament-theme.css';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
    </script>
</x-layouts.app>