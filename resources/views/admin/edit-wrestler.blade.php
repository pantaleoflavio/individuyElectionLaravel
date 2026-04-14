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
                <label for="description">Descrizione:</label>
                <textarea rows="3" name="description" id="description" class="form-control" required>{{ $wrestler->description }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="country">Paese:</label>
                <input type="text" name="country" id="country" value="{{ $wrestler->country }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="category_ids">Categorie:</label>
                <select name="category_ids[]" id="category_ids" class="form-select" multiple required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $wrestler->categories->contains($category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="federation_ids">Federazioni:</label>
                <select name="federation_ids[]" id="federation_ids" class="form-select" multiple required>
                    @foreach($federations as $federation)
                        <option value="{{ $federation->id }}" {{ $wrestler->federations->contains($federation->id) ? 'selected' : '' }}>
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
