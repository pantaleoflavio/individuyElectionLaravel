<x-admin-layout>
    <div class="row">
        <h1 class="d-flex justify-content-center text-uppercase mt-2">Admin Dashboard - Benvenuto {{ $admin->username }}</h1>
    </div>

    <h4>Federazioni con più atleti</h4>
    <div>
        <ul>
                <li>Nome Federazioe - Lottatori: 10</li>
        </ul>
    </div>

    <!-- Top Ranking -->
    <h4>Top Classifiche</h4>
    <div>
        <ul>
            <!-- Aggiornato per mostrare il conteggio totale dei voti invece del punteggio medio -->
            <li>Nome Ranking - Voti Totali: </li>
        </ul>
    </div>

    <!-- Total users -->
    <h4>Total users</h4>
    <div id="totalUsers">
        <div class="alert alert-info" role="alert">
            Total number of users signed: 0</strong>
        </div>
    </div>
</x-admin-layout>