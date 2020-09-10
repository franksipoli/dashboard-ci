 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<br/><br/>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
           		$this->load->view('general/messages');

            ?>

			<h4>Documentos da Venda</h4>

			<br/>

			<h4>Adicionar documento</h4>

	           <form class="form-horizontal" enctype="multipart/form-data" id="frmCadastroTipoContrato" method="POST" action="<?php echo makeUrl("venda","documentos",$cadven->nidcadven)?>">

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Data</label>
	                  <div class="col-lg-10">
	                     <input type="text" name="data" class="form-control" id="documentoData" value="<?php echo isset($dve) ? toUserDate($dve->ddata) : date('d/m/Y')?>" required="required">

	                  </div>
	               </div>

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Documento</label>
	                  <div class="col-lg-10">
	                  	 <select name="nidtbxtdo" required="required" id="documentoTipo" class="form-control">
							<?php
								foreach ($tdo as $item):
									?>
										<option value="<?php echo $item->nidtbxtdo?>" <?php echo isset($dve) && $dve->nidtbxtdo == $item->nidtbxtdo ? '' : ' selected="selected"'?>><?php echo $item->cnometdo?></option>
									<?php
								endforeach;
							?>	                  	 	
	                  	 </select>
	                  </div>
	               </div>

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Observações</label>
	                  <div class="col-lg-10">
                         <textarea name="observacoes" class="form-control" id="documentoObservacoes" rows="5"><?php echo isset($dve) ? $dve->tobservacoes : ""?></textarea>
	                  </div>
	               </div>

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Arquivo</label>
	                  <div class="col-lg-10">
                         <input type="file" name="arquivo" id="documentoArquivo">
	                  </div>
	               </div>

	               <div class="form-group">
	                  <div class="col-lg-offset-2 col-lg-10">
	                     <button type="submit" class="btn btn-sm btn-default">Adicionar documento</button>
	                  </div>
	               </div>

	           </form>

           <br/><br/>

			<h4>Documentos</h4>


			<table class="table table-striped table-hover" data-nidcadven="<?php echo $cadven->nidcadven?>">
				<thead>
					<tr>
						<th width="10%" class="dtdatainicial">Data</th>
						<th width="15%">Data de inclusão</th>
						<th width="10%">Usuário</th>
						<th width="25%" class="nidcadimo">Documento</th>
						<th width="36%">Observações</th>
						<th width="4%" class="documento"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($documentos as $documento):
							?>
								<tr>
									<td><?php echo toUserDate($documento->ddata)?></td>
									<td><?php echo toUserDateTime($documento->dtdatacriacao)?></td>
									<td><?php echo Segusuario_model::getNome($documento->nidtbxsegusu_criacao)?></td>
									<td><?php echo Tipodocumento_model::getNome($documento->nidtbxtdo)?></td>
									<td><?php echo nl2br($documento->tobservacoes)?></td>
									<td width="2%"><a href="<?php echo base_url('documentos_venda/'.$documento->nidcadven.'/'.$documento->carquivo)?>" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></td>
									<td width="2%"><a class="remover-documento" href="<?php echo makeUrl("venda","removerdocumento",$documento->nidcaddoc)?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>
								</tr>
							<?php
						endforeach;
					?>
				</tbody>
			</table>

			<br/><br/>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('venda', 'relatorio' ) ?>" class="btn btn-default">Voltar para lista de vendas</a></div>
			</div>

			<input type="hidden" id="nidcadven" value="<?php echo $cadven->nidcadven?>">

		</div>
	</div>
 </div>