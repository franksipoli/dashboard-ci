<!-- Modal -->
<div class="modal fade" id="modalRetirarChave" tabindex="-1" role="dialog" aria-labelledby="modalRetirarChaveLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalRetirarChaveLabel">Retirar chave</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="inputCodigoChave">
            Chave
          </label>
          <input type="text" name="ncodigo" id="ncodigo" readonly="readonly" class="form-control">
        </div>
        <div class="form-group">
          <label for="nomeresponsavel">
            Responsável
          </label>
          <input id="nomeresponsavel" name="nomeresponsavel" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-nomecpf form-control" required="required">
          <input name="idresponsavel" class="idresponsavel" value="0" type="hidden">
        </div>
        <?php
        if (Parametro_model::get("requerer_senha_chave")):
        ?>
        <div class="form-group">
          <label for="senhaResponsavel">
            Senha
          </label>
          <input type="password" name="csenha" class="form-control" id="senhaResponsavel">
        </div>
        <?php
        endif;
        ?>
        <div class="form-group">
          <label for="inputObservacoes">
            Observações
          </label>
          <input type="text" name="cobservacoes" class="form-control" id="inputObservacoes">
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-danger" id="btnConfirmarRetirada">Retirar</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>