<li class="dropdown dropdown-list">
	<a href="#" data-toggle="dropdown">
		<em class="icon-bell"></em>
		<div class="label label-danger total-msg"></div>
	</a>
	<!-- START Dropdown menu-->
	<ul class="dropdown-menu animated flipInX">
		<li>
			<!-- START list group-->
			<div class="list-group msg-list">
				
				<div class="content"></div>

				<a href="<?php echo makeUrl('msg', 'mensagem') ?>" class="list-group-item link">
					<small></small>
				</a>
				
				<?php 
				/*
				Deixei este trecho comentado caso exista algum módulo de tarefas no sistema. Leandro
				<a href="#" class="list-group-item">
					<div class="media-box">
						<div class="pull-left">
							<em class="fa fa-tasks fa-2x text-success"></em>
						</div>
						<div class="media-box-body clearfix">
							<p class="m0">Tarefas pendentes</p>
							<p class="m0 text-muted"><small>11 tarefas pendentes</small></p>
						</div>
					</div>
				</a>
				*/
				?>

				<!-- last list item -->
				
			</div>
		<!-- END list group-->
		</li>
	</ul>
	<!-- END Dropdown menu-->
</li>