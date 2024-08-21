<x-admin-layout>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3>Modifica Stile</h3>
    <form action="{{ route('admin.category.update', $category->id) }}" method="post" class="form-inline d-inline-block">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-3 d-inline-block">
            <label for="name" class="mr-2">Nome Stile:</label>
            <input type="text" name="name" value="{{ $category->name }}" id="name" class="form-control d-inline-block" required>
        </div>
        <div class="text-center d-inline-block">
            <button type="submit" class="btn btn-primary ml-2">Salva</button>
        </div>
    </form>

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