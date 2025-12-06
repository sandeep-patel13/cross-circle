@props([
    'fluxMainClasses' => ''
])

<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="{{ $fluxMainClasses }}">
        {{ $slot }}
    </flux:main>

    {{ $script ?? '' }}
</x-layouts.app.sidebar>
