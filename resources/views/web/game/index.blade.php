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
                <strong>Deu ruim!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>

    <div class="container-xl mb-5">
        <div class="row justify-content-center"> <!-- Center the heading -->
            <h2>Partidas <b>Detalhes</b></h2>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="container">
            <div class="card mt-5 mx-auto"> <!-- Center the card horizontally -->
                <div class="card-header">
                    <h5 class="text-center">Partida Nº 01</h5>
                </div>
                <div class="card-body">
                    <div class="card-title d-flex justify-content-center">
                        <p>Dia 22 das 19h - 21h</p>
                    </div>
                    <div class="container d-flex justify-content-center">
                        <div class="row">
                            <div class="col">
                                <div class="card mx-auto" style="width: 18rem;"> <!-- Center the inner card horizontally -->
                                    <div class="d-flex justify-content-center">
                                        <img class="card-img-top w-25 p-1" src="{{ asset('/foot.png') }}" alt="Time de Fora">
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Cras justo odio</li>
                                        <li class="list-group-item">Dapibus ac facilisis in</li>
                                        <li class="list-group-item">Vestibulum at eros</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col text-center mt-3">
                                <span style="font-size: xxx-large">X</span>
                            </div>
                            <div class="col">
                                <div class="card mx-auto" style="width: 18rem;"> <!-- Center the inner card horizontally -->
                                    <div class="d-flex justify-content-center">
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
        </div>
    </div>
    <br>
@endsection
