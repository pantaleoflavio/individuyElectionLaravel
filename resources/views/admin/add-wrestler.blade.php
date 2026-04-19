<x-admin-layout>
    <h2 class="text-center">Aggiungi Wrestler</h2>
    <div class="d-flex justify-content-center">
        <form action="{{ route('admin.wrestler.store') }}" method="post" class="w-50">
        @csrf
            <div class="form-group mb-3">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Descrizione:</label>
                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="image_url">Immagine URL (facoltativa):</label>
                <input type="url" name="image_url" id="image_url" class="form-control" placeholder="https://...">
            </div>
            <div class="form-group mb-3">
                <label for="country">Paese:</label>
                <input type="text" name="country" id="country" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label class="d-block">Categorie:</label>
                @php($oldCategoryIds = collect(old('category_ids', []))->map(fn($id) => (int) $id)->all())
                @foreach ($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="category_ids[]" id="category_{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, $oldCategoryIds, true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="form-group mb-3">
                <label class="d-block">Federazioni:</label>
                @php($oldFederationIds = collect(old('federation_ids', []))->map(fn($id) => (int) $id)->all())
                @foreach($federations as $federation)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="federation_ids[]" id="federation_{{ $federation->id }}" value="{{ $federation->id }}" {{ in_array($federation->id, $oldFederationIds, true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="federation_{{ $federation->id }}">{{ $federation->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="form-group mb-3">
                <label for="is_active">Stato Lottatore:</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="1">In attivita</option>
                    <option value="0">Ritirato</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Salva</button>
            </div>
        </form>
    </div>
</x-admin-layout>