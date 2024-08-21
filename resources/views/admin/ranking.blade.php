<x-admin-layout>
    <!-- Ranking List-->

    <h2>Lista Ranking</h2>
    <div class="row">
        <table id="">
            <thead>
                <tr>
                    <th data-sort="name">Ranking<i class="fa-solid" id="icon-name"></i></th>
                    <th>Descrizione</th>
                    <th data-sort="type">Tipologia<i class="fa-solid" id="icon-type"></th>
                    <th data-sort="status">Status<i class="fa-solid" id="icon-status"></th>
                    <th data-sort="category">Stile<i class="fa-solid" id="icon-category"></th>
                    <th data-sort="includes_inactive">Include Inattivi?<i class="fa-solid" id="icon-includes_inactive"></th>
                    <th data-sort="date">Data creazione<i class="fa-solid" id="icon-date"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($rankings as $ranking)
                    <tr class="">
                        <td class="">
                            {{ $ranking->name}}
                        </td>
                        <td class="">
                            {{ $ranking->description}}
                        </td>
                        <td class="">
                            {{ $ranking->type}}
                        </td>
                        <td class="">
                            @if($ranking->status)
                            <p>attivo</p>
                            @else
                            <p>non attivo</p>
                            @endif
                        </td>
                        <td class="">
                            {{ $ranking->category->name ?? 'N/A'}}
                        </td>
                        <td class="">
                            @if($ranking->includes_inactive)
                            <p>si</p>
                            @else
                            <p>no</p>
                            @endif
                        </td>
                        <td class="">
                            {{ $ranking->created_at}}
                        </td>
                        <td class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('admin.ranking.edit', $ranking->id) }}" class="btn btn-primary mx-1">
                                Modifica
                            </a>
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
        <h3>Aggiungi Federazione</h3>
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
                <label for="category_id">Categoria:</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Seleziona Categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</x-admin-layout>