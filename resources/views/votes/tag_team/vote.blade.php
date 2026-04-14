<x-layout>
    <x-second-title>Vota per {{ $tagTeam->name }} - nel ranking: {{ $ranking->name }}</x-second-title>

    <!-- Sezione per i messaggi di errore -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Sezione per i messaggi di successo -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div>
        <strong>Nome:</strong> {{ $tagTeam->name }}
    </div>
    <div>
        <strong>Nazione:</strong> {{ $tagTeam->country }}
    </div>
    <div>
        <strong>Federazione:</strong> {{ $tagTeam->federation->name ?? 'Nessuna Federazione' }}
    </div>

    <form action="{{ route('vote.tagTeam.store') }}" method="POST">
        @csrf
        <input type="hidden" name="tag_team_id" value="{{ $tagTeam->id }}">
        <input type="hidden" name="ranking_id" value="{{ $ranking->id }}">

        <div class="form-group">
            <label for="vote">Seleziona il tuo voto:</label>
            <div>
                @foreach($voteOptions as $option)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="vote" id="vote-{{ $option }}" value="{{ $option }}" required>
                        <label class="form-check-label" for="vote-{{ $option }}">{{ $option }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Vota</button>
    </form>
</x-layout>
