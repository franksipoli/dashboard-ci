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
	          	<a href="<?php echo makeUrl('locacaotemporada', 'pesquisarimoveis') ?>" class="btn btn-lg btn-primary add_msg">Pesquisar imóveis</a>
	       	</div>
      	</div>

      	<hr>

		<div class="col-lg-12">

		<div class="panel panel-default">
        	<div class="panel-heading"><h4>Pesquisar locações</h4></div>
            <div class="panel-body">
              
              <form role="form" class="form-horizontal">

                    <div class="container-fluid">
                    
                        <div class="row">

                         <div class="col-md-3">
                            <label for="input-tipo-data" class="sr-only">Tipo de data</label>
                            <select name="tipo-data" class="form-control" id="input-tipo-data">
                            	<option value="locacao"<?php if($this->input->get('tipo-data') == 'locacao') echo ' selected="selected"' ?>>Período do Contrato da Locação</option>
                                <option value="cadastro"<?php if($this->input->get('tipo-data') == 'cadastro') echo ' selected="selected"' ?>>Data de cadastro</option>
                            </select>
                         </div>
                        
                        <div class="col-md-3">
                            <div id="datetimepicker1" class="input-group date">
                                <input type="text" name="datai" placeholder="Data inicial" class="form-control" value="<?php echo $this->input->get('datai') ?>">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                         </div>

                         <div class="col-md-3">
                            <div id="datetimepicker2" class="input-group date">
                                <input type="text" name="dataf" placeholder="Data final" class="form-control" value="<?php echo $this->input->get('dataf') ?>">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                         </div>

                         <div class="col-offset-md-2">
                             <button type="submit" class="btn btn-primary">Buscar</button>
                         </div>

                        </div>

                        <br/><br/>

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
                            <label for="input-referencia" class="sr-only">Referência</label>
                            <input type="text" name="referencia" class="form-control" id="input-referencia" placeholder="Referência">
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
								<th class="dtdatainicial">Data inicial</th>
								<th class="nidcadimo">Imóvel</th>
								<th class="nidcadgrl">Cliente</th>
								<th class="datacriacao">Data de cadastro</th>
								<th width="2%" class="contrato"></th>
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