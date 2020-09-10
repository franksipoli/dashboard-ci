 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

       	<div class="row">
	       	<div class="col-lg-12">
	          	<a href="<?php echo makeUrl('msg', 'mensagem', 'adicionar') ?>" class="btn btn-lg btn-primary add_msg"><span class="fa fa-envelope"></span> Nova mensagem</a>
	       	</div>
      	</div>

      	<hr>

		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="<?php if($show_tab == 'inbox') echo 'active' ?>"><a href="#recebidas" aria-controls="recebidas" role="tab" data-toggle="tab">Recebidas</a></li>
			<li role="presentation" class="<?php if($show_tab == 'outbox') echo 'active' ?>"><a href="#enviadas" aria-controls="enviadas" role="tab" data-toggle="tab">Enviadas</a></li>
		</ul>

		<div class="tab-content">
			<div id="recebidas" class="tab-pane row<?php if($show_tab == 'inbox') echo ' active' ?>">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<table class="table table-striped table-hover datatable">
								<thead>
									<tr>
										<th class="view"></th>
										<?php // <th class="selectall"><input type="checkbox" title="selecionar/desselecionar todas as mensagens"></th> ?>
										<th class="subject">Assunto</th>
										<th class="from">Remetente</th>
										<th class="datetime">Data de envio</th>
										<th class="delete"></th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
	       </div>

			<div id="enviadas" class="tab-pane row<?php if($show_tab == 'outbox') echo ' active' ?>">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<table class="table table-striped table-hover datatable">
								<thead>
									<tr>
										<th class="view"></th>
										<?php //<th class="selectall"><input type="checkbox" title="selecionar/desselecionar todas as mensagens"></th> ?>
										<th class="subject">Assunto</th>
										<th class="to">Destinatários</th>
										<th class="datetime">Data de envio</th>
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
 </div>

 <script>
 // deletar mensagem
function delete_msg(id)
{
	$.ajax({
		url : '/msg/mensagem/delete'
		,method: 'post'
		,data : 'msg_id='+id
		,success : function(){
			$('tr#row_'+id).hide();
		}
	})
}
 </script>