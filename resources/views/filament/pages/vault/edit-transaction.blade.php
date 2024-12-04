<x-filament::page>
    <section>
        <form wire:submit.prevent="save">
            {{ $this->form }}
        </form>
    </section>
</x-filament::page>
