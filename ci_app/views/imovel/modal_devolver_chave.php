<!-- Modal -->
<div class="modal fade" id="modalDevolverChave" tabindex="-1" role="dialog" aria-labelledby="modalDevolverChaveLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalDevolverChaveLabel">Devolver chave</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="inputCodigoChave">
            Chave
          </label>
          <input type="text" name="ncodigo" id="ncodigo_devolucao" readonly="readonly" class="form-control">
        </div>
        <div class="form-group">
          <label for="nomeresponsavel">
            Responsável
          </label>
          <input id="nomeresponsavel_devolucao" name="nomeresponsavel_devolucao" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-nomecpf form-control" required="required">
          <input name="idresponsavel_devolucao" class="idresponsavel_devolucao" value="0" type="hidden">
        </div>
        <?php
        if (Parametro_model::get("requerer_senha_chave")):
        ?>
        <div class="form-group">
          <label for="senhaResponsavelDevolucao">
            Senha
          </label>
          <input type="password" name="csenha" class="form-control" id="senhaResponsavelDevolucao">
        </div>
        <?php
        endif;
        ?>
        <div class="form-group">
          <button type="button" class="btn btn-danger" id="btnConfirmarDevolucao">Devolver</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>