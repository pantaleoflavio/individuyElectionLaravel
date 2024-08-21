<x-admin-layout>
    <!-- Category List-->

    <h2>Lista Stili</h2>
    <div class="row">
        <table id="">
            <thead>
                <tr>
                    <th data-sort="name">Nome dello Stile<i class="fa-solid" id="icon-name"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr class="">
                        <td class="my-2">
                            {{ $category->name}}
                        </td>
                        <td class="d-flex justify-content-center align-items-center my-2">
                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-primary mx-1">
                                Modifica
                            </a>
                            <form method="post" action="{{ route('admin.category.delete', $category->id) }}" data-confirm="true">
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
        <h3>Aggiungi Stile</h3>
        <form action="{{ route('admin.category.store') }}" method="post" class="form-inline d-inline-block">
            @csrf
            <div class="form-group mb-3 d-inline-block">
                <label for="name" class="mr-2">Nome Stile:</label>
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