<x-admin-layout>
    <!-- Ranking List-->
    @php
        $categories = $categories ?? collect();
        $federations = $federations ?? collect();
    @endphp
    <h2>Lista Ranking</h2>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <table>
            <thead>
                <tr>
                    <th data-sort="name">Ranking<i class="fa-solid" id="icon-name"></i></th>
                    <th>Descrizione</th>
                    <th data-sort="type">Tipologia<i class="fa-solid" id="icon-type"></i></th>
                    <th data-sort="status">Status<i class="fa-solid" id="icon-status"></i></th>
                    <th data-sort="includes_inactive">Include Inattivi?<i class="fa-solid" id="icon-includes_inactive"></i></th>
                    <th data-sort="date">Data creazione<i class="fa-solid" id="icon-date"></i></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($rankings as $ranking)
                    <tr>
                        <td>{{ $ranking->name }}</td>
                        <td>{{ $ranking->description }}</td>
                        <td>{{ $ranking->type }}</td>
                        <td>{{ $ranking->status ? 'attivo' : 'non attivo' }}</td>
                        <td>{{ $ranking->includes_inactive ? 'si' : 'no' }}</td>
                        <td>{{ $ranking->created_at }}</td>
                        <td class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('admin.ranking.edit', $ranking->id) }}" class="btn btn-primary mx-1">Modifica</a>
                            <form method="post" action="{{ route('admin.ranking.delete', $ranking->id) }}" data-confirm="true">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-1">Elimina</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <h3>Aggiungi Ranking</h3>
        <div class="mb-3">
            <form action="{{ route('admin.ranking.federation.create') }}" method="post" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-outline-primary" {{ ($federationRankingExists ?? false) ? 'disabled' : '' }}>
                    Crea ranking federazioni
                </button>
            </form>
            @if($federationRankingExists ?? false)
                <small class="d-block text-muted mt-2">Il ranking federazioni esiste già.</small>
            @endif
        </div>
        <form action="{{ route('admin.ranking.store') }}" method="post" class="form-inline d-inline-block">
            @csrf
            <div class="form-group mb-3 d-block">
                <label for="name" class="mr-2">Nome Ranking:</label>
                <input type="text" name="name" id="name" class="form-control d-inline-block" required>
            </div>
            <div class="form-group mb-3 d-block">
                <label for="description" class="mr-2">Descrizione:</label>
                <textarea name="description" id="description" class="form-control d-inline-block" rows="3" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="type">Tipo:</label>
                <select name="type" id="type" class="form-select">
                    <option value="">Seleziona Tipo</option>
                    <option value="wrestler">Wrestler</option>
                    <option value="tag team">Tag Team</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="status">Stato:</label>
                <select name="status" id="status" class="form-select">
                    <option value="1">Attivo</option>
                    <option value="0">Inattivo</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="category_id">Categoria (facoltativa - e' possibile selezionarne piu di una):</label>
                 <select name="category_ids[]" id="category_ids" class="form-select" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="federation_id">Federazione (facoltativa - e' possibile selezionarne piu di una):</label>
                <select name="federation_ids[]" id="federation_ids" class="form-select" multiple>
                    @foreach ($federations as $federation)
                        <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="countries_text">Nazionalità (facoltativa - e' possibile selezionarne piu di una. Es: Italy, Japan, Mexico):</label>
                <input type="text" name="countries_text" id="countries_text" class="form-control" placeholder="Italy, Japan, Mexico">
            </div>
            <div class="form-group mb-3">
                <label for="includes_inactive">Includi Inattivi:</label>
                <select name="includes_inactive" id="includes_inactive" class="form-select">
                    <option value="0">No</option>
                    <option value="1">Sì</option>
                </select>
            </div>
            <div class="text-center d-inline-block">
                <button type="submit" class="btn btn-primary ml-2">Salva</button>
            </div>
        </form>

    </div>
</x-admin-layout>