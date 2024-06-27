<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">

    <div x-data="{
        state: $wire.$entangle('{{ $getStatePath() }}'),
        formatAmount(event) {

            let number = event.target.value;

            const options = { currency: 'BRL', minimumFractionDigits: 2, maximumFractionDigits: 2 }
            const formatNumber = new Intl.NumberFormat('pt-BR', options)

            number = number.replace( /[^0-9]/g, '' );

            if (number.length == 0) number = '0.00';
            else if (number.length == 1) number = '0.0' + number;
            else if( number.length == 2 ) number = '0.' + number;
            else number = number.substring( 0, number.length - 2 ) + '.' + number.substring( number.length - 2, number.length );

            number = new Number( number );
            number = number.toFixed( 2 );

            this.state = formatNumber.format(number)

        }
    }">

        <x-filament::input.wrapper :valid="! $errors->has('name')" >
            <x-slot name="prefix">
                R$
            </x-slot>
            <x-filament::input type="text" x-model="state" x-on:keyup="formatAmount"/>
        </x-filament::input.wrapper>

    </div>

</x-dynamic-component>
