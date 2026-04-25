<x-admin-layout>
    @php
        $categories = $categories ?? collect();
        $federations = $federations ?? collect();

        $selectedCategoryIds = old('category_ids', $ranking->categories->pluck('id')->all());
        if (empty($selectedCategoryIds) && $ranking->category_id) {
            $selectedCategoryIds = [$ranking->category_id];
        }

        $selectedFederationIds = old('federation_ids', $ranking->federations->pluck('id')->all());
        if (empty($selectedFederationIds) && $ranking->federation_id) {
            $selectedFederationIds = [$ranking->federation_id];
        }

        $isFederationRanking = $ranking->type === 'federation';
    @endphp

    <h2 class="text-center">Modifica Ranking: {{ $ranking->name }}</h2>

    @if(session('error'))
        <div class="alert alert-danger w-50 mx-auto">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger w-50 mx-auto">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

            @unless($isFederationRanking)
            <div class="form-group mb-3">
                <label for="category_ids">Categorie (facoltative, selezione multipla):</label>
                <select name="category_ids[]" id="category_ids" class="form-select" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, array_map('intval', $selectedCategoryIds), true) ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="federation_ids">Federazioni (facoltative, selezione multipla):</label>
                <select name="federation_ids[]" id="federation_ids" class="form-select" multiple>
                    @foreach ($federations as $federation)
                        <option value="{{ $federation->id }}" {{ in_array($federation->id, array_map('intval', $selectedFederationIds), true) ? 'selected' : '' }}>{{ $federation->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="countries_text">Nazionalità (una o più, separate da virgola):</label>
                <input type="text" name="countries_text" id="countries_text" value="{{ old('countries_text', $ranking->country) }}" class="form-control" placeholder="Italy, Japan, Mexico">
            </div>
            @endunless
            
            <div class="form-group mb-3">
                <label for="status">Status del Ranking:</label>
                <select name="status" class="form-select">
                    <option value="1" {{ $ranking->status ? 'selected' : '' }}>Attivo</option>
                    <option value="0" {{ !$ranking->status ? 'selected' : '' }}>Non Attivo</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</x-admin-layout>

