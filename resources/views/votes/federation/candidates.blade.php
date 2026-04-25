<x-layout>
    <x-second-title>Lista delle Federazioni - {{ $ranking->name }}</x-second-title>
    <p>Scegli la federazione da votare</p>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <ul class="list-group">
        @foreach($federations as $federation)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('federations.show', $federation->id) }}">{{ $federation->name }}</a>
                <a class="btn btn-primary" href="{{ route('vote.federation.form', ['federation' => $federation->id, 'ranking' => $ranking->id]) }}">Vota</a>
            </li>
        @endforeach
    </ul>
</x-layout>