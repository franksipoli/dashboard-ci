 <!-- Page content-->
 <div class="content-wrapper">
    <h3><?php echo $title?></h3>
    <?php
    	if (isset($cadgrl)):
    		?>
    			<a href="<?php echo makeUrl("cadgrl/cadastro", "listar")?>" class="btn btn-sm btn-primary">Voltar</a>
    			<br/><br/>
    		<?php
    	endif;
    ?>
    <div class="panel panel-default">
       <div class="panel-body">
          <form id="form-cadastro" action="#">
             <div>
                <h4>Dados pessoais</h4>
                <fieldset>
                	<div class="step-content">
	           			<div class="form-group">
	                   		<div class="row">
		                   		<label for="nidtbxchg" class="col-xs-12 col-sm-3 col-md-2 text-right">Como chegou<?php echo in_array("comochegou", $requiredfields) ? " (*)" : ""?></label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<select name="nidtbxchg" id="nidtbxchg" class="form-control required">
										<?php
											foreach ($chg as $item):
												?>
													<option value="<?php echo $item->nidtbxchg?>"<?php echo isset($cadgrl) && $cadgrl->nidtbxchg == $item->nidtbxchg ? " selected=\"selected\"" : ""?>><?php echo $item->cdescrichg?></option>
												<?php
											endforeach;
										?>	                   				
		                   			</select>
		                   		</div>
	                   		</div>
	                  	</div>
	           			<div class="form-group">
	                   		<div class="row">
		                   		<label for="tipo_pessoa" class="col-xs-12 col-sm-3 col-md-2 text-right">Tipo de pessoa<?php echo in_array("tipo_pessoa", $requiredfields) ? " (*)" : ""?></label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<select <?php echo isset($cadgrl) && $cadgrl->ctipopessoa ? 'disabled="disabled"' : '' ?> name="tipo_pessoa" id="tipo_pessoa" data-jtoggle="tipo_pessoa" class="form-control required">
										<option value="f"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "f" ? " selected=\"selected\"" : ""?>>Física</option>
										<option value="j"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "j" ? " selected=\"selected\"" : ""?>>Jurídica</option>	                   				
		                   			</select>
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="form-group">
	                  		<div class="row">
	                  			<div class="col-xs-12 col-sm-6">
			                   		<div class="row">
				                   		<label for="nidtbxtcg" class="col-xs-12 col-sm-4 text-right">Tipo de cadastro<?php echo in_array("tipo_cadastro", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<?php
				                   			/**
											 * Tipos de cadastro
											 */
				                   			foreach ($tcg as $item):
				                   				?>
				                   				<div class="checkbox">
											    	<label>
											      		<input name="nidtbxtcg[]"<?php echo isset($cadgrl_tpc) && in_array($item->nidtbxtcg, $cadgrl_tpc) ? " checked=\"checked\"" : ""?> value="<?php echo $item->nidtbxtcg?>" type="checkbox"<?php echo $item->nidtbxtcg==Parametro_model::get("id_tipo_cadastro_prestador_servicos") ? 'data-jtoggle="tipo_servico"' : ''?>> <?php echo $item->cdescritcg?>
											    	</label>
												</div>
				                   				<?php
				                   			endforeach;
											?>
				                   		</div>
			                   		</div>                  				
	                  			</div>
	                  			<div class="col-xs-12 col-sm-6" data-tipo_servico="tipo_servico">
	                  				<div class="row">
				                   		<label for="nidtbxtps" class="col-xs-12 col-sm-4 text-right">Tipo de serviço<?php echo in_array("tipo_servico", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   		<?php
				                   			/**
											 * Tipos de serviço
											*/
				                   			foreach ($tps as $item):
				                   				?>
				                   				<div class="checkbox">
											    	<label>
											      		<input name="nidtbxtps[]"<?php echo isset($cadgrl_tps) && in_array($item->nidtbxtps, $cadgrl_tps) ? " checked=\"checked\"" : "" ?> value="<?php echo $item->nidtbxtps?>" type="checkbox"> <?php echo $item->cdescritps?>
											    	</label>
												</div>
				                   				<?php
				                   			endforeach;
										?>
				                   		</div>
			                   		</div> 
	                  			</div>
	                  		</div>
	                  	</div>
	           			<div class="form-group" data-tipo_pessoa="f">
	                   		<div class="row">
		                   		<label for="nomecompleto" class="col-xs-12 col-sm-3 col-md-2 text-right">Nome completo<?php echo in_array("nomecompleto", $requiredfields) ? " (*)" : ""?></label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input id="nomecompleto" maxlength="255" name="nomecompleto" type="text"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "f" ? " value=\"".$cadgrl->cnomegrl."\"" : ""?> class="form-control<?php echo in_array("nomecompleto", $requiredfields) ? " required" : ""?>">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="form-group" data-tipo_pessoa="j">
	                   		<div class="row">
		                   		<label for="razaosocial" class="col-xs-12 col-sm-3 col-md-2 text-right">Razão Social<?php echo in_array("razaosocial", $requiredfields) ? " (*)" : ""?></label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input id="razaosocial" maxlength="255" name="razaosocial" type="text"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "j" ? " value=\"".$cadgrl->cnomegrl."\"" : ""?> class="form-control<?php echo in_array("razaosocial", $requiredfields) ? " required" : ""?>">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
			           			<div class="form-group" data-tipo_pessoa="f">
			                   		<div class="row">
				                   		<label for="data_nascimento" class="col-xs-12 col-sm-4 text-right">Data de Nascimento<?php echo in_array("data_nascimento", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<input id="data_nascimento" maxlength="10" name="data_nascimento" type="text"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "f" && isset($cadfis) ? " value=\"".toUserDate($cadfis->ddtnasc)."\"" : ""?> class="form-control<?php echo in_array("data_nascimento", $requiredfields) ? " required" : ""?>" data-jmask="date">
				                   		</div>
			                   		</div>
			                  	</div>       
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
	                  	 		<div class="form-group" data-tipo_pessoa="f">
			                   		<div class="row">
				                   		<label for="estado_civil" class="col-xs-12 col-sm-3 col-md-2 text-right">Estado Civil<?php echo in_array("estado_civil", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-9 col-md-10">
				                   			<select name="nidtbxest" id="nidtbxest" class="form-control<?php echo in_array("estado_civil", $requiredfields) ? " required" : ""?>">
												<option></option>
												<?php
													foreach ($est as $item):
														?>
															<option value="<?php echo $item->nidtbxest?>"<?php echo isset($cadfis) && $cadfis->nidtbxest == $item->nidtbxest ? " selected=\"selected\"" : "" ?>><?php echo $item->cdescriest?></option>
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
			           			<div class="form-group" data-tipo_pessoa="f">
			                   		<div class="row">
				                   		<label for="cpf" class="col-xs-12 col-sm-4 text-right">CPF<?php echo in_array("cpf", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<input id="cpf" maxlength="14" name="cpf" type="text"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "f" ? " value=\"".$cadgrl->ccpfcnpj."\"" : ""?> class="form-control<?php echo in_array("cpf", $requiredfields) ? " required" : ""?>" data-jmask="cpf">
				                   		</div>
			                   		</div>
			                  	</div>       
			                  	<div class="form-group" data-tipo_pessoa="j">
			                   		<div class="row">
				                   		<label for="cnpj" class="col-xs-12 col-sm-4 text-right">CNPJ<?php echo in_array("cnpj", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<input id="cnpj" maxlength="18" name="cnpj" type="text"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "j" ? " value=\"".$cadgrl->ccpfcnpj."\"" : ""?> class="form-control<?php echo in_array("cnpj", $requiredfields) ? " required" : ""?>" data-jmask="cnpj">
				                   		</div>
			                   		</div>
			                  	 </div>                   			
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
	                  	 		<div class="form-group" data-tipo_pessoa="f">
			                   		<div class="row">
				                   		<label for="rg" class="col-xs-12 col-sm-3 col-md-2 text-right">RG/DNI<?php echo in_array("rg", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-9 col-md-10">
				                   			<input id="rg"maxlength="100" name="rg" type="text"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "f" ? " value=\"".$cadgrl->crgie."\"" : ""?> class="form-control<?php echo in_array("rg", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
			                  	</div>
			                  	<div class="form-group" data-tipo_pessoa="j">
			                   		<div class="row">
				                   		<label for="ie" class="col-xs-12 col-sm-3 col-md-2 text-right">IE<?php echo in_array("ie", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8 col-md-9">
				                   			<input id="ie" data-jmask="integer" maxlength="100" name="ie" type="text"<?php echo isset($cadgrl) && $cadgrl->ctipopessoa == "j" ? " value=\"".$cadgrl->crgie."\"" : ""?> class="form-control<?php echo in_array("ie", $requiredfields) ? " required" : ""?>" <?php echo isset($cadjur) && $cadjur->nieisento ==1 ? 'readonly="readonly"' : ''?>>
				                   		</div>
				                   		<div class="col-xs-12 col-sm-1">
				                   			<label for="ie_isento">
					                   			<input id="ie_isento" type="checkbox" name="ie_isento" <?php echo isset($cadjur) && $cadjur->nieisento ==1 ? 'checked="checked"' : ''?>>
					                   			Isento
					                   		</label>
				                   		</div>
			                   		</div>
			                  	</div>
	                  	 	</div>
	                  	</div> 
	                  	<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
			           			<div class="form-group" data-tipo_pessoa="f">
			                   		<div class="row">
				                   		<label for="data_emissao" class="col-xs-12 col-sm-4 text-right">Data de Emissão<?php echo in_array("data_emissao", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<input id="data_emissao" maxlength="10" name="data_emissao"<?php echo isset($cadfis) && $cadgrl->ctipopessoa == "f" ? " value=\"".toUserDate($cadfis->ddtemirg)."\"" : ""?> type="text" class="form-control<?php echo in_array("data_emissao", $requiredfields) ? " required" : ""?>" data-jmask="date">
				                   		</div>
			                   		</div>
			                  	</div>       
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
	                  	 		<div class="form-group" data-tipo_pessoa="f">
			                   		<div class="row">
				                   		<label for="entidade_emitente" class="col-xs-12 col-sm-3 col-md-2 text-right">Emitente<?php echo in_array("emitente", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-9 col-md-10">
				                   			<select name="nidtbxemi" id="nidtbxemi" class="form-control<?php echo in_array("emitente", $requiredfields) ? " required" : ""?>">
												<option></option>
												<?php
													foreach ($emi as $item):
														?>
															<option value="<?php echo $item->nidtbxemi?>"<?php echo isset($cadfis) && $cadfis->nidtbxemi == $item->nidtbxemi ? " selected=\"selected\"" : ""?>><?php echo $item->cdescriemi?></option>
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
	                  	 		<div class="form-group" data-tipo_pessoa="f">
			                   		<div class="row">
				                   		<label for="nidtbxnac" class="col-xs-12 col-sm-4 text-right">Nacionalidade<?php echo in_array("nacionalidade", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<select name="nidtbxnac" id="nidtbxnac" class="form-control<?php echo in_array("nacionalidade", $requiredfields) ? " required" : ""?>">
				                   				<option></option>
												<?php
													foreach ($nac as $item):
														?>
															<option value="<?php echo $item->nidtbxnac?>"<?php echo isset($cadfis) && $cadfis->nidtbxnac == $item->nidtbxnac ? " selected=\"selected\"" :""?>><?php echo $item->cdescrinac?></option>
														<?php
													endforeach;
												?>
				                   			</select>
				                   		</div>
			                   		</div>
			                  	</div>
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
	                  	 		<div class="form-group" data-tipo_pessoa="f">
			                   		<div class="row">
				                   		<label for="nidtbxcbo" class="col-xs-12 col-sm-3 col-md-2 text-right">Profissão<?php echo in_array("profissao", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-9 col-md-10">
				                   			<select name="nidtbxcbo" id="nidtbxcbo" class="form-control select-select2<?php echo in_array("profissao", $requiredfields) ? " required" : ""?>">
												<option></option>
												<?php
													foreach ($cbo as $item):
														?>
															<option value="<?php echo $item->nidtbxcbo?>"<?php echo isset($cadfis) && $cadfis->nidtbxcbo == $item->nidtbxcbo ? " selected=\"selected\"" :""?>><?php echo $item->cdescricbo?></option>
														<?php
													endforeach;
												?>	                   				
				                   			</select>
				                   		</div>
			                   		</div>
			                  	</div>
	                  	 	</div>
	                  	</div>
	                  	<div class="form-group" data-tipo_pessoa="j">
	                  		<div class="row">
	                  			<div class="col-xs-12 col-sm-6">
			                   		<div class="row">
				                   		<label for="nidtbxatv" class="col-xs-12 col-sm-4 text-right">Atividade<?php echo in_array("atividade", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<select name="nidtbxatv" id="nidtbxatv" class="form-control select-select2<?php echo in_array("atividade", $requiredfields) ? " required" : ""?>">
												<option></option>
												<?php
													foreach ($atv as $item):
														?>
															<option value="<?php echo $item->nidtbxatv?>"<?php echo isset($cadjur) && $cadjur->nidtbxatv == $item->nidtbxatv ? " selected=\"selected\"" :""?>><?php echo $item->cdescriatv?></option>
														<?php
													endforeach;
												?>	                   				
				                   			</select>
				                   		</div>
			                   		</div>                  				
	                  			</div>
	                  			<div class="col-xs-12 col-sm-6">
	                  				<div class="row">
				                   		<label for="cnomefant" class="col-xs-12 col-sm-3 col-md-2 text-right">Nome Fantasia<?php echo in_array("nome_fantasia", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-6 col-md-10">
				                   			<input id="cnomefant" maxlength="255" name="cnomefant"<?php echo isset($cadjur) && $cadgrl->ctipopessoa == "j" ? " value=\"".$cadjur->cnomefant."\"" : ""?> type="text" class="form-control<?php echo in_array("nome_fantasia", $requiredfields) ? " required" : ""?>">
				                   		</div>
			                   		</div>
	                  			</div>
	                  		</div>
	                  	</div> 
	                  	<div class="form-group" data-tipo_pessoa="j">
	                  		<div class="row">
	                  			<div class="col-xs-12 col-sm-6">
			                   		<div class="row">
				                   		<label for="ddtfundacao" class="col-xs-12 col-sm-4 text-right">Data de Fundação<?php echo in_array("data_fundacao", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<input id="ddtfundacao" maxlength="10" name="ddtfundacao"<?php echo isset($cadjur) && $cadgrl->ctipopessoa == "j" ? " value=\"".toUserDate($cadjur->ddtfundacao)."\"" : ""?> type="text" class="form-control<?php echo in_array("data_fundacao", $requiredfields) ? " required" : ""?>" data-jmask="date">
				                   		</div>
			                   		</div>                 				
	                  			</div>
	                  			<div class="col-xs-12 col-sm-6">
	                  				<div class="row">
				                   		<label for="ncaptsocial" class="col-xs-12 col-sm-3 col-md-2 text-right">Capital Social<?php echo in_array("capital_social", $requiredfields) ? " (*)" : ""?></label>
				                   		<div class="col-xs-12 col-sm-9 col-md-10">
				                   			<input id="ncaptsocial" maxlength="30" name="ncaptsocial"<?php echo isset($cadjur) && $cadgrl->ctipopessoa == "j" ? " value=\"".$cadjur->ncaptsocial."\"" : ""?> type="text" class="form-control<?php echo in_array("capital_social", $requiredfields) ? " required" : ""?>" data-jmask="dinheiro">
				                   		</div>
			                   		</div>
	                  			</div>
	                  		</div>
	                  	</div> 
	                  	<?php
	                  	/*
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="creci" class="col-xs-12 col-sm-3 col-md-2 text-right">CRECI</label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input id="creci" maxlength="30" name="creci"<?php echo isset($cadgrl) ? " value=\"".$cadgrl->ccreci."\"" : ""?> type="text" class="form-control<?php echo in_array("creci", $requiredfields) ? " required" : ""?>">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	*/
	                  	?>
	                  	<?php
	                  	if (Parametro_model::get('requerer_senha_chave')):
	                  	?>
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="csenhachave" class="col-xs-12 col-sm-3 col-md-2 text-right">Senha (chaves)</label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input id="csenhachave" maxlength="30" name="csenhachave" type="text" class="form-control<?php echo in_array("senha_chave", $requiredfields) ? " required" : ""?>">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<?php
	                  	endif;
	                  	?>
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="observacoes" class="col-xs-12 col-sm-3 col-md-2 text-right">Observações<?php echo in_array("observacoes", $requiredfields) ? " (*)" : ""?></label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<textarea rows="3" id="observacoes" name="observacoes" class="form-control<?php echo in_array("observacoes", $requiredfields) ? " required" : ""?>"><?php echo isset($cadgrl) ? $cadgrl->cobs : ""?></textarea>
		                   		</div>
	                   		</div>
	                  	</div> 
	                  	<br/>
	                  	<div class="form-group" data-tipo_pessoa="f">
	                  		<h3>Família</h3>
	              			<div class="parente" data-id="-1" style="display: none;">
			                  	<div class="row">
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="tipoparentesco" class="col-xs-12 col-sm-4 text-right">Grau de Parentesco<?php echo in_array("tipo_parentesco", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<select id="tipoparentesco" name="h_tipoparentesco[]" class="form-control<?php echo in_array("tipo_parentesco", $requiredfields) ? " required" : ""?>">
						                   				<option></option>
						                   				<?php
						                   					foreach ( $tpt as $item ):
						                   						?>
						                   							<option value="<?php echo $item->nidtbxtpt?>"><?php echo $item->cdescritpt?></option>
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
						                   		<label for="nome_parente" class="col-xs-12 col-sm-4 text-right">Nome<?php echo in_array("nome_parente", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input name="h_nome_parente[]" maxlength="255" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-parente form-control<?php echo in_array("nome_parente", $requiredfields) ? " required" : ""?>">
						                   			<input type="hidden" name="h_parente_id[]" class="idparente">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  	</div>
		                  	</div>
	                		<?php
	                		if (!isset($cadgrl) || count($parentes) == 0):
	                		?>
	              			<div class="parente" data-id="0">
			                  	<div class="row">
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="tipoparentesco" class="col-xs-12 col-sm-4 text-right">Grau de Parentesco<?php echo in_array("tipo_parentesco", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<select id="tipoparentesco" name="tipoparentesco[]" class="form-control<?php echo in_array("tipo_parentesco", $requiredfields) ? " required" : ""?>">
						                   				<option></option>
						                   				<?php
						                   					foreach ( $tpt as $item ):
						                   						?>
						                   							<option value="<?php echo $item->nidtbxtpt?>"><?php echo $item->cdescritpt?></option>
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
						                   		<label for="nome_parente" class="col-xs-12 col-sm-4 text-right">Nome<?php echo in_array("nome_parente", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input name="nome_parente[]" maxlength="255" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-parente form-control<?php echo in_array("nome_parente", $requiredfields) ? " required" : ""?>">
						                   			<input type="hidden" name="parente_id[]" class="idparente">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  	</div> 
			                  	<div class="row">
		                  			<div class="col-xs-12">
		                  				<div class="form-group">
		                  					<button type="button" class="remover-parente btn btn-labeled btn-danger pull-right">
		                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover este parente
		                  					</button>
		                  				</div>
		                  			</div>
		                  		</div>     			
		                  	</div>
		                  	<?php
		                  	else:
		                  		$i = 0;
		                  		foreach ($parentes as $parente):
		                  		?>
			              			<div class="parente" data-id="<?php echo $i?>">
			                  			<?php
			                  			if ($i > 0):
			                  				?>
			                  					<hr/>
			                  				<?php
			                  			endif;
			                  			?>
			              				<input type="hidden" name="nidtagpar[]" value="<?php echo $parente['nidtagpar']?>">
					                  	<div class="row">
					                  		<div class="col-xs-12 col-sm-6">
							                   <div class="form-group">
							                   		<div class="row">
								                   		<label for="tipoparentesco" class="col-xs-12 col-sm-4 text-right">Grau de Parentesco<?php echo in_array("tipo_parentesco", $requiredfields) ? " (*)" : ""?></label>
								                   		<div class="col-xs-12 col-sm-8">
								                   			<select id="tipoparentesco" name="tipoparentesco[]" class="form-control<?php echo in_array("tipo_parentesco", $requiredfields) ? " required" : ""?>">
								                   				<option></option>
								                   				<?php
								                   					foreach ( $tpt as $item ):
								                   						?>
								                   							<option value="<?php echo $item->nidtbxtpt?>"<?php echo isset($cadgrl) && $parente['nidtbxtpt'] == $item->nidtbxtpt ? " selected=\"selected\"" : ""?>><?php echo $item->cdescritpt?></option>
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
								                   		<label for="nome_parente" class="col-xs-12 col-sm-4 text-right">Nome<?php echo in_array("nome_parente", $requiredfields) ? " (*)" : ""?></label>
								                   		<div class="col-xs-12 col-sm-8">
								                   			<input id="nome_parente" maxlength="250" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" readonly="readonly" name="nome_parente[]" type="text"<?php echo isset($cadgrl) ? " value=\"".$parente['cnomegrl']."\"" : ""?> class="autocomplete-parente form-control<?php echo in_array("nome_parente", $requiredfields) ? " required" : ""?>">
								                   			<input type="hidden" class="idparente" name="parente_id[]" value="<?php echo $parente["nidcadgrl"]?>">
								                   			<a href="#" class="resetarAutocompleteParente btn btn-danger btn-xs">[X]</a>
								                   		</div>
							                   		</div>
							                   </div>	                  			
					                  		</div>
					                  	</div>  
				                  		<div class="row">
				                  			<div class="col-xs-12">
				                  				<div class="form-group">
				                  					<button type="button" class="remover-parente btn btn-labeled btn-danger pull-right">
				                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover este parente
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
		                  			<button type="button" class="adicionar-parente mb-sm btn btn-warning">Adicionar mais um parente</button>
		                  		</div>
		                  	</div>      
                  	 	</div>  
                  	 	<div class="form-group" data-tipo_pessoa="j">
	                  		<h3>Sócios</h3>
	              			<div class="socio" data-id="-1" style="display: none;">
			                  	<div class="row">
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="nome_socio" class="col-xs-12 col-sm-4 text-right">Nome<?php echo in_array("nome_socio", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input name="h_nome_socio[]" maxlength="255" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-socio form-control<?php echo in_array("nome_socio", $requiredfields) ? " required" : ""?>">
						                   			<input type="hidden" name="h_socio_id[]" class="idsocio">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="observacoes" class="col-xs-12 col-sm-4 text-right">Observações<?php echo in_array("observacoes_socio", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input name="h_observacoes_socio[]" type="text" class="form-control<?php echo in_array("observacoes_socio", $requiredfields) ? " required" : ""?>">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  	</div>      			
		                  	</div>
	                		<?php
	                		if (!isset($cadgrl) || count($socios) == 0):
	                		?>
	              			<div class="socio" data-id="0">
			                  	<div class="row">
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="nome_socio" class="col-xs-12 col-sm-4 text-right">Nome<?php echo in_array("nome_socio", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input name="nome_socio[]" maxlength="255" type="text" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-socio form-control<?php echo in_array("nome_socio", $requiredfields) ? " required" : ""?>">
						                   			<input type="hidden" name="socio_id[]" class="idsocio">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="observacoes" class="col-xs-12 col-sm-4 text-right">Observações<?php echo in_array("observacoes_socio", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input name="observacoes_socio[]" type="text" class="form-control<?php echo in_array("observacoes_socio", $requiredfields) ? " required" : ""?>">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  	</div>
		                  		<div class="row">
		                  			<div class="col-xs-12">
		                  				<div class="form-group">
		                  					<button type="button" class="remover-socio btn btn-labeled btn-danger pull-right">
		                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover este sócio
		                  					</button>
		                  				</div>
		                  			</div>
		                  		</div>      			
		                  	</div>
		                  	<?php
		                  	else:
		                  		$i = 0;
		                  		foreach ($socios as $socio):
		                  		?>
			              			<div class="socio" data-id="<?php echo $i?>">
			                  			<?php
			                  			if ($i > 0):
			                  				?>
			                  					<hr/>
			                  				<?php
			                  			endif;
			                  			?>
			              				<input type="hidden" name="nidtagsoc[]" value="<?php echo $socio['nidtagsoc']?>">
					                  	<div class="row">
					                  		<div class="col-xs-12 col-sm-6">
							                   <div class="form-group">
							                   		<div class="row">
								                   		<label for="nome_socio" class="col-xs-12 col-sm-4 text-right">Nome<?php echo in_array("nome_socio", $requiredfields) ? " (*)" : ""?></label>
								                   		<div class="col-xs-12 col-sm-8">
								                   			<input name="nome_socio[]" value="<?php echo $socio['cnomegrl']?>" maxlength="255" type="text" readonly="readonly" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" class="autocomplete-socio form-control<?php echo in_array("nome_socio", $requiredfields) ? " required" : ""?>">
								                   			<a href="#" class="resetarAutocompleteSocio btn btn-danger btn-xs">[X]</a>
								                   			<input type="hidden" value="<?php echo $socio['nidcadgrl']?>" name="socio_id[]" class="idsocio">
								                   		</div>
							                   		</div>
							                   </div>	                  			
					                  		</div>
					                  		<div class="col-xs-12 col-sm-6">
							                   <div class="form-group">
							                   		<div class="row">
								                   		<label for="observacoes" class="col-xs-12 col-sm-4 text-right">Observações<?php echo in_array("observacoes_socio", $requiredfields) ? " (*)" : ""?></label>
								                   		<div class="col-xs-12 col-sm-8">
								                   			<input name="observacoes_socio[]" value="<?php echo $socio['cobs']?>" type="text" class="form-control<?php echo in_array("observacoes_socio", $requiredfields) ? " required" : ""?>">
								                   		</div>
							                   		</div>
							                   </div>	                  			
					                  		</div>
					                  	</div>
				                  		<div class="row">
				                  			<div class="col-xs-12">
				                  				<div class="form-group">
				                  					<button type="button" class="remover-socio btn btn-labeled btn-danger pull-right">
				                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover este sócio
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
		                  			<button type="button" class="adicionar-socio mb-sm btn btn-warning">Adicionar mais um sócio</button>
		                  		</div>
		                  	</div>      
                  	 	</div>   
                  	 </div>           			
                </fieldset>
                <h4>Endereço</h4>
                <fieldset>
                	<div class="step-content">

                		<?php

                		if (!isset($cadgrl) || count($enderecos) == 0):

                		?>

                		<div class="endereco" data-id="0">
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="tipoendereco" class="col-xs-12 col-sm-4 text-right">Tipo de Endereço<?php echo in_array("tipo_endereco", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select id="tipoendereco" name="tipoendereco[]" class="form-control<?php echo in_array("tipo_endereco", $requiredfields) ? " required" : ""?>">
					                   				<option value=""></option>
					                   				<?php
					                   					foreach ( $tpe as $item ):
					                   						?>
					                   							<option value="<?php echo $item->nidtbxtpe?>"><?php echo $item->cdescritpe?></option>
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
		                  		<div class="col-xs-12 col-sm-8">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="endereco" class="col-xs-12 col-sm-3 text-right">Endereço<?php echo in_array("endereco", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-9">
					                   			<div class="row">
					                   				<div class="col-xs-12 col-sm-4">
							                   			<select id="tipologradouro" name="nidtbxtpl[]" class="form-control">
							                   				<option value=""></option>
							                   				<?php
							                   					foreach ($tpl as $tipo):
							                   						?>
							                   							<option value="<?php echo $tipo->nidtbxtpl?>"><?php echo $tipo->cnometpl?></option>
							                   						<?php
							                   					endforeach;
							                   				?>
							                   			</select>
					                   				</div>
					                   				<div class="col-xs-12 col-sm-8">
					                   					<input id="endereco" maxlength="255" name="endereco[]" type="text" class="form-control<?php echo in_array("endereco", $requiredfields) ? " required" : ""?>">
					                   				</div>
					                   			</div>
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-4">
		                  			<div class="form-group">
				                   		<div class="row">
					                   		<label for="numero" class="col-xs-12 col-sm-3 col-md-2 text-right">Número<?php echo in_array("numero", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-9 col-md-10">
					                   			<input id="numero" maxlength="20" name="numero[]" type="text" class="form-control<?php echo in_array("numero", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                  	 </div>
		                  		</div>
		                  	</div>      			
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="complemento" class="col-xs-12 col-sm-4 text-right">Complemento<?php echo in_array("complemento", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input maxlength="50" id="complemento" name="complemento[]" type="text" class="form-control<?php echo in_array("complemento", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
		                  			<div class="form-group">
				                   		<div class="row">
					                   		<label for="bairro" class="col-xs-12 col-sm-3 col-md-2 text-right">Bairro<?php echo in_array("bairro", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-9 col-md-10">
					                   			<input id="bairro" maxlength="255" name="bairro[]" type="text" class="form-control<?php echo in_array("bairro", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                  	 </div>
		                  		</div>
		                  	</div>  
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="cep" class="col-xs-12 col-sm-4 text-right">CEP<?php echo in_array("cep", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="cep" maxlength="10" name="cep[]" data-jmask="cep" type="text" class="form-control<?php echo in_array("cep", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
		                  			<div class="form-group">
		                  				<div class="row">
		                  					<label for="pais" class="col-xs-12 col-sm-3 col-md-2 text-right">País<?php echo in_array("pais", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-9 col-md-10">
					                   			<select name="pais[]" class="form-control<?php echo in_array("pais", $requiredfields) ? " required" : ""?>">
					                   				<option value=""></option>
					                   				<?php
					                   					foreach ($lista_pais as $key=>$value):
					                   						?>
					                   							<option value="<?php echo $value->nidtbxpas?>" <?php echo !isset($cadgrl) && $value->cdescripas == "Brasil" ? 'selected="selected"' : ''?>><?php echo $value->cdescripas?></option>
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
					                   		<label for="uf" class="col-xs-12 col-sm-4 text-right">UF<?php echo in_array("uf", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select name="uf[]" class="form-control<?php echo in_array("uf", $requiredfields) ? " required" : ""?>">
					                   				<option value=""></option>
					                   				<?php
					                   					foreach ($lista_uf as $key=>$value):
					                   						?>
					                   							<option value="<?php echo $value->nidtbxuf?>"><?php echo $value->csiglauf?></option>
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
					                   		<label class="col-xs-12 col-sm-3 col-md-2 text-right">Cidade<?php echo in_array("cidade", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-9 col-md-10">
					                   			<input name="cidade[]" maxlength="255" type="text" data-action="<?php echo makeUrl("dep", "uf", "buscarAjaxLocalizacao")?>" class="autocomplete-cidade form-control<?php echo in_array("cidade", $requiredfields) ? " required" : ""?>">
					                   			<input type="hidden" name="cidade_id[]" class="idcidade">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div>
	                  		<div class="row">
	                  			<div class="col-xs-12">
	                  				<div class="form-group">
	                  					<button type="button" class="remover-endereco btn btn-labeled btn-danger pull-right">
	                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover este endereço
	                  					</button>
	                  				</div>
	                  			</div>
	                  		</div>
	                  	</div>

	                  	<?php

	                  	else: /* Endereços */

	                  		$i = 0;

	                  		foreach ($enderecos as $endereco):

	                  			?>

		                		<div class="endereco" data-id="<?php echo $i?>">
		                			<?php if ($i>0): ?><hr /><?php endif; ?>
		                			<input type="hidden" name="nidtagedc[]" value="<?php echo $endereco['nidtagedc']?>">
				                  	<div class="row">
				                  		<div class="col-xs-12 col-sm-6">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="tipoendereco" class="col-xs-12 col-sm-4 text-right">Tipo de Endereço<?php echo in_array("tipo_endereco", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<select id="tipoendereco" name="tipoendereco[]" class="form-control<?php echo in_array("tipo_endereco", $requiredfields) ? " required" : ""?>">
							                   				<option value=""></option>
							                   				<?php
							                   					foreach ( $tpe as $item ):
							                   						?>
							                   							<option value="<?php echo $item->nidtbxtpe?>"<?php echo $item->nidtbxtpe == $endereco['nidtbxtpe'] ? " selected=\"selected\"" : ""?>><?php echo $item->cdescritpe?></option>
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
				                  		<div class="col-xs-12 col-sm-8">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="endereco" class="col-xs-12 col-sm-3 text-right">Endereço<?php echo in_array("endereco", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-9">
							                   			<div class="row">
							                   				<div class="col-xs-12 col-sm-4">
							                   					<select id="tipologradouro" name="nidtbxtpl[]" class="form-control">
									                   				<option value=""></option>
									                   				<?php
									                   					foreach ($tpl as $tipo):
									                   						?>
									                   							<option value="<?php echo $tipo->nidtbxtpl?>"<?php echo $tipo->nidtbxtpl == $endereco['nidtbxtpl'] ? ' selected="selected"' : ''?>><?php echo $tipo->cnometpl?></option>
									                   						<?php
									                   					endforeach;
									                   				?>
									                   			</select>
							                   				</div>
							                   				<div class="col-xs-12 col-sm-8">
							                   					<input id="endereco" maxlength="255" name="endereco[]" value="<?php echo $endereco['cdescrilog']?>" type="text" class="form-control<?php echo in_array("endereco", $requiredfields) ? " required" : ""?>">
							                   				</div>
							                   			</div>
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
				                  		<div class="col-xs-12 col-sm-4">
				                  			<div class="form-group">
						                   		<div class="row">
							                   		<label for="numero" class="col-xs-12 col-sm-3 col-md-2 text-right">Número<?php echo in_array("numero", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-9 col-md-10">
							                   			<input id="numero" maxlength="20" name="numero[]" value="<?php echo $endereco['cnumero']?>" type="text" class="form-control<?php echo in_array("numero", $requiredfields) ? " required" : ""?>">
							                   		</div>
						                   		</div>
						                  	 </div>
				                  		</div>
				                  	</div>      			
				                  	<div class="row">
				                  		<div class="col-xs-12 col-sm-6">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="complemento" class="col-xs-12 col-sm-4 text-right">Complemento<?php echo in_array("complemento", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<input maxlength="50" id="complemento" name="complemento[]" value="<?php echo $endereco['ccomplemento']?>" type="text" class="form-control<?php echo in_array("complemento", $requiredfields) ? " required" : ""?>">
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
				                  		<div class="col-xs-12 col-sm-6">
				                  			<div class="form-group">
						                   		<div class="row">
							                   		<label for="bairro" class="col-xs-12 col-sm-3 col-md-2 text-right">Bairro<?php echo in_array("bairro", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-9 col-md-10">
							                   			<input id="bairro" maxlength="255" name="bairro[]" type="text" value="<?php echo $endereco['cdescribai']?>" class="form-control<?php echo in_array("bairro", $requiredfields) ? " required" : ""?>">
							                   		</div>
						                   		</div>
						                  	 </div>
				                  		</div>
				                  	</div>  
				                  	<div class="row">
				                  		<div class="col-xs-12 col-sm-6">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="cep" class="col-xs-12 col-sm-4 text-right">CEP<?php echo in_array("cep", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<input id="cep" maxlength="10" name="cep[]" data-jmask="cep" value="<?php echo !empty($endereco['ccep_log']) ? $endereco['ccep_log'] : $endereco['ccep_loc']?>" type="text" class="form-control<?php echo in_array("cep", $requiredfields) ? " required" : ""?>">
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
  				                  		<div class="col-xs-12 col-sm-6">
				                  			<div class="form-group">
				                  				<div class="row">
				                  					<label for="pais" class="col-xs-12 col-sm-3 col-md-2 text-right">País<?php echo in_array("pais", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-9 col-md-10">
							                   			<select name="pais[]" class="form-control <?php echo in_array("pais", $requiredfields) ? " required" : ""?>">
							                   				<option value=""></option>
							                   				<?php
							                   					foreach ($lista_pais as $key=>$value):
							                   						?>
							                   							<option value="<?php echo $value->nidtbxpas?>"<?php echo !empty($endereco) && $endereco['nidtbxpas'] == $value->nidtbxpas ? ' selected="selected"' : ''?>><?php echo $value->cdescripas?></option>
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
							                   		<label for="uf" class="col-xs-12 col-sm-4 text-right">UF<?php echo in_array("uf", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<input name="current_uf[]" type="hidden" value="<?php echo $endereco['nidtbxuf']?>">
							                   			<select name="uf[]" class="form-control <?php echo in_array("uf", $requiredfields) ? " required" : ""?>">
							                   				<option value=""></option>
							                   				<?php
							                   					foreach ($lista_uf as $key=>$value):
							                   						?>
							                   							<option value="<?php echo $value->nidtbxuf?>"<?php echo $value->nidtbxuf == $endereco['nidtbxuf'] ? " selected=\"selected\"" : ""?>><?php echo $value->csiglauf?></option>
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
							                   		<label for="cidade" class="col-xs-12 col-sm-3 col-md-2 text-right">Cidade<?php echo in_array("cidade", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-9 col-md-10">
							                   			<input name="cidade[]" maxlength="255" type="text" data-action="<?php echo makeUrl("dep", "uf", "buscarAjaxLocalizacao")?>" value="<?php echo $endereco['cdescriloc']?>" class="autocomplete-cidade form-control<?php echo in_array("cidade", $requiredfields) ? " required" : ""?>">
					                   					<input type="hidden" name="cidade_id[]" class="idcidade">
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
				                  	</div>

			                  		<div class="row">
			                  			<div class="col-xs-12">
			                  				<div class="form-group">
			                  					<button type="button" class="remover-endereco btn btn-labeled btn-danger pull-right">
			                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover este endereço
			                  					</button>
			                  				</div>
			                  			</div>
			                  		</div>

			                  	</div>

	                  			<?php

	                  			$i++;

	                  		endforeach; /* Endereços */

	                  	endif; /* Endereços */

	                  	?>

	                  	<div class="row">
	                  		<div class="col-xs-12">
	                  			<button type="button" class="adicionar-endereco mb-sm btn btn-warning">Adicionar mais um endereço</button>
	                  		</div>
	                  	</div>
                  	</div> 
                </fieldset>
                <h4>Contato</h4>
                <fieldset>
                	<div class="step-content">
                		<h3>Telefones</h3>
                		<?php
                		if (!isset($cadgrl) || count($telefones) == 0):
                		?>
              			<div class="telefone" data-id="0">
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="tipotelefone" class="col-xs-12 col-sm-4 text-right">Tipo de Telefone<?php echo in_array("tipo_telefone", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select id="tipotelefone" name="tipotelefone[]" class="form-control<?php echo in_array("tipo_telefone", $requiredfields) ? " required" : ""?>">
					                   				<option></option>
					                   				<?php
					                   					foreach ( $ttl as $item ):
					                   						?>
					                   							<option value="<?php echo $item->nidtbxttl?>"><?php echo $item->cdescrittl?></option>
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
					                   		<label for="telefone" class="col-xs-12 col-sm-4 text-right">Telefone<?php echo in_array("telefone", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="telefone" maxlength="25" name="telefone[]" type="text" class="form-control<?php echo in_array("telefone", $requiredfields) ? " required" : ""?>" data-jmask="phone">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div> 
		                  	<div class="row">
	                  			<div class="col-xs-12">
	                  				<div class="form-group">
	                  					<button type="button" class="remover-telefone btn btn-labeled btn-danger pull-right">
	                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover este telefone
	                  					</button>
	                  				</div>
	                  			</div>
	                  		</div>     			
	                  	</div>
	                  	<?php
	                  	else:
	                  		$i = 0;
	                  		foreach ($telefones as $telefone):
	                  		?>
		              			<div class="telefone" data-id="<?php echo $i?>">
		                  			<?php
		                  			if ($i > 0):
		                  				?>
		                  					<hr/>
		                  				<?php
		                  			endif;
		                  			?>
		              				<input type="hidden" name="nidtagtel[]" value="<?php echo $telefone['nidtagtel']?>">
				                  	<div class="row">
				                  		<div class="col-xs-12 col-sm-6">
						                   <div class="form-group">
						                   		<div class="row">
							                   		<label for="tipotelefone" class="col-xs-12 col-sm-4 text-right">Tipo de Telefone<?php echo in_array("tipo_telefone", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<select id="tipotelefone" name="tipotelefone[]" class="form-control<?php echo in_array("tipo_telefone", $requiredfields) ? " required" : ""?>">
							                   				<option></option>
							                   				<?php
							                   					foreach ( $ttl as $item ):
							                   						?>
							                   							<option value="<?php echo $item->nidtbxttl?>"<?php echo isset($cadgrl) && $telefone['nidtbxttl'] == $item->nidtbxttl ? " selected=\"selected\"" : ""?>><?php echo $item->cdescrittl?></option>
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
							                   		<label for="telefone" class="col-xs-12 col-sm-4 text-right">Telefone<?php echo in_array("telefone", $requiredfields) ? " (*)" : ""?></label>
							                   		<div class="col-xs-12 col-sm-8">
							                   			<input id="telefone" maxlength="25" name="telefone[]" type="text"<?php echo isset($cadgrl) ? " value=\"".$telefone['cdescritel']."\"" : ""?> class="form-control<?php echo in_array("telefone", $requiredfields) ? " required" : ""?>" data-jmask="phone">
							                   		</div>
						                   		</div>
						                   </div>	                  			
				                  		</div>
				                  	</div>  
			                  		<div class="row">
			                  			<div class="col-xs-12">
			                  				<div class="form-group">
			                  					<button type="button" class="remover-telefone btn btn-labeled btn-danger pull-right">
			                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover este telefone
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
	                  			<button type="button" class="adicionar-telefone mb-sm btn btn-warning">Adicionar mais um telefone</button>
	                  		</div>
	                  	</div>
	                  	<hr>
	                  	<h3>E-mails</h3>
	                  	<?php
	                  		if (!isset($cadgrl) || count($emails) == 0):
	                  	?>
              			<div class="email" data-id="0">
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="tipoemail" class="col-xs-12 col-sm-4 text-right">Tipo de E-mail<?php echo in_array("tipo_email", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select id="tipoemail" name="tipoemail[]" class="form-control<?php echo in_array("tipo_email", $requiredfields) ? " required" : ""?>">
					                   				<option></option>
					                   				<?php
					                   					foreach ( $tem as $item ):
					                   						?>
					                   							<option value="<?php echo $item->nidtbxtem?>"><?php echo $item->cdescritem?></option>
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
					                   		<label for="email" class="col-xs-12 col-sm-4 text-right">E-mail<?php echo in_array("email", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="email" maxlength="255" name="email[]" type="email" class="form-control<?php echo in_array("email", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div> 
		                  	<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<button type="button" class="remover-email btn btn-labeled btn-danger pull-right">
											<span class="btn-label"><i class="fa fa-times"></i></span>Remover este e-mail
										</button>
									</div>
								</div>
							</div>     			
	                  	</div>
	                  	<?php
	                  		else:
	                  			$i = 0;
	                  			foreach ($emails as $email):
	                  				?>
				              			<div class="email" data-id="<?php echo $i?>">
				              				<?php
				              				if ( $i>0 ):
			                  					?>
			                  					<hr />
			                  					<?php
			                  				endif;
			                  				?>
				              				<input type="hidden" name="nidtagema[]" value="<?php echo $email['nidtagema']?>">
						                  	<div class="row">
						                  		<div class="col-xs-12 col-sm-6">
								                   <div class="form-group">
								                   		<div class="row">
									                   		<label for="tipoemail" class="col-xs-12 col-sm-4 text-right">Tipo de E-mail<?php echo in_array("tipo_email", $requiredfields) ? " (*)" : ""?></label>
									                   		<div class="col-xs-12 col-sm-8">
									                   			<select id="tipoemail" name="tipoemail[]" class="form-control<?php echo in_array("tipo_email", $requiredfields) ? " required" : ""?>">
									                   				<option></option>
									                   				<?php
									                   					foreach ( $tem as $item ):
									                   						?>
									                   							<option value="<?php echo $item->nidtbxtem?>"<?php echo isset($cadgrl) && $item->nidtbxtem == $email['nidtbxtem'] ? " selected=\"selected\"" : ""?>><?php echo $item->cdescritem?></option>
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
									                   		<label for="email" class="col-xs-12 col-sm-4 text-right">E-mail<?php echo in_array("email", $requiredfields) ? " (*)" : ""?></label>
									                   		<div class="col-xs-12 col-sm-8">
									                   			<input maxlength="255" id="email" name="email[]" type="email"<?php echo isset($cadgrl) ? " value=\"".$email['cdescriemail']."\"" : ""?> class="form-control<?php echo in_array("email", $requiredfields) ? " required" : ""?>">
									                   		</div>
								                   		</div>
								                   </div>	                  			
						                  		</div>
						                  	</div> 
											<div class="row">
												<div class="col-xs-12">
													<div class="form-group">
														<button type="button" class="remover-email btn btn-labeled btn-danger pull-right">
															<span class="btn-label"><i class="fa fa-times"></i></span>Remover este e-mail
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
	                  			<button type="button" class="adicionar-email mb-sm btn btn-warning">Adicionar mais um e-mail</button>
	                  		</div>
	                  	</div>
                	</div>
                </fieldset>
                <h4>Dados Bancários</h4>
                <fieldset>
                	<div class="step-content">
                		<h3>Dados Bancários</h3>
                		<?php
                		if (!isset($cadgrl) || count($dadosbancarios) == 0):
                		?>
              			<div class="conta" data-id="0">
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="banco" class="col-xs-12 col-sm-4 text-right">Banco<?php echo in_array("banco", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select id="banco" name="banco[]" class="form-control<?php echo in_array("banco", $requiredfields) ? " required" : ""?>">
					                   				<option></option>
					                   				<?php
					                   					foreach ( $bco as $item ):
					                   						?>
					                   							<option value="<?php echo $item->nidtbxbco?>"><?php echo $item->cnomebco?></option>
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
					                   		<label for="titular" class="col-xs-12 col-sm-4 text-right">Titular<?php echo in_array("titular", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="titular" maxlength="250" name="titular[]" type="text" class="form-control<?php echo in_array("titular", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div> 
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="agencia" class="col-xs-12 col-sm-4 text-right">Agência<?php echo in_array("agencia", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="agencia" maxlength="30" name="agencia[]" type="text" class="form-control<?php echo in_array("agencia", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="conta" class="col-xs-12 col-sm-4 text-right">Conta<?php echo in_array("conta", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="conta" maxlength="250" name="conta[]" type="text" class="form-control<?php echo in_array("conta", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div> 
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="tipo_conta" class="col-xs-12 col-sm-4 text-right">Tipo de Conta<?php echo in_array("tipo_conta", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<select name="tipo_conta[]" id="tipo_conta" class="form-control<?php echo in_array("tipo_conta", $requiredfields) ? " required" : ""?>">
					                   				<option></option>
					                   				<?php
					                   					foreach ($tic as $tipo):
					                   						?>
					                   							<option value="<?php echo $tipo->nidtbxtic?>"><?php echo $tipo->cnometic?></option>
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
					                   		<label for="codigo_tipo_conta" class="col-xs-12 col-sm-4 text-right">Código<?php echo in_array("codigo", $requiredfields) ? " (*)" : ""?></label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<input id="codigo_tipo_conta" maxlength="100" name="codigo_tipo_conta[]" type="text" class="form-control<?php echo in_array("codigo_tipo_conta", $requiredfields) ? " required" : ""?>">
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div> 
		                  	<div class="row">
		                  		<div class="col-xs-12 col-sm-6">
				                   <div class="form-group">
				                   		<div class="row">
					                   		<label for="principal" class="col-xs-12 col-sm-4 text-right">Principal</label>
					                   		<div class="col-xs-12 col-sm-8">
					                   			<label class="switch">
					                   			 <input type="hidden" name="principal_[]" value="0" class="hiddenPrincipal">
					                             <input type="checkbox" name="principal[]" value="1" id="contaPrincipal">
					                             <span></span>
					                          </label>
					                   		</div>
				                   		</div>
				                   </div>	                  			
		                  		</div>
		                  	</div> 
							<div class="row">
	                  			<div class="col-xs-12">
	                  				<div class="form-group">
	                  					<button type="button" class="remover-conta btn btn-labeled btn-danger pull-right">
	                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover esta conta
	                  					</button>
	                  				</div>
	                  			</div>
	                  		</div>
	                  	</div>
	                  	<?php
	                  	else:
	                  		$i = 0;
	                  		foreach ($dadosbancarios as $dado):
	                  		?>
	              			<div class="conta" data-id="<?php echo $i?>">
	              				<?php
	                  			if ($i > 0):
	                  				?>
	                  					<hr/>
	                  				<?php
	                  			endif;
	                  			?>
	              				<input type="hidden" name="nidtagbco[]" value="<?php echo $dado->nidtagbco?>">
			                  	<div class="row">
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="banco" class="col-xs-12 col-sm-4 text-right">Banco<?php echo in_array("banco", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<select id="banco" name="banco[]" class="form-control<?php echo in_array("banco", $requiredfields) ? " required" : ""?>">
						                   				<option></option>
						                   				<?php
						                   					foreach ( $bco as $item ):
						                   						?>
						                   							<option value="<?php echo $item->nidtbxbco?>" <?php echo $item->nidtbxbco == $dado->nidtbxbco ? ' selected="selected"' : ''?>><?php echo $item->cnomebco?></option>
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
						                   		<label for="titular" class="col-xs-12 col-sm-4 text-right">Titular<?php echo in_array("titular", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input id="titular" maxlength="250" value="<?php echo $dado->ctitular?>" name="titular[]" type="text" class="form-control<?php echo in_array("titular", $requiredfields) ? " required" : ""?>">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  	</div> 
			                  	<div class="row">
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="agencia" class="col-xs-12 col-sm-4 text-right">Agência<?php echo in_array("agencia", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input id="agencia" maxlength="30" value="<?php echo $dado->cagencia?>" name="agencia[]" type="text" class="form-control<?php echo in_array("agencia", $requiredfields) ? " required" : ""?>">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="conta" class="col-xs-12 col-sm-4 text-right">Conta<?php echo in_array("conta", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input id="conta" maxlength="250" name="conta[]" value="<?php echo $dado->cconta?>" type="text" class="form-control<?php echo in_array("conta", $requiredfields) ? " required" : ""?>">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  	</div> 
			                  	<div class="row">
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="tipo_conta" class="col-xs-12 col-sm-4 text-right">Tipo de Conta<?php echo in_array("tipo_conta", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<select name="tipo_conta[]" id="tipo_conta" class="form-control">
						                   			<option></option>
						                   			<?php
					                   					foreach ($tic as $tipo):
					                   						?>
					                   							<option value="<?php echo $tipo->nidtbxtic?>"<?php echo $dado->nidtbxtic == $tipo->nidtbxtic ? ' selected="selected"' : ''?>><?php echo $tipo->cnometic?></option>
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
						                   		<label for="codigo_tipo_conta" class="col-xs-12 col-sm-4 text-right">Código<?php echo in_array("codigo", $requiredfields) ? " (*)" : ""?></label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<input id="codigo_tipo_conta" maxlength="100" value="<?php echo $dado->ccodtipoconta?>" name="codigo_tipo_conta[]" type="text" class="form-control<?php echo in_array("codigo_tipo_conta", $requiredfields) ? " required" : ""?>">
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  	</div> 
			                  	<div class="row">
			                  		<div class="col-xs-12 col-sm-6">
					                   <div class="form-group">
					                   		<div class="row">
						                   		<label for="principal" class="col-xs-12 col-sm-4 text-right">Principal</label>
						                   		<div class="col-xs-12 col-sm-8">
						                   			<label class="switch">
						                   			 <input type="hidden" name="principal_[]" value="<?php echo $dado->nprincipal == 1 ? 1 : 0?>" class="hiddenPrincipal">
						                             <input type="checkbox" name="principal[]" <?php echo $dado->nprincipal == 1 ? 'checked="checked"' : ''?> value="1" id="contaPrincipal">
						                             <span></span>
						                          </label>
						                   		</div>
					                   		</div>
					                   </div>	                  			
			                  		</div>
			                  	</div>
		                  		<div class="row">
		                  			<div class="col-xs-12">
		                  				<div class="form-group">
		                  					<button type="button" class="remover-conta btn btn-labeled btn-danger pull-right">
		                  						<span class="btn-label"><i class="fa fa-times"></i></span>Remover esta conta
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
	                  			<button type="button" class="adicionar-conta mb-sm btn btn-warning">Adicionar mais uma conta</button>
	                  		</div>
	                  	</div>
                	</div>
                </fieldset>
             </div>
             <!-- Etapa do registro -->
             <input type="hidden" name="etapa" value="geral" id="etapa">
             <?php
             if (isset($cadgrl)):
	             ?>
		             <input type="hidden" name="edit" value="1" id="edit">
		             <input type="hidden" name="nidcadgrl" value="<?php echo $cadgrl->nidcadgrl?>" id="nidcadgrl">
	             <?php
             endif;
             ?>
             <input type="hidden" name="redirectUrl" value="<?php echo makeUrl("cadgrl", "cadastro", "listar")?>" id="redirectUrl">
          </form>
       </div>
    </div>
 </div>