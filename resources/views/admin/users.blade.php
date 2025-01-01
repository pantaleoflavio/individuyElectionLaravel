<x-admin-layout>
    <h2 class="text-2xl font-bold mb-4">Lista Utenti</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <x-table id="usersTable">
        <!-- Header -->
        <x-slot:header>
            <x-table-header-users />
        </x-slot:header>

        <!-- Rows -->
        @foreach($users as $user)
        <x-table-row-users 
            :user="$user" 
            :actions="[
                [
                    'url' => route('admin.users.delete', $user->id),
                    'label' => 'Elimina',
                    'class' => 'btn-danger',
                    'method' => 'DELETE'
                ]
            ]" />
        @endforeach
    </x-table>
</x-admin-layout>
