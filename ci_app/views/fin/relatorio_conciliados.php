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
		          	<a href="<?php echo makeUrl('fin/conciliacao', 'conciliados') ?>" class="btn btn-lg btn-primary add_msg">Pesquisar novamente</a>
		       	</div>
	      	</div>

	      	<hr>

			<div class="table-responsive">

			<table class="table table-condensed table-striped">

			<thead>

				<th width="10%">Número</th>
				<th width="20%">Locação</th>
				<th width="10%">Entrada</th>
				<th width="10%">Saída</th>
				<th width="20%">Locatário</th>
				<th width="10%">Vencimento</th>
				<th width="10%">Valor</th>
				<th width="10%">Status</th>
			</thead>

			<tbody>

	      	<?php

	      		foreach ($boletos as $boleto):

	      			?>	
	      				<tr>
	      					<td><?php echo $boleto->cnumerodocumento?></td>
	      					<td><?php echo $boleto->imo->creferencia." - ".$boleto->imo->ctitulo?></td>
	      					<td><?php echo toUserDate($boleto->loc->ddatainicial)?></td>
	      					<td><?php echo toUserDate($boleto->loc->ddatafinal)?></td>
	      					<td><?php echo $boleto->csacado?></td>
	      					<td><?php echo toUserDate($boleto->ddatavencimento)?></td>
	      					<td>R$<?php echo number_format($boleto->nvalor, 2, ".", ",")?></td>
	      					<td>
	      						<?php
	      							if ($boleto->ddatapagamento):
	      								?>
	      									<span class="label label-success">PAGO</span>
	      								<?php
	      							elseif ($boleto->nconciliado):
	      								?>
	      									<span class="label label-warning">CONCILIADO - <?php echo toUserDate($boleto->ddataconciliado)?></span>
	      								<?php
	      							endif;
	      						?>
	      						</td>
	      				</tr>
	      			<?php

	      		endforeach;

	      	?>

	      	</tbody>

	      	</table>

       </div>
    </div>
</div>