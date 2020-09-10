<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","finalidade","inserir")?>" class="btn btn-sm btn-success">Inserir nova finalidade</a>
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
                        <th>Finalidade</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($finalidades as $finalidade){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $finalidade->cnomefin?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dci","finalidade","editar","?id=".$finalidade->nidtbxfin)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dci","finalidade","excluir","?id=".$finalidade->nidtbxfin)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover a finalidade <?php echo $finalidade->cnomefin?>?">Remover</a>
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