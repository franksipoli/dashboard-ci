<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("cadimo","imovel","listar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <?php
         		$this->load->view('general/messages');
            ?>
            <form action="#" method="POST">
               <div class="form-group">
                  <label class="col-lg-2 control-label">Imagens</label>
                  <div class="col-lg-10">
                     <input type="file" name="file_upload" id="file_upload" />
                  </div>
               </div>
            </form>
            <form action="#" method="POST" class="form-horizontal" id="frmDados">
               <input type="hidden" id="nidcadimo" value="<?php echo $nidcadimo?>">
               <?php
                  if (isset($relacionados) && is_array($relacionados) && count($relacionados) > 0):
                     ?>
                        <div class="row">
                           <div class="col-xs-12 col-md-10 col-md-offset-2">
                              <strong>Enviar anexos para os Imóvels relacionados:</strong>
                           </div>
                        </div>
                        <?php
                        foreach ($relacionados as $imo):
                           ?>
                              <div class="row">
                                 <div class="col-xs-12 col-md-10 col-md-offset-2">
                                    <div class="checkbox c-checkbox">
                                       <label>
                                       <input type="checkbox" checked="checked" name="aplicar_relacionado[]" value="<?php echo $imo->nidcadimo?>" class="enviar-relacionado needsclick">
                                       <span class="fa fa-check"></span><?php echo $imo->creferencia."_".$imo->nunidade." - ".$imo->ctitulo;?></label>
                                    </div>
                                 </div>
                              </div>
                           <?php
                        endforeach;
                  endif;
               ?>
            </form>
         </div>
      </div>
      <!-- END panel-->
      <div class="panel panel-default">
         <div class="panel-body">   
            <form action="#" method="POST" id="frmOrdemImagens">
               <div class="row" id="imagens">
                  <?php
                     foreach ($imagens as $imagem):
                        ?>
                           <div class="col-xs-12 col-sm-2 imovel_foto">
                              <div class="form-group">
                                 <a href="#" data-id="<?php echo $imagem->nidtagimi?>" class="removerFoto"><i class="fa fa-times"></i></a>
                                 <img src="<?php echo base_url("imagens/".$pasta_menor."/thumb/".$imagem->nidtagimi.".jpg")?>" class="img-responsive">
                                 <input type="hidden" name="ordem[]" value="<?php echo $imagem->nidtagimi?>">
                                 <label>
                                    <input type="checkbox" name="enviar_site[<?php echo $imagem->nidtagimi?>]" value="1">
                                    Enviar para o site
                                 </label> 
                              </div>
                           </div>
                        <?php
                     endforeach;
                  ?>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- END row-->
<!-- END panel-->
</div>