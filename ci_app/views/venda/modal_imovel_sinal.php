<!-- Modal -->
<div class="modal fade" id="modalImovelSinal" tabindex="-1" role="dialog" aria-labelledby="modalImovelSinalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalImovelSinalLabel">Sinais de negócio</h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-condensed table-striped" id="tableListaSinais">
                <thead>
                  <tr>
                    <th>Comprador</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Vendedor</th>
                    <th>Status</th>
                    <th>Proposta</th>
                    <th width="3%"></th>
                    <th width="3%"></th>
                    <th width="3%"></th>
                    <th width="3%"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>              
            </div>
          </div>
          <div class="modal-header">
            <h4 class="modal-title" id="modalSinaisLabelCadastrar">Cadastrar Sinal</h4>
          </div>
          <form action="<?php echo base_url("venda/cadastrarsinal")?>" method="POST" class="form-horizontal">
            <div class="modal-body">
              <div class="container-fluid">
                  <input type="hidden" name="returnurl" id="returnurl" value="<?php echo base_url().ltrim($_SERVER['REQUEST_URI'], '/')?>">
                  <input type="hidden" name="nidcadimo" value="" id="nidcadimo_sinal">
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
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputNomeComprador" class="control-label">Comprador</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input id="nomecomprador" name="nomecomprador" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-nomecpf form-control" required="required">
                        <input name="idcpfcomprador" class="idcpfcomprador" value="0" type="hidden">
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
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputDataDespesa" class="control-label">Data do Sinal</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="data" class="form-control" required="required" id="inputDataSinal">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputValorVenda" class="control-label">Valor da venda</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <input type="text" name="valor_venda" class="form-control" required="required" id="inputValorVenda" data-jmask="dinheiro">
                      </div>  
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-3"><label for="inputStatusSinal" class="control-label">Status</label></div>
                      <div class="col-xs-12 col-sm-8 col-md-9">
                        <select name="status_sinal" class="form-control" id="inputStatusSinal">
                          <?php
                          foreach ($ssi as $item):
                            ?>
                            <option value="<?php echo $item->nidtbxssi?>"><?php echo $item->cdescricao?></option>
                            <?php
                          endforeach;
                          ?>
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