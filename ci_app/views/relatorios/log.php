 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

		<?php
       		$this->load->view('general/messages');
        ?>

		<div class="col-lg-12">

		<div class="panel panel-default">
        	<div class="panel-heading"><h4>Pesquisar nos logs</h4></div>
            <div class="panel-body">
              
              <form role="form" class="form-horizontal">

                    <div class="container-fluid">
                    
                        <div class="row">

                         <div class="col-md-3">
                            <label for="input-usuario" class="sr-only">Usuário</label>
                            <select name="usuario" class="form-control" id="input-usuario">
                                <option value=""<?php if(!$this->input->get('usuario')) echo ' selected="selected"' ?>>Todos os usuários</option>
                                <?php
                                    foreach ($usuarios as $usuario):
                                        ?>
                                            <option value="<?php echo $usuario->nidtbxsegusu?>"<?php if($this->input->get('usuario') == $usuario->nidtbxsegusu) echo ' selected="selected"' ?>><?php echo $usuario->cnome?></option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>
                         </div>

                         <div class="col-md-3">
                            <label for="input-entidade" class="sr-only">Entidade</label>
                            <select name="entidade" class="form-control" id="input-entidade">
                                <option value=""<?php if(!$this->input->get('entidade')) echo ' selected="selected"' ?>>Todas as entidades</option>
                                <option value="cadgrl"<?php if($this->input->get('entidade') == 'cadgrl') echo ' selected="selected"' ?>>Cadastro geral</option>
                                <option value="cadimo"<?php if($this->input->get('entidade') == 'cadimo') echo ' selected="selected"' ?>>Cadastro de imóveis</option>
                                <option value="cadloc"<?php if($this->input->get('entidade') == 'cadloc') echo ' selected="selected"' ?>>Locação Temporada</option>
                            </select>
                         </div>

                         <div class="col-offset-md-2">
                             <button type="submit" class="btn btn-primary">Buscar</button>
                         </div>

                        </div>

                    </div>

              </form>
           </div>
        </div>

			<div class="panel panel-default">
				<div class="panel-body">
					<table id="log_lista" class="table table-striped table-hover datatable">
						<thead>
							<tr>
								<th class="ddata">Data</th>
								<th class="nidtbxsegusu">Usuário</th>
								<th class="nidentidade">Entidade</th>
                                <th class="citem">Item</th>
								<th class="cacao">Ação</th>
								<th width="2%" class="view"></th>
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