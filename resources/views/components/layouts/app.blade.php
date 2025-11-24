<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="flex items-center justify-center">
        {{ $slot }}
    </flux:main>

    {{ $script ?? '' }}
</x-layouts.app.sidebar>
