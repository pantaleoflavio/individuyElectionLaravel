<x-layout>
<h1>Ranking: {{ $ranking->name }}</h1>

<h2>Partecipanti e Media Voti</h2>
<ul>
    @foreach($participants as $participant)
        <li>
            {{ $participant->participant->name }}: Media Voti = {{ number_format($participant->average_vote, 2) }}
        </li>
    @endforeach
</ul>
</x-layout>