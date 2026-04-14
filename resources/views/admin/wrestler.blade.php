<x-admin-layout>
    <h2>Lista Wrestler</h2>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.wrestler.add') }}" class="btn btn-success">Aggiungi nuovo Wrestler</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrizione</th>
                <th>Categorie</th>
                <th>Paese</th>
                <th>Federazioni</th>
                <th>Stato</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($wrestlers as $wrestler)
                <tr>
                    <td>{{ $wrestler->name }}</td>
                    <td>{{ $wrestler->description }}</td>
                    <td>{{ $wrestler->categories->pluck('name')->join(', ') ?: 'Nessuna Categoria' }}</td>
                    <td>{{ $wrestler->country ?? 'Nessuna Nazione' }}</td>
                    <td>{{ $wrestler->federations->pluck('name')->join(', ') ?: 'Nessuna Federazione' }}</td>
                    <td>{{ $wrestler->is_active ? 'in attivita' : 'ritirato' }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.wrestler.edit', $wrestler->id) }}" class="btn btn-primary">Modifica</a>
                        <form method="POST" action="{{ route('admin.wrestler.delete', $wrestler->id) }}" data-confirm="true">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin-layout>
