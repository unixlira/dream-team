<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon" href="{{ asset('/ball.png') }}" sizes="192x192" />
        <!--[if !mso]><!-->
        <title>Society Team Generator</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    </head>
    <body>
        <nav class="navbar fixed-top bg-dark">
            <div class="container">
                <a class="navbar-brand text-white" href="/">
                    <img src="https://www.codeitsolution.com/images/logo-mobile.png" alt="" width="170px">
                </a>
                @if(request()->routeIs('admin.*'))
                    <div class="d-flex justify-content-between">
                        <ul class="navbar-nav mx-2">
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-secondary p-2 " href="/">Início</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav mx-2">
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-secondary p-2" href="{{ route('admin.team.index') }}">Times</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav mx-2">
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-secondary p-2" href="{{ route('admin.player.index') }}">Jogadores</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav mx-2">
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-secondary p-2" href="{{ route('admin.player-team.index') }}">Times com Jogadores</a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </nav>

        <div class="container mt-5">
            <div id="loader" class="loader-container" style="display: none">
                <div class="loader"></div>
            </div>
            @yield('content')
        </div>
        <br>
        <footer class="footer fixed-bottom bg-dark">
            <div class="container">
                <p>
                    <span class="text-secondary fw-bold">&copy; 2023 by</span>
                    <a class="text-decoration-none link-lira text-secondary fw-bold" href="https://unixlira.github.io">
                        José Lira
                    </a>
                </p>
            </div>
        </footer>
        @stack('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script>
            $('[data-toggle="tooltip"]').tooltip();

            function showLoader() {
                $('#loader').show();
            }
        </script>
    </body>
</html>
