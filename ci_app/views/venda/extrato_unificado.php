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
		          	<a href="<?php echo $returnurl ?>" class="btn btn-lg btn-primary">Voltar</a>
		       	</div>
	      	</div>

	      	<hr>

	      	<h2>Dados gerais</h2>

	      	<div class="row">
	      		<div class="col-xs-12 col-sm-3 col-md-2"><strong>Imóvel</strong></div>
	      		<div class="col-xs-12 col-sm-9 col-md-10"><?php echo $cadimo->creferencia?></div>
	      	</div>
	      	<div class="row">
	      		<div class="col-xs-12 col-sm-3 col-md-2"><strong>Comprador</strong></div>
	      		<div class="col-xs-12 col-sm-9 col-md-10"><?php echo $comprador->cnomegrl?></div>
	      	</div>

	      	<div class="row">
	      		<div class="col-xs-12 col-sm-3 col-md-2"><strong>Proprietário (s)</strong></div>
	      		<div class="col-xs-12 col-sm-9 col-md-10">
	      			<?php
	      				foreach ($proprietario as $prop):
	      					echo $prop->cadgrl->cnomegrl." - CPF/CNPJ ".toUserCpfCnpj($prop->cadgrl->ccpfcnpj)." - ".$prop->ipr->npercentual."%";
	      					?>
	      					<br/>
	      					<?php
	      				endforeach;
	      			?>
	      		</div>
	      	</div>

	      	<h2>Financeiro</h2>

	      	<div class="row">
	      		<div class="col-xs-12 col-sm-3 col-md-2"><strong>Valor total</strong></div>
	      		<div class="col-xs-12 col-sm-9 col-md-10"><?php echo toUserCurrency($cadven->nvalor, "R$")?></div>
	      	</div>
	      	<div class="row">
	      		<div class="col-xs-12 col-sm-3 col-md-2"><strong>Quantidade de parcelas</strong></div>
	      		<div class="col-xs-12 col-sm-9 col-md-10"><?php echo $cadven->nquantidadeparcelas?></div>
	      	</div>

	      	<h2>Sinais</h2>

	      	<?php
	      	if (is_array($sinais) && count($sinais) > 0):
	      	?>

	      	<div class="table-responsive">
	      		<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Data</th>
							<th>Comprador</th>
							<th>Status</th>
							<th>Valor</th>
							<th>Descrição</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
				      	<?php
				      		foreach ($sinais as $sinal){
				      			?>
				      				<tr>
				      					<td><?php echo toUserDate($sinal->dtdata)?></td>
				      					<td><?php echo $sinal->comprador->cnomegrl?></td>
				      					<td><?php echo $sinal->status->cdescricao?></td>
				      					<td><?php echo toUserCurrency($sinal->nvalor, "R$")?></td>
				      					<td><?php echo $sinal->tdescricao?></td>
				      					<td><a href="<?php echo $sinal->contrato?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
				      				</tr>
				      			<?php
				      		}
				      	?>
					</tbody>
				</table>
	      	</div>
			<?php
			else:
				?>
					<p class="alert alert-danger">Nenhum sinal</p>
				<?php
			endif;
			?>	      	

	      	<h2>Propostas</h2>

	      	<?php

	      	if (is_array($propostas) && count($propostas) > 0):

	      	?>

	      	<div class="table-responsive">
	      		<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Data</th>
							<th>Cliente</th>
							<th>Tipo</th>
							<th>Descrição</th>
						</tr>
					</thead>
					<tbody>
				      	<?php
				      		foreach ($propostas as $proposta){
				      			?>
				      				<tr>
				      					<td><?php echo $proposta->data?></td>
				      					<td><?php echo $proposta->cliente?></td>
				      					<td><?php echo $proposta->tipo?></td>
				      					<td><?php echo $proposta->tdescricao?></td>
				      				</tr>
				      			<?php
				      		}
				      	?>
					</tbody>
				</table>
	      	</div>

	      	<?php

	      	else:

	      		?>
	      			<p class="alert alert-danger">Nenhuma proposta</p>
	      		<?php

	      	endif;

	      	?>

	      	<h2>Comissões</h2>

	      	<div class="table-responsive">
	      		<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Tipo de comissão</th>
							<th>Percentual</th>
							<th>Valor</th>
							<th>Status</th>
							<th></th>
							<th>Confirmação</th>
						</tr>
					</thead>
					<tbody>
				      	<?php
				      		foreach ($lcm as $item){
				      			?>
				      				<tr>
				      					<td><?php echo $item->tcm->cdescritcm?></td>
				      					<td><?php echo number_format($item->nvalor, 2, ",", ".")."%"?></td>
				      					<td><?php echo toUserCurrency(Venda_model::getValorComissao($item->nidtaglcm) * $cadven->nvalor, "R$")?></td>
				      					<td><?php echo Statuspagamento_model::getNome($item->nidtbxstp)?></td>
				      					<?php
				      					if (Documento_model::temTodosObrigatorios("Venda", $cadven->nidcadven)):
				      					?>
				      					<td>
				      					<?php
				      						if ($item->nidtbxstp == Parametro_model::get('id_status_pagamento_pendente')):
				      							?>
				      								<a href="#" data-comissao="<?php echo $item->nidtaglcm?>" class="btn-status-comissao btn-confirmar"><i class="fa fa-check" aria-hidden="true"></i></a>
				      							<?php
				      						else:
				      							?>
				      								<a href="#" data-comissao="<?php echo $item->nidtaglcm?>" class="btn-status-comissao btn-cancelar"><i class="fa fa-times" aria-hidden="true"></i></a>
				      							<?php
				      						endif;
				      					?>
				      					</td>
				      					<td><span class="data_confirmacao_comissao"><?php echo $item->dtdatapagamento ? toUserDatetime($item->dtdatapagamento) : ''?></span></td>
				      					<?php
				      					else:
				      					?>
				      						<td colspan="2">Enviar documentação</td>
				      					<?php
				      					endif;
				      					?>
				      				</tr>
				      			<?php
				      		}
				      	?>
					</tbody>
				</table>
	      	</div>

    </div>
</div>