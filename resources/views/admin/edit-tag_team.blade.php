<x-admin-layout>
    <h2 class="text-center">Modifica Tag Team: {{ $tagTeam->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-center">
        <form action="{{ route('admin.tag_team.update', $tagTeam->id) }}" method="post" class="w-50">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" value="{{ $tagTeam->name }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Descrizione:</label>
                <textarea name="description" id="description" class="form-control" rows="3" required>{{ $tagTeam->description }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="image_url">Immagine URL (facoltativa):</label>
                <input type="url" name="image_url" id="image_url" value="{{ $tagTeam->image_url }}" class="form-control" placeholder="https://...">
            </div>

            <div class="form-group mb-3">
                <label for="country">Paese:</label>
                <input type="text" name="country" id="country" value="{{ $tagTeam->country }}" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label class="d-block">Categorie:</label>
                @php($selectedCategoryIds = collect(old('category_ids', $tagTeam->categories->pluck('id')->all()))->map(fn($id) => (int) $id)->all())
                @foreach ($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="category_ids[]" id="edit_category_{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, $selectedCategoryIds, true) || $tagTeam->category_id == $category->id ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_category_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>

            <div class="form-group mb-3">
                <label class="d-block">Federazioni:</label>
                @php($selectedFederationIds = collect(old('federation_ids', $tagTeam->federations->pluck('id')->all()))->map(fn($id) => (int) $id)->all())
                @foreach($federations as $federation)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="federation_ids[]" id="edit_federation_{{ $federation->id }}" value="{{ $federation->id }}" {{ in_array($federation->id, $selectedFederationIds, true) || $tagTeam->federation_id == $federation->id ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_federation_{{ $federation->id }}">{{ $federation->name }}</label>
                    </div>
                @endforeach
            </div>

            <div class="form-group mb-3">
                <label for="is_active">Attivita:</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $tagTeam->is_active ? 'selected' : '' }}>Attivo</option>
                    <option value="0" {{ !$tagTeam->is_active ? 'selected' : '' }}>Ritirato</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</x-admin-layout>
