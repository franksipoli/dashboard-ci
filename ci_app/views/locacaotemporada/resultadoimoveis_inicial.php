<h3><?php echo $title?></h3>
<div class="row">
  <div class="col-lg-12">
      <a href="<?php echo makeUrl('locacaotemporada', 'pesquisarimoveis') ?>" class="btn btn-lg btn-primary">Voltar para a pesquisa</a>
  </div>
</div>
<br/><br/>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <?php
                  $this->load->view('general/messages');
               ?>
            <?php
              if (count($imoveis) == 0):
                ?>
                  <p class="alert alert-danger">Nenhum Imóvel encontrado com esses critérios</p>
                <?php
              endif;
              foreach ($imoveis as $imovel):
                ?>
                  <div class="row">

                    <div class="col-xs-12">

                      <h4><?php echo Tipoimovel_model::getById($imovel->nidtbxtpi)->cnometpi?> - Ref. <?php echo $imovel->creferencia?> - <?php echo $imovel->ctitulo?></h4>
                      <h5><?php echo Enderecoimovel_model::getString($imovel->nidcadimo)?></h5>

                    </div>

                  </div>
                  <div class="row">
                    
                    <div class="col-xs-12 col-sm-3">

                      <div class="row">
                        <div class="col-xs-12">
                          <?php

                          $foto = Imovel_model::getPrimeiraFoto($imovel->nidcadimo);

                          if ($foto):

                          ?>

                            <img src="<?php echo Imovel_model::getPrimeiraFoto($imovel->nidcadimo)?>?v=<?php echo date('YmdHis')?>" class="img-responsive">

                          <?php

                          else:

                           ?>

                            <img src="<?php echo base_url("imagens/semfoto.jpg")?>" class="img-responsive">

                          <?php

                          endif;

                          ?>
                        </div>
                      </div>
                      <div class="row links-locacao">
                        <div class="col-xs-6 col-sm-2 text-center">
                          
                          <a href="<?php echo makeUrl("cadimo","imovel/imagenscliente", $imovel->nidcadimo."?returnurl=".urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"))?>" class="link" title="Fotos do Imóvel"><i class="fa fa-picture-o"></i></a>

                        </div>
                        <div class="col-xs-6 col-sm-2 text-center">

                          <a href="<?php echo makeUrl("locacaotemporada","inserir", $imovel->nidcadimo)?>?data_inicial=<?php echo $data_inicial?>&amp;data_final=<?php echo $data_final?>" class="link" title="Locar Imóvel"><i class="fa fa-key"></i></a>

                        </div>
                        <div class="col-xs-6 col-sm-2 text-center">

                          <a href="<?php echo makeUrl("locacaotemporada","relatorio", $imovel->nidcadimo)?>" class="link" title="Relatório de locações"><i class="fa fa-calendar-o"></i></a>

                        </div>
                        <div class="col-xs-6 col-sm-2 text-center">

                          <a href="<?php echo makeUrl("cadimo/imovel","bens", $imovel->nidcadimo)?>" class="link" title="Relação de bens"><i class="fa fa-cutlery"></i></a>

                        </div>
                        <div class="col-xs-6 col-sm-2 text-center">

                          <a href="#" data-imovel="<?php echo $imovel->nidcadimo?>" class="adicionar-imovel-atendimento link" title="Adicionar à lista de atendimento" data-toggle="modal" data-target="#modalImovelAtendimento"><i class="fa fa-user-plus"></i></a>

                        </div>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-9">

                      <?php
                        $pacotes = Tipopacote_model::getByImovel($imovel->nidcadimo);
                        if (is_array($pacotes)):
                          foreach ($pacotes as $pacote):
                            ?>
                              <p class="alert alert-danger"><?php echo $pacote['cnomepac']?> com mínimo de <?php echo $pacote['nmindias']?> dias, ao valor de R$<?php echo number_format($pacote['nvlrdiaria'], 2, ",", ".")?> por diária, totalizando o valor de R$<?php echo number_format($pacote['nvlrpacote'], 2, ",", ".")?></p>
                            <?php
                          endforeach;
                        endif;
                      ?>

                      <table class="informacoes-imovel table table-striped table-condensed">
                        <tr>
                          <td width="20%"><strong>Entidade</strong></td>
                          <td>
                              <?php
                                $entidade = Entidade_model::getById($imovel->nidtbxent);
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

                        if (!$neutralizar_calendario):

                          ?>
                            <tr>
                              <td colspan="2">
                                <div class="datepicker_container datepicker-busca-imoveis" data-meses="<?php echo $meses?>" data-inicial="<?php echo $data_inicial?>" data-ocupado="<?php echo implode(",", Imovel_model::getDiasOcupados($imovel->nidcadimo))?>"></div>
                              </td>
                            </tr>
                          <?php

                        endif;

                        ?>

                      </table>

                    </div>

                  </div>

                  <hr>

                <?php
              endforeach;
            ?>
         </div>
      </div>

      <input type="hidden" name="neutralizar_calendario" id="neutralizar_calendario" value="<?php echo $neutralizar_calendario ? 1 : 0?>">

      <!-- END panel-->
   </div>
</div>
<!-- END row-->
<!-- END panel-->
</div>