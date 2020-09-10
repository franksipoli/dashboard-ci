 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
           		$this->load->view('general/messages');
            ?>

			<h4>Ata de Chaves - Chave <?php echo $imovel->creferencia.".".($imovel->nunidade ? $imovel->nunidade : 1).".".$chave->nidcadchv?>- Imóvel <?php echo $imovel->creferencia?></h4>

			<br/>

			<?php

			if ($disponivel_retirada):

			?>

				<div class="row">
					<div class="voltar col-lg-3"><a href="#" data-toggle="modal" id="btnRetirarChave" data-target="#modalRetirarChave" class="btn btn-danger">Retirar chave</a></div>
				</div>

				<br/>

			<?php

			else:

				?>
				<p class="alert alert-danger">A chave não está disponível para retirada pois possui uma devolução em aberto</p>
				<div class="row">
					<div class="voltar col-lg-3"><a href="#" data-toggle="modal" id="btnDevolverChave" data-target="#modalDevolverChave" class="btn btn-danger">Devolver chave</a></div>
				</div>
				<br/>
				<?php				

			endif;

			?>

			<h4>Ata</h4>

			<table id="chave_lista" class="table table-striped table-hover datatable" data-nidcadimo="<?php echo $imovel->nidcadimo?>" data-nidcadchv="<?php echo $chave->nidcadchv?>">
				<thead>
					<tr>
						<th width="10%">Saída</th>
						<th width="10%">Devolução</th>
						<th width="23%">Retirado por</th>
						<th width="23%">Devolvido por</th>
						<th width="30%">Observações</th>
						<th width="2%"></th>
						<th width="2%"></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>

			<br/><br/>

			<hr>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('cadimo/imovel','chaves', $imovel->nidcadimo) ?>" class="btn btn-default">Voltar para lista de chaves</a></div>
			</div>

			<input type="hidden" id="nidcadimo" value="<?php echo $imovel->nidcadimo?>">
			<input type="hidden" id="nidcadchv" value="<?php echo $chave->nidcadchv?>">
			<input type="hidden" id="ncodchv" value="<?php echo $imovel->creferencia.".".($imovel->nunidade ? $imovel->nunidade : 1).".".$chave->nidcadchv?>">

		</div>
	</div>
 </div>