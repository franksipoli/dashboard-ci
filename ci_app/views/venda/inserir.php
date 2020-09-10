 <!-- Page content-->
 <div class="content-wrapper">
    <h3><?php echo $title?></h3>
    <div class="panel panel-default">
       <div class="panel-body">
          <form id="form-cadastro-venda" action="#">
             <div>
                <h4>Imóvel &amp; Proprietário</h4>
                <fieldset>
                	<div class="step-content">
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="valor_total" class="col-xs-12 col-sm-2 text-right">Valor do Imóvel</label>
		                   		<div class="col-xs-12 col-sm-3">
		                   			<div class="input-group">
									  <span class="input-group-addon">R$</span>
									  <input type="text" readonly="readonly" class="form-control" name="valor_imovel" id="inputValorImovel" value="<?php echo max($valores)?>" data-jmask="dinheiro">
									</div>
		                   		</div>
	                   		</div>
	                  	</div>
	                  	<div class="form-group">
	                   		<div class="row">
		                   		<label for="valor_total" class="col-xs-12 col-sm-2 text-right">Valor Total</label>
		                   		<div class="col-xs-12 col-sm-3">
		                   			<div class="input-group">
									  <span class="input-group-addon">R$</span>
									  <input type="text" class="form-control" name="valor_total" id="inputValorTotal" value="<?php echo number_format($sin->nvalor, 2, ".", ",")?>" data-jmask="dinheiro">
									</div>
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
													<option<?php echo isset($quantidade_parcelas_venda) && $i==$quantidade_parcelas_venda ? ' selected="selected"' : ''?> value="<?php echo $i?>"><?php echo $i?></option>
												<?php
											}	
										?>	                   				
		                   			</select>
		                   		</div>
	                   		</div>
	                  	</div>
                		<div class="form-group">
	                   		<div class="row">
		                   		<label for="titulo" class="col-xs-12 col-sm-3 col-md-2 text-right">Cliente</label>
		                   		<div class="col-xs-12 col-sm-9 col-md-10">
		                   			<input type="text" class="form-control" name="cliente" value="<?php
		                   			echo toUserCpfCnpj($cadgrl->ccpfcnpj)." - ".$cadgrl->cnomegrl;
		                   			?>" readonly="readonly">
		                   			<input type="hidden" name="clienteid" id="clienteid" value="<?php echo $cadgrl->nidcadgrl?>">
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
	                  	<p>A venda foi salva com sucesso!</p>
	                  	<ul class="boletos">
	                  	</ul>
                	</div>
                </fieldset>
             </div>
             <!-- Etapa do registro -->
             <input type="hidden" name="etapa" value="geral" id="etapa">
             <?php
             if (isset($cadven)):
             ?>
             <input type="hidden" name="edit" value="1" id="edit">
             <input type="hidden" name="nidcadven" value="<?php echo $cadimo->nidcadven?>" id="nidcadven">
             <?php
             endif;
             ?>
             <input type="hidden" name="sinalid" value="<?php echo $sin->nidtbxsin?>">
             <input type="hidden" name="redirectUrl" value="<?php echo makeUrl("venda", "listar" )?>" id="redirectUrl">
          </form>
       </div>
    </div>
 </div>