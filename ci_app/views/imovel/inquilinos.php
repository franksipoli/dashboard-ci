 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
           		$this->load->view('general/messages');
            ?>

			<h4><?php echo $cadimo->ctitulo ?></h4>
			<p>
				<small>
					<?php if($cadimo->dtdataatualizacao) echo '<br>última atualização em '.toUserDateTime($cadimo->dtdataatualizacao, TRUE); ?>
				.</small>
			</p>

			<h4>Dados do inquilino</h4>

			<!-- START panel-->
			<div class="panel panel-default">
			 <div class="panel-body">
			    <form class="form-horizontal" id="frmCadastroInquilino" method="POST" action="<?php echo isset($tipocontrato) ? makeUrl("cadimo","tipocontrato","update","?id=".$tipocontrato->nidtbxcon) : makeUrl("cadimo","tipocontrato","insert")?>">
			       <?php
			       		$this->load->view('general/messages');
			       ?>
			       <div class="form-group">
			          <label class="col-lg-2 control-label">Descrição</label>
			          <div class="col-lg-10">
			             <input type="text" placeholder="Descrição" name="cnomecon" class="form-control" required="required" value="<?php echo isset($tipocontrato) ? $tipocontrato->cnomecon : $this->session->flashdata('cnomecon')?>" />
			          </div>
			       </div>
			    </form>
			 </div>
			</div>

			<?php

			if (count($proprietarios) > 0):

				?>

					<br />

					<h4>Proprietários</h4>
					
					<table class="table">			

					<?php

					foreach ($proprietarios as $proprietario):

					?>

						<tr>
							<th width="30%"><?php echo $proprietario->cadgrl->cnomegrl?> (<?php echo $proprietario->cadgrl->ccpfcnpj?>)</th>
							<td>
								<?php
									echo $proprietario->ipr->npercentual."%";
								?>
							</td>
						</tr>

					<?php

					endforeach;

					?>

					</table>

					<?php

			else:

				?>
					<h4>Nenhum proprietário informado</h4>
				<?php

			endif;

			?>

			<?php

			if (count($angariadores) > 0):

				?>

					<br />

					<h4>Angariadores</h4>
					
					<table class="table">			

					<?php

					foreach ($angariadores as $angariador):

					?>

						<tr>
							<th width="25%"><?php echo $angariador->segusu->cnome?></th>
							<td>
								<?php
									echo $angariador->ang->npercentual."%";
								?>
							</td>
						</tr>

					<?php

					endforeach;

					?>

					</table>

					<?php

			else:

				?>
					<h4>Nenhum angariador informado</h4>
				<?php

			endif;

			/* TODO exibir restante das informações do cadastro de Imóvel */

			?>

			<hr>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('cadimo','imovel','listar') ?>" class="btn btn-default">Voltar para lista de imóveis</a></div>
				<div class="editar col-lg-2 pull-right"><a href="<?php echo makeUrl('cadimo/imovel','editar', $nidcadimo) ?>" class="btn btn-primary">Editar Imóvel</a></div>
			</div>

			<input type="hidden" id="nidcadloc" value="<?php echo $cadloc->nidcadloc?>">

		</div>
	</div>
 </div>