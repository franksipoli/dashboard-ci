 <!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmPesquisaEntradas" method="GET" action="<?php echo makeUrl("fin","conciliacao/conciliados")?>">

               <?php
               		$this->load->view('general/messages');
               ?>

               <div class="form-group">
                  <label class="col-lg-2 control-label">Período</label>
                  <div class="col-lg-10">
                     <div class="row">
                        <div class="col-xs-12 col-sm-6">
                           <input type="text" id="data_inicial" name="datan" placeholder="DD/MM/AAAA" class="form-control" value="<?php echo $this->input->get('datan') ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                           <input type="text" id="data_final" name="dataf" placeholder="DD/MM/AAAA" class="form-control" value="<?php echo $this->input->get('datan') ?>">
                        </div>
                     </div> 
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-xs-12 text-center">
                     <button type="submit" class="btn btn-lg btn-info" style="margin-top: 15px;">Pesquisar</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <!-- END panel-->
   </div>
</div>
<!-- END row-->
<!-- END panel-->
</div>