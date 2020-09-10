 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

		<?php
          $this->load->view('general/messages');
       ?>

		<form id="atendimento" action="<?php echo makeUrl("ate", "atendimento", "update")?>" method="post" class="form-horizontal">

			<div class="row">
				
				<div class="col-lg-6 col-md-6">
					<h4><?php echo $this->ate->title ?></h4>
					<p><small>
						Registrado por <?php echo $this->ate->insertuser ?> em <?php echo toUserDateTime($this->ate->didata,' às ') ?>
						<?php if($this->ate->dudata) echo '<br>Última modificação por '.$this->ate->updateuser.' em '.toUserDateTime($this->ate->dudata, ' às ') ?>
					</small></p>
				</div>

			</div>

			<hr>
			
			<input type="hidden" name="atendimento_id" value="<?php echo $this->ate->nidcadate ?>">
			<input type="hidden" name="cadastro_id" value="<?php echo $this->ate->geral ?>">

			<?php 
				echo (validation_errors()) 
					? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' 
					: '';
			?>

			<div class="row">

				<div class="col-lg-6 col-md-6">

					<h4>Dados do atendimento</h4>

					<div class="form-group">
						<label for="tipo" class="col-lg-3 col-md-3 control-label">Tipo*:</label>
						<div class="col-lg-9 col-md-9">
							<select name="tipo" id="tipo" required="required" class="form-control">
								<?php
									foreach ($fin as $finalidade):
										?>
											<option value="<?php echo $finalidade->nidtbxfin?>"<?php if($this->ate->nidtbxfin == $finalidade->nidtbxfin) echo ' selected="selected"' ?>><?php echo $finalidade->cnomefin?></option>
										<?php
									endforeach;
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="nome" class="col-lg-3 col-md-3 control-label">Nome*:</label>
						<div class="col-lg-9 col-md-9">
							<input type="text" name="nome" id="nome" value="<?php echo $this->ate->title ?>" required="required" class="form-control" minlength="3" maxlength="100" autocomplete="off">
						</div>
					</div>

					<div class="form-group">
						<label for="telefone" class="col-lg-3 col-md-3 control-label">Telefone*:</label>
						<div class="col-lg-5 col-md-5">
							<input type="text" name="telefone" id="telefone" data-jmask="phone" value="<?php echo $this->ate->cdescritel ?>" required="required" class="form-control" maxlength="15" autocomplete="off">
						</div>

						<div class="col-lg-4 col-md-4">
							<select name="telefone_tipo" id="telefone_tipo" class="form-control">
								<option value="">Selecione</option>
								<?php
								foreach ($this->telefone_tipo as $t)
								{
									$selected = ($t->nidtbxttl == $this->ate->nidtbxttl) ? ' selected="selected"' : '';
									echo '<option value="'.$t->nidtbxttl.'"'.$selected.set_select('telefone_tipo', $t->nidtbxttl).'>'.$t->cdescrittl.'</option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="col-lg-3 col-md-3 control-label">E-mail:</label>
						<div class="col-lg-5 col-md-5">
							<input type="email" name="email" id="email" value="<?php echo $this->ate->email ?>" class="form-control" minlength="5" maxlength="100" autocomplete="off">
						</div>
						<div class="col-lg-4 col-md-4">
							<select name="email_tipo" id="email_tipo" class="form-control">
								<option value="">Selecione</option>
								<?php 
								foreach ($this->email_tipo as $e)
								{
									$selected = ($e->nidtbxtem == $this->ate->nidtbxtem) ? ' selected="selected"' : '';
									echo '<option value="'.$e->nidtbxtem.'"'.$selected.set_select('email_tipo', $e->nidtbxtem).'>'.$e->cdescritem.'</option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="corretor" class="col-lg-3 col-md-3 control-label">Atendente*:</label>
						<div class="col-lg-9 col-md-9">
							<select name="corretor" id="corretor" required="required" class="form-control">
								<option value="">Selecione</option>
								<?php foreach ($this->users as $u)
								{
									$selected = ($u->user_id == $this->ate->corretor) ? ' selected="selected"' : '';
									echo '<option value="'.$u->user_id.'"'.$selected.set_select('corretor', $u->user_id).'>'.$u->user_name.'</option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="como_chegou" class="col-lg-3 col-md-3 control-label">Como chegou:</label>
						<div class="col-lg-9 col-md-9">
							<select name="como_chegou" id="como_chegou" class="form-control">
								<option value="">Selecione</option>
								<?php
								foreach ($this->como_chegou as $ch)
								{
									$selected = ($ch->nidtbxchg == $this->ate->nidtbxchg) ? ' selected="selected"' : '';
									echo '<option value="'.$ch->nidtbxchg.'"'.$selected.set_select('como_chegou', $ch->nidtbxchg).'>'.$ch->cdescrichg.'</option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="obs" class="col-lg-3 col-md-3 control-label">Observações:</label>
						<div class="col-lg-9 col-md-9">
							<textarea class="form-control" id="obs" name="obs" ><?php echo $this->ate->cobs ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="status" class="col-lg-3 col-md-3 control-label">Status:</label>
						<div class="col-lg-4 col-md-4">
							<select name="nidtbxsat" id="status" required="required" class="form-control">
								<?php
									foreach ($sat as $item):
										?>
											<option value="<?php echo $item->nidtbxsat?>"<?php echo $item->nidtbxsat == $this->ate->nidtbxsat ? " selected='selected'" : ""?>><?php echo $item->cnomesat?></option>
										<?php
									endforeach;
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="checkbox col-lg-offset-3 col-md-offset-3 col-lg-10 col-md-10">
							<label>
								<input type="checkbox" name="liberar" value="1"<?php if($this->ate->clibera == 1) echo ' checked="checked"' ?>> Atendimento liberado
							</label>
						</div>
					</div>
				
				</div>

				<div class="col-lg-6 col-md-6">

					<div id="imoveis_relacionados">

						<h4>Produtos Relacionados</h4>

						<div class="row">

							<?php
							if (count($imoveis) > 0):
								foreach ($imoveis as $imovel):
								?>
								<div class="col-sm-4">
									<div class="thumbnail">
										<div class="remove"><a href="<?php echo makeUrl("ate","atendimento/removerimovel", $this->ate->nidcadate)?>?imovel=<?php echo $imovel->nidcadimo?>" title="Remover da lista de atendimento"><span class="fa fa-remove"></span></a></div>
										<a class="details" href="<?php echo makeUrl("cadimo","imovel/visualizar", $imovel->nidcadimo)?>" title="ver detalhes do Imóvel">
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
											<div class="caption">
												<p><strong>Ref. <?php echo $imovel->creferencia?></strong><br><?php echo $imovel->ctitulo?></p>
											</div>
										</a>
									</div>
								</div>
								<?php endforeach;
							else:
								?>
									<div class="col-xs-12">
										<p class="alert alert-danger">Nenhum Produto relacionado</p>
									</div>
								<?php
							endif;
							?>
							
						</div>

					</div>
					<!--
					<div id="imoveis_relacionados">

						<h4>Avaliações relacionadas</h4>

						<div class="row">

							<?php
							//if (count($avaliacoes) > 0):
								?>
								<div class="col-xs-12">
									<table class="table table-condensed table-striped">
									<?php
									//foreach ($avaliacoes as $avaliacao):
									?>
										<tr>
											<td width="70%"><?php //echo toUserDateTime($avaliacao->dtdatacriacao)?></td>
											<td><a href="<?php //echo makeUrl("venda", "ver_avaliacao", $avaliacao->nidtbxava)?>" class="btn btn-sm btn-info">Visualizar</a></td>
										</tr>
									<?php //endforeach;
									?>
									</table>
								</div>
								<?php
							//else:
								?>
									<div class="col-xs-12">
										<p class="alert alert-danger">Nenhuma avaliação relacionada</p>
									</div>
								<?php
							//endif;
							?>
							
						</div>

					</div>
					-->

				</div>

			</div>

			<hr>

			<div class="form-group" style='text-align:center'>
				<p><small>*Campos obrigatórios</small></p>
				<button type="submit" class="btn btn-primary btn-lg">Atualizar atendimento</button>
			</div>

		</form>

		</div>
	</div>
 </div>