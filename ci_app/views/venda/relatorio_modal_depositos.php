<!-- Modal -->
<div class="modal fade"<?php echo isset($abrir_modal_depositos) && $abrir_modal_depositos == 1 ? ' data-autoopen="1" data-nidcadven="'.$nidcadven.'"' : ''?> id="modalDepositos" tabindex="-1" role="dialog" aria-labelledby="modalDepositosLabel">
  <input type="hidden" name="nidcadven_deposito" id="nidcadven_deposito">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalDepositosLabel">Extrato de Depósitos</h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-condensed table-bordered">
                <tr>
                  <td width="30%"><strong>Ref. </strong><span id="referenciaImovel"></span></td>
                  <td><strong>Imóvel:</strong> <span id="tituloImovel"></span></td>
                </tr>
                <tr>
                  <td><strong>Proprietários</strong></td>
                  <td><span id="proprietariosImovel"></span></td>
                </tr>
                <tr>
                  <td colspan="2"><strong><span id="periodoVenda"></span></strong></td>
                </tr>
                <tr>
                  <td colspan="2"><strong>Comprador: </strong><span id="compradorVenda"></span></td>
                </tr>
                <tr>
                  <td colspan="2"><strong>Valor Total: </strong><span id="valortotalVenda"></span></td>
                </tr>
              </table>
            </div>
          </div>

          <div class="container-fluid">
            <div id="panelReceber" class="panel panel-primary">
                <div class="panel-heading panel-heading-collapsed">
                   Valores a receber do comprador
                   <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="" class="pull-right" data-original-title="Collapse Panel">
                      <em class="fa fa-plus"></em>
                   </a>
                </div>
                <!-- .panel-wrapper is the element to be collapsed-->
                <div class="panel-wrapper collapse" aria-expanded="false" style="height: 0px;">
                   <div class="panel-body">
                      <div class="table-responsive">
                        <table class="table table-condensed table-bordered" id="tableListaDepositosReceber">
                        </table>
                      </div>
                      <span class="label label-success" id="totalDepositosRecebidos"></span>&nbsp;<span id="totalDepositosReceber" class="label label-danger"></span>
                   </div>
                </div>
             </div>
         </div>     
      </div>
  </div>
</div>