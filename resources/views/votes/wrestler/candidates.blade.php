<x-layout>
    <x-second-title>Lista dei Candidati - {{ $ranking->name }}</x-second-title>
    <p>Scegli chi votare</p>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <x-table id="candidatesTable">
        <x-slot name="header">
            <x-table-header />
        </x-slot>

        @foreach($wrestlers as $wrestler)
            <x-table-row :item="$wrestler" url="{{ route('vote.wrestler.form', ['wrestler' => $wrestler->id, 'ranking' => $ranking->id]) }}" />
        @endforeach
    </x-table>

</x-layout>