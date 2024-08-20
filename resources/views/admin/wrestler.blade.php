<x-admin-layout>
    <!-- Wrestler List-->
    <div class="row">
        <div class="col-md-12">
            <h2>Lista Wrestler</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Stile</th>
                        <th>Nazione</th>
                        <th>nome federazione</th>
                        <th>Attivita</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wrestlers as $wrestler)
                        <tr>
                            <td>
                                {{ $wrestler->name }}
                            </td>
                            <td>
                                {{ $wrestler->category->name ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $wrestler->country }}
                            </td>
                            <td>
                                {{ $wrestler->federation->name ?? 'N/A' }}
                            </td> 
                            @if($wrestler->is_active)
                                <td>in attivita</td>
                            @else
                                <td>ritirato</td>
                            @endif
                            
                            <td>
                                <a href="{{ route('admin.wrestler.edit', $wrestler->id) }}">Modifica</a>
                            </td>
                            <td>
                                Elimina
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>