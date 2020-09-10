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
		          	<a href="<?php echo makeUrl('locacaotemporada', 'depositos') ?>" class="btn btn-lg btn-primary add_msg">Pesquisar novamente</a>
		       	</div>
	      	</div>

	      	<hr>

	      	<form action="<?php echo makeUrl('locacaotemporada', 'confirmardepositos')?>" method="POST">

	      	<div class="form-group">
	      		<div class="row">
	      			<div class="col-xs-12">
	      				<button type="submit" class="pull-right btn btn-success btn-sm" onclick="if (!(confirm('Deseja realmente confirmar os depósitos selecionados?'))) return false;">Confirmar selecionados</button>
	      			</div>
	      		</div>
	      	</div>

	      	<?php

	      	foreach ($bancos as $banco):

	      	?>

	      		<h4><?php echo $banco->cicone ? '<img src="'.base_url('assets/app/img/banco/'.$banco->cicone).'" style="display: inline-block; vertical-align: middle; margin-right: 15px; max-width: 36px; height: auto;"> ' : ''?><?php echo $banco->ccodigo." - ".$banco->cnomebco?></h4>

				<div class="table-responsive">

				<table class="table table-condensed table-striped">

				<thead>
					<th width="10%">Tipo</th>
					<th width="40%">Cadastro</th>
					<th width="10%">Data de pagamento</th>
					<th width="10%">Valor</th>
					<th width="20%">Forma de pagamento</th>
					<th width="10%">Status</th>
				</thead>

				<tbody>

		      	<?php

		      		foreach ($depositos[$banco->nidtbxbco] as $deposito):

		      			?>	
		      				<tr>
		      					<td><?php echo $deposito->ctipotransacao == "D" ? "Pagar" : "Receber"?></td>
		      					<td><a href="<?php echo makeUrl('cadgrl/cadastro', 'visualizar', $deposito->nidcadgrl)?>"><?php echo $deposito->cadgrl->cnomegrl?></a></td>
		      					<td><?php echo toUserDate($deposito->ddatapagamento)?></td>
		      					<td>R$<?php echo number_format($deposito->nvalor, 2, ".", ",")?></td>
		      					<td><?php echo Formapagamento_model::getById($deposito->nidtbxfpa)->cnomefpa?></td>
		      					<td><?php
		      						$status = Statuspagamento_model::getById($deposito->nidtbxstp);
		      						?>
		      						<span class="label <?php echo $status->clabel?>"><?php echo $status->cdescricao?><?php echo $status->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? " - ".toUserDate($deposito->ddatapagamento) : ""?></span>
		      					</td>
		      					<td>
		      						<?php
		      						if ($status->cdescricao=="PENDENTE"):
		      						?>
		      						<input type="checkbox" name="nidcadfin[]" value="<?php echo $deposito->nidcadfin?>">
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

	       <br/><br/>

       <?php

       endforeach;

       ?>

   		</form>

    </div>
</div>