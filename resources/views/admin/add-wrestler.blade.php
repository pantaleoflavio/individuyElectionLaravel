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
                <label for="country">Paese:</label>
                <input type="text" name="country" id="country" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="category_ids">Categorie:</label>
                <select name="category_ids[]" id="category_ids" class="form-select" multiple required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="federation_ids">Federazioni:</label>
                <select name="federation_ids[]" id="federation_ids" class="form-select" multiple required>
                    @foreach($federations as $federation)
                        <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                    @endforeach
                </select>
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
