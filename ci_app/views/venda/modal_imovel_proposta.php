<!-- Modal -->
<div class="modal fade" id="modalImovelProposta" tabindex="-1" role="dialog" aria-labelledby="modalImovelPropostaLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalImovelPropostaLabel">Propostas</h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-condensed table-striped" id="tableListaPropostas">
                <thead>
                  <tr>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Texto</th>
                    <th>Tipo</th>
                    <th>Vendedor</th>
                    <th>Status</th>
                    <th width="5%"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>              
            </div>
          </div>
          <div class="modal-header">
            <h4 class="modal-title" id="modalSinaisLabelCadastrar">Fazer proposta</h4>
          </div>
          <form action="<?php echo base_url("venda/cadastrarsinal")?>" method="POST" class="form-horizontal">
            <div class="modal-body">
              <div class="container-fluid">
                  <input type="hidden" name="returnurl" id="returnurl" value="<?php echo base_url().ltrim($_SERVER['REQUEST_URI'], '/')?>">
                  <input type="hidden" name="nidcadimo" value="" id="nidcadimo_proposta">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="imputImovel" class="control-label">Imóvel</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="nome_imovel" class="form-control" required="required" id="inputImovelNome" readonly="readonly">
                        <input type="hidden" name="nidcadimo" id="nidcadimo" value="">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputCliente" class="control-label">Cliente</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input id="nomecliente" name="nomecliente" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-nomecpf form-control" required="required">
                        <input name="idcpfcliente" class="idcpfcliente" value="0" type="hidden">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputDataProposta" class="control-label">Data</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="data" class="form-control" required="required" id="inputDataProposta">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputDescricao" class="control-label">Texto</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="descricao" class="form-control" required="required" id="inputDescricao">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputTipoProposta" class="control-label">Tipo</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <select name="tipo_proposta" class="form-control" id="inputTipoProposta">
                          <?php
                          foreach ($tpr as $item):
                            ?>
                              <option value="<?php echo $item->nidtbxtpr?>"><?php echo $item->cnome?></option>
                            <?php
                          endforeach;
                          ?>
                        </select>
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputStatusProposta" class="control-label">Status</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <select name="status_proposta" class="form-control" id="inputStatusProposta">
                          <option value="1">Ativa</option>
                          <option value="0">Desativada</option>
                        </select>
                      </div>  
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
      </div>
  </div>
</div>