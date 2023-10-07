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

    <div class="container-xl">
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
                    @foreach($games as $game)
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-center">Partida Nº 01 <br> Dia 22 das 19h - 21h</h5>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row justify-content-center"> <!-- Centralize a linha -->
                                        <div class="col">
                                            <div class="card mx-auto" style="width: 18rem;">
                                                <div class="text-center"> <!-- Centralize a imagem horizontalmente -->
                                                    <img class="card-img-top w-25 p-1" src="{{ asset('/foot.png') }}" alt="Time de Fora">
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">Cras justo odio</li>
                                                    <li class="list-group-item">Dapibus ac facilisis in</li>
                                                    <li class="list-group-item">Vestibulum at eros</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col text-center mt-5">
                                            <span style="font-size: xxx-large">X</span>
                                        </div>
                                        <div class="col">
                                            <div class="card mx-auto" style="width: 18rem;">
                                                <div class="text-center"> <!-- Centralize a imagem horizontalmente -->
                                                    <img class="card-img-top w-25 p-1" src="{{ asset('/foot2.png') }}" alt="Time de Fora">
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">Cras justo odio</li>
                                                    <li class="list-group-item">Dapibus ac facilisis in</li>
                                                    <li class="list-group-item">Vestibulum at eros</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <br>
@endsection
