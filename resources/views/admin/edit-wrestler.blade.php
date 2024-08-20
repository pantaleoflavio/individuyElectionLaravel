<x-admin-layout>
    <h2>Modifica Wrestler: {{ $wrestler->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.wrestler.update', $wrestler->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" value="{{$wrestler->name}}" required>
        </div>

        <div class="form-group">
            <label for="country">Paese:</label>
            <input type="text" name="country" id="country" value="{{$wrestler->country}}">
        </div>

        <div class="form-group">
            <label for="category_id">Categoria:</label>
            <select name="category_id" id="category_id">
                <option value="">Seleziona Categoria</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $wrestler->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="federation_id">Federazione:</label>
            <select name="federation_id" id="federation_id">
                <option value="">Seleziona Federazione</option>
                @foreach($federations as $federation)
                    <option value="{{ $federation->id }}" {{ $federation->id == $wrestler->federation_id ? 'selected' : '' }}>
                        {{ $federation->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="is_active">Attivita:</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ $wrestler->is_active ? 'selected' : '' }}>Attivo</option>
                <option value="0" {{ !$wrestler->is_active ? 'selected' : '' }}>Ritirato</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
    </form>
</x-admin-layout>