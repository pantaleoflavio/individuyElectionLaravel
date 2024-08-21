@props(['item', 'url'])

<tr>
    <td>{{ $item->name }}</td>
    <td>{{ $item->category->name ?? 'Nessuno Stile' }}</td>
    <td>{{ $item->country ?? 'Nessuna Nazione' }}</td>
    <td>{{ $item->federation->name ?? 'Nessuna Federazione' }}</td>
    <td>
        <a href="{{ $url }}" class="btn btn-primary">{{$slot}}</a>
    </td>
</tr>
