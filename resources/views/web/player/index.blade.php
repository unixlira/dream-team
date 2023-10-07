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

<div class="container-xl">
    <div class="row justify-content-start">
        <p>
            <h2>Jogadores <b>Detalhes</b></h2>
    </div>
    <hr style="border-top: 1px solid #1f1f1f;">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8">
                        <a href="{{ route('admin.player.create') }}" class="btn btn-sm btn-primary mt-2" onclick="showLoader()">
                            <i class="material-icons align-middle">add_circle</i>
                            <span class="align-middle"><b>Adicionar jogador</b></span>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <nav class="navbar navbar-light bg-light">
                            <form class="form-inline" method="GET" action="{{ url()->current() }}">
                                <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Search" name="search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                                    <i class="material-icons align-middle">&#xE8B6;</i>
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome <i class="fa fa-sort"></i></th>
                        <th>Nível de Habilidade</th>
                        <th>Goleiro</th>
                        <th>Presença <i class="fa fa-sort"></i></th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($players as $player)
                    <tr>
                        <td>{{ $player->id }}</td>
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->skill_level }}</td>
                        <td>
                            @if($player->is_goalkeeper)
                                <span class="btn btn-sm btn-success disabled">Sim</span>
                            @else
                                <span class="btn btn-sm btn-danger disabled">Não</span>
                            @endif
                        </td>
                        <td>
                            @if($player->is_presence)
                                <span class="btn btn-sm btn-success disabled">Sim</span>
                            @else
                                <span class="btn btn-sm btn-danger disabled">Não</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.player.show', $player->public_id) }}" class="view" title="View" data-toggle="tooltip" onclick="showLoader()">
                                <i class="material-icons">&#xE417;</i>
                            </a>
                            <a href="{{ route('admin.player.edit', $player->public_id) }}" class="edit" title="Edit" data-toggle="tooltip" onclick="showLoader()">
                                <i class="material-icons">&#xE254;</i>
                            </a>
                            <a href="" class="delete" title="Delete" data-toggle="tooltip" data-id="{{ $player->public_id }}">
                                <i class="material-icons">&#xE872;</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row mb-5">
                <div class="col-3">
                    <div class="d-flex justify-content-start text-hint btn btn-secondary ">
                        Mostrando&nbsp;<b>{{ $players->firstItem() }}</b>&nbsp;de&nbsp;<b>{{ $players->total() }}</b>&nbsp;resultados
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-end">
                        {{ $players->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <br>
@endsection

@pushonce('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('.delete').on("click", function (e) {
                e.preventDefault();
                let playerId = $(this).data("id");
                let confirmation = confirm('Tem certeza que deseja excluir este jogador?');

                if (confirmation) {
                    let url = "{{ route('admin.player.destroy', ':playerId') }}".replace(':playerId', playerId);

                    showLoader();

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "DELETE"
                        },
                        success: function (data) {
                            location.reload();
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                        },
                        complete: function () {
                            hideLoader();
                        }
                    });
                }
            });

            $('.pagination li.page-item a.page-link').addClass('btn btn-sm');

            $('.pagination li.page-item span.page-link').addClass('btn btn-sm');

            function showLoader() {
                $('#loader').show();
            }

            function hideLoader() {
                $('#loader').hide();
            }

        });
    </script>
@endpushonce


