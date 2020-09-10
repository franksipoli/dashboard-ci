 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
           		$this->load->view('general/messages');
            ?>

			<h4><?php echo $imovel->ctitulo ?></h4>

			<br/>

			   <h4>Adicionar local de chaves</h4>

			   <br/>

	           <form class="form-horizontal" id="frmCadastroChave" method="POST" action="<?php echo makeUrl("cadimo/imovel","chaves",$imovel->nidcadimo)?>">

	               <div class="form-group">
	                  <label class="col-lg-2 control-label">Local</label>
	                  <div class="col-lg-10">
	                     <select name="local" class="form-control" id="chaveLocal" required="required">
	                     	<?php
	                     		foreach ($lch as $item):
	                     			?>
	                     				<option value="<?php echo $item->nidtbxlch?>"><?php echo $item->cnomelch?></option>
	                     			<?php
	                     		endforeach;
	                     	?>
	                     </select>
	                  </div>
	               </div>

	               <div class="form-group">
	                  <div class="col-lg-offset-2 col-lg-10">
	                     <button type="submit" class="btn btn-sm btn-default">Adicionar chave</button>
	                  </div>
	               </div>

	           </form>

	           <br/><br/>

			<h4>Chaves</h4>

			<table id="chave_lista" class="table table-striped table-hover datatable" data-nidcadimo="<?php echo $imovel->nidcadimo?>">
				<thead>
					<tr>
						<th>Local</th>
						<th>Código</th>
						<th>Data de Criação</th>
						<th width="2%"></th>
						<th width="2%"></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>

			<br/><br/>

			<hr>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('cadimo','imovel','listar') ?>" class="btn btn-default">Voltar para lista de Imóvels</a></div>
			</div>

			<input type="hidden" id="nidcadimo" value="<?php echo $nidcadimo?>">

		</div>
	</div>
 </div>