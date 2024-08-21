<x-admin-layout>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3>Modifica Federazione</h3>
    <form action="{{ route('admin.federation.update', $federation->id) }}" method="post" class="form-inline d-inline-block">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-3 d-inline-block">
            <label for="name" class="mr-2">Nome Federazione:</label>
            <input type="text" name="name" value="{{ $federation->name }}" id="name" class="form-control d-inline-block" required>
        </div>
        <div class="text-center d-inline-block">
            <button type="submit" class="btn btn-primary ml-2">Salva</button>
        </div>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</x-admin-layout>