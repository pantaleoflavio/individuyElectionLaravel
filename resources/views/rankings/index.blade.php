<x-layout>
    <x-second-title>Le Classifiche Disponibili</x-second-title>

    <!-- Classifiche per Wrestler -->
    <h4>Wrestler</h4>
    <ul>
        @forelse($rankings->where('type', 'wrestler') as $ranking)
            <li>
                <a href="{{ route('rankings.show', $ranking->id) }}">
                    {{ $ranking->name }} - 
                    @if($ranking->status)
                        <span class="mx-2 badge badge-success bg-success">Attiva</span>
                    @else
                        <span class="mx-2 badge badge-danger bg-secondary">Inattiva</span>
                    @endif
                </a>
            </li>
        @empty
            <li>Nessuna classifica per wrestler disponibile.</li>
        @endforelse
    </ul>

    <!-- Classifiche per Tag Team -->
    <h4>Tag Team</h4>
    <ul>
        @forelse($rankings->where('type', 'tag team') as $ranking)
            <li>
                <a href="{{ route('rankings.show', $ranking->id) }}">
                    {{ $ranking->name }} - 
                    @if($ranking->status)
                        <span class="mx-2 badge badge-success bg-success">Attiva</span>
                    @else
                        <span class="mx-2 badge badge-danger bg-secondary">Inattiva</span>
                    @endif
                </a>
            </li>
        @empty
            <li>Nessuna classifica per tag team disponibile.</li>
        @endforelse
    </ul>
</x-layout>
