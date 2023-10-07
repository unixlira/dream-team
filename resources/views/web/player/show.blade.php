@extends('template')

@section('content')
    <div class="container-xl">
        <div class="row justify-content-start">
            <p>
            <h2>Jogador <b>Caro</b></h2>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="mt-2">
            <div class="row">
                <div class="col-md-4 cols-sm-12">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control"  value="{{ $player->name }}" disabled>
                    </div>
                </div>
                <div class="col-md-4 cols-sm-12">
                    <div class="mb-3">
                        <label for="skill_level" class="form-label">Nível de Habilidade</label>
                        <input type="text" class="form-control" value="{{ $player->skill_level }}" disabled>
                    </div>
                </div>
                <div class="col-md-4 cols-sm-12">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="is_goalkeeper" class="form-label">Goleiro</label>
                            <input type="text" class="form-control" value="{{ $player->is_goalkeeper === 0 ? 'Sim' : 'Não' }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 cols-sm-12">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="is_goalkeeper" class="form-label">Presença Confirmada</label>
                            <input type="text" class="form-control" value="{{ $player->is_presence === 0 ? 'Sim' : 'Não' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-star mt-5 mb-5">
                <a  href="{{ route('admin.player.index') }}" class="btn btn-dark" onclick="showLoader()">Voltar</a>
            </div>
        </div>
    </div>
    <br>
@endsection
