 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmConciliaBoleto" method="POST" action="<?php echo makeUrl("fin","conciliacao","conciliar")?>" enctype="multipart/form-data">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Arquivo</label>
                  <div class="col-lg-10">
                     <input type="file" name="userfile" class="form-control">
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Tipo de arquivo</label>
                  <div class="col-lg-10">
                     <select name="userfile" class="form-control">
                        <option>RET</option>
                        <option>TXT</option>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default">Conciliar</button>
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