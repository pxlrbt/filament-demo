@props([
    'id',
    'open' => false
])
<div class="border border-current/10 rounded">
    <details {{ $open ? 'open' : '' }}>
        <summary class="relative flex w-full items-start justify-between text-left px-4 py-2">
            <span class="text-base/7 font-semibold">
                {{ $title }}
            </span>

            <span class="ml-6 flex h-7 items-center">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-open:hidden">
                    <path d="M12 6v12m6-6H6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-open:hidden">
                    <path d="M18 12H6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        </summary>

    <div class="px-4 py-2 space-y-4">
        {{ $slot }}
    </div>
</div>
