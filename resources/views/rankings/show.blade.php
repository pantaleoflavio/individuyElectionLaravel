<x-layout>
    <h1>Ranking: {{ $ranking->name }}</h1>

    <h2>Partecipanti e Media Voti</h2>
    <ul class="list-group">
        @foreach($participants as $participant)
            @php
                $averageVote = $participant->average_vote;
                $fullStars = floor($averageVote / 2);
                $halfStar = $averageVote % 2 >= 1 ? 1 : 0;
                $emptyStars = 5 - $fullStars - $halfStar;
            @endphp
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>{{ $participant->participant->name }}</div>
                <span>
                    {{ number_format($averageVote, 2) }}
                    @for($i = 0; $i < $fullStars; $i++)
                        <i class="fas fa-star" style="color: blue;"></i>
                    @endfor
                    @if($halfStar)
                        <i class="fas fa-star-half-alt" style="color: blue;"></i>
                    @endif
                    @for($i = 0; $i < $emptyStars; $i++)
                        <i class="far fa-star" style="color: gray;"></i>
                    @endfor
                </span>
            </li>
        @endforeach
    </ul>
</x-layout>
