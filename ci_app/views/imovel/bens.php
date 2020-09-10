 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">
			<button data-toggle="modal" data-target="#modalBens" class="btn btn-success btn-md">Lista para impressão</button>
			<a href="<?php echo makeUrl("cadimo/imovel", "listar")?>" class="btn btn-sm btn-info">Voltar</a>
			<br/><br/>
			<input type="hidden" name="nidcadimo" id="nidcadimo" value="<?php echo $nidcadimo?>">

			<?php
           		$this->load->view('general/messages');
            ?>

			<h4><?php echo $cadimo->ctitulo ?></h4>

			<div class="row">
				<div class="col-xs-12 col-sm-6 lista-grupos">
					<div>

					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active"><a href="#grupos" aria-controls="grupos" role="tab" data-toggle="tab">Grupos</a></li>
					    <li role="presentation"><a href="#lista" aria-controls="lista" role="tab" data-toggle="tab">Lista</a></li>
					  </ul>

					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="grupos">

							<!-- START panel-->
							<h3>Grupos de bens</h3>
							<div class="container-grupos">
							<?php
							$i = 1;
							foreach ($grupos as $grupo):
							if ($i == 1):
								?>
								<div class="row">
								<?php
							endif;

							if ($grupo->cnomegrb == "Avulsos"){
								$cor_avulsos = $grupo->ccor;
							}

							?>
							<div class="col-xs-12 col-sm-6">
								<div class="panel panel-default grupo-bens" data-grupo="<?php echo $grupo->nidtbxgrb?>" style="background-color: <?php echo $grupo->ccor?>">
								 <div class="panel-body">
								 	<h4><?php echo $grupo->cnomegrb?> <a href="#" class="open-bens"><i class="fa fa-plus-square"></i></a></h4>
								 	<ul>
								 	<?php
								 		$bens = Bem_model::getByGrupo($grupo->nidtbxgrb);
								 		foreach ($bens as $bem){
								 			?>
								 				<li data-bem="<?php echo $bem->nidtbxbem?>" data-quantidade="<?php echo $bem->quantidade?>"><?php echo $bem->cnomebem?></li>
								 			<?php
								 		}
								 	?>
								 	</ul>
								 </div>
								</div>
							</div>
							<?php
							if ($i == 2):
								?>
								</div>
								<?php
								$i = 1;
							else:
								$i++;
							endif;
							endforeach;
							if ($i!=1):
								?>
								</div>
							<?php
							endif;
							?>
							</div>

					    </div>
					    <div role="tabpanel" class="tab-pane" id="lista">
					    	<div class="form-group">
					    		<label for="inputNomeBem">Buscar bem:</label>
					    		<input type="text" name="nome_bem" id="inputNomeBem" class="form-control input-sm">
					    	</div>
					    	<div class="form-group">
						    	<ul class="lista-bens-alfabetica">
						    	<?php
						    		foreach ($bens_alfabetica as $bem):
						    			?>
						    				<li data-bem="<?php echo $bem->nidtbxbem?>" data-quantidade="1" data-nome="<?php echo strtoupper($bem->cnomebem)?>"><?php echo $bem->cnomebem?></li>
						    			<?php
						    		endforeach;
						    	?>
						    	</ul>
					    	</div>
					    	<div class="form-group">
					    		<div class="row">
					    			<div class="col-xs-12 col-sm-6">
					    				<input type="text" name="nome_bem" id="inputAdicionarNomeBem" class="form-control input-sm">
					    			</div>
					    			<div class="col-xs-12 col-sm-3">
					    				<button type="button" class="btn btn-xs btn-warning adicionar-bem">Adicionar bem</button>
					    			</div>
					    		</div>
					    	</div>
					    </div>
					  </div>

					</div>
				</div>
				<div class="hidden-xs col-xs-12 col-sm-1 text-center">
					<i class="fa fa-3 fa-chevron-right seta-bens"></i>
				</div>
				<div class="col-xs-12 col-sm-5">
					<!-- START panel-->
					<h3>Itens do Imóvel</h3>
					<div class="panel panel-info">
					 <div class="panel-heading">Arraste para cá os Itens que deseja adicionar ao Imóvel</div>
					 <div class="panel-body bens-imovel">
					 	<?php
					 	foreach ($bens_imovel as $gbi=>$dados):
					 	$grupo = $dados['id'];
					 	if (!$grupo || $grupo == 0):
					 		$avulsos = $dados;
					 		continue;
					 	endif;
					 	?>
					 	<div class="panel panel-default grupo-bens" data-grupo="<?php echo $grupo?>" style="background-color: <?php echo $dados['cor']?>">
						 <div class="panel-body">
						 	<h4><?php echo $dados['nome']?> <a href="#" class="open-bens"><i class="fa fa-plus-square"></i></a></h4>
						 	<ul>
						 	<?php
						 		foreach ($dados['bens'] as $bem){
						 			?>
						 				<li data-bem="<?php echo $bem['id']?>" data-quantidade="<?php echo $bem['quantidade']?>" data-info="<?php echo implode("|", $bem['informacoes'])?>">
						 					<?php echo $bem['nome']?>
						 				</li>
						 			<?php
						 		}
						 	?>
						 	</ul>
						 </div>
						</div>
						<?php
						endforeach;
						?>
					 	<div class="panel panel-default grupo-bens avulsos" data-grupo="0" style="background-color: <?php echo $cor_avulsos?>">
							 <div class="panel-body">
							 	<h4>Avulsos <a href="#" class="open-bens"><i class="fa fa-plus-square"></i></a></h4>
							 	<ul>
							 		<?php
							 			foreach ($avulsos as $avulso):
							 				?>
							 				<li data-bem="<?php echo $avulso['id']?>" data-quantidade="<?php echo $avulso['quantidade']?>" data-info="<?php echo implode("|", $avulso['informacoes'])?>"><?php echo $avulso['nome']?></li>
							 				<?php
							 			endforeach;
							 		?>
							 	</ul>
							 </div>
						</div>
					 </div>
					</div>
				</div>
			</div>

		</div>
	</div>
 </div>