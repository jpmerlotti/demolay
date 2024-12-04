<x-filament::page>
    <section>
        @livewire('vault.transactions-table', ['vault' => $this->record])
    </section>
</x-filament::page>
