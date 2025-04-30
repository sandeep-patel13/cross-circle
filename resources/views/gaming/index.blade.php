<x-master-layout>
    <x-slot name="mainSlot">
        <livewire:cross-circle-master-livewire />
    </x-slot>

    <x-slot name="script">
        <script>
            function goBack() {
                window.location.href = "{{ route('play-game') }}";
            }
        </script>
    </x-slot>

</x-master-layout>
