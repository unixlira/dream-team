@extends('template')

@section('content')
    <div class="d-flex justify-content-center">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Deu certo!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Deu ruim!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>

    <div class="container-xl mb-5">
        <div class="row justify-content-start">
            <p>
            <h2>Partidas <b>Detalhes</b></h2>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row mb-3">
                        <div class="col-sm-8">
                            <a href="{{ route('admin.game.create') }}" class="btn btn-sm btn-primary mt-2" onclick="showLoader()">
                                <i class="material-icons align-middle">shuffle</i>
                                <span class="align-middle"><b>Sortear Partidas</b></span>
                            </a>
                        </div>
                    </div>
                    @if($gamesResource->count() > 1)
                        @foreach($gamesResource as $game)
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-center">
                                        <span class="text-success">Partida Nº {{ $game->id }}</span> <br>
                                        Data {{ $game->game_at->format('d-m-Y') }} as {{ $game->game_at->format('H:i') }}
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            @if($game->teamA)
                                                <div class="col">
                                                    <div class="card mx-auto" style="width: 20rem;">
                                                        <div class="text-center">
                                                            <img class="card-img-top w-25 p-1" src="{{ asset('/foot.png') }}" alt="Time de Fora">
                                                            <h5>{{ $game->teamA->name }}</h5>
                                                        </div>
                                                        <ul class="list-group list-group-flush">
                                                            @foreach($game->teamA->players as $playersA)
                                                                <li class="list-group-item d-flex justify-content-between">
                                                                    <span class="text-left fw-semibold">{{ $playersA?->player->name }}</span>
                                                                    <span class="fw-semibold {{ $playersA?->player->is_goalkeeper ? 'text-success' : 'text-info' }}">
                                                                        {{ $playersA?->player->is_goalkeeper ? 'Goleiro' : 'Jogador' }}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                                <div class="col text-center mt-5">
                                                    <span style="font-size: xxx-large">X</span>
                                                </div>
                                            @if($game->teamA)
                                                <div class="col">
                                                    <div class="card mx-auto" style="width: 20rem;">
                                                        <div class="text-center">
                                                            <img class="card-img-top w-25 p-1" src="{{ asset('/foot2.png') }}" alt="Time de Fora">
                                                            <h5>{{ $game->teamB->name }}</h5>
                                                        </div>
                                                        <ul class="list-group list-group-flush">
                                                            @foreach($game->teamB->players as $playersB)
                                                                <li class="list-group-item d-flex justify-content-between">
                                                                    <span class="text-left fw-semibold">{{ $playersB?->player->name }}</span>
                                                                    <span class="fw-semibold {{ $playersB?->player->is_goalkeeper ? 'text-success' : 'text-info' }}">
                                                                        {{ $playersB?->player->is_goalkeeper ? 'Goleiro' : 'Jogador' }}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <hr class="bg-dark rounded bg-dark w-50 mb-4 mt-4" style="height: 10px;">
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center">
                            <h1 class="text-dark">Nenhuma partida agendada</h1>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
