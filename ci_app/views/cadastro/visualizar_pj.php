 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
           		$this->load->view('general/messages');
            ?>

			<h4><?php echo $cadgrl->cnomegrl ?></h4>
			<p>
				<small>
					Cadastrado em <?php echo toUserDateTime($cadgrl->dtdatacriacao) ?> por <?php echo Segusuario_model::getNome($cadgrl->nidtbxsegusu_criacao)?>
					<?php if($cadgrl->dtdataatualizacao) echo '<br>Última atualização em '.toUserDateTime($cadgrl->dtdataatualizacao)." por ".Segusuario_model::getNome($cadgrl->nidtbxsegusu_atualizacao); ?>
				.</small>
			</p>

			<div class="form-group">
			<?php
				foreach ($tipos_cadastro as $tipo_cadastro):
					?>
						<span class="label label-info"><?php echo $tipo_cadastro->cdescritcg?></span>
					<?php
				endforeach;
				if ($tipos_servico):
					foreach ($tipos_servico as $tipo_servico):
						?>
							<span class="label label-success"><?php echo $tipo_servico['nome']?></span>
						<?php
					endforeach;
				endif;
			?>
			</div>

			<h4>Pessoa jurídica</h4>

			<table class="table">
				<tr>
					<th width="25%">Como chegou</th>
					<td>
						<?php
							echo !empty($comochegou->cdescrichg) ? $comochegou->cdescrichg : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<tr>
					<th>Razão Social</th>
					<td>
						<?php
							echo !empty($cadgrl->cnomegrl) ? $cadgrl->cnomegrl : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<tr>
					<th>CNPJ</th>
					<td>
						<?php
							echo !empty($cadgrl->ccpfcnpj) ? $cadgrl->ccpfcnpj : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
				<tr>
					<th>IE</th>
					<td>
						<?php
							if ($cadjur->nieisento){
								echo "Isento";
							} else {
								echo !empty($cadgrl->crgie) ? $cadgrl->crgie : "<i>Não preenchido</i>";
							}
						?>
					</td>
				</tr>
				<tr>
					<th>Observações</th>
					<td>
						<?php
							echo !empty($cadgrl->cobs) ? $cadgrl->cobs : "<i>Não preenchido</i>";
						?>
					</td>
				</tr>
			</table>

			<?php

			if (count($enderecos) > 0):

				?>
					
					<?php

					foreach ($enderecos as $endereco):

					?>

					<br />

					<h4>Endereço <?php echo $endereco['tpe']?></h4>

					<table class="table">

						<tr>
							<th width="25%">Logradouro</th>
							<td>
								<?php
									echo !empty($endereco['cdescrilog']) ? $endereco['cdescrilog'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

						<tr>
							<th width="25%">Número</th>
							<td>
								<?php
									echo !empty($endereco['cnumero']) ? $endereco['cnumero'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

						<tr>
							<th width="25%">Complemento</th>
							<td>
								<?php
									echo !empty($endereco['ccomplemento']) ? $endereco['ccomplemento'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

						<tr>
							<th width="25%">CEP (logradouro)</th>
							<td>
								<?php
									echo !empty($endereco['ccep_log']) ? $endereco['ccep_log'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

						<tr>
							<th width="25%">Bairro</th>
							<td>
								<?php
									echo !empty($endereco['cdescribai']) ? $endereco['cdescribai'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

						<tr>
							<th width="25%">Localidade</th>
							<td>
								<?php
									echo !empty($endereco['cdescriloc']) ? $endereco['cdescriloc'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

						<tr>
							<th width="25%">UF</th>
							<td>
								<?php
									echo !empty($endereco['cdescriuf']) ? $endereco['cdescriuf'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

						<tr>
							<th width="25%">País</th>
							<td>
								<?php
									echo !empty($endereco['cdescripas']) ? $endereco['cdescripas'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

					</table>

					<?php

					endforeach;

			else:

				?>
					<hr>
					<h4>Nenhum endereço informado</h4>
					<hr>
				<?php

			endif;

			?>

			<?php

			if (count($telefones) > 0):

				?>
					
					<?php

					foreach ($telefones as $telefone):

					?>

					<br />

					<h4>Telefone <?php echo $telefone['ttl']?></h4>

					<table class="table">

						<tr>
							<th width="25%">Telefone</th>
							<td>
								<?php
									echo !empty($telefone['cdescritel']) ? $telefone['cdescritel'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

					</table>

					<?php

					endforeach;

			else:

				?>
					<hr>
					<h4>Nenhum telefone informado</h4>
					<hr>
				<?php

			endif;

			?>

			<?php

			if (count($emails) > 0):

				?>
					
					<?php

					foreach ($emails as $email):

					?>

					<br />

					<h4>E-mail <?php echo $email['tem']?></h4>

					<table class="table">

						<tr>
							<th width="25%">E-mail</th>
							<td>
								<?php
									echo !empty($email['cdescriemail']) ? $email['cdescriemail'] : "<i>Não preenchido</i>";
								?>
							</td>
						</tr>

					</table>

					<?php

					endforeach;

			else:

				?>
					<hr>
					<h4>Nenhum e-mail informado</h4>
					<hr>
				<?php

			endif;

			?>

			<?php
			echo Log_model::getViewLog("cadgrl", $cadgrl->nidcadgrl);
			?>

			<hr>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('cadgrl','cadastro','listar') ?>" class="btn btn-default">Voltar para cadastros</a></div>
				<div class="editar col-lg-2 pull-right"><a href="<?php echo makeUrl('cadgrl/cadastro','editar',$cadgrl->nidcadgrl) ?>" class="btn btn-primary">Editar cadastro</a></div>
			</div>

		</div>
	</div>
 </div>