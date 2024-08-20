<x-admin-layout>
    <!-- Wrestler List-->
    <div class="row">
        <div class="col-md-12">
            <h2>Lista Wrestler</h2>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.wrestler.add') }}" class="btn btn-success">Aggiungi nuovo Wrestler</a>
            </div>
            <x-table id="candidatesTable">
                <x-slot name="header">
                    <x-table-header />
                </x-slot>
                @foreach($wrestlers as $wrestler)
                    <x-table-row :item="$wrestler" url="{{ route('admin.wrestler.edit', $wrestler->id) }}">
                        Modifica
                        @if($wrestler->is_active)
                            <td>in attivita</td>
                        @else
                            <td>ritirato</td>
                        @endif
                        <form method="POST" action="{{ route('admin.wrestler.delete', $wrestler->id) }}" data-confirm="true">
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