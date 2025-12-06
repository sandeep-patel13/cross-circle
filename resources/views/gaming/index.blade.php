<x-layouts.app :title="__('Dashboard')" fluxMainClasses="flex items-center justify-center">

    <livewire:cross-circle-master-livewire />


    <x-slot:script>
        <script>
            function goBack() {
                window.location.href = "{{ route('play-game') }}";
            }
        </script>
    </x-slot>

</x-layouts.app>
