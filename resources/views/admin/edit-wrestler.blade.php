<x-admin-layout>
    <h2 class="text-center">Modifica Wrestler: {{ $wrestler->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-center">
        <form action="{{ route('admin.wrestler.update', $wrestler->id) }}" method="post" class="w-50">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" value="{{ $wrestler->name }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="country">Paese:</label>
                <input type="text" name="country" id="country" value="{{ $wrestler->country }}" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="category_id">Categoria:</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Seleziona Categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $wrestler->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="federation_id">Federazione:</label>
                <select name="federation_id" id="federation_id" class="form-select">
                    <option value="">Seleziona Federazione</option>
                    @foreach($federations as $federation)
                        <option value="{{ $federation->id }}" {{ $federation->id == $wrestler->federation_id ? 'selected' : '' }}>
                            {{ $federation->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="is_active">Attivita:</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $wrestler->is_active ? 'selected' : '' }}>Attivo</option>
                    <option value="0" {{ !$wrestler->is_active ? 'selected' : '' }}>Ritirato</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</x-admin-layout>
