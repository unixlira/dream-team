@extends('template')

@section('content')
    <div class="container-xl">
        <div class="row justify-content-start">
            <p>
            <h2>Atualizar <b>Time</b></h2>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="mt-2">
            <form method="POST" action="{{ route('admin.team.update', $team->public_id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome </label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}">
                            <div id="name" class="form-text">Insira o nome do time</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="max_players" class="form-label">Número de Jogadores </label>
                            <input type="number" class="form-control" id="max_players" name="max_players" min="1" max="6">
                            <div id="max_players" class="form-text">Insira o máx. de jogadores para esse time de 1 a 6</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5 ">
                    <a href="{{ route('admin.team.index') }}" class="btn btn-dark w-25 mx-2" onclick="showLoader()">Voltar</a>
                    <button type="submit" class="btn btn-info w-25 text-white mx-2" onclick="showLoader()">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
