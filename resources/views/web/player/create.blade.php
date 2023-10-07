@extends('template')

@section('content')
    <div class="container-xl">
        <div class="row justify-content-start">
            <div class="text-left">
                <p>
                <h2>Adicionar jogador</h2>
                </p>
            </div>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="mt-2">
            <form method="POST" action="{{ route('admin.player.store') }}">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <div id="name" class="form-text">Insira nome ou apelido do jogador</div>
                        </div>
                        <div class="mb-3 mt-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_presence" name="is_presence" value="1">
                                <label class="form-check-label" for="is_presence">
                                    Confirmar presença do jogador
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="skill_level" class="form-label">Nível de Habilidade</label>
                            <input type="number" class="form-control" id="skill_level" name="skill_level" max="5" min="1">
                            <div id="skill_level" class="form-text">Insira um valor de 1 até 5</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="is_goalkeeper" class="form-label">Goleiro</label>
                            <select class="form-select" aria-label="É goleiro" name="is_goalkeeper">
                                <option selected></option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                            <div id="is_goalkeeper" class="form-text">O jogador vai ser goleiro?</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <a href="{{ route('admin.player.index') }}" class="btn btn-dark w-25 mx-2" onclick="showLoader()">Voltar</a>
                    <button type="submit" class="btn btn-success w-25 mx-2" onclick="showLoader()">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
