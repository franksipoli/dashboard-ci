 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <div class="form-group">
         <a href="<?php echo makeUrl("cadgrl","entidade","inserir")?>" class="btn btn-sm btn-success">Inserir nova entidade</a>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-xs-12">
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
                        <th>Entidade</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $i = 1;
                     foreach ($entidades as $entidade){
                        ?>
                           <tr>
                              <td><?php echo $i?></td>
                              <td><?php
                                 if (isset($entidade['cadgrl'])):
                                    echo $entidade['cadgrl']->cnomegrl;
                                 elseif (isset($entidade['cadjur'])):
                                    echo $entidade['cadjur']->cnomefant;
                                 endif;
                                 ?>
                              </td>
                              <td>
                                 <?php
                                    if (isset($entidade['cadgrl'])):
                                       echo "Pessoa Física";
                                    elseif (isset($entidade['cadjur'])):
                                       echo "Pessoa Jurídica";
                                    endif;
                                 ?>
                              </td>
                              <td>
                                 <a href="<?php echo makeUrl("cadgrl","entidade","editar","?id=".$entidade['nidtbxent'])?>" class="btn btn-square btn-info btn-xs">Editar</a>
                                 <a href="<?php echo makeUrl("cadgrl","entidade","excluir","?id=".$entidade['nidtbxent'])?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover a entidade?">Remover</a>
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
</div>
<!-- END row-->
</div>