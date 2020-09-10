 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
                $this->load->view('general/messages');
            ?>

			<?php

			if (isset($cadimo) && !empty($cadimo)):

			?>

			<h4>Imóvel a ser avaliado: <?php echo $cadimo->creferencia?> - <?php echo $cadimo->ctitulo?></h4>
			<hr>

			<table class="table table-striped">
				<thead>
					<tr>
						<?php
						if ($cadimo->nidcadimo):
						?>
						<th width="10%">Foto</th>
						<?php
						endif;
						?>
						<th width="25%">Referência/Título</th>
						<th width="15%">Área</th>
						<?php
						if ($cadimo->nidcadimo):
						?>
						<th width="15%">Valor</th>
						<th width="15%">Média</th>
						<th class="hidden-print"></th>
						<?php
						endif;
						?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
						if ($cadimo->nidcadimo):
						?>
						<td>

							<div class="col-xs-12">

								<?php

						          $foto = Imovel_model::getPrimeiraFoto($cadimo->nidcadimo);

						          if ($foto):

						          ?>

						            <img src="<?php echo Imovel_model::getPrimeiraFoto($cadimo->nidcadimo)?>?v=<?php echo date('YmdHis')?>" class="img-responsive">

						          <?php

						          else:

						           ?>

						            <img src="<?php echo base_url("imagens/semfoto.jpg")?>" class="img-responsive">

						          <?php

						          endif;

						          ?>

					         </div>
						</td>
						<?php
						endif;
						?>
						<td><?php echo $cadimo->creferencia." - ".$cadimo->ctitulo?></td>
						<td><strong>Total:</strong> <?php echo number_format($cadimo->nareautil, 2, ",", ".")?>m²</td>
						<?php
						if ($cadimo->nidcadimo):
						?>
						<td>
						<?php
							foreach ($fva as $finalidadevalor):
								if ($finalidadevalor['nidtbxfin'] != Parametro_model::get('finalidade_venda_id')):
									continue;
								endif;
								$valor = Finalidadetipovalor_model::getByImovelFinalidade($cadimo->nidcadimo, $finalidadevalor['nidtagfva']);
								if (!$valor):
									continue;
								endif;
								echo "<strong>".$finalidadevalor['cnometpv'].":</strong> ";
								echo "R$".number_format($valor, 2, ",", ".");
								echo "<br/>";
							endforeach;
						?>
						</td>
						<td>
						<?php
							foreach ($fva as $finalidadevalor):
								if ($finalidadevalor['nidtbxfin'] != Parametro_model::get('finalidade_venda_id')):
									continue;
								endif;
								$valor = Finalidadetipovalor_model::getByImovelFinalidade($cadimo->nidcadimo, $finalidadevalor['nidtagfva']);
								if (!$valor):
									continue;
								endif;
								echo "<strong>".$finalidadevalor['cnometpv'].":</strong> ";
								echo "R$".number_format($valor / $cadimo->nareautil, 2, ",", ".")."/m²";
								echo "<br/>";
							endforeach;
						?>
						</td>
						<td class="hidden-print"></td>
						<?php
						endif;
						?>
					</tr>
				</tbody>
			</table>

			<hr>

			<?php

				if ($cadimo->nidcadimo):

				?>

				<div class="row">
					<?php
					if ($returnurl):
					?>
					<div class="voltar col-lg-3"><a href="<?php echo $returnurl ?>" class="btn btn-default">Voltar para a busca</a></div>
					<?php
					endif;
					?>
					<div class="editar col-lg-2 pull-right"><a href="<?php echo makeUrl('cadimo/imovel','editar',$cadimo->nidcadimo) ?>" class="btn btn-primary">Editar Imóvel</a></div>
				</div>

				<?php

				endif;

			endif;

			?>

			<br/><br/>

			<h4>Referências</h4>
			<hr>

			<table class="table table-striped">
				<thead>
					<tr>
						<th width="10%">Foto</th>
						<th width="25%">Referência/Título</th>
						<th width="15%">Área</th>
						<th width="15%">Valor</th>
						<th width="15%">Média</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$media = 0;
						$contador = 0;
						foreach ($imoveis_lista as $imovel):
							?>
								<tr>
									<td>
										<div class="col-xs-12">

											<?php
									          $foto = Imovel_model::getPrimeiraFoto($imovel->nidcadimo);
									          if ($foto):
									          ?>
									            <img src="<?php echo Imovel_model::getPrimeiraFoto($imovel->nidcadimo)?>?v=<?php echo date('YmdHis')?>" class="img-responsive">
									          <?php
									          else:
									           ?>
									            <img src="<?php echo base_url("imagens/semfoto.jpg")?>" class="img-responsive">
									          <?php
									          endif;
									          ?>
								         </div>
									</td>
									<td><?php echo $imovel->creferencia." - ".$imovel->ctitulo?></td>
									<td><strong>Total:</strong> <?php echo number_format($imovel->nareautil, 2, ",", ".")?>m²</td>
									<td>
									<?php
										foreach ($fva as $finalidadevalor):
											if ($finalidadevalor['nidtbxfin'] != Parametro_model::get('finalidade_venda_id')):
												continue;
											endif;
											$valor = Finalidadetipovalor_model::getByImovelFinalidade($imovel->nidcadimo, $finalidadevalor['nidtagfva']);
											if (!$valor):
												continue;
											endif;
											echo "<strong>".$finalidadevalor['cnometpv'].":</strong> ";
											echo "R$".number_format($valor, 2, ",", ".");
											echo "<br/>";
										endforeach;
									?>
									</td>
									<td>
									<?php
										foreach ($fva as $finalidadevalor):
											if ($finalidadevalor['nidtbxfin'] != Parametro_model::get('finalidade_venda_id')):
												continue;
											endif;
											$valor = Finalidadetipovalor_model::getByImovelFinalidade($imovel->nidcadimo, $finalidadevalor['nidtagfva']);
											if (!$valor):
												continue;
											endif;
											$valor_media = $valor / $imovel->nareautil;
											echo "<strong>".$finalidadevalor['cnometpv'].":</strong> ";
											echo "R$".number_format($valor_media, 2, ",", ".")."/m²";
											echo "<br/>";
											$contador ++;
											$media += $valor_media;
										endforeach;
									?>
									</td>
								</tr>
							<?php
						endforeach;
					?>
				</tbody>
			</table>

			<br/><br/>

			<h4>Conclusão: o valor médio estimado para este Imóvel é de R$<?php echo number_format(($media/$contador) * $cadimo->nareautil, 2, ",", ".")?></h4>

			<br/><br/>

			<div class="row">
				<div class="col-xs-12 text-center">
					<a href="javascript:window.print();" class="btn btn-info hidden-print">Imprimir avaliação</a>
					<a href="javascript:;" class="btn btn-info hidden-print">Enviar por e-mail</a>
					<a href="javascript:history.go(-1);" class="btn btn-info hidden-print">Voltar</a>
				</div>
			</div>

		</div>
	</div>
 </div>