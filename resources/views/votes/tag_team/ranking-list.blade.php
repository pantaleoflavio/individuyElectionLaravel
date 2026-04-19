<x-layout>
    @foreach ($rankings as $ranking)
        <x-sub-card
            title="{{ $ranking->name }}"
            text="{{ $ranking->description }}"
            href="/tag-team-candidates?ranking_id={{ $ranking->id }}"
        />
    @endforeach
</x-layout>