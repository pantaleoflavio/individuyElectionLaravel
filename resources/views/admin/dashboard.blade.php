<x-admin-layout>
    <div class="row">
        <h1 class="d-flex justify-content-center text-uppercase mt-2">Admin Dashboard - Benvenuto {{ $admin->username }}</h1>
    </div>

    <h4>Federazioni</h4>
    <div>
        <ul>
            @foreach($federationsWithCounts as $federation)
                <li>
                    {{ $federation->name }}: 
                    {{ $federation->wrestler_count }} lottatori, 
                    {{ $federation->tag_team_count }} tag team
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Top Ranking -->
    <h4>Top Classifiche Wreslter</h4>
    <div>
        <ul>
            @foreach($wrestlerRankings as $ranking)
                <li>{{ $ranking->name }}: {{ $ranking->votes_wrestler_count }} voti</li>
            @endforeach
        </ul>
    </div>

    <h4>Top Classifiche Tag Team</h4>
    <div>
        <ul>
            @foreach($tagTeamRankings as $ranking)
                <li>{{ $ranking->name }}: {{ $ranking->votes_tag_team_count }} voti</li>
            @endforeach
        </ul>
    </div>

    <!-- Total users -->
    <h4>Total users</h4>
    <div id="totalUsers">
        <div class="alert alert-info" role="alert">
            Total number of users signed: {{ $totalUsers }}</strong>
        </div>
    </div>
</x-admin-layout>