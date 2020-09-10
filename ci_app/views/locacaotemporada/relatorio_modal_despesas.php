<!-- Modal -->
<div class="modal fade"<?php echo isset($abrir_modal_despesas) && $abrir_modal_despesas == 1 ? ' data-autoopen="1" data-nidcadloc="'.$nidcadloc.'"' : ''?> id="modalDespesas" tabindex="-1" role="dialog" aria-labelledby="modalDespesasLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalDespesasLabel">Despesas</h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-condensed table-striped" id="tableListaDespesas">
                <thead>
                  <tr>
                    <th width="34%">Prestador</th>
                    <th width="34%">Descrição</th>
                    <th width="15%"></th>
                    <th width="15%"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>              
            </div>
          </div>
          <div class="modal-header">
            <h4 class="modal-title" id="modalDespesasLabelCadastrar">Cadastrar Despesa</h4>
          </div>
          <form action="<?php echo base_url("locacaotemporada/cadastrardespesa")?>" method="POST" class="form-horizontal">
            <div class="modal-body">
              <div class="container-fluid">
                  <input type="hidden" name="returnurl" id="returnurl" value="<?php echo base_url().ltrim($_SERVER['REQUEST_URI'], '/')?>">
                  <input type="hidden" name="nidcadloc" value="" id="nidcadloc_despesa">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputPrestador" class="control-label">Prestador</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <select name="nidcadgrl" class="form-control" id="inputPrestador">
                          <?php
                            foreach ($prestadores as $prestador):
                              $tiposervico = Tiposervico_model::getByPrestador($prestador->nidcadgrl);
                              $nomes = array();
                              foreach ($tiposervico as $item):
                                $nomes[] = $item['nome'];
                              endforeach;
                              ?>
                                <option value="<?php echo $prestador->nidcadgrl?>"><?php echo $prestador->cnomegrl?> (<?php echo implode(', ', $nomes) ?>)</option>
                              <?php
                            endforeach;
                          ?>
                        </select>
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputValorCobrado" class="control-label">Valor Cobrado</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="valor_cobrado" class="form-control" required="required" id="inputValorCobrado" data-jmask="dinheiro">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputValorPrestador" class="control-label">Valor do Prestador</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="valor_prestador" class="form-control" required="required" id="inputValorPrestador" data-jmask="dinheiro">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputDescricao" class="control-label">Descrição</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="descricao" class="form-control" required="required" id="inputDescricao">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputDataDespesa" class="control-label">Data</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="data" class="form-control" required="required" id="inputDataDespesa">
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