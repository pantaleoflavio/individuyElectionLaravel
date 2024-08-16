<x-layout>
    <x-second-title>Il tuo profilo</x-second-title>
    
    <div class="container">
        <h4>{{ $user->name }}</h4>
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        @if($user->image_path)
            <div>
                <img src="{{ asset('storage/' . $user->image_path) }}" alt="Profile Image" style="width: 150px; height: 150px;">
            </div>
        @endif
    </div>
    <div class="my-3">
        <a href="{{ route('user.edit') }}">Modifica Profilo</a>
    </div>

    <hr>

    <h3>I tuoi voti ai Wrestler</h3>
    <div class="votes mt-3">
        @forelse ($wrestlerVotes as $vote)
        <ul>
            <li>
                <strong>Wrestler:</strong> {{ $vote->wrestler->name }} - <strong>voto:</strong> {{ $vote->vote }} - <strong>ranking:</strong> {{ $vote->ranking->name }}.
            </li>
        </ul>
        @empty
            <p>Non hai ancora votato per nessun wrestler.</p>
        @endforelse
    </div>

    <h3>I tuoi voti ai Tag Team</h3>
    <div class="votes mt-3">
        @forelse ($tagTeamVotes as $vote)
        <ul>
            <li>
                <strong>Tag Team:</strong> {{ $vote->tagTeam->name }} - <strong>voto:</strong> {{ $vote->vote }} - <strong>ranking:</strong> {{ $vote->ranking->name }}.
            </li>
        </ul>
        @empty
            <p>Non hai ancora votato per nessun Tag Team.</p>
        @endforelse
    </div>

</x-layout>