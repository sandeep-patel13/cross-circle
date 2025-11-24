<div class="d-flex justify-content-center w-100">
    @if ($gameStarter == null)
        <livewire:game-starter-form-livewire />
    @else
        <livewire:cross-circle-box-livewire :gameStarter="$gameStarter" />
    @endif
</div>
