<!-- Modal -->
<div class="modal fade" id="modalImovelAtendimento" tabindex="-1" role="dialog" aria-labelledby="modalImovelAtendimentoLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalImovelAtendimentoLabel">Adicionar Imóvel ao atendimento</h4>
          </div>
          <div class="modal-body">
            <p class="alert alert-warning">Selecione o atendimento ao qual deseja adicionar este Imóvel</p>
            <input type="hidden" name="nidcadimo_atendimento" id="nidcadimo_atendimento" val="">
            <div class="form-group">
                <select name="nidcadate" id="nidcadate_lista" class="form-control"></select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary adicionar-imovel-atendimento-action">Adicionar</button>
          </div>
      </div>
  </div>
</div>