 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dep","formapagamento","inserir")?>" class="btn btn-sm btn-success">Inserir nova forma de pagamento</a>
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
                        <th>Forma de Pagamento</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($formas as $forma){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $forma->cnomefpa?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dep","formapagamento","editar","?id=".$forma->nidtbxfpa)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dep","formapagamento","excluir","?id=".$forma->nidtbxfpa)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover a forma de pagamento <?php echo $forma->cnomefpa?>?">Remover</a>
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