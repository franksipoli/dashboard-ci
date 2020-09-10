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
		          	<a href="<?php echo makeUrl('locacaotemporada', 'relatorio') ?>" class="btn btn-lg btn-primary add_msg">Pesquisar novamente</a>
		       	</div>
	      	</div>

	      	<hr>

			<div class="table-responsive">

			<table class="table table-condensed table-striped">

			<thead>
				<th width="7%">Reserva</th>
				<th width="7%">Entrada</th>
				<th width="7%">Saída</th>
				<th width="11%">Imóvel</th>
				<th width="23%">Locatário</th>
				<th width="9%">Crédito</th>
				<th width="9%">Comissão</th>
				<th width="9%">Despesa</th>
				<th width="9%">Saldo</th>
				<th colspan="6" width="9%">Funções</th>
			</thead>

			<tbody>

	      	<?php

	      		$sum_valor_total = "";
	      		$sum_comissoes = "";
	      		$sum_despesas = "";
	      		$sum_saldo = "";

	      		foreach ($locacoes as $locacao):

	      			/* Valor total da locação, incluindo a taxa administrativa */

	      			$valor_total = $locacao->reserva->nvalor;

	      			/* Valor da taxa administrativa */

	      			$taxa_administrativa = $locacao->reserva->ntaxaadm;

	      			/* Comissão do vendedor, em porcentagem */

	      			$total_comissoes = Locacaotemporada_model::getTotalComissoes($locacao->reserva->nidcadloc);
	      			
	      			/* Verifica no modelo o valor da soma de todas as despesas da locação */

	      			$total_despesas = Despesa_model::getTotalCobradoLocacao($locacao->reserva->nidcadloc);
	      			
	      			/* Soma os totais */

	      			$sum_valor_total += $valor_total;
	      			$sum_comissoes += $total_comissoes;
	      			$sum_despesas += $total_despesas;
	      			$sum_saldo += $valor_total - $total_comissoes - $total_despesas;

	      			$saldo = $valor_total - $total_comissoes - $total_despesas;

	      			?>	
	      				<tr>
	      					<td><?php echo toUserDate($locacao->reserva->dtdatacriacao)?></td>
	      					<td><?php echo toUserDate($locacao->reserva->ddatainicial)?></td>
	      					<td><?php echo toUserDate($locacao->reserva->ddatafinal)?></td>
	      					<td><a href="<?php echo base_url('cadimo/imovel/visualizar/'.$locacao->imovel->nidcadimo)?>"><?php echo 'Ref. '.$locacao->imovel->creferencia?></a></td>
	      					<td><a href="<?php echo base_url('cadgrl/cadastro/editar/'.$locacao->locatario->nidcadgrl)?>"><?php echo $locacao->locatario->cnomegrl?></a></td>
	      					<td><span class="valor text-primary">R$<?php echo number_format($valor_total, 2, ",", ".")?></span></td>
	      					<td><span class="valor text-danger">R$<?php echo number_format($total_comissoes, 2, ",", ".")?></span></td>
	      					<td><span class="valor text-danger">R$<?php echo number_format($total_despesas, 2, ",", ".")?></span></td>
	      					<td><span class="valor <?php echo $saldo >= 0 ? "text-primary" : "text-danger"?>">R$<?php echo number_format($saldo, 2, ",", ".")?></span></td>
	      					<td><a href="#"<?php echo $nidcadloc == $locacao->reserva->nidcadloc && $abrir_modal_despesas ? ' data-autoopen="1"' : ''?> title="Cadastrar despesas" class="cadastrar-despesa" data-locacao="<?php echo $locacao->reserva->nidcadloc?>" data-toggle="modal" data-target="#modalDespesas"><span class="fa fa-calculator"></span></a></td>
	      					<td><a href="#"<?php echo $nidcadloc == $locacao->reserva->nidcadloc && $abrir_modal_servicos ? ' data-autoopen="1"' : ''?> title="Cadastrar serviços" class="cadastrar-servico" data-locacao="<?php echo $locacao->reserva->nidcadloc?>" data-toggle="modal" data-target="#modalServicos"><span class="fa fa-wrench"></span></a></td>
	      					<td><a href="#"<?php echo $nidcadloc == $locacao->reserva->nidcadloc && $abrir_modal_depositos ? ' data-autoopen="1"' : ''?> title="Depósitos" class="cadastrar-deposito" data-locacao="<?php echo $locacao->reserva->nidcadloc?>" data-toggle="modal" data-target="#modalDepositos"><span class="fa fa-usd"></span></a></td>
	      					<td><a href="<?php echo base_url("locacaotemporada/contratos/".$locacao->reserva->nidcadloc)?>" title="Imprimir"><span class="fa fa-print"></span></a></td>
	      					<td><a href="<?php echo base_url("locacaotemporada/unificado/".$locacao->reserva->nidcadloc)?>" title="Extrato unificado"><span class="fa fa-file"></span></a></td>
	      					<td><a href="<?php echo base_url("locacaotemporada/remover/".$locacao->reserva->nidcadloc."?returnurl=".urlencode(base_url().ltrim($_SERVER['REQUEST_URI'], '/')))?>" class="apagar-locacao" title="Apagar"><span class="fa fa-trash"></span></a></td>
	      				</tr>
	      			<?php

	      		endforeach;

	      	?>

	      	</tbody>

	      	<tfooter>

		      	<tr>
		      		<td colspan="5"><strong>Total</strong></td>
  					<td><span class="valor text-primary">R$<?php echo number_format($sum_valor_total, 2, ",", ".")?></span></td>
  					<td><span class="valor text-danger">R$<?php echo number_format($sum_comissoes, 2, ",", ".")?></span></td>
  					<td><span class="valor text-danger">R$<?php echo number_format($sum_despesas, 2, ",", ".")?></span></td>
  					<td><span class="valor <?php echo $sum_saldo >= 0 ? "text-primary" : "text-danger"?>">R$<?php echo number_format($sum_saldo, 2, ",", ".")?></span></td>
		      		<td colspan="4"></td>
		      	</tr>

	      	</tfooter>

	      	</table>

       </div>
    </div>
</div>