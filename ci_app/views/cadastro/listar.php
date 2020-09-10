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
	          	<a href="<?php echo makeUrl('cadgrl', 'cadastro', 'inserir') ?>" class="btn btn-lg btn-primary add_msg">Inserir Cadastro</a>
	       	</div>
      	</div>

      	<hr>

		<div class="col-lg-12">

					<div class="panel panel-default">
        	<div class="panel-heading"><h4>Pesquisar cadastros</h4></div>
            <div class="panel-body">
              
              <form role="form" class="form-horizontal">

                <div class="form-group">
                    
                    <div class="col-md-5">
                        <input id="input-palavra-chave" name="palavra" type="text" placeholder="Palavra-chave" class="form-control" value="<?php echo $this->input->get('palavra') ?>">
                    </div>

                    <div class="col-md-3">
                        <select name="campo" class="form-control" id="input-campo">
                            <option value="">Campo de pesquisa</option>
                            <option value="nome"<?php if($this->input->get('campo') == 'nome') echo ' selected="selected"' ?>>Nome</option>
                            <option value="cpf"<?php if($this->input->get('campo') == 'cpf') echo ' selected="selected"' ?>>CPF</option>
                            <option value="rg"<?php if($this->input->get('campo') == 'rg') echo ' selected="selected"' ?>>RG</option>
                            <option value="endereco"<?php if($this->input->get('campo') == 'endereco') echo ' selected="selected"' ?>>Endereço do cliente</option>
                            <option value="cidade"<?php if($this->input->get('campo') == 'cidade') echo ' selected="selected"' ?>>Cidade</option>
                            <option value="email"<?php if($this->input->get('campo') == 'email') echo ' selected="selected"' ?>>E-mail</option>
                            <option value="telefone"<?php if($this->input->get('campo') == 'telefone') echo ' selected="selected"' ?>>Telefone</option>
                            <option value="obs"<?php if($this->input->get('campo') == 'obs') echo ' selected="selected"' ?>>Texto de observação</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="tipo_cadastro" class="form-control" id="input-tipo">
                            <option value="">Tipo</option>
                        	<?php
                            foreach($this->data['tipo_cadastro'] as $tipo_cadastro){
                            	$selected = ($this->input->get('tipo_cadastro') == $tipo_cadastro->nidtbxtcg) ? ' selected="selected"' : '';
                            	echo '<option value="'.$tipo_cadastro->nidtbxtcg.'"'.$selected.'>'.$tipo_cadastro->cdescritcg.'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="estadocivil" class="form-control" id="input-estadocivil">
                            <option value="">Estado civil</option>
                            <?php
                            foreach($this->data['estado_civil'] as $estado_civil){
                            	$selected = ($this->input->get('estadocivil') == $estado_civil->nidtbxest) ? ' selected="selected"' : '';
                            	echo '<option value="'.$estado_civil->nidtbxest.'"'.$selected.'>'.$estado_civil->cdescriest.'</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>

                <hr>

                <div class="form-group">
                    

                    <div class="col-md-3">
                        <label for="input-tipo-data" class="sr-only">Tipo de data</label>
                        <select name="tipo_data" class="form-control" id="input-tipo-data">
                            <option value="nascimento"<?php if($this->input->get('tipo_data') == 'nascimento') echo ' selected="selected"' ?>>Data de nascimento</option>
                            <option value="cadastro"<?php if($this->input->get('tipo_data') == 'cadastro') echo ' selected="selected"' ?>>Data de cadastro</option>
                            <option value="atendimento"<?php if($this->input->get('tipo_data') == 'atendimento') echo ' selected="selected"' ?>>Data do atendimento</option>
                        </select>
                    </div>

                    <div class="col-md-6">
	                    <div class="row">
	                    
		                    <div class="col-md-6 date-field df0">
		                        <div id="datetimepicker0" class="input-group date">
		                            <input type="text" name="datan" placeholder="DD/MM/AAAA" class="form-control" value="<?php echo $this->input->get('datan') ?>">
		                            <span class="input-group-addon">
		                                <span class="fa fa-calendar"></span>
		                            </span>
		                        </div>
		                     </div>

		                    <div class="col-md-6 date-field df1">
		                        <div id="datetimepicker1" class="input-group date">
		                            <input type="text" name="datai" placeholder="Data inicial" class="form-control" value="<?php echo $this->input->get('datai') ?>">
		                            <span class="input-group-addon">
		                                <span class="fa fa-calendar"></span>
		                            </span>
		                        </div>
		                     </div>

		                     <div class="col-md-6 date-field df2">
		                        <div id="datetimepicker2" class="input-group date">
		                            <input type="text" name="dataf" placeholder="Data final" class="form-control" value="<?php echo $this->input->get('dataf') ?>">
		                            <span class="input-group-addon">
		                                <span class="fa fa-calendar"></span>
		                            </span>
		                        </div>
		                     </div>

	                 	</div>
                 	</div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary pull-right">Buscar</button>
                    </div>

                </div>

              </form>
           </div>
        </div>

			<div class="panel panel-default">
				<div class="panel-body">
					<table id="cadastro_lista" class="table table-striped table-hover datatable">
						<thead>
							<tr>
								<th class="cnomegrl">Nome</th>
								<th class="ccpfcnpj">CPF / CNPJ</th>
								<th class="crgie">RG / Inscr. Est</th>
								<th class="cdescriemail">E-mail</th>
								<th class="cdescritel">Telefone</th>
								<th class="datacriacao">Data de cadastro</th>
								<th width="1%" class="dadosbancarios"></th>
                                <th width="1%" class="edit"></th>
								<th width="1%" class="view"></th>
								<th width="1%" class="delete"></th>
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