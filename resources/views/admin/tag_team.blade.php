<x-admin-layout>
    <!-- Tag Team List-->
    <div class="row">
        <div class="col-md-12">
            <h2>Lista Tag Team</h2>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.tag_team.add') }}" class="btn btn-success">Aggiungi nuovo Tag Team</a>
            </div>
            <x-table id="candidatesTable">
                <x-slot name="header">
                    <x-table-header />
                </x-slot>
                @foreach($tagTeams as $tagTeam)
                    <x-table-row :item="$tagTeam" url="{{ route('admin.tag_team.edit', $tagTeam->id) }}">
                        Modifica
                        @if($tagTeam->is_active)
                            <td>in attivita</td>
                        @else
                            <td>ritirato</td>
                        @endif
                        <form method="POST" action="{{ route('admin.tag_team.delete', $tagTeam->id) }}" data-confirm="true">
                            @csrf
                            @method('DELETE')
                            <td><button type="submit" class="btn btn-danger">Elimina</button></td>
                        </form>
                    </x-table-row>

                @endforeach
            </x-table>
        </div>
    </div>

</x-admin-layout>