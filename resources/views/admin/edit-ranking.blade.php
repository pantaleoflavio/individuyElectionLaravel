<x-admin-layout>
    <h2 class="text-center">Modifica Ranking: {{ $ranking->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-center">
        <form action="{{ route('admin.ranking.update', $ranking->id) }}" method="post" class="w-50">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" value="{{ $ranking->name }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Descrizione:</label>
                <textarea rows="3" name="description" id="description" class="form-control">{{ $ranking->description }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="type">Tipo:</label>
                <select name="type" id="type" class="form-select">
                    <option value="">Seleziona Tipo</option>
                    <option value="wrestler" {{ $ranking->type ? 'selected' : '' }} >Wrestler</option>
                    <option value="tag team" {{ $ranking->type ? 'selected' : '' }} >Tag Team</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="status">Stato Attivo:</label>
                <select name="status" id="status" class="form-select">
                    <option value="1" {{ $ranking->status ? 'selected' : '' }} >Attivo</option>
                    <option value="0" {{ $ranking->status ? 'selected' : '' }} >Inattivo</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="category_id">Categoria:</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Seleziona Categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $ranking->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="includes_inactive">Includi Inattivi:</label>
                <select name="includes_inactive" id="includes_inactive" class="form-select">
                    <option value="0" {{ $ranking->include_inactive ? 'selected' : '' }} >No</option>
                    <option value="1" {{ $ranking->include_inactive ? 'selected' : '' }} >Sì</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</x-admin-layout>
