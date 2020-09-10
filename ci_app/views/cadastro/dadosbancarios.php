 <!-- Page content-->
 <div class="content-wrapper">
    <h3><?php echo $title ?></h3>
    <div class="panel panel-default">
        <div class="panel-body">

            <?php
                $this->load->view('general/messages');

            ?>

            <div class="row">
                <div class="col-lg-12">
                    <a href="<?php echo makeUrl('cadgrl', 'cadastro', 'listar') ?>" class="btn btn-lg btn-primary">Voltar para a lista de cadastros</a>
                </div>
            </div>

            <br/><br/>

            <h4>Adicionar dado</h4>

               <form class="form-horizontal" id="frmCadastroTipoContrato" method="POST" action="<?php echo makeUrl("cadgrl/cadastro","dadosbancarios",$cadgrl->nidcadgrl)?>">

                   <div class="form-group">
                      <label class="col-lg-2 control-label">Banco</label>
                      <div class="col-lg-10">
                        <select name="banco" class="form-control">
                            <?php
                                foreach ($bco as $item):
                                    ?> 
                                        <option value="<?php echo $item->nidtbxbco?>"><?php echo $item->ccodigo." - ".$item->cnomebco?></option>
                                    <?php
                                endforeach;
                            ?>
                        </select>
                      </div>
                   </div>

                   <div class="form-group">
                      <label class="col-lg-2 control-label">Titular</label>
                      <div class="col-lg-10">
                         <input type="text" name="titular" class="form-control" required="required" value="<?php echo $cadgrl->cnomegrl?>">
                      </div>
                   </div> 

                   <div class="form-group">
                      <label class="col-lg-2 control-label">Agência</label>
                      <div class="col-lg-10">
                         <input type="text" name="cagencia" class="form-control" required="required">
                      </div>
                   </div>

                   <div class="form-group">
                      <label class="col-lg-2 control-label">Conta</label>
                      <div class="col-lg-10">
                         <input type="text" name="cconta" class="form-control" required="required">
                      </div>
                   </div>

                   <div class="form-group">
                      <label class="col-lg-2 control-label">Tipo de Conta</label>
                      <div class="col-lg-10">
                        <select name="tipo_conta" class="form-control">
                            <?php
                                foreach ($tic as $item):
                                    ?> 
                                        <option value="<?php echo $item->nidtbxtic?>"><?php echo $item->cnometic?></option>
                                    <?php
                                endforeach;
                            ?>
                        </select>
                      </div>
                   </div>

                   <div class="form-group">
                      <label class="col-lg-2 control-label">Código (Tipo de Conta)</label>
                      <div class="col-lg-10">
                         <input type="text" name="codigo_tipo_conta" class="form-control">
                      </div>
                   </div>

                   <div class="form-group">
                      <label class="col-lg-2 control-label">Principal</label>
                      <div class="col-lg-10">
                         <label class="switch">
                             <input type="checkbox" name="principal" value="1" id="contaPrincipal">
                             <span></span>
                          </label>
                      </div>
                   </div>

                   <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                         <button type="submit" class="btn btn-sm btn-default">Adicionar</button>
                      </div>
                   </div>

               </form>

            <br/>

            <h4>Dados bancários</h4>


            <table id="cadastro_lista" class="table table-striped table-hover datatable" data-nidcadgrl="<?php echo $cadgrl->nidcadgrl?>">
                <thead>
                    <tr>
                        <th class="iconebanco"></th>
                        <th class="cbanco">Banco</th>
                        <th class="ctitular">Titular</th>
                        <th class="cagencia">Agência</th>
                        <th class="cconta">Conta</th>
                        <th class="ctipo">Tipo</th>
                        <th class="ccodigo">Código</th>
                        <th width="1%" class="principal"></th>
                        <th width="1%" class="delete"></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <input type="hidden" id="nidcadgrl" value="<?php echo $cadgrl->nidcadgrl?>">

        </div>
    </div>
 </div>