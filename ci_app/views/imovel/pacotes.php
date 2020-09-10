 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php

           		$this->load->view('general/messages');
            ?>

			<h4><?php echo $cadimo->ctitulo ?></h4>

			<h4>Pacotes</h4>

			<!-- START panel-->
			<div class="panel panel-default">
			 <div class="panel-body">
			    <form action="<?php echo base_url("cadimo/imovel/pacotes/".$nidcadimo)?>" method="POST">
					<?php
						foreach ($pacotes as $pacote):
							?>
								<div class="row pacote">
									<div class="col-xs-12 col-sm-3">
										<div class="form-group">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="nidtbxpac[]" value="<?php echo $pacote->nidtbxpac?>" <?php echo isset($pacotes_selecionados[$pacote->nidtbxpac]) ? ' checked="checked"' : ''?>>
													<?php echo $pacote->cnomepac?>
												</label>
											</div>
										</div>
									</div>
									<div class="col-xs-12 col-sm-3">
										<div class="form-group">
											<input type="text" name="nvlrdiaria[<?php echo $pacote->nidtbxpac?>]" value="<?php echo isset($pacotes_selecionados[$pacote->nidtbxpac]) ? $pacotes_selecionados[$pacote->nidtbxpac]['nvlrdiaria'] : max($valores)?>" class="form-control" placeholder="Valor da diária" data-jmask="dinheiro">
										</div>
									</div>
									<div class="col-xs-12 col-sm-3">
										<div class="form-group">
											<input type="text" name="nmindias[<?php echo $pacote->nidtbxpac?>]" value="<?php echo isset($pacotes_selecionados[$pacote->nidtbxpac]) ? $pacotes_selecionados[$pacote->nidtbxpac]['nmindias'] : ''?>" class="form-control" placeholder="Mínimo de dias" data-jmask="number">
										</div>
									</div>
									<div class="col-xs-12 col-sm-3">
										<div class="form-group">
											<input type="text" name="nvlrpacote[<?php echo $pacote->nidtbxpac?>]" value="<?php echo isset($pacotes_selecionados[$pacote->nidtbxpac]) ? $pacotes_selecionados[$pacote->nidtbxpac]['nvlrpacote'] : ''?>" class="form-control" placeholder="Valor do pacote" data-jmask="dinheiro">
										</div>
									</div>
								</div>
							<?php
						endforeach;
					?>
					<div class="row">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-info">Atualizar</button>							
						</div>
					</div>
			    </form>
			 </div>
			</div>

			<hr>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('cadimo','imovel','listar') ?>" class="btn btn-default">Voltar para lista de imóveis</a></div>
			</div>

			<input type="hidden" id="nidcadimo" value="<?php echo $nidcadimo?>">

		</div>
	</div>
 </div>