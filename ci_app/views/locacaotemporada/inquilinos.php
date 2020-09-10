 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<a href="<?php echo makeUrl('locacaotemporada', 'contratos', $cadloc->nidcadloc)?>" class="btn btn-sm btn-info">Contratos</a>
	<br/><br/>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
           		$this->load->view('general/messages');

            ?>

			<h4>Ficha de Inquilinos</h4>

			<br/>

			<h4>Adicionar inquilino</h4>

               <form class="form-horizontal" id="frmCadastroTipoContrato" method="POST" action="<?php echo makeUrl("locacaotemporada","inquilinos",$cadloc->nidcadloc)?>">

					<div class="form-group">
	                  <label class="col-lg-2 control-label">Carregar dados do locatário</label>
	                  <div class="col-lg-10">
	                  	 <label class="switch">
	                         <input type="checkbox" name="locatario_responsavel" id="inquilinoLocatarioResponsavel">
	                         <span></span>
	                      </label>
	                  </div>
	               </div>

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Nome</label>
	                  <div class="col-lg-10">
	                     <input type="text" name="nome" class="form-control" id="inquilinoNome" required="required">

	                  </div>
	               </div>

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Idade</label>
	                  <div class="col-lg-10">
	                     <input type="text" name="idade" id="inquilinoIdade" class="form-control" required="required">
	                  </div>
	               </div>

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Responsável</label>
	                  <div class="col-lg-10">
	                  	 <label class="switch">
	                         <input type="checkbox" name="responsavel" value="1" id="inquilinoResponsavel">
	                         <span></span>
	                      </label>
	                  </div>
	               </div>

					<?php

					/* Informações que aparecem só se o inquilino for o responsável pela locação */

					?>

	               <div id="inquilinoResponsavelAdicionais" style="display: none;">

						<div class="form-group">
			                <label class="col-lg-2 control-label">Telefone</label>
			                <div class="col-lg-10">
			                     <input type="text" id="inquilinoTelefone" name="telefone" class="form-control" data-jmask="phone">			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-lg-2 control-label">RG</label>
			                <div class="col-lg-10">
			                     <input type="text" id="inquilinoRG" name="rg" class="form-control">
			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-lg-2 control-label">CPF</label>
			                <div class="col-lg-10">
			                     <input type="text" id="inquilinoCPF" name="cpf" class="form-control" data-jmask="cpf">
			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-lg-2 control-label">Data de Nascimento</label>
			                <div class="col-lg-10">
			                     <input type="text" id="inquilinoDataNascimento" name="data_nascimento" class="form-control" data-jmask="date">
			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-lg-2 control-label">Cidade</label>
			                <div class="col-lg-10">
			                     <input type="text" id="inquilinoCidade" name="cidade" class="form-control">
			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-lg-2 control-label">UF</label>
			                <div class="col-lg-10">
			                	<select name="uf" id="inquilinoUF" class="form-control">
			                		<option value=""></option>
			                		<?php
			                			foreach (estadosDoBrasil() as $sigla=>$nome):
			                				?>
			                					<option><?php echo $sigla?></option>
			                				<?php
			                			endforeach;
			                		?>
			                	</select>
			                </div>
			            </div>
	
	               </div>

	               <div class="form-group">
	                  <div class="col-lg-offset-2 col-lg-10">
	                     <button type="submit" class="btn btn-sm btn-default">Adicionar inquilino</button>
	                  </div>
	               </div>

               </form>

               <br/><br/>

			   <h4>Adicionar veículo</h4>

               <form class="form-horizontal" id="frmCadastroveiculo" method="POST" action="<?php echo makeUrl("locacaotemporada","inquilinos",$cadloc->nidcadloc)?>">

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Modelo</label>
	                  <div class="col-lg-10">
	                     <input type="text" name="modelo" class="form-control" id="veiculoModelo" required="required">

	                  </div>
	               </div>

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Placa</label>
	                  <div class="col-lg-10">
	                     <input type="text" name="placa" id="veiculoPlaca" class="form-control">
	                  </div>
	               </div>

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Cor</label>
	                  <div class="col-lg-10">
	                     <input type="text" name="cor" id="veiculoCor" class="form-control">
	                  </div>
	               </div>

	               <div class="form-group">
	                  <div class="col-lg-offset-2 col-lg-10">
	                     <button type="submit" class="btn btn-sm btn-default">Adicionar veículo</button>
	                  </div>
	               </div>

               </form>

			<br/>

			<h4>Inquilinos</h4>


			<table id="imovel_lista" class="table table-striped table-hover datatable" data-nidcadloc="<?php echo $cadloc->nidcadloc?>">
				<thead>
					<tr>
						<th class="dtdatainicial">Nome</th>
						<th class="nidcadimo">Idade</th>
						<th width="2%" class="inquilino"></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>

			<br/><br/>

			<h4>Veículos</h4>


			<table id="veiculo_lista" class="table table-striped table-hover datatable" data-nidcadloc="<?php echo $cadloc->nidcadloc?>">
				<thead>
					<tr>
						<th class="modelo">Modelo</th>
						<th class="placa">Placa</th>
						<th class="cor">Cor</th>
						<th width="2%" class="veiculo"></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>

			<br/><br/>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('locacaotemporada', 'listar' ) ?>" class="btn btn-default">Voltar para lista de locações</a></div>
			</div>

			<input type="hidden" id="nidcadloc" value="<?php echo $cadloc->nidcadloc?>">

		</div>
	</div>
 </div>