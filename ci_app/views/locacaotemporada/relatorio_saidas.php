 <!-- Page content-->
 <div class="content-wrapper">
    <h3><?php echo $title?></h3>
    <div class="panel panel-default">
       <div class="panel-body">
       		<?php
       		$this->load->view('general/messages');
	        ?>

	       	<div class="row">
		       	<div class="col-lg-12">
		          	<a href="<?php echo makeUrl('locacaotemporada', 'relatoriosaidas') ?>" class="btn btn-lg btn-primary add_msg">Pesquisar novamente</a>
		       	</div>
	      	</div>

	      	<hr>

			<div class="table-responsive">

			<table class="table table-condensed table-striped">

			<thead>

				<th width="10%">Entrada</th>
				<th width="20%">Saída</th>
				<th width="35%">Imóvel</th>
				<th width="35%">Locatário</th>
			</thead>

			<tbody>

	      	<?php

	      		foreach ($locacoes as $locacao):

	      			?>	
	      				<tr>
	      					<td><?php echo toUserDate($locacao->reserva->ddatainicial)?></td>
	      					<td><?php echo toUserDate($locacao->reserva->ddatafinal)?> +1 dia</td>
	      					<td><a href="<?php echo base_url('cadimo/imovel/visualizar/'.$locacao->imovel->nidcadimo)?>"><?php echo 'Ref. '.$locacao->imovel->creferencia?></a></td>
	      					<td><a href="<?php echo base_url('cadgrl/cadastro/editar/'.$locacao->locatario->nidcadgrl)?>"><?php echo $locacao->locatario->cnomegrl?></a></td>
	      				</tr>
	      			<?php

	      		endforeach;

	      	?>

	      	</tbody>

	      	</table>

       </div>
    </div>
</div>