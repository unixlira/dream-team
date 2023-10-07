@extends('template')

@section('content')
    <div class="container-xl">
        <div class="row justify-content-start">
            <div class="text-left">
                <p>
                <h1>Society Teams Generator </h1>
                </p>
            </div>
            <div class=" mt-3">
                <p>
                    <img class="profile-image" src="https://unixlira.github.io/images/logo.png" alt="José Lira">
                    <span class="fw-bold">José Lira &nbsp;</span>
                    <span class="text-secondary">Última atualização: </span>
                    <span class="fw-bold text-secondary">07/10/2023 as 14:43 pm </span>
                </p>
                <p>Abaixo links do Sistema <i>"Jogadores, Times e Partidas"</i> do projeto Code Group para gerar
                    manualmente.</p>
            </div>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="row justify-content-center">
            <div class="container mb-5">
                <div class="row">
                    <div class="col-md-3 col-sm-12 mb-3">
                        <a href="{{ route('admin.player.index') }}" class="btn btn-dark w-100" onclick="showLoader()">Jogadores</a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-3">
                        <a href="{{ route('admin.team.index') }}" class="btn btn-dark w-100" onclick="showLoader()">Times</a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-3">
                        <a href="{{ route('admin.player-team.index') }}" class="btn btn-dark w-100"
                           onclick="showLoader()">Jogadores e Times</a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-3">
                        <a href="{{ route('admin.game.index') }}" class="btn btn-dark w-100"
                           onclick="showLoader()">Gerar Partidas dos Times</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <span class="fw-bold text-dark">OU</span>
        </div>
        <div class="row justify-content-start">
            <div class="text-left">
                <p>
                <h1>Gerar com IA </h1>
                </p>
            </div>
            <div class=" mt-3">
                <p>Abaixo link que gera automaticamente <i>"Jogadores, Times e Partidas"</i> e apaga <b>TODAS
                        TABELAS</b> do banco de dados para inserção de dados fictícios.</p>
                <p>
                    <span
                        class="text-danger"><i>"Recomendado para teste inicial, antes de explorar links acima."</i></span>
                </p>
            </div>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="row justify-content-center">
            <div class="container  mb-5">
                <div class="row">
                    <div class="col-md-3 col-sm-12 mb-3">
                        <button type="button" class="btn btn-dark w-100" data-toggle="modal"
                                data-target="#createPlayers">Gerar Jogadores
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-3">
                        <button type="button" class="btn btn-dark w-100" data-toggle="modal"
                                data-target="#createTeams">Gerar Times
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-3">
                        <a href="{{ route('admin.player-team.shuffle') }}" class="btn btn-dark w-100"
                           onclick="showLoader()">Gerar Jogadores e Times</a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-3">
                        <a href="{{ route('admin.game.create') }}" class="btn btn-dark w-100" onclick="showLoader()">
                            Gerar Partidas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('web.player.component.modal')
    @include('web.team.component.modal')
@endsection


