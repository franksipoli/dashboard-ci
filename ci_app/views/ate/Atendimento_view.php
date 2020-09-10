 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

       	<div class="row">
	       	<div class="col-lg-12">
	          	<a href="<?php echo makeUrl('ate', 'atendimento', 'adicionar') ?>" class="btn btn-lg btn-primary add_msg"><span class="fa fa-comments-o"></span> Novo atendimento</a>
	       	</div>
      	</div>

      	<br/>

		<div class="panel panel-default">
        	<div class="panel-heading"><h4>Pesquisar atendimentos</h4></div>
            <div class="panel-body">
              
              <form role="form" class="form-horizontal">

                <div class="form-group">
                    
                    <div class="col-md-6">
                        <input id="input-palavra-chave" name="palavra" type="text" placeholder="Palavra-chave" class="form-control" value="<?php echo $this->input->get('palavra') ?>">
                    </div>

                    <div class="col-md-2">
                        <select name="campo" class="form-control" id="input-campo">
                            <option value="">Campo</option>
                            <option value="nome"<?php if($this->input->get('campo') == 'nome') echo ' selected="selected"' ?>>Nome</option>
                            <option value="obs"<?php if($this->input->get('campo') == 'obs') echo ' selected="selected"' ?>>Texto da Observação</option>
                            <option value="telefone"<?php if($this->input->get('campo') == 'telefone') echo ' selected="selected"' ?>>Telefone</option>
                            <option value="corretor"<?php if($this->input->get('campo') == 'corretor') echo ' selected="selected"' ?>>Atendente</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="tipo" class="form-control" id="input-tipo">
                            <option value="">Tipo</option>
                            <?php
                            foreach ($finalidades as $fin):
                            ?>
                            <option value="<?php echo $fin->nidtbxfin?>"<?php $this->input->get('tipo') == $fin->nidtbxfin ? ' selected="selected"' : '' ?>><?php echo $fin->cnomefin?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-control" id="input-tipo-data">
                            <option value="">Status</option>
                            <?php
                            foreach ($sat as $item):
                              ?>
                              <option value="<?php echo $item->nidtbxsat?>"<?php if($this->input->get('status') == $item->nidtbxsat) echo ' selected="selected"' ?>><?php echo $item->cnomesat?></option>
                              <?php
                            endforeach;
                            ?>
                        </select>
                    </div>

                </div>

                <hr>

                <div class="form-group">
                    
                     <div class="col-md-3">
                        <label for="input-tipo-data" class="sr-only">Tipo de data</label>
                        <select name="tipo-data" class="form-control" id="input-tipo-data">
                            <option value="cadastro"<?php if($this->input->get('tipo-data') == 'cadastro') echo ' selected="selected"' ?>>Data de cadastro</option>
                            <option value="atendimento"<?php if($this->input->get('tipo-data') == 'atendimento') echo ' selected="selected"' ?>>Data do atendimento</option>
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

              </form>
           </div>
        </div>


		<div id="atendimentos" class="tab-pane row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<table class="table table-striped table-hover datatable">
							<thead>
								<tr>
									<th class="nome">Nome</th>
									<th class="telefone">Telefone</th>
									<th class="corretor">Atendente</th>
									<th class="datetime">Inserido em</th>
									<th class="status">Status</th>
									<th class="view">Produtos</th>
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
 </div>