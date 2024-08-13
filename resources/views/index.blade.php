<x-layout>
    <h1 class="text-center mb-5">Bentornato nella Piattaforma di Votazione di individuy Italiani!</h1>

    <!-- Sezione per i messaggi di errore e successo -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <x-main-card 
        title="Votazioni" 
        text="Questa sezione permetterà agli utenti di votare per i loro show o incontri preferiti." 
        href="/vote-lists" 
        linkLabel="Vai alle Votazioni" 
    />

    <x-main-card 
        title="Classifiche" 
        text="Qui vengono mostrate le classifiche basate sui voti degli utenti." 
        href="/" 
        linkLabel="Vedi le Classifiche" 
    />

</x-layout>