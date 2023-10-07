@extends('template')

@section('content')
    <div class="container-xl">
        <div class="row justify-content-start">
            <div class="text-left">
                <p>
                <h2>Adicionar time</h2>
                </p>
            </div>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="mt-2">
            <form method="POST" action="{{ route('admin.team.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome </label>
                            <input type="text" class="form-control" id="name" name="name">
                            <div id="name" class="form-text">Insira nome do time.</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <a href="{{ route('admin.team.index') }}" class="btn btn-dark w-25 mx-2">Voltar</a>
                    <button type="submit" class="btn btn-success w-25 mx-2">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
