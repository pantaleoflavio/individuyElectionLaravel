<x-layout>
    @if($rankings->isEmpty())
        <div class="alert alert-info">
            Non ci sono federation ranking disponibili.
        </div>
    @else
        @foreach ($rankings as $ranking)
            <x-sub-card
                title="{{ $ranking->name }}"
                text="{{ $ranking->description }}"
                href="{{ route('federations.candidates', ['ranking_id' => $ranking->id]) }}"
            />
        @endforeach
    @endif
</x-layout>