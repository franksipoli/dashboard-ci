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
        	<div class="panel-heading"><h4>Pesquisar locações</h4></div>
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
					<table id="locacao_lista" class="table table-striped table-hover datatable">
						<thead>
							<tr>
								<th class="dtdatainicial">Data inicial</th>
								<th class="nidcadimo">Imóvel</th>
								<th class="nidcadgrl">Cliente</th>
								<th class="datacriacao">Data de cadastro</th>
                                <th class="dataexclusao">Data de exclusão</th>
                                <th class="criado_por">Criado por</th>
                                <th class="excluido_por">Excluído por</th>
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