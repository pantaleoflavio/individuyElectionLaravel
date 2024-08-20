<x-admin-layout>
    <!-- Wrestler List-->
    <div class="row">
        <div class="col-md-12">
            <h2>Lista Wrestler</h2>
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
                        
                        <td>
                            Elimina
                        </td>
                    </x-table-row>

                @endforeach
            </x-table>
        </div>
    </div>

</x-admin-layout>