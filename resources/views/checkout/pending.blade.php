<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md mx-auto text-center">
            <div class="mb-8">
                <div class="w-20 h-20 mx-auto mb-6 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-yellow-600 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                
                <h1 class="text-3xl font-bold text-white mb-4">Payment Processing</h1>
                <p class="text-lg text-gray-300 mb-8">
                    We're currently processing your payment. This page will automatically update once your payment is confirmed.
                </p>
            </div>

            <div class="bg-gray-900 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-white mb-3">Purchase Details</h3>
                <div class="text-left space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-400">License Type:</span>
                        <span class="text-white capitalize">{{ $themeConfig->license_type }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Email:</span>
                        <span class="text-white">{{ $themeConfig->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Status:</span>
                        <span class="text-yellow-500 capitalize">{{ $themeConfig->payment_status }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <a href="/editor" class="inline-flex items-center text-orange-500 hover:text-orange-400 transition-colors">
                    ← Back to Editor
                </a>
            </div>
        </div>
    </div>

    <script>
        // Refresh the page every 5 seconds to check for payment completion
        setTimeout(function() {
            window.location.reload();
        }, 5000);
    </script>
</x-layouts.app>