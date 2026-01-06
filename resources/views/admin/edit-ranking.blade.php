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

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</x-admin-layout>

