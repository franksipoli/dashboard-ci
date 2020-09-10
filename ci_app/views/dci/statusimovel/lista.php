 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","statusimovel","inserir")?>" class="btn btn-sm btn-success">Inserir novo status do Produto</a>
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
                        <th>Finalidade</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($status as $item){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $item->cdescristi?></td>
                              <td><?php echo Finalidade_model::getNome($item->nidtbxfin)?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dci","statusimovel","editar","?id=".$item->nidtbxsti)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dci","statusimovel","excluir","?id=".$item->nidtbxsti)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover o status do Produto <?php echo $item->cdescristi?>?">Remover</a>
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