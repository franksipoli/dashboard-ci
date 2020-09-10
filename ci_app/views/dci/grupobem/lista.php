<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","grupobem","inserir")?>" class="btn btn-sm btn-success">Inserir grupo de bens</a>
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
                        <th>Grupo</th>
                        <th>Cor</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($grupos as $grb){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $grb->cnomegrb?></td>
                              <td><?php echo $grb->ccor?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dci","grupobem","editar","?id=".$grb->nidtbxgrb)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dci","grupobem","excluir","?id=".$grb->nidtbxgrb)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover o grupo de bens <?php echo $grb->cnomegrb?>?">Remover</a>
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