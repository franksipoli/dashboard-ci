 <!-- Page content-->
 <div class="content-wrapper">
    <h3><?php echo $title?></h3>
    <div class="panel panel-default">
       <div class="panel-body">
          <form id="form-cadastro-locacao" action="#">
             <div>
                <h4>Imóvel &amp; Parceiro</h4>
                <fieldset>
                	<div class="step-content">
                		<input type="hidden" name="data_hoje" id="data_hoje" value="<?php echo date('d/m/Y')?>">
	                  	<div class="row">
	                  	 	<div class="col-xs-12 col-sm-6">
		           			  	<div class="form-group">
			                   		<div class="row">
				                   		<label for="data_inicial" class="col-xs-12 col-sm-4 text-right">Data Inicial</label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<input id="data_inicial" value="<?php echo isset($data_inicial) ? $data_inicial : ""?>" name="data_inicial" type="text" class="form-control<?php echo in_array("data_inicial", $requiredfields) ? " required" : ""?>" data-jmask="date">
				                   		</div>
			                   		</div>
			                  	</div>      
	                  	 	</div>
	                  	 	<div class="col-xs-12 col-sm-6">
		           			  	<div class="form-group">
			                   		<div class="row">
				                   		<label for="data_final" class="col-xs-12 col-sm-4 text-right">Data Final</label>
				                   		<div class="col-xs-12 col-sm-8">
				                   			<input id="data_final" value="<?php echo isset($data_final) ? $data_final : ""?>" name="data_final" type="text" class="form-control<?php echo in_array("data_final", $requiredfields) ? " required" : ""?>" data-jmask="date">
				                   		</div>
			                   		</div>
			                  	</div>      
	                  	 	</div>
	                  	</div>
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="taxa_administrativa" class="col-xs-12 col-sm-2 text-right">Taxa Administrativa</label>
		                   		<div class="col-xs-12 col-sm-2">
		                   			<input type="text" class="form-control" name="taxa_administrativa" id="inputTaxaAdministrativa" data-jmask="dinheiro" value="<?php echo number_format($taxa_administrativa, 2)?>">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="form-group" style="display: none;">
	                   		<div class="row">
		                   		<label for="valor_total" class="col-xs-12 col-sm-2 text-right">Valor Total</label>
		                   		<div class="col-xs-12 col-sm-3">
		                   			<div class="input-group">
									  <span class="input-group-addon">R$</span>
									  <input type="text" class="form-control" name="valor_total" id="inputValorTotal" data-jmask="dinheiro">
									</div>
		                   		</div>
		                   		<div class="col-xs-12 col-sm-5">
		                   			<span id="descValorTotal"></span>
		                   		</div>
	                   		</div>
	                  	</div>
                		<div class="form-group">
	                   		<div class="row">
		                   		<label for="titulo" class="col-xs-12 col-sm-3 col-md-2 text-right">Quantidade de Parcelas</label>
		                   		<div class="col-xs-12 col-sm-2">
		                   			<select name="quantidade_parcelas" id="quantidade_parcelas" class="form-control">
										<?php
											for ($i=1;$i<=10;$i++){
												?>
													<option<?php echo isset($quantidade_parcelas_locacao) && $i==$quantidade_parcelas_locacao ? ' selected="selected"' : ''?> value="<?php echo $i?>"><?php echo $i?></option>
												<?php
											}	
										?>	                   				
		                   			</select>
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="form-group parcela-item hidden" data-parcela="0">
	                   		<div class="row">
		                   		<label for="titulo" class="numero-parcela col-xs-12 col-sm-2 col-lg-2 text-right">Parcela 0</label>
		                   		<div class="col-xs-12 col-md-3">
		                   			<input type="text" name="valor_parcela[]" data-jmask="dinheiro" value="" class="valor form-control">
		                   		</div>
		                   		<div class="col-xs-12 col-md-7">
		                   			<div class="checkbox">
		                   				<label><input type="checkbox" class="fixar-valor" name="fixar[]" value=""><span class="hidden-xs hidden-sm hidden-md">Fixar valor</span><span class="hidden-lg">Fixar</span></label>
		                   			</div>
		                   		</div>
		                   		<div class="col-xs-12 col-md-3 col-md-offset-2">
									<input type="text" name="data[]" value="" placeholder="Data" data-jmask="date" class="data-vencimento form-control">
		                   		</div>
		                   		<div class="col-xs-12 col-md-3">
									<select name="forma_pagamento[]" class="forma-pagamento form-control">
										<?php
											foreach ($fpa as $item):
												?>
													<option value="<?php echo $item->nidtbxfpa?>"><?php echo $item->cnomefpa?></option>
												<?php
											endforeach;
										?>
									</select>
		                   		</div>
		                   		<div class="col-xs-12 col-md-4">
									<input type="text" name="observacoes[]" value="" placeholder="Observações" class="observacoes form-control">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-2 col-sm-offset-2">
									<button class="btn btn-danger" id="btnAtualizarValores">Atualizar Valores</button>									
								</div>
							</div>
	                  	</div>
                		<div class="form-group">
	                   		<div class="row">
		                   		<label for="pagamento" class="col-xs-12 col-sm-2 text-right">Pagamento</label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<textarea name="pagamento" id="infoPagamento" rows="5" class="form-control"></textarea>
		                   		</div>
	                   		</div>
	                  	</div>
                		<div class="form-group">
	                   		<div class="row">
		                   		<label for="titulo" class="col-xs-12 col-sm-3 col-md-2 text-right">Cliente</label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input id="cliente" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" name="cliente" type="text" class="form-control<?php echo in_array("cliente", $requiredfields) ? " required" : ""?>">
		                   			<input type="hidden" name="clienteid" id="clienteid" value="">
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="imovel" class="col-xs-12 col-sm-3 col-md-2 text-right">Imóvel (Referência ou Título)</label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input type="text" class="form-control" name="imovel" value="<?php
		                   			echo $cadimo->creferencia." - ".$cadimo->ctitulo;
		                   			?>" readonly="readonly">
		                   			<input type="hidden" name="imovelid" id="imovelid" value="<?php echo $cadimo->nidcadimo?>">
		                   		</div>
	                   		</div>
	                  	</div>
                  	</div>                			
                </fieldset>
                <h4>Finalização</h4>
                <fieldset>
                	<div class="step-content">
	                  	<p>A locação foi salva com sucesso!</p>
	                  	<ul class="boletos">
	                  	</ul>
	                  	<br/><br/>
	                  	<p>Você pode agora <a href="#" class="imprimir-contrato">imprimir o contrato</a> <!--ou <a href="#" class="imprimir-ficha">preencher a ficha de inquilinos</a> --> </p>
                	</div>
                </fieldset>
             </div>
             <!-- Etapa do registro -->
             <input type="hidden" name="etapa" value="geral" id="etapa">
             <?php
             if (isset($cadloc)):
             ?>
             <input type="hidden" name="edit" value="1" id="edit">
             <input type="hidden" name="nidcadloc" value="<?php echo $cadimo->nidcadloc?>" id="nidcadloc">
             <?php
             endif;
             ?>
             <input type="hidden" name="redirectUrl" value="<?php echo makeUrl("locacaotemporada", "listar" )?>" id="redirectUrl">
          </form>
       </div>
    </div>
 </div>