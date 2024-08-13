<x-layout>
    @foreach ($rankings as $ranking)
        <x-sub-card 
            title="{{ $ranking->name }}" 
            text="{{ $ranking->description }}" 
            href="/wrestler-candidates?category_id={{ $ranking->category_id }}&includes_inactive={{ $ranking->includes_inactive }}&ranking_id={{ $ranking->id }}"
        />
    @endforeach
</x-layout>