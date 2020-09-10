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
		          	<a href="<?php echo makeUrl('venda', 'relatorio') ?>" class="btn btn-lg btn-primary add_msg">Pesquisar novamente</a>
		       	</div>
	      	</div>

	      	<hr>

			<div class="table-responsive">

			<table class="table table-condensed table-striped">

			<thead>
				<th width="10%">Data</th>
				<th width="30%">Imóvel</th>
				<th width="30%">Comprador</th>
				<th width="12%">Valor</th>
				<th width="12%">Comissão</th>
				<th colspan="3" width="6%">Funções</th>
			</thead>

			<tbody>

	      	<?php

	      		$sum_valor_total = "";
	      		$sum_comissoes = "";
	      		$sum_saldo = "";

	      		foreach ($vendas as $venda):

	      			/* Valor total da locação, incluindo a taxa administrativa */

	      			$valor_total = $venda->venda->nvalor;

	      			/* Comissão do vendedor, em porcentagem */

	      			$total_comissoes = Venda_model::getTotalComissoes($venda->venda->nidcadven);
	      			/* Soma os totais */

	      			$sum_valor_total += $valor_total;
	      			$sum_comissoes += $total_comissoes;
	      			$sum_saldo += $valor_total - $total_comissoes;

	      			$saldo = $valor_total - $total_comissoes;

	      			?>	
	      				<tr>
	      					<td><?php echo toUserDate($venda->venda->dtdatacriacao)?></td>
	      					<td><a href="<?php echo base_url('cadimo/imovel/visualizar/'.$venda->imovel->nidcadimo)?>"><?php echo 'Ref. '.$venda->imovel->creferencia.($venda->imovel->nunidade ? " - ".$venda->imovel->nunidade : "")?></a></td>
	      					<td><a href="<?php echo base_url('cadgrl/cadastro/editar/'.$venda->venda->nidcadgrl)?>"><?php echo $venda->comprador->cnomegrl?></a></td>
	      					<td><span class="valor text-primary">R$<?php echo number_format($valor_total, 2, ",", ".")?></span></td>
	      					<td><span class="valor text-danger">R$<?php echo number_format($total_comissoes, 2, ",", ".")?></span></td>
	      					<td width="2%"><a href="<?php echo base_url("venda/unificado/".$venda->venda->nidcadven)?>" title="Extrato unificado"><span class="fa fa-file"></span></a></td>
	      					<td width="2%"><a href="<?php echo base_url("venda/documentos/".$venda->venda->nidcadven)?>" title="Documentos"><span class="fa fa-upload"></span></a></td>
	      					<td width="2%"><a href="<?php echo base_url("venda/remover/".$venda->venda->nidcadven."?returnurl=".urlencode(base_url().ltrim($_SERVER['REQUEST_URI'], '/')))?>" class="apagar-venda" title="Apagar"><span class="fa fa-trash"></span></a></td>
	      				</tr>
	      			<?php

	      		endforeach;

	      	?>

	      	</tbody>

	      	<tfooter>

		      	<tr>
		      		<td colspan="3"><strong>Total</strong></td>
  					<td><span class="valor text-primary">R$<?php echo number_format($sum_valor_total, 2, ",", ".")?></span></td>
  					<td><span class="valor text-danger">R$<?php echo number_format($sum_comissoes, 2, ",", ".")?></span></td>
		      		<td colspan="2"></td>
		      	</tr>

	      	</tfooter>

	      	</table>

       </div>
    </div>
</div>