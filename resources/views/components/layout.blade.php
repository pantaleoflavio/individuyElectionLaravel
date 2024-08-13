<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Individuy Election</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <!-- Header with nav bar -->
    <header class="">
        <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">individuy Election</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/vote-lists">Votazioni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Classifiche</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/federations">Federazioni</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::check() ? Auth::user()->username : 'Utente' }}
                        </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @guest
                                <li><a class="dropdown-item" href="/login">Login</a></li>
                                <li><a class="dropdown-item" href="/register">Signup</a></li>
                            @endguest
                            @auth
                                <li><a class="dropdown-item" href="/profile">Profilo</a></li>
                                <form  method="POST" action="/logout">
                                    @csrf
                                    @method('DELETE')
                                    <li><button class="dropdown-item" >Logout</button></li>
                                </form>
                            @endauth
                        </ul>
                    </li>
                </ul>
                <form action="" method="get">
                    <input type="hidden" name="page" value="search">
                    <input type="text" name="query" placeholder="Cerca nel sito..." required>
                    <button type="submit">Cerca</button>
                </form>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main -->
    <main class="container min-height-main">
        <div class="py-5">
           
            <div class="row">
                {{ $slot }}
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="text-center text-lg-start bg-secondary">
        <div class="container d-flex justify-content-center py-5">
        <a title="forum individuy italiani" target="_blank" href="https://indyviduitaliani.forumcommunity.net/" class="btn btn-primary btn-lg btn-floating mx-2" style="background-color: #54456b;">
            <i class="fab fa-wordpress"></i>
        </a>
        <a title="nostro canale youtube" target="_blank" href="https://youtube.com/@indyviduichannel3919?si=PARsIaG31J4sC-Um" class="btn btn-primary btn-lg btn-floating mx-2" style="background-color: #54456b;">
            <i class="fab fa-youtube"></i>
        </a>
        <a title="gruppo whatsapp" target="_blank" href="https://chat.whatsapp.com/IthimX4dVEvBhE5iA1wqbt" class="btn btn-primary btn-lg btn-floating mx-2" style="background-color: #54456b;">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a title="il canale spotify" target="_blank" href="https://open.spotify.com/show/1axEIE0N4t7h1Jmk81dqIp?si=INAD9lIySNareLLokbBbTQ&utm_source=copy-link" class="btn btn-primary btn-lg btn-floating mx-2" style="background-color: #54456b;">
            <i class="fab fa-spotify"></i>
        </a>
        <a title="La pagina instagram" target="_blank" href="https://www.instagram.com/indyviduipodcast?igsh=dzBkM2Y0ZWVxcjk0" class="btn btn-primary btn-lg btn-floating mx-2" style="background-color: #54456b;">
            <i class="fab fa-instagram"></i>
        </a>
    </div>

        <!-- Copyright -->
        <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2024 Copyright:
        <a class="text-white" href="https://www.linkedin.com/in/flavio-pantaleo-517935279/" target="_blank">Flavio Pantaleo</a>
        </div>
        <!-- Copyright -->
    </footer>
</body>
</html>