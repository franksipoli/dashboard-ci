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
	      		<div class="col-xs-12 col-sm-3 col-md-2"><strong>Período</strong></div>
	      		<div class="col-xs-12 col-sm-9 col-md-10"><?php echo toUserDate($cadloc->ddatainicial)?> a <?php echo toUserDate($cadloc->ddatafinal)?></div>
	      	</div>

	      	<div class="row">
	      		<div class="col-xs-12 col-sm-3 col-md-2"><strong>Locatário</strong></div>
	      		<div class="col-xs-12 col-sm-9 col-md-10"><?php echo $locatario->cnomegrl?></div>
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
	      		<div class="col-xs-12 col-sm-9 col-md-10"><?php echo toUserCurrency($cadloc->nvalor, "R$")?></div>
	      	</div>
	      	<div class="row">
	      		<div class="col-xs-12 col-sm-3 col-md-2"><strong>Taxa Administrativa</strong></div>
	      		<div class="col-xs-12 col-sm-9 col-md-10"><?php echo toUserCurrency($cadloc->ntaxaadm, "R$")?></div>
	      	</div>
	      	<div class="row">
	      		<div class="col-xs-12 col-sm-3 col-md-2"><strong>Quantidade de parcelas</strong></div>
	      		<div class="col-xs-12 col-sm-9 col-md-10"><?php echo $cadloc->nquantidadeparcelas?></div>
	      	</div>

	      	<h2>Depósitos a receber</h2>

	      	<div class="table-responsive">
	      		<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Data de pagamento</th>
							<th>Forma de pagamento</th>
							<th>Valor</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
				      	<?php
				      		foreach ($depositos_receber as $deposito){
				      			?>
				      				<tr>
				      					<td><?php echo $deposito->ddatapagamento?></td>
				      					<td><?php echo Formapagamento_model::getNome($deposito->nidtbxfpa)?></td>
				      					<td><?php echo toUserCurrency($deposito->nvalor, "R$")?></td>
				      					<td><?php echo Statuspagamento_model::getNome($deposito->nidtbxstp)?></td>
				      				</tr>
				      			<?php
				      		}
				      	?>
					</tbody>
				</table>
	      	</div>

	      	<h2>Depósitos a fazer</h2>

	      	<div class="table-responsive">
	      		<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Data de pagamento</th>
							<th>Nome</th>
							<th>Forma de pagamento</th>
							<th>Valor</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
				      	<?php
				      		foreach ($depositos_fazer as $deposito){
				      			?>
				      				<tr>
				      					<td><?php echo $deposito->ddatapagamento?></td>
				      					<td><?php echo Cadastro_model::getNome($deposito->nidcadgrl)?></td>
				      					<td><?php echo Formapagamento_model::getNome($deposito->nidtbxfpa)?></td>
				      					<td><?php echo toUserCurrency($deposito->nvalor, "R$")?></td>
				      					<td><?php echo Statuspagamento_model::getNome($deposito->nidtbxstp)?></td>
				      				</tr>
				      			<?php
				      		}
				      	?>
					</tbody>
				</table>
	      	</div>

	      	<h2>Despesas</h2>

	      	<div class="table-responsive">
	      		<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Data de pagamento</th>
							<th>Forma de pagamento</th>
							<th>Valor</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
				      	<?php
				      		foreach ($despesas_receber as $deposito){
				      			?>
				      				<tr>
				      					<td><?php echo $deposito->ddatapagamento?></td>
				      					<td><?php echo Formapagamento_model::getNome($deposito->nidtbxfpa)?></td>
				      					<td><?php echo toUserCurrency($deposito->nvalor, "R$")?></td>
				      					<td><?php echo Statuspagamento_model::getNome($deposito->nidtbxstp)?></td>
				      				</tr>
				      			<?php
				      		}
				      	?>
					</tbody>
				</table>
	      	</div>

    </div>
</div>