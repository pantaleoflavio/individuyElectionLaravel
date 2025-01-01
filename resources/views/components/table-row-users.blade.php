@props(['user', 'actions' => []])

<tr>
    <td>{{ $user->name }}</td>
    <td>
        <!-- Nessuna azione per il Super Admin -->
        @if($user->role === 'super_admin')
            <span class="text-muted">Nessuna azione disponibile</span>
        @else
            <!-- Azioni dinamiche -->
            @foreach($actions as $action)
                @if($action['method'] === 'GET')
                    <!-- Link normale per il metodo GET -->
                    <a href="{{ $action['url'] }}" class="btn {{ $action['class'] ?? 'btn-primary' }}">
                        {{ $action['label'] }}
                    </a>
                @else
                    <!-- Form per metodi diversi da GET -->
                    <form action="{{ $action['url'] }}" method="POST" style="display: inline;">
                        @csrf
                        @method($action['method'])
                        <button type="submit" class="btn {{ $action['class'] ?? 'btn-primary' }}">
                            {{ $action['label'] }}
                        </button>
                    </form>
                @endif
            @endforeach

            <!-- Azione di promozione o rimozione admin -->
            @if($user->role === 'admin')
                <form action="{{ route('admin.users.demote', $user->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-warning">Non più Admin</button>
                </form>
            @elseif($user->role === 'user')
                <form action="{{ route('admin.users.promote', $user->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-secondary">Rendi Admin</button>
                </form>
            @endif
        @endif
    </td>
</tr>
