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

				else:

				?>

				<div class="row">
					<div class="col-lg-2 pull-right"><a href="<?php echo makeUrl('venda','avaliacao') ?>" class="btn btn-primary">Nova avaliação</a></div>
				</div>

				<?php				

				endif;

			else:

			?>

			<h4>Imóvel a ser avaliado:</h4>
			<hr>

			<!-- START panel-->
			<div class="panel panel-default">
			 <div class="panel-body">
			 	<div class="container-fluid">
				    <form class="form-horizontal" id="frmAvaliaImovel" method="POST" action="<?php echo makeUrl("venda","avaliacao")?>">
				       <div class="form-group">
				          <label class="col-xs-2 control-label">Referência</label>
				          <div class="col-xs-10">
				          	 <input type="text" name="referencia" class="form-control">
				          </div>
				       </div>
				       <div class="form-group">
				          <label class="col-xs-2 control-label">Título</label>
				          <div class="col-xs-10">
				          	 <input type="text" name="titulo" class="form-control">
				          </div>
				       </div>
				       <div class="form-group">
				          <label class="col-xs-2 control-label">Descrição</label>
				          <div class="col-xs-10">
				          	 <input type="text" name="descricao" class="form-control">
				          </div>
				      	</div>
				      	<div class="form-group">
				          <label class="col-xs-2 control-label">Metragem (m²)</label>
				          <div class="col-xs-10">
				          	 <input type="text" name="metragem" class="form-control" data-jmask="number">
				          </div>
				        </div>
				        <div class="form-group">
				          <label class="col-xs-2 control-label">Atendimento</label>
				          <div class="col-xs-10">
				          	<select name="nidcadate" class="form-control">
				          		<option value=""></option>
					          	<?php
					          	if (is_array($atendimentos) && count($atendimentos) > 0):
			                        foreach ($atendimentos as $ate):
			                           ?>
			                       		  <option value="<?php echo $ate->nidcadate?>"><?php echo $ate->cadgrl->cnomegrl?></option>
			                           <?php
			                        endforeach;
			                     endif;
			                     ?>
				          	</select>
				          </div>
				        </div>
				        <div class="form-group">
				      	  <div class="col-xs-12">
				      	  	<button type="submit" class="btn btn-sm btn-primary">Avaliar</button>
				      	  </div>
				      	</div>
				    </form>
				</div>
			 </div>
			</div>

			<?php

			endif;

			?>

			<br/><br/>

			<h4>Referências</h4>
			<hr>

			<?php

			if (count($imoveis_lista) == 0):

			?>

			<p class="alert alert-danger">Nenhum Imóvel na lista</p>

			<?php

			else:

			?>

			<table class="table table-striped">
				<thead>
					<tr>
						<th width="10%">Foto</th>
						<th width="25%">Referência/Título</th>
						<th width="15%">Área</th>
						<th width="15%">Valor</th>
						<th width="15%">Média</th>
						<th class="hidden-print"></th>
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
											if (!$valor || $finalidadevalor['cnometpv'] != Parametro_model::get('finalidade_valor_padrao')):
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
									<?php
									if ($cadimo->nidcadimo):
									?>
									<td class="hidden-print"><a href="<?php echo makeUrl("venda", "removerImovelAvaliacao", $imovel->nidcadimo)."?imovel_avaliar=".$cadimo->nidcadimo?>" title="Remover Imóvel da lista"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
									<?php
									else:
									?>
									<td class="hidden-print"><a href="<?php echo makeUrl("venda", "removerImovelAvaliacao", $imovel->nidcadimo)."?avaliacao_id=".$avaliacao_id?>" title="Remover Imóvel da lista"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
									<?php	
									endif;
									?>
								</tr>
							<?php
						endforeach;
						$media_total = $media / $contador;
					?>
				</tbody>
				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th>Média</th>
						<th>R$<?php echo number_format($media_total, 2, ",", ".")."/m²"?></th>
						<th class="hidden-print"></th>
					</tr>
				</tfoot>
			</table>

			<br/><br/>

			<h4>Imóveis considerados</h4>
			<hr>

			<table class="table table-striped">
				<thead>
					<tr>
						<th width="10%">Foto</th>
						<th width="25%">Referência/Título</th>
						<th width="15%">Área</th>
						<th width="15%">Valor</th>
						<th width="15%">Média</th>
						<th class="hidden-print"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$media = 0;
						$contador = 0;
						foreach ($imoveis_lista as $imovel):
								$considerar = true;
									foreach ($fva as $finalidadevalor):
										if ($finalidadevalor['nidtbxfin'] != Parametro_model::get('finalidade_venda_id')):
											continue;
										endif;
										$valor = Finalidadetipovalor_model::getByImovelFinalidade($imovel->nidcadimo, $finalidadevalor['nidtagfva']);
										if (!$valor || $finalidadevalor['cnometpv'] != Parametro_model::get('finalidade_valor_padrao')):
											continue;
										endif;
										$valor_media = $valor / $imovel->nareautil;
										$limite_superior = $media_total + $media_total*Parametro_model::get('percentual_amostragem_avaliacao')/100;
										$limite_inferior = $media_total - $media_total*Parametro_model::get('percentual_amostragem_avaliacao')/100;
										if ($valor_media > $limite_superior || $valor_media < $limite_inferior):
											$considerar = false;
										endif;
									endforeach;
								if (!$considerar):
									continue;
								endif;
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
											if (!$valor || $finalidadevalor['cnometpv'] != Parametro_model::get('finalidade_valor_padrao')):
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
									<?php
									if ($cadimo->nidcadimo):
									?>
									<td class="hidden-print"><a href="<?php echo makeUrl("venda", "removerImovelAvaliacao", $imovel->nidcadimo)."?imovel_avaliar=".$cadimo->nidcadimo?>" title="Remover Imóvel da lista"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
									<?php
									else:
									?>
									<td class="hidden-print"><a href="<?php echo makeUrl("venda", "removerImovelAvaliacao", $imovel->nidcadimo)."?avaliacao_id=".$avaliacao_id?>" title="Remover Imóvel da lista"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
									<?php	
									endif;
									?>
								</tr>
							<?php
						endforeach;
					?>
				</tbody>
				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th>Média</th>
						<th>R$<?php echo number_format($media/$contador, 2, ",", ".")."/m²"?></th>
						<th class="hidden-print"></th>
					</tr>
				</tfoot>
			</table>

			<br/><br/>

			<h4>Conclusão: o valor médio estimado para este Imóvel é de R$<?php echo number_format(($media/$contador) * $cadimo->nareautil, 2, ",", ".")?></h4>

			<br/><br/>

			<div class="row">
				<div class="col-xs-12 text-center">
					<a href="javascript:window.print();" class="btn btn-info hidden-print">Imprimir avaliação</a>
					<a href="javascript:;" class="btn btn-info hidden-print">Enviar por e-mail</a>
				</div>
			</div>

			<?php

			endif;

			?>

		</div>
	</div>
 </div>