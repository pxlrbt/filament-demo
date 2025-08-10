<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div>
            <h2 class="mb-4">
                Theme Colors
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($this->getColors() as $colorKey)
                    <div class="flex items-center space-x-4">
                        <div
                            class="size-8 rounded-lg border-gray-200 dark:border-gray-600"
                            style="background-color: var(--{{ $colorKey }}-600);"
                        >
                        </div>

                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ ucfirst($colorKey) }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
