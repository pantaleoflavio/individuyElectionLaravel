<x-layout>
    <x-second-title>Lista delle Federazioni</x-second-title>
    <ul class="list-group">
        @foreach ($federations as $federation)
            <li class="list-group-item">
                <a href="{{ route('federations.show', $federation->id) }}">{{$federation->name}}</a>
            </li>
        @endforeach
    </ul>

</x-layout>