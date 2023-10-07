@extends('template')

@section('content')
    <div class="container-xl">
        <div class="row justify-content-start">
            <p>
            <h2>Time <b>Caro</b></h2>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="mt-2">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="name" class="form-label">Public ID</label>
                        <input type="text" class="form-control"  value="{{ $team->public_id }}" disabled>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control"  value="{{ $team->name }}" disabled>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-star mt-5 mb-5">
                <a  href="{{ route('admin.team.index') }}" class="btn btn-dark" onclick="showLoader()">Voltar</a>
            </div>
        </div>
    </div>
@endsection
