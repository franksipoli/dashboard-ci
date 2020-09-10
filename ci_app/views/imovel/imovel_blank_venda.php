  <div class="row">

    <div class="col-xs-12">

      <h4 class="imovel_titulo"><?php echo Tipoimovel_model::getById($imovel->nidtbxtpi)->cnometpi?> - Ref. <?php echo $imovel->creferencia?> - <?php echo $imovel->ctitulo?></h4>
      <h5><span class="label label-warning"><?php echo Enderecoimovel_model::getString($imovel->nidcadimo)?></span></h5>

    </div>

  </div>

  <br/><br/>

  <?php

      $enderecos = Enderecoimovel_model::getByImovel($imovel->nidcadimo);

      $enderecos = $enderecos[0];

  ?>

  <div class="row">
    
    <div class="col-xs-12 col-sm-5">

      <div class="row">
        <div class="col-xs-12">
          <a href="#" class="fotos-cliente" data-imovel="<?php echo $imovel->nidcadimo?>">

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
          </a>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-sm-1">

      <div class="row links-locacao">

        <div class="col-xs-6 text-center">
          <a href="#" class="link sinal" data-imovel="<?php echo $imovel->nidcadimo?>" title="Fazer sinal de negócio" data-toggle="modal" data-target="#modalImovelSinal">
            <?php
            if (is_array($sinais) && count($sinais) > 0):
            ?>
            <img src="<?php echo base_url("assets/icons/imovel_com_sinal.jpg")?>">
            <?php
            else:
            ?>
            <img src="<?php echo base_url("assets/icons/fazer_sinal_negocio.jpg")?>">
            <?php
            endif;
            ?>
          </a>
        </div>
        <div class="col-xs-6 text-center">
          <a href="#" class="link proposta" data-imovel="<?php echo $imovel->nidcadimo?>" title="Propostas" data-toggle="modal" data-target="#modalImovelProposta">
            <?php
            if (is_array($propostas) && count($propostas) > 0):
            ?>
            <img src="<?php echo base_url("assets/icons/imovel_com_proposta.jpg")?>">
            <?php
            else:
            ?>
            <img src="<?php echo base_url("assets/icons/fazer_proposta.jpg")?>">
            <?php
            endif;
            ?>
          </a>
        </div>
        <div class="col-xs-6 text-center">
          <a href="#" class="link avaliacao" title="Adicionar amostragem para avaliação" data-imovel="<?php echo $imovel->nidcadimo?>"><img src="<?php echo base_url("assets/icons/adicionar_lista_avaliacao.jpg")?>"></a>
        </div>
        <div class="col-xs-6 text-center">
          <a href="<?php echo makeUrl("venda", "avaliacao", $imovel->nidcadimo)?>" class="link avaliar" title="Avaliar este Imóvel"><img src="<?php echo base_url("assets/icons/visualizar_amostra_avaliacao.jpg")?>"></a>
        </div>
        <div class="col-xs-6 text-center">
          <a href="<?php echo makeUrl("cadimo","imovel/imagenscliente", $imovel->nidcadimo)?>" class="link fotos-cliente" data-imovel="<?php echo $imovel->nidcadimo?>" title="Fotos do Imóvel"><img src="<?php echo base_url("assets/icons/mais_detalhes.jpg")?>"></a>
        </div>
        <div class="col-xs-6 text-center">
          <a href="#" data-imovel="<?php echo $imovel->nidcadimo?>" class="adicionar-imovel-atendimento link" title="Adicionar à lista de atendimento" data-toggle="modal" data-target="#modalImovelAtendimento"><img src="<?php echo base_url("assets/icons/adicionar_a_lista.jpg")?>"></a>
        </div>
        <div class="col-xs-6 text-center">
          <a href="#" data-imovel="<?php echo $imovel->nidcadimo?>" class="link link-proprietario" title="Proprietário" data-toggle="modal" data-target="#modalImovelProprietario"><img src="<?php echo base_url("assets/icons/proprietario.jpg")?>"></a>
        </div>
        <div class="col-xs-6 text-center">
          <a href="#" data-imovel="<?php echo $imovel->nidcadimo?>" class="link link-angariador" title="Angariador" data-toggle="modal" data-target="#modalImovelAngariador"><img src="<?php echo base_url("assets/icons/angariador.jpg")?>"></a>
        </div>
        <div class="col-xs-6 text-center">

            <a href="<?php echo makeUrl("cadimo/imovel","editar", $imovel->nidcadimo)?>" class="link" title="Editar Imóvel"><img src="<?php echo base_url("assets/icons/atualizar_imovel.jpg")?>"></a>

          </div>
      </div>

    </div>

    <div class="col-xs-12 col-sm-6 col-container-painel-informacoes">

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

      <div class="row detalhes-imovel">

        <div class="col-xs-12">

        <div class="panel panel-primary">

        <div class="panel-heading panel-heading-collapsed">
          Informações
          <a href="#" data-tool="panel-collapse" data-toggle="tooltip" title="" class="pull-right" data-original-title="Abrir informações">
                              <em class="fa fa-plus"></em>
                           </a>
        </div>

          <div class="panel-wrapper collapse" aria-expanded="false">

            <div class="form-group">

              <div class="row">

              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Bairro</h3>
                <span class="label label-primary"><?php echo $enderecos['cdescribai']?></span>
              </div>
              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Quartos</h3>
                <span class="label label-primary"><?php echo $imovel->nquartos?></span>
              </div>
              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Área Construída</h3>
                <span class="label label-primary"><?php echo number_format($imovel->nareacons, 2, ",", ".")?>m²</span>
              </div>
              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Área Útil</h3>
                <span class="label label-primary"><?php echo number_format($imovel->nareautil, 2, ",", ".")?>m²</span>
              </div>
              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Entidade</h3>
                <span class="label label-primary">
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
                </span>
              </div>
              <?php
              if ($imovel->nareapriv  > 0):
              ?>
              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Área Privativa</h3>
                <span class="label label-primary">
                    <?php echo number_format($imovel->nareapriv, 2, ",", ".")?>m²
                </span>
              </div>
              <?php
              endif;
              ?>
              <?php
              if ($imovel->nareacom  > 0):
              ?>
              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Área Comercial</h3>
                <span class="label label-primary">
                    <?php echo number_format($imovel->nareacom, 2, ",", ".")?>m²
                </span>
              </div>
              <?php
              endif;
              ?>
              <?php
              if ($imovel->nareaterreno  > 0):
              ?>
              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Área do terreno</h3>
                <span class="label label-primary">
                    <?php echo number_format($imovel->nareaterreno, 2, ",", ".")?>m²
                </span>
              </div>
              <?php
              endif;
              ?>
              <?php
              if ($imovel->nareaaverbada  > 0):
              ?>
              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Área averbada:</h3>
                <span class="label label-primary">
                    <?php echo number_format($imovel->nareaaverbada, 2, ",", ".")?>m²
                </span>
              </div>
              <?php
              endif;
              ?>
              <?php
              if ($imovel->nsuites  > 0):
              ?>
              <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                <h3>Número de suítes</h3>
                <span class="label label-primary">
                    <?php echo $imovel->nsuites?>
                </span>
              </div>
              <?php
              endif;
              ?>
              <?php
              foreach ($fva as $item):
                if ($item['nidtbxfin'] == Parametro_model::get("finalidade_locacao_id")):
                  $valor = Finalidadetipovalor_model::getByImovelFinalidade($imovel->nidcadimo, $item['nidtagfva']);
                    if ($valor > 0):
                      ?>
                        <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                          <h3>Valor (<?php echo $item['cnometpv']?>)</h3>
                          <span class="label label-warning">
                              R$<?php echo number_format($valor, 2, ",", ".")?>
                          </span>
                        </div>
                      <?php
                    endif;
                endif;
              endforeach;

              $distancias = Imoveldistancia_model::getByImovel($imovel->nidcadimo);

              foreach ($distancias as $distancia):

                if ($distancia['ndistancia'] > 0):
                    ?>
                      <div class="col-xs-12 col-sm-6 col-lg-3 text-center">
                        <h3><?php echo $distancia['tpd']?></h3>
                        <span class="label label-primary">
                            <?php echo $distancia['ndistancia']?> <?php echo $distancia['tmd']?>
                        </span>
                      </div>
                    <?php
                endif;

              endforeach;

            ?>    

            </div>  

          </div>

        </div>

      </div>

      </div>

    </div>

  </div>

  <hr>