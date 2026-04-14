<x-admin-layout>
    <h2 class="text-center">Modifica Ranking: {{ $ranking->name }}</h2>

    <div class="d-flex justify-content-center">
        <form action="{{ route('admin.ranking.update', $ranking->id) }}" method="post" class="w-50">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $ranking->name) }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Descrizione:</label>
                <textarea rows="3" name="description" id="description" class="form-control">{{ old('description', $ranking->description) }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="status">Status del Ranking:</label>
                <select name="status" class="form-select">
                    <option value="1" {{ $ranking->status ? 'selected' : '' }}>Attivo</option>
                    <option value="0" {{ !$ranking->status ? 'selected' : '' }}>Non Attivo</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="category_id">Categoria:</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Seleziona Categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $ranking->category_id === $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="federation_id">Federazione:</label>
                <select name="federation_id" id="federation_id" class="form-select">
                    <option value="">Seleziona Federazione</option>
                    @foreach ($federations as $federation)
                        <option value="{{ $federation->id }}" {{ $ranking->federation_id === $federation->id ? 'selected' : '' }}>
                            {{ $federation->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="country">Nazionalita:</label>
                <input type="text" name="country" id="country" value="{{ old('country', $ranking->country) }}" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="includes_inactive">Includi Inattivi:</label>
                <select name="includes_inactive" id="includes_inactive" class="form-select">
                    <option value="0" {{ !$ranking->includes_inactive ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $ranking->includes_inactive ? 'selected' : '' }}>Sì</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</x-admin-layout>
