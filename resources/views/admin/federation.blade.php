<x-admin-layout>
    <!-- Federation List-->

    <h2>Lista Federazioni</h2>
    <div class="row">
        <table id="">
            <thead>
                <tr>
                    <th data-sort="name">Federazione<i class="fa-solid" id="icon-name"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($federations as $federation)
                    <tr class="">
                        <td class="">
                            {{ $federation->name}}
                        </td>
                        <td class="d-flex justify-content-end mx-3">
                            <a href="{{ route('admin.federation.edit', $federation->id) }}" class="btn btn-primary mx-5">
                                Modifica
                            </a>
                            <form method="post" action="{{ route('admin.federation.delete', $federation->id) }}" data-confirm="true">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-5">Elimina</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <h3>Aggiungi Federazione</h3>
        <form action="{{ route('admin.federation.store') }}" method="post" class="form-inline d-inline-block">
            @csrf
            <div class="form-group mb-3 d-inline-block">
                <label for="name" class="mr-2">Nome Federazione:</label>
                <input type="text" name="name" id="name" class="form-control d-inline-block" required>
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