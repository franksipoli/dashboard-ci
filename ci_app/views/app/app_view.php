<!-- Page content-->
<div class="content-wrapper">
	<h3><?php echo $title?></h3>
      <div class="panel panel-default">
         <div class="panel-body">
         	<?php
           		$this->load->view('general/messages');
           ?>
            <div class="table-responsive">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>App</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($apps as $app){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $app->cname?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("app/app","config", $app->nidtbxapp)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        </td>
		                     </tr>
                  		<?php
                  		$i++;
                  	}
                  	?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
</div>