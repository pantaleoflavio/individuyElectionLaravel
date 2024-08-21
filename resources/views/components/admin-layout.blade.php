<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Individuy Election Admin</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <button class="btn btn-primary d-block d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">Menu</span>
            </button>
            
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">
                                <i class="fas fa-home"></i> Main Site
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-hammer"></i> Admin Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <i class="fa-solid fa-user"></i> lista Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.wrestler') }}">
                                <i class="fa-solid fa-video"></i> Lista Wrestler
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.tag_team') }}">
                                <i class="fa-solid fa-dice-two"></i> Lista Tag Team
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.category') }}">
                                <i class="fa-solid fa-tv"></i> Lista Stili
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.federation') }}">
                                <i class="fa-solid fa-sitemap"></i> Lista Federationi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                            <i class="fa-solid fa-trophy"></i> Lista Ranking
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Admin Main -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                {{ $slot }}
            </div>

        </div>
    </div>
<!-- Admin Footer -->
</body>
</html>