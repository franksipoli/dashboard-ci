 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

		<?php
       		$this->load->view('general/messages');
        ?>

       	<div class="row">
	       	<div class="col-lg-12">
	          	<a href="<?php echo makeUrl('cadimo', 'imovel', 'inserir') ?>" class="btn btn-lg btn-primary add_msg">Inserir Produto</a>
	       	</div>
      	</div>

      	<hr>

		<div class="col-lg-12">

		<div class="panel panel-default">
        	<div class="panel-heading"><h4>Pesquisar Produtos</h4></div>
            <div class="panel-body">
              
              <form role="form">

                <div class="container-fluid">

                        
                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <input id="input-palavra-chave" name="palavra" type="text" placeholder="Palavra-chave" class="form-control" value="<?php echo $this->input->get('palavra') ?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="campo" class="form-control" id="input-campo">
                                        <option value="">Campo de pesquisa</option>
                                        <option value="titulo"<?php if($this->input->get('campo') == 'titulo') echo ' selected="selected"' ?>>Título</option>
                                        <option value="referencia"<?php if($this->input->get('campo') == 'referencia') echo ' selected="selected"' ?>>Referência</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="tipo_imovel" class="form-control" id="input-tipo">
                                        <option value="">Tipo</option>
                                    	<?php
                                        foreach($tpi as $item){
                                        	$selected = ($this->input->get('tipo_imovel') == $item->nidtbxtpi) ? ' selected="selected"' : '';
                                        	echo '<option value="'.$item->nidtbxtpi.'"'.$selected.'>'.$item->cnometpi.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">Buscar</button>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input id="input-nome-proprietario" name="proprietario" type="text" placeholder="Parceiro (Nome/CPF)" value="<?php echo $this->input->get('proprietario') ? $this->input->get('proprietario') : ""?>" class="form-control" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>">
                                    <input type="hidden" name="proprietario_id" id="proprietarioid" value="<?php echo $this->input->get('proprietario_id') ? $this->input->get('proprietario_id') : 0?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="status" class="form-control" id="input-status">
                                        <option value="">Status</option>
                                        <?php
                                        foreach($sti as $item){
                                            $selected = ($this->input->get('status') == $item->nidtbxsti) ? ' selected="selected"' : '';
                                            echo '<option value="'.$item->nidtbxsti.'"'.$selected.'>'.Finalidade_model::getNome($item->nidtbxfin)." - ".$item->cdescristi.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                </div>

              </form>
           </div>
        </div>

			<div class="panel panel-default">
				<div class="panel-body">
					<table id="imovel_lista" class="table table-striped table-hover datatable">
						<thead>
							<tr>
								<th class="cnomegrl">Referência</th>
								<th class="ccpfcnpj">Finalidade</th>
								<th class="crgie">Tipo</th>
								<th class="cdescriemail">Título</th>
								<th class="datacriacao">Data de cadastro</th>
								<!--<th width="2%" class="images"></th> -->
                                <!--<th width="2%" class="pacotes"></th> -->
                                <!--<th width="2%" class="chaves"></th> -->
                                <!--<th width="2%" class="relacao_bens"></th> -->
                                <!--<th width="2%" class="servicos"></th> -->
                                <th width="2%" class="edit"></th>
								<th width="2%" class="view"></th>
								<th width="2%" class="delete"></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>


       </div>
    </div>
 </div>