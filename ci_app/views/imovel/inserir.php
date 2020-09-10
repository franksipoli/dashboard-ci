 <!-- Page content-->
 <div class="content-wrapper">
    <h3><?php echo $title?></h3>
    <?php
    	if (isset($cadimo)):
    		?>
    			<a href="<?php echo makeUrl("cadimo/imovel", "listar")?>" class="btn btn-sm btn-primary">Voltar</a>
    			<br/><br/>
    		<?php
    	endif;
    ?>
    <div class="panel panel-default">
       <div class="panel-body">
          <form id="form-cadastro-imovel" action="#">
             <div>
                <h4>Dados Básicos </h4>
                <fieldset>
                	<div class="step-content">
                   		<div class="row">
                   			<div class="col-xs-12 col-sm-6">
                   				<div class="form-group">
                   					<div class="row">
				                   		<label for="entidade" class="col-xs-12 col-sm-4 text-right">Entidade<?php echo in_array("entidade", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<select name="nidtbxent" id="nidtbxent" class="form-control<?php echo in_array("entidade", $requiredfields) ? " required" : ""?>">
												<?php
													foreach ($ent as $item):
														?>
															<option value="<?php echo $item->nidtbxent?>"<?php echo isset($cadimo) && $cadimo->nidtbxent == $item->nidtbxent ? " selected=\"selected\"" : "" ?>>
																<?php
																if ($item->nidcadgrl):
																	echo Cadastro_model::getById($item->nidcadgrl)->cnomegrl;
																elseif ($item->nidcadjur):
																	echo Pessoajuridica_model::getById($item->nidcadjur)->cnomefant;
																endif;
																?>
															</option>
														<?php
													endforeach;
												?>	                   				
				                   			</select>
				                   		</div>
				                   	</div>
				                </div>
		                   	</div>
		                   	<div class="col-xs-12 col-sm-6">
		                   		<div class="form-group">
		                   			<div class="row">
				                   		<label for="nidtbxfin" class="col-xs-12 col-sm-3 col-md-2 text-right">Finalidade<?php echo in_array("finalidade", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-9 col-md-10">
				                   			<select name="nidtbxfin" id="nidtbxfin" data-jtoggle="finalidade" class="form-control<?php echo in_array("finalidade", $requiredfields) ? " required" : ""?>">
												<?php
													$array_finalidades = array();
													foreach ($fin as $item):
														$array_finalidades[] = $item->nidtbxfin;
														?>
															<option value="<?php echo $item->nidtbxfin?>"<?php echo isset($cadimo) && $cadimo->nidtbxfin == $item->nidtbxfin ? " selected=\"selected\"" : "" ?>><?php echo $item->cnomefin?></option>
														<?php
													endforeach;
												?>	                   				
				                   			</select>
				                   		</div>
			                   		</div>
				                </div>
		                   	</div>
                   		</div>
	                  	<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
			           			<div class="form-group">
			                   		<div class="row">
				                   		<label for="nidtbxtpi" class="col-xs-12 col-sm-4 text-right">Tipo do Produto<?php echo in_array("tipo_imovel", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<select name="nidtbxtpi" id="nidtbxtpi" class="form-control<?php echo in_array("tipo_imovel", $requiredfields) ? " required" : ""?>">
												<option value=""></option>
												<?php
													foreach ($tpi as $item):
														?>
															<option value="<?php echo $item->nidtbxtpi?>"<?php echo isset($cadimo) && $cadimo->nidtbxtpi == $item->nidtbxtpi ? " selected=\"selected\"" : "" ?>><?php echo $item->cnometpi?></option>
														<?php
													endforeach;
												?>	                   				
				                   			</select>
				                   		</div>
			                   		</div>
			                  	</div>       
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
	                  	 		<div class="form-group">
	                  	 			<div class="row">
										<label for="status" class="col-xs-12 col-sm-3 col-md-2 text-right">Status<?php echo in_array("status_imovel", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-9 col-md-10">
				                   			<select name="nidtbxsti" id="nidtbxsti" class="form-control<?php echo in_array("status_imovel", $requiredfields) ? " required" : ""?>">
				                   			</select>
				                   		</div>
				                   	</div>
			                  	</div>
	                  	 	</div>
	                  	</div>
	                  	<div class="form-group" style="display: none;" id="listaTiposSecundarios">
		                  	<div class="row">
								<div class="col-xs-12 col-sm-6">
				           			<div class="form-group">
				                   		<div class="row">
					                   		<label for="nidtbxtpi" class="col-xs-12 col-sm-4 text-right">Tipos secundários</label>
					                   		<div class="col-xs-12 col-sm-8" id="lista">
					                   		</div>
				                   		</div>
				                  	</div>       
		                  	 	</div>
		                  	</div>
	                  	</div>
                		<div class="form-group">
	                   		<div class="row">
		                   		<label for="titulo" class="col-xs-12 col-sm-3 col-md-2 text-right">Título<?php echo in_array("titulo", $requiredfields) ? " (*)" : ""?></label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input id="titulo" name="titulo"<?php echo isset($cadimo) ? " value=\"".$cadimo->ctitulo."\"" : ""?> type="text" class="form-control<?php echo in_array("titulo", $requiredfields) ? " required" : ""?>">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="referencia" class="col-xs-12 col-sm-3 col-md-2 text-right">Referência</label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input id="referencia" readonly="readonly" name="referencia" value="<?php echo isset($cadimo) ? $cadimo->creferencia : $referencia?>" type="text" class="form-control<?php echo in_array("referencia", $requiredfields) ? " required" : ""?>">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
		           			  	<div class="form-group">
			                   		<div class="row">
				                   		<label for="data_inicio_contrato" class="col-xs-12 col-sm-4 text-right">Período do contrato<?php echo in_array("periodo_contrato", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-3">
				                   			<input id="data_inicio_contrato" name="data_inicio_contrato"<?php echo isset($cadimo) ? " value=\"".(!empty($cadimo->dtdatainicial_contrato) ? toUserDate($cadimo->dtdatainicial_contrato) : "")."\"" : ""?> type="text" class="form-control<?php echo in_array("periodo_contrato", $requiredfields) ? " required" : ""?>" data-jmask="date">
				                   		</div>
				                   		<div class="col-xs-12 col-sm-1 text-center">
				                   			<label for="data_fim_contrato">até</label>
				                   		</div>
				                   		<div class="col-xs-12 col-sm-3">
				                   			<input id="data_fim_contrato" name="data_fim_contrato"<?php echo isset($cadimo) ? " value=\"".(!empty($cadimo->dtdatafinal_contrato) ? toUserDate($cadimo->dtdatafinal_contrato) : "")."\"" : ""?> type="text" class="form-control<?php echo in_array("periodo_contrato", $requiredfields) ? " required" : ""?>" data-jmask="date">
				                   		</div>
			                   		</div>
			                  	</div>      
	                  	 	</div>
	                  	</div>
	                  	<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
		           			  	<div class="form-group">
			                   		<div class="row">
				                   		<div class="col-xs-12 col-sm-3 col-sm-offset-4">
				                   			<input id="dias_somar" name="dias_somar" class="form-control" data-jmask="integer">
				                   		</div>
				                   		<div class="col-xs-12 col-sm-2 text-center">
				                   			<button type="button" class="btn btn-sm btn-info" id="inputSomarData">Somar dias úteis</button>
				                   		</div>
			                   		</div>
			                  	</div>      
	                  	 	</div>
	                  	</div>
	                  	<!--
	                  	<div class="form-group" data-finalidade="<?php //echo Parametro_model::get("finalidade_venda_id")?>">
	                   		<div class="row">
		                   		<label for="construtora" class="col-xs-12 col-sm-3 col-md-2 text-right">Construtora<?php //echo in_array("construtora", $requiredfields) ? " (*)" : ""?></label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input id="construtora" name="construtora"<?php //echo isset($cadimo) ? " value=\"".$cadimo->cconstrutora."\"" : ""?> type="text" class="form-control<?php //echo in_array("construtora", $requiredfields) ? " required" : ""?>">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div data-finalidade="<?php //echo Parametro_model::get("finalidade_venda_id")?>">
		                  	<div class="row">
		                  	 	<div class="col-xs-12 col-sm-6">
			           			  	<div class="form-group">
				                   		<div class="row">
					                   		<label for="ano_construcao" class="col-xs-12 col-sm-4 text-right">Ano de construção<?php //echo in_array("ano_construcao", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="ano_construcao" name="ano_construcao"<?php //echo isset($cadimo) ? " value=\"".$cadimo->nanocons."\"" : ""?> type="text" class="form-control<?php //echo in_array("ano_construcao", $requiredfields) ? " required" : ""?>" data-jmask="ano">
					                   		</div>
				                   		</div>
				                  	</div>      
		                  	 	</div>
		                  	 	<div class="col-xs-12 col-sm-6">
		                  	 		<div class="form-group">
				                   		<div class="row">
					                   		<label for="nidtbxtsc" class="col-xs-12 col-sm-4 text-right">Status da Construção<?php //echo in_array("status_construcao", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select name="nidtbxtsc" id="nidtbxtsc" class="form-control<?php //echo in_array("status_construcao", $requiredfields) ? " required" : ""?>">
													<option value=""></option>
													<?php
														//foreach ($tsc as $item):
															?>
																<option value="<?php //echo $item->nidtbxtsc?>"<?php //echo isset($cadimo) && $cadimo->nidtbxtsc == $item->nidtbxtsc ? " selected=\"selected\"" : "" ?>><?php //echo $item->cnometsc?></option>
															<?php
														//endforeach;
													?>	                   				
					                   			</select>
					                   		</div>
				                   		</div>
				                  	</div>
		                  	 	</div>
		                  	</div>
	                  	</div>
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="condominio" class="col-xs-12 col-sm-3 col-md-2 text-right">Condomínio<?php //echo in_array("condominio", $requiredfields) ? " (*)" : ""?></label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input id="condominio" name="condominio"<?php //echo isset($cadimo) ? " value=\"".$cadimo->ccondominio."\"" : ""?> type="text" class="form-control<?php //echo in_array("condominio", $requiredfields) ? " required" : ""?>">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<?php
	                  	//if (!isset($cadimo)):
	                  	?>
	                  	<div class="form-group" data-finalidade="<?php //echo Parametro_model::get("finalidade_venda_id")?>">
	                  		<div class="row">
	                  			<label for="nunidades" class="col-xs-12 col-sm-3 col-md-2 text-right">Unidades<?php //echo in_array("unidades", $requiredfields) ? " (*)" : ""?></label>
	                  			<div class="col-xs-12 col-sm-3 col-md-4">
	                  				<select id="nunidades" name="unidades" class="form-control<?php //echo in_array("unidades", $requiredfields) ? 'required' : ''?>">
	                  					<?php
	                  					//for ($i=1;$i<=99;$i++):
		                  					?>
		                  						<option value="<?php //echo $i?>"<?php //echo isset($cadimo) && $cadimo->nunidades == $i ? ' selected="selected"' : ''?>><?php //echo $i?></option>
		                  					<?php
	                  					//endfor;
	                  					?>
	                  				</select>
	                  			</div>
	                  		</div>
	                  	</div>
	                  	<?php
	                  	//endif;
	                  	?>
						-->
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="descricao" class="col-xs-12 col-sm-3 col-md-2 text-right">Descrição<?php echo in_array("descricao", $requiredfields) ? " (*)" : ""?></label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<textarea id="descricao" name="descricao" rows="5" class="form-control<?php echo in_array("descricao", $requiredfields) ? " required" : ""?>"><?php echo isset($cadimo) ? $cadimo->tdescricao : ""?></textarea>
		                   		</div>
	                   		</div>
	                  	</div>
						<div class="form-group" style="display: none;" data-caracteristicas="<?php echo isset($caracteristicas) && is_array($caracteristicas) ? implode($caracteristicas, "|") : ""?>" id="listaCaracteristicas">
		                  	<div class="row">
								<div class="col-xs-12 col-sm-6">
				           			<div class="form-group">
				                   		<div class="row">
					                   		<label for="nidtbxtpi" class="col-xs-12 col-sm-4 text-right">Características<?php echo in_array("caracteristicas", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8" id="lista">
					                   		</div>
				                   		</div>
				                  	</div>       
		                  	 	</div>
		                  	</div>
	                  	</div>
	                  	<h3>Parceiros</h3>
	                  	<?php
	                  		if (!isset($cadimo) || count($proprietarios) == 0):
	                  	?>
              			<div class="proprietario" data-id="0">
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="nomecpfproprietario" class="col-xs-12 col-sm-4 text-right">Nome/CPF<?php echo in_array("nome_proprietario", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="nomecpfproprietario" name="nomecpfproprietario[]" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-nomecpf form-control<?php echo in_array("nome_proprietario", $requiredfields) ? " required" : ""?>">
					                   			<input name="idcpfproprietario[]" class="idcpfproprietario" value="0" type="hidden">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="percentualproprietario" class="col-xs-12 col-sm-4 text-right">%<?php echo in_array("percentual_proprietario", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="percentualproprietario" name="percentualproprietario[]" type="text" data-jmask="percent" class="form-control<?php echo in_array("percentual_proprietario", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div>    
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<button type="button" class="remover-proprietario btn btn-labeled btn-danger pull-right">
											<span class="btn-label"><i class="fa fa-times"></i></span>Remover este parceiro
										</button>
									</div>
								</div>
							</div>
	                  	</div>
	                  	<?php
	                  		else:
	                  			$i = 0;
	                  			foreach ($proprietarios as $proprietario):
	                  				if ( $i>0 ):
	                  					?>
	                  					<hr />
	                  					<?php
	                  				endif;
	                  				?>
				              			<div class="proprietario" data-id="<?php echo $i?>">
						                  	<div class="row">
						                  		<div class="col-xs-12 col-sm-6">
								                   <div class="form-group">
								                   		<div class="row">
									                   		<label for="nomecpfproprietario" class="col-xs-12 col-sm-4 text-right">Nome/CPF<?php echo in_array("nome_proprietario", $requiredfields) ? " (*)" : ""?></label>
									                   		<div class="col-xs-12 col-sm-8">
									                   			<input id="nomecpfproprietario" value="<?php echo $proprietario['cadgrl']->cnomegrl?>" name="nomecpfproprietario[]" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-nomecpf form-control<?php echo in_array("nome_proprietario", $requiredfields) ? " required" : ""?>" readonly="readonly">
									                   			<a href="#" class="resetarAutocomplete btn btn-danger btn-xs">[X]</a>
									                   			<input name="idcpfproprietario[]" class="idcpfproprietario" value="<?php echo $proprietario['cadgrl']->nidcadgrl?>" type="hidden">
									                   		</div>
								                   		</div>
								                   </div>	                  			
						                  		</div>
						                  		<div class="col-xs-12 col-sm-6">
								                   <div class="form-group">
								                   		<div class="row">
									                   		<label for="percentualproprietario" class="col-xs-12 col-sm-4 text-right">%<?php echo in_array("percentual_proprietario", $requiredfields) ? " (*)" : ""?></label>
									                   		<div class="col-xs-12 col-sm-8">
									                   			<input id="percentualproprietario" value="<?php echo $proprietario['ipr']->npercentual?>" name="percentualproprietario[]" type="text" data-jmask="percent" class="form-control<?php echo in_array("percentual_proprietario", $requiredfields) ? " required" : ""?>">
									                   		</div>
								                   		</div>
								                   </div>	                  			
						                  		</div>
						                  	</div>    
											<div class="row">
												<div class="col-xs-12">
													<div class="form-group">
														<button type="button" class="remover-proprietario btn btn-labeled btn-danger pull-right">
															<span class="btn-label"><i class="fa fa-times"></i></span>Remover este Parceiro
														</button>
													</div>
												</div>
											</div>
					                  	</div>	            
	                  				<?php
	                  				$i++;
	                  			endforeach;
	                  		endif;
	                  	?>
	                  	<div class="row">
	                  		<div class="col-xs-12">
	                  			<button type="button" class="adicionar-proprietario mb-sm btn btn-warning">Adicionar mais um Parceiro</button>
	                  		</div>
	                  	</div>
	                  	<h3>Indicadores</h3>
	                  	<?php
	                  		if (!isset($cadimo) || count($angariadores) == 0):
	                  	?>
              			<div class="angariador" data-id="0">
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="nomeangariador" class="col-xs-12 col-sm-4 text-right">Nome<?php echo in_array("nome_angariador", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="nomeangariador" name="nomeangariador[]" type="text" data-action="<?php echo makeUrl("seg", "usuario", "buscarAjaxNome")?>" class="autocomplete-nome form-control<?php echo in_array("nome_angariador", $requiredfields) ? " required" : ""?>">
					                   			<input name="idangariador[]" class="idangariador" value="0" type="hidden">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="percentualangariador" class="col-xs-12 col-sm-4 text-right">%<?php echo in_array("percentual_angariador", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="percentualangariador" name="percentualangariador[]" type="text" data-jmask="percent" class="form-control<?php echo in_array("percentual_angariador", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div>  
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<button type="button" class="remover-angariador btn btn-labeled btn-danger pull-right">
											<span class="btn-label"><i class="fa fa-times"></i></span>Remover este indicador
										</button>
									</div>
								</div>
							</div>    			
	                  	</div>
	                  	<?php
	                  		else:
	                  			$i = 0;
	                  			foreach ($angariadores as $angariador):
	                  				if ( $i>0 ):
	                  					?>
	                  					<hr />
	                  					<?php
	                  				endif;
	                  				?>
				              			<div class="angariador" data-id="<?php echo $i?>">
						                  	<div class="row">
						                  		<div class="col-xs-12 col-sm-6">
								                   <div class="form-group">
								                   		<div class="row">
									                   		<label for="nomeangariador" class="col-xs-12 col-sm-4 text-right">Nome<?php echo in_array("nome_angariador", $requiredfields) ? " (*)" : ""?></label>
									                   		<div class="col-xs-12 col-sm-8">
									                   			<input id="nomeangariador" value="<?php echo $angariador['segusu']->cnome?>" name="nomeangariador[]" type="text" data-action="<?php echo makeUrl("seg", "usuario", "buscarAjaxNome")?>" class="autocomplete-nome form-control<?php echo in_array("nome_angariador", $requiredfields) ? " required" : ""?>" readonly="readonly">
									                   			<a href="#" class="resetarAutocompleteAngariador btn btn-danger btn-xs">[X]</a>
									                   			<input name="idangariador[]" class="idangariador" value="<?php echo $angariador['segusu']->nidtbxsegusu?>" type="hidden">
									                   		</div>
								                   		</div>
								                   </div>	                  			
						                  		</div>
						                  		<div class="col-xs-12 col-sm-6">
								                   <div class="form-group">
								                   		<div class="row">
									                   		<label for="percentualangariador" class="col-xs-12 col-sm-4 text-right">%<?php echo in_array("percentual_angariador", $requiredfields) ? " (*)" : ""?></label>
									                   		<div class="col-xs-12 col-sm-8">
									                   			<input id="percentualangariador" value="<?php echo $angariador['ang']->npercentual?>" name="percentualangariador[]" type="text" data-jmask="percent" class="form-control<?php echo in_array("percentual_angariador", $requiredfields) ? " required" : ""?>">
									                   		</div>
								                   		</div>
								                   </div>	                  			
						                  		</div>
						                  	</div>   
											<div class="row">
												<div class="col-xs-12">
													<div class="form-group">
														<button type="button" class="remover-angariador btn btn-labeled btn-danger pull-right">
															<span class="btn-label"><i class="fa fa-times"></i></span>Remover este indicador
														</button>
													</div>
												</div>
											</div>
					                  	</div>
	                  				<?php
	                  				$i++;
	                  			endforeach;
	                  		endif;
	                  	?>
	                  	<div class="row">
	                  		<div class="col-xs-12">
	                  			<button type="button" class="adicionar-angariador mb-sm btn btn-warning">Adicionar mais um indicador</button>
	                  		</div>
	                  	</div>
                  	</div>                			
                </fieldset>
                <h4>Valores e Dados Gerais</h4>
                <fieldset>
                	<div class="step-content">
						<?php
						foreach ($array_finalidades as $fin):
						?>
                		<div data-finalidade="<?php echo $fin?>">
							<?php
								foreach ($fva as $item):
									if ($item['nidtbxfin'] != $fin)
										continue;
									$nidtagfva = $item['nidtagfva'];
									?>
				                  	<div class="row">
				                  	 	<div class="col-xs-12 col-sm-6">
						           			<div class="form-group">
						                   		<div class="row">
							                   		<label for="nidtbxtpi" class="col-xs-12 col-sm-4 col-md-3 text-right">Valor (<?php echo $item['cnometpv']?>)</label>
							                   		<div class="col-xs-12 col-sm-8 col-md-9">
							                   			<input id="valor" data-jmask="dinheiro" value="<?php echo $valores[$nidtagfva]?>" name="valor[<?php echo $item['nidtagfva']?>]" type="text"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "f" ? " value=\"".$cadgrl->cnomegrl."\"" : ""?> class="form-control<?php echo in_array("nomecompleto", $requiredfields) ? " required" : ""?>">
							                   		</div>
						                   		</div>
						                  	</div>       
				                  	 	</div>
				                  	</div>
			                  		<?php
		                  		endforeach;
	                  		?>
                		</div><!-- LOCAÇÃO TEMPORADA -->
						<?php
						endforeach;
						?>
						<?php
							if (is_array($comissoes_padrao)):
								foreach ($comissoes_padrao as $finalidade=>$valor):
									foreach ($valor as $tipo=>$padrao):
										?>
										<input type="hidden" class="valor_padrao_comissao" data-finalidade-id="<?php echo $finalidade?>" data-tipo="<?php echo $tipo?>" value="<?php echo $padrao?>">
										<?php
									endforeach;
								endforeach;
							endif;
							foreach ($tcm as $item):
								?>
			                  	<div class="row">
			                  	 	<div class="col-xs-12 col-sm-6">
					           			<div class="form-group">
					                   		<div class="row">
						                   		<label for="nidtbxtpi" class="col-xs-12 col-sm-4 col-md-3 text-right">Comissão (<?php echo $item->cdescritcm?>)</label>
						                   		<div class="col-xs-12 col-sm-8 col-md-9">
						                   			<input id="comissao" data-tipo-comissao="<?php echo $item->nidtbxtcm?>" data-jmask="number" name="comissao[<?php echo $item->nidtbxtcm?>]" type="text" value="<?php echo isset($comissoes) ? $comissoes[$item->nidtbxtcm] : ''?>" class="form-control-comissao form-control<?php echo in_array("valor_comissao", $requiredfields) ? " required" : ""?>">
						                   		</div>
					                   		</div>
					                  	</div>       
			                  	 	</div>
			                  	</div>
		                  		<?php
	                  		endforeach;
                  		?>
						<div class="row">
							<div class="col-xs-12 col-sm-6">
			                  	<div class="form-group" data-finalidade="<?php echo Parametro_model::get("finalidade_locacao_id")?>">
			                   		<div class="row">
				                   		<label for="taxa_administrativa" class="col-xs-12 col-sm-4 col-md-3 text-right">Taxa administrativa</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="taxa_administrativa" name="taxa_administrativa"<?php echo isset($cadimo) ? " value=\"".$cadimo->ntaxaadm."\"" : ""?> type="text" data-jmask="dinheiro" class="form-control<?php echo in_array("taxa_administrativa", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>
			                </div>
			            </div>
			            <!--
						<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
								<div class="form-group">
			                   		<div class="row">
				                   		<label for="area_construida" class="col-xs-12 col-sm-4 col-md-3 text-right">Área Construída</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="area_construida" data-jmask="number" name="area_construida"<?php //echo isset($cadimo) ? " value=\"".str_replace(".","",$cadimo->nareacons)."\"" : ""?> type="text" class="form-control<?php //echo in_array("area_construida", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>       
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
	                  	 		<div class="form-group">
			                   		<div class="row">
				                   		<label for="area_averbada" class="col-xs-12 col-sm-4 col-md-3 text-right">Área Averbada</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="area_averbada" data-jmask="number" name="area_averbada"<?php //echo isset($cadimo) ? " value=\"".$cadimo->nareaaverbada."\"" : ""?> type="text" class="form-control<?php //echo in_array("area_averbada", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>
	                  	 	</div>
	                  	</div>
						<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
								<div class="form-group">
			                   		<div class="row">
				                   		<label for="area_terreno" class="col-xs-12 col-sm-4 col-md-3 text-right">Área do Terreno</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="area_terreno" data-jmask="number" name="area_terreno"<?php //echo isset($cadimo) ? " value=\"".$cadimo->nareaterreno."\"" : ""?> type="text" class="form-control<?php //echo in_array("area_terreno", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>      
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
	                  	 		<div class="form-group">
			                   		<div class="row">
				                   		<label for="area_util" class="col-xs-12 col-sm-4 col-md-3 text-right">Área Útil</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="area_util" data-jmask="number" name="area_util"<?php //echo isset($cadimo) ? " value=\"".$cadimo->nareautil."\"" : ""?> type="text" class="form-control<?php //echo in_array("area_util", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>
	                  	 	</div>
	                  	</div>
						<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
								<div class="form-group">
			                   		<div class="row">
				                   		<label for="area_terreno" class="col-xs-12 col-sm-4 col-md-3 text-right">Área Privativa</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="area_privativa" data-jmask="number" name="area_privativa"<?php //echo isset($cadimo) ? " value=\"".$cadimo->nareapriv."\"" : ""?> type="text" class="form-control<?php //echo in_array("area_privativa", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>      
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
	                  	 		<div class="form-group">
			                   		<div class="row">
				                   		<label for="area_comercial" class="col-xs-12 col-sm-4 col-md-3 text-right">Área Comercial</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="area_comercial" data-jmask="number" name="area_comercial"<?php //echo isset($cadimo) ? " value=\"".$cadimo->nareacom."\"" : ""?> type="text" class="form-control<?php //echo in_array("area_comercial", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>
	                  	 	</div>
	                  	</div>
						<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
								<div class="form-group">
			                   		<div class="row">
				                   		<label for="quartos" class="col-xs-12 col-sm-4 col-md-3 text-right">Número de Quartos</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="quartos" data-jmask="number" name="quartos"<?php //echo isset($cadimo) ? " value=\"".$cadimo->nquartos."\"" : ""?> type="text" class="form-control<?php //echo in_array("quartos", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>     
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
			                  	<div class="form-group">
			                   		<div class="row">
				                   		<label for="suites" class="col-xs-12 col-sm-4 col-md-3 text-right">Número de Suítes</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="suites" data-jmask="number" name="suites"<?php //echo isset($cadimo) ? " value=\"".$cadimo->nsuites."\"" : ""?> type="text" class="form-control<?php //echo in_array("suites", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>
	                  	 	</div>
	                  	</div>	    
	                  	<div class="row" data-finalidade="<?php //echo Parametro_model::get("finalidade_locacao_id")?>">
	                  	 	<div class="col-xs-12 col-sm-6">
								<div class="form-group">
			                   		<div class="row">
				                   		<label for="acomodacoes" class="col-xs-12 col-sm-4 col-md-3 text-right">Número de Acomodações</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="acomodacoes" data-jmask="number" name="acomodacoes"<?php //echo isset($cadimo) ? " value=\"".$cadimo->nacomodacoes."\"" : ""?> type="text" class="form-control<?php //echo in_array("acomodacoes", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>     
	                  	 	</div>
	                  	</div>              	
                  	</div> 
                </fieldset>
            	-->
                <h4>Dados gerais</h4>
                <fieldset>
                	<div class="step-content">
	                  	<div class="form-group" data-finalidade="<?php echo Parametro_model::get("finalidade_venda_id")?>">
	                  		<h3>Permuta</h3>
	                   		<div class="row">
								<div class="col-xs-12">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="aceita_permuta" id="aceitaPermuta" value="1"<?php echo isset($cadimo) && $cadimo->npermuta ? ' checked="checked"' : ''?>>
											Aceita permuta
										</label>
									</div>
								</div>
	                   		</div>
	                   		<div class="row" id="listaTipoPermuta" style="display: none;">
								<div class="col-xs-12">
									<?php
										foreach ($tpp as $item):
											?>
												<div class="checkbox">
													<label>
														<input type="checkbox" name="nidtbxtpp[]" value="<?php echo $item->nidtbxtpp?>" class="nidtbxtpp"<?php echo isset($permutas) && isset($permutas[$item->nidtbxtpp]) ? ' checked="checked"' : ''?>>
														<?php echo $item->cnometpp?>
														<input type="text" name="cdescriipe[<?php echo $item->nidtbxtpp?>]" class="form-control" readonly="readonly" value="<?php echo isset($permutas) && isset($permutas[$item->nidtbxtpp]) ? $permutas[$item->nidtbxtpp] : ''?>">
													</label>
												</div>
											<?php
										endforeach;
									?>
								</div>
	                   		</div>
	                  	</div>
	                  	<div class="form-group" data-finalidade="<?php echo Parametro_model::get("finalidade_venda_id")?>">
	                   		<div class="row">
		                  	 	<div class="col-xs-12 col-sm-6">
									<div class="form-group">
				                   		<div class="row">
					                   		<label for="matricula" class="col-xs-12 col-sm-4 col-md-3 text-right">Matrícula</label>
					                   		<div class="col-xs-12 col-sm-8 col-md-9">
					                   			<input id="matricula" name="matricula"<?php echo isset($cadimo) ? " value=\"".$cadimo->cmatricula."\"" : ""?> type="text" class="form-control<?php echo in_array("matricula", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                  	</div>     
		                  	 	</div>
		                  	 	<!--
		                  	 	<div class="col-xs-12 col-sm-6">
									<div class="form-group">
				                   		<div class="row">
					                   		<label for="lote" class="col-xs-12 col-sm-4 col-md-3 text-right">Lote</label>
					                   		<div class="col-xs-12 col-sm-8 col-md-9">
					                   			<input id="lote" name="lote"<?php //echo isset($cadimo) ? " value=\"".$cadimo->clote."\"" : ""?> type="text" class="form-control<?php //echo in_array("lote", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                  	</div>     
		                  	 	</div>
		                  	 	-->
		                  	</div>
		                  	<!--
		                  	<div class="row">
		                  	 	<div class="col-xs-12 col-sm-6">
									<div class="form-group">
				                   		<div class="row">
					                   		<label for="quadra" class="col-xs-12 col-sm-4 col-md-3 text-right">Quadra</label>
					                   		<div class="col-xs-12 col-sm-8 col-md-9">
					                   			<input id="quadra" name="quadra"<?php //echo isset($cadimo) ? " value=\"".$cadimo->cquadra."\"" : ""?> type="text" class="form-control<?php //echo in_array("quadra", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                  	</div>     
		                  	 	</div>
		                  	 	<div class="col-xs-12 col-sm-6">
									<div class="form-group">
				                   		<div class="row">
					                   		<label for="planta" class="col-xs-12 col-sm-4 col-md-3 text-right">Planta</label>
					                   		<div class="col-xs-12 col-sm-8 col-md-9">
					                   			<input id="planta" name="planta"<?php //echo isset($cadimo) ? " value=\"".$cadimo->cplanta."\"" : ""?> type="text" class="form-control<?php //echo in_array("planta", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                  	</div>     
		                  	 	</div>
		                  	</div>
		                  	-->
	                  	</div>
	                  	<!--
	                  	<h3>Serviços</h3>
	                  	<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
								<div class="form-group">
			                   		<div class="row">
				                   		<label for="matricula_luz" class="col-xs-12 col-sm-4 col-md-3 text-right">Matrícula de luz</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="matricula_luz" name="matricula_luz"<?php //echo isset($cadimo) ? " value=\"".$cadimo->cmatluz."\"" : ""?> type="text" class="form-control<?php //echo in_array("matricula_luz", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>     
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
			                  	<div class="form-group">
			                   		<div class="row">
				                   		<label for="luz_ligada" class="col-xs-12 col-sm-4 col-md-3 text-right">Luz ligada</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<div class="checkbox">
												<label>
													<input type="checkbox" name="luz_ligada" value="1"<?php //echo isset($cadimo) && $cadimo->nluzligada == 1 ? " checked=\"checked\"" : ""?>>
												</label>
				                   			</div>
				                   		</div>
			                   		</div>
			                  	</div>
	                  	 	</div>
	                  	</div>
	                  	<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
								<div class="form-group">
			                   		<div class="row">
				                   		<label for="matricula_agua" class="col-xs-12 col-sm-4 col-md-3 text-right">Matrícula de água</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="matricula_agua" name="matricula_agua"<?php //echo isset($cadimo) ? " value=\"".$cadimo->cmatagua."\"" : ""?> type="text" class="form-control<?php //echo in_array("matricula_agua", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>     
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
			                  	<div class="form-group">
			                   		<div class="row">
				                   		<label for="agua_ligada" class="col-xs-12 col-sm-4 col-md-3 text-right">Água ligada</label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<div class="checkbox">
												<label>
													<input type="checkbox" name="agua_ligada" value="1"<?php //echo isset($cadimo) && $cadimo->nagualigada == 1 ? " checked=\"checked\"" : ""?>>
												</label>
				                   			</div>
				                   		</div>
			                   		</div>
			                  	</div>
	                  	 	</div>
	                  	</div>
						-->
						<h3>Observações</h3>
                		<?php
                		if (!isset($cadimo) || count($observacoes) == 0):
                		?>
              			<div class="observacao" data-id="0">
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="tipoobservacao" class="col-xs-12 col-sm-4 col-md-3 text-right">Tipo de Observação</label>
					                   		<div class="col-xs-12 col-sm-8 col-md-9">
					                   			<select id="tipoobservacao" name="tipoobservacao[]" class="form-control<?php echo in_array("tipo_observacao", $requiredfields) ? " required" : ""?>">
					                   				<option></option>
					                   				<?php
					                   					foreach ( $obs as $item ):
					                   						?>
					                   							<option value="<?php echo $item->nidtbxobs?>"><?php echo $item->cnomeobs?></option>
					                   						<?php
					                   					endforeach;
					                   				?>
					                   			</select>
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="observacao" class="col-xs-12 col-sm-4 text-right">Observação</label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<textarea id="observacao" name="observacao[]" rows="5" class="form-control<?php echo in_array("observacao", $requiredfields) ? " required" : ""?>"></textarea>
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div>  
	                  		<div class="row">
	                  			<div class="col-xs-12">
	                  				<div class="form-group">
	                  					<button type="button" class="remover-observacao btn btn-labeled btn-danger pull-right">
	                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover esta observação
	                  					</button>
	                  				</div>
	                  			</div>
	                  		</div>    			
	                  	</div>
	                  	<?php
	                  	else:
	                  		$i = 0;
	                  		foreach ($observacoes as $observacao):
	                  		?>
	                  			<?php
	                  			if ($i > 0):
	                  				?>
	                  					<hr/>
	                  				<?php
	                  			endif;
	                  			?>
	                  			<div class="observacao" data-id="<?php echo $i?>">
				                  	<div class="row">
				                  		<div class="col-xs-12 col-sm-6">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="tipoobservacao" class="col-xs-12 col-sm-4 col-md-3 text-right">Tipo de Observação</label>
							                   		<div class="col-xs-12 col-sm-8 col-md-9">
							                   			<select id="tipoobservacao" name="tipoobservacao[]" class="form-control<?php echo in_array("tipo_observacao", $requiredfields) ? " required" : ""?>">
							                   				<option></option>
							                   				<?php
							                   					foreach ( $obs as $item ):
							                   						?>
							                   							<option value="<?php echo $item->nidtbxobs?>"<?php echo $observacao['nidtbxobs'] == $item->nidtbxobs ? ' selected="selected"' : ''?>><?php echo $item->cnomeobs?></option>
							                   						<?php
							                   					endforeach;
							                   				?>
							                   			</select>
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
				                  		<div class="col-xs-12 col-sm-6">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="observacao" class="col-xs-12 col-sm-4 text-right">Observação</label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<textarea id="observacao" name="observacao[]" rows="5" class="form-control<?php echo in_array("observacao", $requiredfields) ? " required" : ""?>"><?php echo $observacao['observacao']?></textarea>
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
				                  	</div>  
			                  		<div class="row">
			                  			<div class="col-xs-12">
			                  				<div class="form-group">
			                  					<button type="button" class="remover-observacao btn btn-labeled btn-danger pull-right">
			                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover esta observação
			                  					</button>
			                  				</div>
			                  			</div>
			                  		</div>
			                  	</div>
	                  			<?php
	                  			$i++;
	                  		endforeach;
	                  	endif;
	                  	?>
	                  	<div class="row">
	                  		<div class="col-xs-12">
	                  			<button type="button" class="adicionar-observacao mb-sm btn btn-warning">Adicionar mais uma observação</button>
	                  		</div>
	                  	</div>

                	</div>
                </fieldset>
                
                <!-- Retirando ENdereços e Distancias do Cadastro de Imovel
                
                <h4>Endereço</h4>
                <?php
                //$endereco = $endereco[0];
                ?>
                <fieldset>
                	<div class="step-content">
	                	<div class="endereco">
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-8">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="endereco" class="col-xs-12 col-sm-3 text-right">Endereço</label>
					                   		<div class="col-xs-12 col-sm-9">
					                   			<div class="row">
					                   				<div class="col-xs-12 col-sm-4">
					                   					<select id="tipologradouro" name="nidtbxtpl[]" class="form-control">
							                   				<?php
							                   					//foreach ($tpl as $tipo):
							                   						?>
							                   							<option value="<?php //echo $tipo->nidtbxtpl?>"<?php //echo $tipo->nidtbxtpl == $endereco['nidtbxtpl'] ? ' selected="selected"' : ''?>><?php //echo $tipo->cnometpl?></option>
							                   						<?php
							                   					//endforeach;
							                   				?>
							                   			</select>
					                   				</div>
					                   				<div class="col-xs-12 col-sm-8">
					                   					<input id="endereco" value="<?php //echo $endereco['cdescrilog']?>" name="endereco[]" type="text" class="form-control<?php //echo in_array("endereco", $requiredfields) ? " required" : ""?>">
					                   				</div>
					                   			</div>
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-4">
		                  			<div class="form-group">
				                   		<div class="row">
					                   		<label for="numero" class="col-xs-12 col-sm-3 col-md-2 text-right">Número</label>
					                   		<div class="col-xs-12 col-sm-9 col-md-10">
					                   			<input id="numero" name="numero[]" value="<?php //echo $endereco['cnumero']?>" type="text" class="form-control<?php //echo in_array("numero", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                  	 </div>
		                  		</div>
		                  	</div>      			
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="complemento" class="col-xs-12 col-sm-4 text-right">Complemento</label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="complemento" name="complemento[]" value="<?php //echo $endereco['ccomplemento']?>" type="text" class="form-control<?php //echo in_array("complemento", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
		                  			<div class="form-group">
				                   		<div class="row">
					                   		<label for="bairro" class="col-xs-12 col-sm-3 col-md-2 text-right">Bairro</label>
					                   		<div class="col-xs-12 col-sm-9 col-md-10">
					                   			<input id="bairro" name="bairro[]" type="text" value="<?php //echo $endereco['cdescribai']?>" class="form-control<?php //echo in_array("bairro", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                  	 </div>
		                  		</div>
		                  	</div>  
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
		                  			<div class="form-group">
				                   		<div class="row">
					                   		<label for="uf" class="col-xs-12 col-sm-4 text-right">UF</label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select name="uf[]" class="form-control select-select2<?php //echo in_array("uf", $requiredfields) ? " required" : ""?>">
					                   				<?php
					                   					//foreach ($lista_uf as $key=>$value):
					                   						?>
					                   							<option value="<?php //echo $value->nidtbxuf?>"<?php //echo $endereco['nidtbxuf'] == $value->nidtbxuf ? ' selected="selected"' : ''?>><?php //echo Pais_model::getById($value->nidtbxpas)->cdescripas." - ".$value->csiglauf?></option>
					                   						<?php
					                   					//endforeach;
					                   				?>
					                   			</select>
					                   		</div>
				                   		</div>
				                  	 </div>
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="cidade" class="col-xs-12 col-sm-3 col-md-2 text-right">Cidade</label>
					                   		<div class="col-xs-12 col-sm-9 col-md-10">
					                   			<input name="cidade[]" type="text" value="<?php //echo $endereco['cdescriloc']?>" data-action="<?php //echo makeUrl("dep","uf","buscarAjaxLocalizacao")?>" class="autocomplete-cidade form-control<?php //echo in_array("cidade", $requiredfields) ? " required" : ""?>">
					                   			<input type="hidden" name="idcidade[]" value="<?php //echo $endereco['nidtbxloc']?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div>
		                	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="cep" class="col-xs-12 col-sm-4 text-right">CEP</label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="cep" name="cep[]" data-jmask="cep" value="<?php //echo $endereco['ccep_loc'] ? $endereco['ccep_loc'] : $endereco['ccep_log']?>" type="text" class="form-control<?php //echo in_array("cep", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
		                  			<div class="form-group">
		                  				<div class="row">
		                  					<label for="cep_pertence" class="col-xs-12 col-sm-3 col-md-2 text-right">CEP da cidade</label>
					                   		<div class="col-xs-12 col-sm-9 col-md-10">
					                   			<select id="cep_pertence" name="cep_cidade[]" class="form-control">
					                   				<option value="0" <?php //echo $endereco['ccep_log'] ? 'selected="selected"' : ''?>>Não</option>
					                   				<option value="1" <?php //echo !$endereco['ccep_log'] && $endereco['ccep_loc'] ? 'selected="selected"' : ''?>>Sim</option>
					                   			</select>
					                   		</div>
		                  				</div>
		                  			</div>
		                  		</div>
		                  	</div>
		                  	
		                  	

		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="latitude" class="col-xs-12 col-sm-4 text-right">Latitude</label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="latitude" name="latitude" type="text" value="<?php //echo $cadimo->clatitude?>" class="form-control<?php //echo in_array("latitude", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
		                  			<div class="form-group">
		                  				<div class="row">
		                  					<label for="longitude" class="col-xs-12 col-sm-3 col-md-2 text-right">Longitude</label>
					                   		<div class="col-xs-12 col-sm-9 col-md-10">
					                   			<input id="longitude" name="longitude" value="<?php //echo $cadimo->clongitude?>" type="text" class="form-control<?php //echo in_array("longitude", $requiredfields) ? " required" : ""?>">
					                   		</div>
		                  				</div>
		                  			</div>
		                  		</div>
		                  	</div>
		                  	<div class="row">
		                  		<div class="col-xs-12">
			                   		<div class="row">
				                   		<div class="col-xs-12 col-sm-2 col-sm-offset-2">
				                   			<div class="checkbox c-checkbox">
			                                    <label>
			                                       <input type="checkbox" name="publicar_endereco" value="1" checked="<?php //echo $imovel->npublicarendereco == 1 ? "checked" : ""?>">
			                                       <span class="fa fa-check"></span>Exibir endereço no site</label>
			                                 </div>
				                   		</div>
			                   		</div>
		                  		</div>
		                  	</div>
		                  	<div class="row">
		                  		<div class="col-xs-12">
			                   		<div class="row">
				                   		<div class="col-xs-12 col-sm-2 col-sm-offset-2">
				                   			<div class="checkbox c-checkbox">
			                                    <label>
			                                       <input type="checkbox" name="publicar_site" value="1" checked="<?php //echo $imovel->npublicarsite == 1 || !isset($imovel) ? "checked" : ""?>">
			                                       <span class="fa fa-check"></span>Publicar Imóvel no site</label>
			                                 </div>
				                   		</div>
			                   		</div>
		                  		</div>
		                  	</div>
		                  	<div class="row">
		                  		<div class="col-xs-12">
		                  			<div class="form-group text-center">
		                  				<button id="getLatitudeLongitudeMapa" type="button" class="btn btn-sm btn-info">Obter latitude e longitude no mapa</button>
		                  		</div>
		                  	</div>
	                  	</div>

	                  	

	                  	

						<h3>Distâncias</h3>
                		<?php
                		//if (!isset($cadimo) || count($distancias) == 0):
                		?>
              			<div class="distancia" data-id="0">
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="tipodistancia" class="col-xs-12 col-sm-4 text-right">Tipo de Distância</label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select id="tipodistancia" name="tipodistancia[]" class="form-control<?php //echo in_array("tipo_distancia", $requiredfields) ? " required" : ""?>">
					                   				<option></option>
					                   				<?php
					                   					//foreach ( $tpd as $item ):
					                   						?>
					                   							<option value="<?php //echo $item->nidtbxtpd?>"><?php //echo $item->cnometpd?></option>
					                   						<?php
					                   					//endforeach;
					                   				?>
					                   			</select>
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="tipomedidadistancia" class="col-xs-12 col-sm-4 text-right">Tipo de Medida</label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select id="tipomedidadistancia" name="tipomedidadistancia[]" class="form-control<?php //echo in_array("tipo_medida_distancia", $requiredfields) ? " required" : ""?>">
					                   				<option></option>
					                   				<?php
					                   					//foreach ( $tmd as $item ):
					                   						?>
					                   							<option value="<?php //echo $item->nidtbxtmd?>"><?php //echo $item->cnometmd?></option>
					                   						<?php
					                   					//endforeach;
					                   				?>
					                   			</select>
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div> 
							<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="distancia" class="col-xs-12 col-sm-4 text-right">Distância</label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="distancia" name="distancia[]" type="text" class="form-control<?php //echo in_array("distancia", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div>    
	                  		<div class="row">
	                  			<div class="col-xs-12">
	                  				<div class="form-group">
	                  					<button type="button" class="remover-distancia btn btn-labeled btn-danger pull-right">
	                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover esta distância
	                  					</button>
	                  				</div>
	                  			</div>
	                  		</div>  			
	                  	</div>
	                  	<?php
	                  	//else:
	                  		//$i = 0;
	                  		//foreach ($distancias as $distancia):
	                  		?>
	                  			<?php
	                  			//if ($i > 0):
	                  				?>
	                  					<hr/>
	                  				<?php
	                  			//endif;
	                  			?>
		              			<div class="distancia" data-id="<?php //echo $i?>">
				                  	<div class="row">
				                  		<div class="col-xs-12 col-sm-6">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="tipodistancia" class="col-xs-12 col-sm-4 text-right">Tipo de Distância</label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<select id="tipodistancia" name="tipodistancia[]" class="form-control<?php //echo in_array("tipo_distancia", $requiredfields) ? " required" : ""?>">
							                   				<option></option>
							                   				<?php
							                   					//foreach ( $tpd as $item ):
							                   						?>
							                   							<option value="<?php //echo $item->nidtbxtpd?>"<?php //echo $item->nidtbxtpd == $distancia['nidtbxtpd'] ? ' selected="selected"' : ''?>><?php //echo $item->cnometpd?></option>
							                   						<?php
							                   					//endforeach;
							                   				?>
							                   			</select>
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
				                  		<div class="col-xs-12 col-sm-6">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="tipomedidadistancia" class="col-xs-12 col-sm-4 text-right">Tipo de Medida</label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<select id="tipomedidadistancia" name="tipomedidadistancia[]" class="form-control<?php //echo in_array("tipo_medida_distancia", $requiredfields) ? " required" : ""?>">
							                   				<option></option>
							                   				<?php
							                   					//foreach ( $tmd as $item ):
							                   						?>
							                   							<option value="<?php //echo $item->nidtbxtmd?>"<?php //echo $item->nidtbxtmd == $distancia['nidtbxtmd'] ? ' selected="selected"' : ''?>><?php //echo $item->cnometmd?></option>
							                   						<?php
							                   					//endforeach;
							                   				?>
							                   			</select>
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
				                  	</div> 
									<div class="row">
				                  		<div class="col-xs-12 col-sm-6">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="distancia" class="col-xs-12 col-sm-4 text-right">Distância</label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<input id="distancia" name="distancia[]" value="<?php //echo $distancia['ndistancia']?>" type="text" class="form-control<?php //echo in_array("distancia", $requiredfields) ? " required" : ""?>">
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
				                  	</div>     
			                  		<div class="row">
			                  			<div class="col-xs-12">
			                  				<div class="form-group">
			                  					<button type="button" class="remover-distancia btn btn-labeled btn-danger pull-right">
			                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover esta distância
			                  					</button>
			                  				</div>
			                  			</div>
			                  		</div>
			                  	</div>
	                  		<?php
	                  		//$i++;
	                  		//endforeach;
	                  	//endif;
	                  	?>
	                  	<div class="row">
	                  		<div class="col-xs-12">
	                  			<button type="button" class="adicionar-distancia mb-sm btn btn-warning">Adicionar mais uma distância</button>
	                  		</div>
	                  	</div>
	                  	
	                  	

                	</div>
                </fieldset>

            	Fim de Endereço e Distancias -->
            	
             </div>
             <!-- Etapa do registro -->
             <input type="hidden" name="etapa" value="geral" id="etapa">
             <?php
             if (isset($cadimo)):
             ?>
             <input type="hidden" name="edit" value="1" id="edit">
             <input type="hidden" name="nidcadimo" value="<?php echo $cadimo->nidcadimo?>" id="nidcadimo">
             <?php
             endif;
             ?>
             <input type="hidden" name="redirectUrl" value="<?php echo makeUrl("cadimo", "imovel", "listar")?>" id="redirectUrl">
          </form>
       </div>
    </div>
 </div>