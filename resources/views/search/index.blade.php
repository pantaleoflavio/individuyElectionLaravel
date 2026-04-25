<x-layout>
    <x-second-title>Risultati ricerca</x-second-title>

    @if($query === '')
        <p>Inserisci un testo nella barra di ricerca per trovare wrestler, tag team, federazioni o classifiche.</p>
    @else
        <p>
            Risultati per: <strong>{{ $query }}</strong>
        </p>

        <h4>Wrestler</h4>
        <ul>
            @forelse($wrestlers as $wrestler)
                <li><a href="{{ route('wrestlers.show', $wrestler) }}">{{ $wrestler->name }}</a></li>
            @empty
                <li>Nessun wrestler trovato.</li>
            @endforelse
        </ul>

        <h4>Tag Team</h4>
        <ul>
            @forelse($tagTeams as $tagTeam)
                <li><a href="{{ route('tag-teams.show', $tagTeam) }}">{{ $tagTeam->name }}</a></li>
            @empty
                <li>Nessun tag team trovato.</li>
            @endforelse
        </ul>

        <h4>Federazioni</h4>
        <ul>
            @forelse($federations as $federation)
                <li><a href="{{ route('federations.show', $federation->id) }}">{{ $federation->name }}</a></li>
            @empty
                <li>Nessuna federazione trovata.</li>
            @endforelse
        </ul>

        <h4>Classifiche</h4>
        <ul>
            @forelse($rankings as $ranking)
                <li><a href="{{ route('rankings.show', $ranking->id) }}">{{ $ranking->name }}</a></li>
            @empty
                <li>Nessuna classifica trovata.</li>
            @endforelse
        </ul>
    @endif
</x-layout>