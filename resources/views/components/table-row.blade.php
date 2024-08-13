@props(['item', 'url'])

<tr>
    <td>{{ $item->name }}</td>
    <td>{{ $item->country ?? 'Nessuna Nazione' }}</td>
    <td>{{ $item->federation->name ?? 'Nessuna Federazione' }}</td>
    <td>
        <a href="{{ $url }}" class="btn btn-primary">Vota</a>
    </td>
</tr>
