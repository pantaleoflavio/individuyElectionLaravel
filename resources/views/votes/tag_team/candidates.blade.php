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

        @foreach($tagTeams as $tagTeam)
            <x-table-row :item="$tagTeam" url="{{ route('vote.tagTeam.form', ['tagTeam' => $tagTeam->id, 'ranking' => $ranking->id]) }}" />
        @endforeach
    </x-table>

</x-layout>