<div class="content-wrapper">
 <a href="<?php echo makeUrl('venda', 'pesquisarimoveis')?>" class="btn btn-sm btn-info">Voltar para a pesquisa</a>
 <br/><br/>
 <?php
 if (count($imoveis)):
 ?>
 <!-- Page content-->
 <div class="row">
    <div class="col-xs-12">
       <div id="carouselResultado">
         <div class="carousel-resultado">
          <div class="carousel-wrapper">
            <?php

                foreach ($imoveis as $imovel):
                  
                    $foto = Imovel_model::getPrimeiraFoto($imovel->nidcadimo);

                    if ($foto):

                    ?>

                      <a href="#" class="imovel-item" data-imovel="<?php echo $imovel->nidcadimo?>">
                        <img src="<?php echo Imovel_model::getPrimeiraFoto($imovel->nidcadimo)?>?v=<?php echo date('YmdHis')?>" class="img-responsive">
                        <div class="back">
                          <p class="referencia"><?php echo $imovel->creferencia?></p>
                          <p class="titulo"><?php echo $imovel->ctitulo?></p>
                        </div>
                      </a>
                    <?php

                    endif;

                endforeach;

            ?>
          </div>
         </div>
         <div class="controls">
          <a href="#" class="prev"><i class="fa fa-chevron-left"></i></a>
          <a href="#" class="next"><i class="fa fa-chevron-right"></i></a>
         </div>
       </div>
    </div>
  </div>
 <?php
 endif;
 ?>
<br/><br/>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body" id="panelImovel">
            <p class="alert alert-warning">Selecione um Imóvel para obter informações</p>
         </div>
      </div>

      <!-- END panel-->
   </div>
</div>
<!-- END row-->
<!-- END panel-->
</div>
?>