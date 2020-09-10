 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dep","uf","inserir")?>" class="btn btn-sm btn-success">Inserir nova UF</a>
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
                        <th>Descrição</th>
                        <th>Sigla</th>
                        <th>País</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($ufs as $uf){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $uf->cdescriuf?></td>
		                        <td><?php echo $uf->csiglauf?></td>
		                        <td><?php echo Pais_model::getById($uf->nidtbxpas)->cdescripas?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dep","uf","editar","?id=".$uf->nidtbxuf)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dep","uf","excluir","?id=".$uf->nidtbxuf)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover a UF <?php echo $uf->cdescriuf?>?">Remover</a>
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