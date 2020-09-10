<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo $returnurl?>" class="voltar btn btn-sm btn-info">Voltar para a busca</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <!-- END panel-->
      <div class="panel panel-default lista-fotos-imovel">
         <div class="panel-body">   

            <div id="carousel-imagens-cliente" class="carousel slide" data-ride="carousel" style="display: block; margin: 0 auto; width: 100%; max-width: <?php echo $maiorlargura?>px;">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <?php
                for ($i=0; $i<count($imagens);$i++):
                ?>
                <li data-target="#carousel-imagens-cliente" data-slide-to="<?php echo $i?>"<?php echo $i == 0 ? ' class="active"' : ''?>></li>
                <?php
                endfor;
                ?>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">

                <?php

                $i = 0;

                foreach ($imagens as $imagem):

                ?>

                <div class="item<?php echo $i++==0 ? ' active' : ''?>">
                  <img src="<?php echo base_url("imagens/".$pasta_maior."/".$imagem->nidtagimi.".jpg")?>" class="img-responsive">
                </div>

                <?php

                endforeach;

                ?>

              </div>

              <!-- Controls -->
              <a class="left carousel-control" href="#carousel-imagens-cliente" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
              </a>
              <a class="right carousel-control" href="#carousel-imagens-cliente" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Próximo</span>
              </a>
            </div>   

            <div class="row miniaturas">
              <?php
                $i = 0;
                foreach ($imagens as $imagem):
                  ?>
                    <div class="col-xs-6 col-sm-2 col-md-1">
                       <a href="#" class="" data-slide-to="<?php echo $i++?>"><img src="<?php echo base_url("imagens/".$pasta_maior."/".$imagem->nidtagimi.".jpg")?>" class="img-responsive"></a>
                    </div>
                  <?php
                endforeach;
              ?>
            </div>        

            <br/><br/>

            <div class="row">
              <div class="col-xs-12">
                <table class="informacoes-imovel table table-striped table-condensed">
                  <tr>
                    <td width="20%"><strong>Entidade</strong></td>
                    <td>
                        <?php
                          if ($entidade->nidcadgrl):
                            echo Cadastro_model::getById($entidade->nidcadgrl)->cnomegrl;
                          elseif ($entidade->nidcadjur):
                            echo Pessoajuridica_model::getById($entidade->nidcadjur)->cnomefant;
                          else:
                            echo "<i>Não preenchido</i>";
                          endif;
                        ?>
                    </td>
                  </tr>

                  <?php

                  if ($imovel->nareacons > 0):
                  ?>
                  <tr>
                    <td><strong>Área construída:</strong></td>
                    <td><?php echo number_format($imovel->nareacons, 2, ",", ".")?>m²</td>
                  </tr>
                  <?php
                  endif;

                  if ($imovel->nareautil  > 0):
                  ?>
                  <tr>
                    <td><strong>Área útil:</strong></td>
                    <td><?php echo number_format($imovel->nareautil, 2, ",", ".")?>m²</td>
                  </tr>
                  <?php
                  endif;

                  if ($imovel->nareapriv  > 0):
                  ?>
                  <tr>
                    <td><strong>Área privativa:</strong></td>
                    <td><?php echo number_format($imovel->nareapriv, 2, ",", ".")?>m²</td>
                  </tr>
                  <?php
                  endif;

                  if ($imovel->nareacom  > 0):
                  ?>
                  <tr>
                    <td><strong>Área comercial:</strong></td>
                    <td><?php echo number_format($imovel->nareacom, 2, ",", ".")?>m²</td>
                  </tr>
                  <?php
                  endif;

                  if ($imovel->nareaterreno  > 0):
                  ?>
                  <tr>
                    <td><strong>Área do terreno:</strong></td>
                    <td><?php echo number_format($imovel->nareaterreno, 2, ",", ".")?>m²</td>
                  </tr>
                  <?php
                  endif;

                  if ($imovel->nareaaverbada  > 0):
                  ?>
                  <tr>
                    <td><strong>Área averbada:</strong></td>
                    <td><?php echo number_format($imovel->nareaaverbada, 2, ",", ".")?>m²</td>
                  </tr>
                  <?php
                  endif;

                  if ($imovel->nquartos  > 0):
                  ?>
                  <tr>
                    <td><strong>Número de quartos:</strong></td>
                    <td><?php echo $imovel->nquartos?></td>
                  </tr>
                  <?php
                  endif;

                  if ($imovel->nsuites  > 0):
                  ?>
                  <tr>
                    <td><strong>Número de suítes:</strong></td>
                    <td><?php echo $imovel->nsuites?></td>
                  </tr
                  <?php
                  endif;

                  ?>

                  <tr>
                    <td><strong>Endereço:</strong></td>
                    <td><?php echo Enderecoimovel_model::getString($imovel->nidcadimo)?></td>
                  </tr>

                  <?php

                  $enderecos = Enderecoimovel_model::getByImovel($imovel->nidcadimo);

                  $enderecos = $enderecos[0];

                  ?>

                  <tr>
                    <td><strong>Bairro:</strong></td>
                    <td><?php echo $enderecos['cdescribai']?></td>
                  </tr>

                  <?php

                  foreach ($fva as $item):
                    if ($item['nidtbxfin'] == Parametro_model::get("finalidade_locacao_id")):
                      $valor = Finalidadetipovalor_model::getByImovelFinalidade($imovel->nidcadimo, $item['nidtagfva']);
                        if ($valor > 0):
                          ?>
                            <tr>
                              <td><strong>Valor (<?php echo $item['cnometpv']?>):</strong></td>
                              <td>R$<?php echo number_format($valor, 2, ",", ".")?></td>
                            </tr>
                          <?php
                        endif;
                    endif;
                  endforeach;

                  $distancias = Imoveldistancia_model::getByImovel($imovel->nidcadimo);

                  foreach ($distancias as $distancia):

                    if ($distancia['ndistancia'] > 0):
                        ?>
                          <tr>
                            <td><strong><?php echo $distancia['tpd']?>:</strong></td>
                            <td><?php echo $distancia['ndistancia']?> <?php echo $distancia['tmd']?></td>
                          </tr>
                        <?php
                    endif;

                  endforeach;

                  ?>

                </table>
              </div>
            </div> 

            <?php

            if ($imovel->clatitude && $imovel->clongitude):

            ?>

            <br/><br/>

            <div class="row">
              <div class="col-xs-12">
                <input type="hidden" id="latitude" value="<?php echo $imovel->clatitude?>">
                <input type="hidden" id="longitude" value="<?php echo $imovel->clongitude?>">
                <div id="map" style="width: 100%; height: 700px"></div> 
              </div>
            </div>

            <?php

            endif;

            ?>

         </div>
      </div>
   </div>
</div>
<!-- END row-->
<!-- END panel-->
</div>