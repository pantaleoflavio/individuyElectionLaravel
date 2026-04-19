<x-layout>
    <x-second-title>Federazione: {{ $federation->name }}</x-second-title>

    <h2>Wrestlers</h2>
    @if ($wrestlers->isEmpty())
        <p>Nessun wrestler trovato per questa federazione.</p>
    @else
        <ul class="list-group">
            @foreach ($wrestlers as $wrestler)
                <li class="list-group-item">
                    <a href="{{ route('wrestlers.show', $wrestler->id) }}">{{ $wrestler->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h2>Tag Teams</h2>
    @if ($tagTeams->isEmpty())
        <p>Nessun tag team trovato per questa federazione.</p>
    @else
        <ul class="list-group">
            @foreach ($tagTeams as $tagTeam)
                <li class="list-group-item">{{ $tagTeam->name }}</li>
            @endforeach
        </ul>
    @endif
</x-layout>
