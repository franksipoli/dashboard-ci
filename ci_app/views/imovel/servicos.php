 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

			<?php
           		$this->load->view('general/messages');
            ?>

			<h4>Inserir serviço - Imóvel <?php echo $cadimo->creferencia?></h4>

			<br/>

		    <form class="form-horizontal" id="frmCadastroServico" method="POST" action="<?php echo isset($servico) ? makeUrl("cadimo","imovel","updateservico","?id=".$servico->nidtagise) : makeUrl("cadimo","imovel","insertservico")?>">
		       <input type="hidden" name="nidcadimo" value="<?php echo $cadimo->nidcadimo?>">
		       <div class="form-group">
		          <label class="col-lg-2 control-label">Tipo de serviço</label>
		          <div class="col-lg-10">
		          	 <select name="nidtbxtps" class="form-control">
						<?php
							foreach ($tps as $tipo):
								?>
									<option value="<?php echo $tipo->nidtbxtps?>"><?php echo $tipo->cdescritps?></option>
								<?php
							endforeach;
						?>
		          	 </select>
		          </div>
		       </div>
		       <div class="form-group">
		          <label class="col-lg-2 control-label">Prestador</label>
		          <div class="col-lg-10">
		             <input type="text" placeholder="Nome" data-action="<?php echo makeUrl("cadgrl","cadastro","buscarPrestadorAjaxNome")?>" name="cnomeprestador" class="form-control autocomplete-nomeprestador" required="required" value="<?php echo isset($servico) ? $servico->prestador->cnomegrl : $this->session->flashdata('cnomegrl')?>" />
		          	 <input type="hidden" name="nidcadgrl" id="nidcadgrl" value="0">
		          </div>
		       </div>
		       <div class="form-group">
		          <label class="col-lg-2 control-label">Valor</label>
		          <div class="col-lg-10">
		             <input type="text" placeholder="Valor" name="nvalor" class="form-control" required="required" value="<?php echo isset($servico) ? $servico->nvalor : $this->session->flashdata('nvalor')?>" data-jmask="dinheiro" />
		          </div>
		       </div>
		       <div class="form-group">
		       	  <div class="col-xs-12">
		       	  	<input type="submit" value="Cadastrar" class="btn btn-info btn-md">
		       	  </div>
		       </div>
		    </form>

			<table id="servico_lista" class="table table-striped">
				<thead>
					<tr>
						<th>Tipo de serviço</th>
						<th>Prestador</th>
						<th>Valor</th>
						<th width="2%"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($servicos as $servico):
							?>
								<tr>
									<td><?php echo $servico->tbxtps->cdescritps?></td>
									<td><?php echo $servico->cadgrl->cnomegrl?></td>
									<td>R$<?php echo number_format($servico->nvalor, 2, ",", ".")?></td>
									<td><a title="Excluir serviço" href="<?php echo makeUrl("cadimo/imovel", "excluirservico", $servico->nidtagise)?>"><i class="fa fa-trash"></i></a></td>
								</tr>
							<?php
						endforeach;
					?>
				</tbody>
			</table>

			<hr>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('cadimo','imovel','listar') ?>" class="btn btn-default">Voltar para lista de imóveis</a></div>
			</div>

		</div>
	</div>
 </div>