 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<a href="<?php echo makeUrl('locacaotemporada', 'inquilinos', $cadloc->nidcadloc)?>" class="btn btn-sm btn-info">Ficha de inquilinos</a>
	<br/><br/>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
           		$this->load->view('general/messages');

            ?>

			<h4>Contratos da Locação - <?php echo $cadimo->creferencia ?> - <?php echo toUserDate($cadloc->ddatainicial)?></h4>
			<p>
				<small>
					Cadastrado em <?php echo toUserDateTime($cadloc->dtdatacriacao) ?>
					<?php if($cadloc->dtdataatualizacao) echo '<br>última atualização em '.toUserDateTime($cadloc->dtdataatualizacao); ?>
				.</small>
			</p>

			<br/>

			<?php

			if (count($contratos) == 0):

			?>

			<h4>Criar contrato</h4>

               <form class="form-horizontal" id="frmCadastroTipoContrato" method="POST" action="<?php echo makeUrl("locacaotemporada","contratos",$cadloc->nidcadloc,"?funcao=gerar")?>">

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Tipo de Contrato</label>
	                  <div class="col-lg-10">
	                     <select name="nidtbxcon" id="nidtbxcon" class="form-control">
							<?php
								foreach ($con as $item):
									?>
										<option value="<?php echo $item->nidtbxcon?>"><?php echo $item->cnomecon?></option>
									<?php
								endforeach;
							?>
	                     </select>
	                  </div>
	               </div>

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Conteúdo</label>
	                  <div class="col-lg-10">
	                     <div data-role="editor-toolbar" data-target="#editor" class="btn-toolbar btn-editor">
	                        <div class="btn-group">
	                           <a data-edit="bold" data-toggle="tooltip" title="Bold (Ctrl/Cmd+B)" class="btn btn-default">
	                              <em class="fa fa-bold"></em>
	                           </a>
	                           <a data-edit="italic" data-toggle="tooltip" title="Italic (Ctrl/Cmd+I)" class="btn btn-default">
	                              <em class="fa fa-italic"></em>
	                           </a>
	                           <a data-edit="underline" data-toggle="tooltip" title="Underline (Ctrl/Cmd+U)" class="btn btn-default">
	                              <em class="fa fa-underline"></em>
	                           </a>
	                        </div>
	                     </div>
	                     <div style="overflow:scroll; height:450px;max-height:450px" class="form-control wysiwyg mt-lg"><?php echo isset($con[0]) ? $con[0]->tconteudo : $this->session->flashdata('tconteudo')?></div>
	                  </div>
	               </div>

	               <input type="hidden" name="tconteudo" id="recebe-wysiwyg">

	               <div class="form-group">
	                  <div class="col-lg-offset-2 col-lg-10">
	                     <button type="submit" class="btn btn-sm btn-default">Gerar contrato</button>
	                  </div>
	               </div>

               </form>

			<br/>

			<?php

			endif;

			?>

			<h4>Contratos gerados</h4>


			<table id="imovel_lista" class="table table-striped table-hover datatable" data-nidcadloc="<?php echo $cadloc->nidcadloc?>">
				<thead>
					<tr>
						<th class="dtdatainicial">Data</th>
						<th class="nidcadimo">Criado por</th>
						<th width="2%" class="contrato"></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>

			<br/><br/>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('locacaotemporada','listar' ) ?>" class="btn btn-default">Voltar para lista de locações</a></div>
			</div>

		</div>
	</div>
 </div>