@props(['item', 'url'])

@php
    $categoryNames = collect();
    if (method_exists($item, 'categories')) {
        $categoryNames = $categoryNames->merge($item->categories->pluck('name'));
    }
    if (isset($item->category) && $item->category) {
        $categoryNames->push($item->category->name);
    }
    $categoryNames = $categoryNames->filter()->unique()->values();

    $federationNames = collect();
    if (method_exists($item, 'federations')) {
        $federationNames = $federationNames->merge($item->federations->pluck('name'));
    }
    if (isset($item->federation) && $item->federation) {
        $federationNames->push($item->federation->name);
    }
    $federationNames = $federationNames->filter()->unique()->values();
@endphp

<tr>
    <td>
        @if($item instanceof \App\Models\Wrestler)
            <a href="{{ route('wrestlers.show', $item->id) }}">{{ $item->name }}</a>
        @elseif($item instanceof \App\Models\TagTeam)
            <a href="{{ route('tag-teams.show', $item->id) }}">{{ $item->name }}</a>
        @else
            {{ $item->name }}
        @endif
    </td>
    <td>{{ $categoryNames->isNotEmpty() ? $categoryNames->implode(', ') : 'Nessuno Stile' }}</td>
    <td>{{ $item->country ?? 'Nessuna Nazione' }}</td>
    <td>{{ $federationNames->isNotEmpty() ? $federationNames->implode(', ') : 'Nessuna Federazione' }}</td>
    <td>
        <a href="{{ $url }}" class="btn btn-primary">{{$slot}}</a>
    </td>
</tr>
