<x-layout>
    <x-second-title>Vota per {{ $wrestler->name }} - nel ranking: {{ $ranking->name }}</x-second-title>

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
        <strong>Nome:</strong> {{ $wrestler->name }}
    </div>
    <div>
        <strong>Nazione:</strong> {{ $wrestler->country }}
    </div>
    <div>
        <strong>Federazione:</strong> {{ $wrestler->federation->name ?? 'Nessuna Federazione' }}
    </div>

    <form action="{{ route('vote.wrestler.store') }}" method="POST">
        @csrf
        <input type="hidden" name="wrestler_id" value="{{ $wrestler->id }}">
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
