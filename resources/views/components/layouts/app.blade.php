<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    {{ $script ?? '' }}
</x-layouts.app.sidebar>
