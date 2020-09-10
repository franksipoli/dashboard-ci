<!-- Modal -->
<div class="modal fade"<?php echo isset($abrir_modal_servicos) && $abrir_modal_servicos == 1 ? ' data-autoopen="1" data-nidcadloc="'.$nidcadloc.'"' : ''?> id="modalServicos" tabindex="-1" role="dialog" aria-labelledby="modalServicosLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalServicosLabel">Serviços</h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-condensed table-striped" id="tableListaServicos">
                <thead>
                  <tr>
                    <th width="15%">Data</th> 
                    <th width="40%">Serviço</th>
                    <th width="20%">Valor</th>
                    <th width="15%">Status</th> 
                    <th width="5%"></th>
                    <th width="5%"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>              
            </div>
          </div>
          <div class="modal-header">
            <h4 class="modal-title" id="modalDespesasLabelCadastrar">Cadastrar Serviço</h4>
          </div>
          <form action="<?php echo base_url("locacaotemporada/cadastrarservico")?>" method="POST" class="form-horizontal">
            <div class="modal-body">
              <div class="container-fluid">
                  <input type="hidden" name="returnurl" id="returnurl" value="<?php echo base_url().ltrim($_SERVER['REQUEST_URI'], '/')?>">
                  <input type="hidden" name="nidcadloc" value="" id="nidcadloc_servico">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputServico" class="control-label">Serviço</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <select name="nidtbxtps" class="form-control" id="inputServico">
                          <?php
                            foreach ($tps as $item):
                              ?>
                                <option value="<?php echo $item->nidtbxtps?>"><?php echo $item->cdescritps?></option>
                              <?php
                            endforeach;
                          ?>
                        </select>
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputValorCobrado" class="control-label">Valor</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="valor_cobrado" class="form-control" required="required" id="inputValorCobrado" data-jmask="dinheiro">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputDataServico" class="control-label">Data</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="data" class="form-control" required="required" id="inputDataServico">
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