<x-layout>
    <x-second-title>Federazione: {{ $federation->name }}</x-second-title>

    <h2>Wrestlers</h2>
    <ul class="list-group">
        @foreach ($wrestlers as $wrestler)
            <li class="list-group-item">{{ $wrestler->name }}</li>
        @endforeach
    </ul>

    <h2>Tag Teams</h2>
    <ul class="list-group">
        @foreach ($tagTeams as $tagTeam)
            <li class="list-group-item">{{ $tagTeam->name }}</li>
        @endforeach
    </ul>
</x-layout>
