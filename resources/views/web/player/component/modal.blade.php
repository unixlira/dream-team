<div class="modal fade" id="createPlayers" tabindex="-1" role="dialog" aria-labelledby="createPlayers" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPlayers">Gerar Jogadores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="qtdPlayer" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="qtdPlayer" name="qtdPlayer" max="25" min="1">
                <div id="qtdPlayer" class="form-text">Insira a quantidade de jogadores até 25</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary btn-salvar" data-type="player">Salvar</button>
            </div>
        </div>
    </div>
</div>
