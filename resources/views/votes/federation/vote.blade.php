<x-layout>
    <x-second-title>Vota per {{ $federation->name }} - nel ranking: {{ $ranking->name }}</x-second-title>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div><strong>Federazione:</strong> {{ $federation->name }}</div>

    <form action="{{ route('vote.federation.store') }}" method="POST">
        @csrf
        <input type="hidden" name="federation_id" value="{{ $federation->id }}">
        <input type="hidden" name="ranking_id" value="{{ $ranking->id }}">

        <div class="form-group">
            <label for="vote">Seleziona il tuo voto:</label>
            @if($existingVote !== null)
                <p><strong>Voto attuale:</strong> {{ $existingVote }}</p>
            @endif
            <div>
                @foreach($voteOptions as $option)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="vote" id="vote-{{ $option }}" value="{{ $option }}" {{ (float) $existingVote === (float) $option ? 'checked' : '' }} required>
                        <label class="form-check-label" for="vote-{{ $option }}">{{ $option }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">{{ $existingVote !== null ? 'Aggiorna voto' : 'Vota' }}</button>
    </form>
</x-layout>