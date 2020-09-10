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
					Cadastrado em <?php echo toUserDateTime($cadimo->dtdatacriacao) ?>
					<?php if($cadimo->dtdataatualizacao) echo '<br>última atualização em '.toUserDateTime($cadimo->dtdataatualizacao); ?>
				.</small>
			</p>

			<h4>Dados principais</h4>

			<table class="table">
				<tr>
					<th width="25%">Entidade</th>
					<td>
						<?php
							if ($entidade->nidcadgrl):
								echo Cadastro_model::getById($entidade->nidcadgrl)->cnomegrl;
							elseif ($entidade->nidcadjur):
								echo Pessoajuridica_model::getById($entidade->nidcadjur)->cnomefant;
							else:
								echo "<i>Não preenchido</i>";
							endif;
						?>
					</td>
				</tr>
				<tr>
					<th>Tipo de Imóvel</th>
					<td>
						<?php
							echo !empty($tipo_imovel->cnometpi) ? $tipo_imovel->cnometpi : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<tr>
					<th>Tipos secundários</th>
					<td>
						<?php
							foreach ($tipos_secundarios as $tipo):
								$nomes[] = $tipo->cnometp2;
							endforeach;
							echo !empty($nomes) ? implode(", ", $nomes) : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<tr>
					<th>Finalidade</th>
					<td>
						<?php
							echo !empty($finalidade->cnomefin) ? $finalidade->cnomefin : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<tr>
					<th>Referência</th>
					<td>
						<?php
							echo !empty($cadimo->creferencia) ? $cadimo->creferencia : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<!--
				<tr>
					<th>Construtora</th>
					<td>
						<?php
							//echo !empty($cadimo->cconstrutora) ? $cadimo->cconstrutora : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<tr>
					<th>Ano de Construção</th>
					<td>
						<?php
							//echo !empty($cadimo->nanocons) ? $cadimo->nanocons : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<tr>
					<th>Status da Construção</th>
					<td>
						<?php
							//echo !empty($status_construcao->cnometsc) ? $status_construcao->cnometsc : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<tr>
					<th>Condomínio</th>
					<td>
						<?php
							//echo !empty($cadimo->ccondominio) ? $cadimo->ccondominio : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				-->

				<?php
				if ($cadimo->nidcadfin == Parametro_model::get('finalidade_venda_id')):
				?>
					<tr>
						<th>Matrícula</th>
						<td>
							<?php
								echo !empty($cadimo->cmatricula) ? $cadimo->cmatricula : "<i>Não preenchido</i>";
							?>
						</td>
					</tr>
					<!--
					<tr>
						<th>Lote</th>
						<td>
							<?php
								//echo !empty($cadimo->clote) ? $cadimo->clote : "<i>Não preenchido</i>";
							?>
						</td>
					</tr>
					<tr>
						<th>Quadra</th>
						<td>
							<?php
								//echo !empty($cadimo->cquadra) ? $cadimo->cquadra : "<i>Não preenchido</i>";
							?>
						</td>
					</tr>
					<tr>
						<th>Planta</th>
						<td>
							<?php
								//echo !empty($cadimo->cplanta) ? $cadimo->cplanta : "<i>Não preenchido</i>";
							?>
						</td>
					</tr>
					-->
				<?php
				endif;
				?>
			</table>

			<?php

			if (count($proprietarios) > 0):

				?>

					<br />

					<h4>Parceiros no Imóvel</h4>
					
					<table class="table">			

					<?php

					foreach ($proprietarios as $proprietario):

					?>

						<tr>
							<th width="25%"><?php echo $proprietario->cadgrl->cnomegrl?> (<?php echo $proprietario->cadgrl->ccpfcnpj?>)</th>
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
					<h4>Nenhum Parceiro informado</h4>
				<?php

			endif;

			?>

			<?php

			if (count($angariadores) > 0):

				?>

					<br />

					<h4>Indicadores</h4>
					
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
					<h4>Nenhum indicador informado</h4>
				<?php

			endif;

			/* TODO exibir restante das informações do cadastro de Imóvel */

			?>

			<?php
			echo Log_model::getViewLog("cadimo", $cadimo->nidcadimo);
			?>

			<hr>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('cadimo','imovel','listar') ?>" class="btn btn-default">Voltar para lista de Imóvels</a></div>
				<div class="editar col-lg-2 pull-right"><a href="<?php echo makeUrl('cadimo/imovel','editar', $cadimo->nidcadimo) ?>" class="btn btn-primary">Editar Imóvel</a></div>
			</div>

		</div>
	</div>
 </div>