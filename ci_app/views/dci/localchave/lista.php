 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","localchave","inserir")?>" class="btn btn-sm btn-success">Inserir novo local de chaves</a>
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
                        <th>Local de chaves</th>
                        <th>Possui controle</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($locais as $local){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $local->cnomelch?></td>
		                        <td><?php echo $local->ncontrole ? "Sim" : "Não"?></td>
                              <td>
		                        	<a href="<?php echo makeUrl("dci","localchave","editar","?id=".$local->nidtbxlch)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dci","localchave","excluir","?id=".$local->nidtbxlch)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover o local de chaves <?php echo $local->cnomelch?>?">Remover</a>
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