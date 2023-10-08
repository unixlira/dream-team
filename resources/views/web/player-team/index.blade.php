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
                <h2>Atribuir <b>Jogadores ao time</b></h2>
        </div>
        <hr style="border-top: 1px solid #1f1f1f;">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <a href="{{ route('admin.player-team.shuffle') }}" class="btn btn-sm btn-primary mt-2" onclick="showLoader()">
                                <i class="material-icons align-middle">shuffle</i>
                                <span class="align-middle"><b>Sortear Jogadores </b></span>
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Time <i class="fa fa-sort"></i></th>
                            <th>Máx.<i class="fa fa-sort"></i></th>
                            <th>Jogadores <i class="fa fa-sort"></i></th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($playersTeamsResource as $playersTeams)
                        <tr>
                            <td>{{ $playersTeams->id }}</td>
                            <td>{{ $playersTeams->team->name }}</td>
                            <td>{{ $playersTeams->team->max_players }}</td>
                            <td>
                                <ul>
                                    @foreach($playersTeams->team->players as $players)
                                            <li>
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="fw-bold">Nome: </span>{{ $players->player->name }}
                                                    </div>
                                                    @if($players->player->is_goalkeeper)
                                                        <div class="col">
                                                            <span class="fw-bold">Tipo: </span><span class="text-success">Goleiro</span>
                                                        </div>
                                                    @else
                                                        <div class="col">
                                                            <span class="fw-bold">Tipo: </span><span class="text-info">Jogador</span>
                                                        </div>
                                                    @endif
                                                    <div class="col">
                                                        <span class="fw-bold">Nível: </span>{{ $players->player->skill_level }}
                                                    </div>
                                                    <div class="col">
                                                        <span class="fw-bold">Presença: </span>{{ $players->player->is_presence == 1 ? 'Sim' : 'Não'}}
                                                    </div>
                                                </div>
                                            </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <a href="" class="delete" title="Delete" data-toggle="tooltip" data-id="{{ $playersTeams->team->public_id }}">
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
                            Mostrando&nbsp;<b>{{ $playersTeamsResource->firstItem() }}</b>&nbsp;de&nbsp;<b>{{ $playersTeamsResource->total() }}</b>&nbsp;resultados
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            {{ $playersTeamsResource->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
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
                let playerTeamId = $(this).data("id");
                let confirmation = confirm('Tem certeza que deseja excluir este item?');

                if (confirmation) {
                    let url = "{{ route('admin.player-team.destroy', ['player_team' => ':playerTeamId']) }}".replace(':playerTeamId', playerTeamId);

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


