 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dep","feriado","inserir")?>" class="btn btn-sm btn-success">Inserir novo feriado</a>
		</div>
	</div>
</div>
<div class="row">
   <div class="col-xs-12">
      <div class="panel panel-default">
         <div class="panel-body">
         	<?php
           		$this->load->view('general/messages');
           ?>
            <div class="table-responsive">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Feriado</th>
                        <th>Data</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($feriados as $feriado){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $feriado->cdescrifer?></td>
                              <td><?php echo toUserDate($feriado->ddata)?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dep","feriado","editar","?id=".$feriado->nidtbxfer)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dep","feriado","excluir","?id=".$feriado->nidtbxfer)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover o feriado <?php echo $feriado->cdescrifer?>?">Remover</a>
		                        </td>
		                     </tr>
                  		<?php
                  		$i++;
                  	}
                  	?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END row-->
</div>