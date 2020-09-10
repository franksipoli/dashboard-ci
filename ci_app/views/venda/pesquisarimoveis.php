 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmPesquisaImoveis" method="GET" action="<?php echo makeUrl("venda","resultadoimoveis")?>">
               
               <?php
               		$this->load->view('general/messages');
               ?>

               <div role="tabpanel">
                 <!-- Nav tabs-->
                 <ul role="tablist" class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="#geral" aria-controls="geral" role="tab" data-toggle="tab" aria-expanded="true">Geral</a>
                    </li>
                    <li role="presentation" class=""><a href="#localizacao" aria-controls="localizacao" role="tab" data-toggle="tab" aria-expanded="false">Localização</a>
                    </li>
                    <li role="presentation" class=""><a href="#caracteristicas" aria-controls="caracteristicas" role="tab" data-toggle="tab" aria-expanded="false">Características</a>
                    </li>
                 </ul>
                 <!-- Tab panes-->
                 <div class="tab-content">
                    <div id="geral" role="tabpanel" class="tab-pane active">

                      <input type="hidden" name="nidtbxfin" value="<?php echo Parametro_model::get('finalidade_venda_id')?>">
                         <div class="form-group">
                            <label class="col-lg-2 control-label">Tipo de Imóvel</label>
                            <div class="col-lg-10">
                               <select class="form-control" name="nidtbxtpi" placeholder="Tipo de Imóvel">
                                  <option value=""></option>
                                  <?php
                                    foreach ($tpi as $item):
                                        ?>
                                          <option value="<?php echo $item->nidtbxtpi?>"><?php echo $item->cnometpi?></option>
                                        <?php
                                    endforeach;
                                  ?>
                               </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-lg-2 control-label">Área Averbada</label>
                            <div class="col-lg-10">
                                <div class="checkbox c-checkbox">
                                   <label>
                                      <input type="checkbox" value="1" name="area_averbada">
                                      <span class="fa fa-check"></span>
                                   </label>
                                </div>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-lg-2 control-label">Situação da locação</label>
                            <div class="col-lg-10">
                               <label class="radio-inline c-radio">
                                  <input id="inlineradio1" type="radio" name="situacao_locacao" value="" checked="checked">
                               <span class="fa fa-circle"></span>Neutralizar opção</label>
                               <label class="radio-inline c-radio">
                                  <input id="inlineradio1" type="radio" name="situacao_locacao" value="c" checked="">
                               <span class="fa fa-circle"></span>Com opção assinada</label>
                               <label class="radio-inline c-radio">
                                  <input id="inlineradio1" type="radio" name="situacao_locacao" value="s" checked="">
                               <span class="fa fa-circle"></span>Sem opção assinada</label>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-lg-2 control-label">Referência</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Referência" name="referencia" class="form-control">
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-lg-2 control-label">Ordenar por</label>
                            <div class="col-lg-10">
                                <div class="row">
                                  <div class="col-xs-12 col-sm-2">
                                      <select name="ordenar_por" class="form-control">
                                          <option value="tipo">Tipo</option>
                                          <option value="ref">Referência</option>
                                          <option value="ultimos_cadastros">Últimos Cadastros</option>
                                          <option value="valor">Valor Crescente</option>
                                          <option value="valor_descrescente">Valor Decrescente</option>
                                          <option value="metragem">Metragem</option>
                                          <option value="quartos">Quartos</option>
                                      </select>
                                  </div>
                                </div>
                            </div>
                         </div>
                    </div>
                    <div id="localizacao" role="tabpanel" class="tab-pane">
                       <div class="form-group">
                          <label class="col-lg-2 control-label">Endereço</label>
                          <div class="col-lg-10">
                              <div class="row">
                                <div class="col-xs-12 col-sm-2">
                                    <select name="endereco_comparador" class="form-control">
                                        <option value=""></option>
                                        <option>Rua</option>
                                        <option>Avenida</option>
                                        <option>Praça</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-7">
                                    <input type="text" placeholder="Endereço" name="endereco" class="form-control">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <input type="text" placeholder="Número" name="numero" class="form-control">
                                </div>
                              </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-lg-2 control-label">CEP</label>
                          <div class="col-lg-10">
                              <input type="text" placeholder="CEP" name="cep" data-jmask="cep" class="form-control">
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-lg-2 control-label">Estado</label>
                          <div class="col-lg-10">
                              <div class="row">
                                <div class="col-xs-12 col-sm-2">
                                    <select name="estado" class="form-control">
                                        <option value="">Todos</option>
                                        <?php
                                          foreach ($uf as $item):
                                            ?>
                                              <option value="<?php echo $item->nidtbxuf?>"><?php echo $item->cdescriuf?></option>
                                            <?php
                                          endforeach;
                                        ?>
                                    </select>
                                </div>
                              </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-lg-2 control-label">Localização</label>
                          <div class="col-lg-10">
                              <div class="row">
                                <div class="col-xs-12 col-sm-2">
                                    <select name="localizacao" class="form-control">
                                        <option value="">Todos</option>
                                        <?php
                                          foreach ($loc as $item):
                                            ?>
                                              <option data-uf="<?php echo $item->nidtbxuf?>"<?php echo $item->cdescriloc == Parametro_model::get("cidade_padrao_busca_locacao") ? ' selected="selected"' : ''?> value="<?php echo $item->nidtbxloc?>"><?php echo $item->cdescriloc?></option>
                                            <?php
                                          endforeach;
                                        ?>
                                    </select>
                                </div>
                              </div>
                          </div>
                       </div>
                       <?php
                       foreach ($tpd as $item):
                       ?>
                       <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo $item->cnometpd?></label>
                          <div class="col-lg-10">
                              <div class="row">
                                <div class="col-xs-12 col-sm-2">
                                    <select name="distancia_comparador[<?php echo $item->nidtbxtpd?>]" class="form-control">
                                        <option>Igual</option>
                                        <option>Menor</option>
                                        <option>Maior</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-7">
                                    <input type="text" placeholder="Distância" name="distancia[<?php echo $item->nidtbxtpd?>]" class="form-control">
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                    <select name="distancia_unidade[<?php echo $item->nidtbxtpd?>]" class="form-control">
                                        <?php
                                        foreach ($tmd as $item_tmd):
                                        ?>
                                          <option><?php echo $item_tmd->cnometmd?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                              </div>
                          </div>
                       </div>
                       <?php
                       endforeach;
                       ?>
                       <div class="form-group">
                          <label class="col-lg-2 control-label">Bairros</label>
                          <div class="col-lg-10">
                              <div class="row">
                              <?php
                              $i = 1;
                              foreach ($bai as $item):
                                ?>
                                <div class="col-xs-4 bairro" data-localidade="<?php echo $item->nidtbxloc?>">
                                  <div class="checkbox c-checkbox">
                                     <label>
                                        <input type="checkbox" name="bairros[]" value="<?php echo $item->nidtbxbai?>">
                                        <span class="fa fa-check"></span><?php echo $item->cdescribai?></label>
                                  </div>
                                </div>
                                <?php
                              endforeach;
                              ?>
                              </div>
                          </div>
                       </div>

                    </div>
                    <div id="caracteristicas" role="tabpanel" class="tab-pane">

                      <div class="form-group">
                          <label class="col-lg-2 control-label">Nº de quartos</label>
                          <div class="col-lg-10">
                              <div class="row">
                                <div class="col-xs-12 col-sm-2">
                                    <select name="n_quartos_comparador" class="form-control">
                                        <option value="=">Igual a</option>
                                        <option value=">=">Maior ou igual a</option>
                                        <option value="<=">Menor ou igual a</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-10">
                                    <input type="text" placeholder="Número de quartos" name="n_quartos" class="form-control" data-jmask="number">
                                </div>
                              </div>
                          </div>
                       </div>

                       <div class="form-group">
                          <label class="col-lg-2 control-label">Nº de acomodações</label>
                          <div class="col-lg-10">
                              <div class="row">
                                <div class="col-xs-12 col-sm-2">
                                    <select name="n_acomodacoes_comparador" class="form-control">
                                        <option value="=">Igual a</option>
                                        <option value=">=">Maior ou igual a</option>
                                        <option value="<=">Menor ou igual a</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-10">
                                    <input type="text" placeholder="Número de acomodações" name="n_acomodacoes" class="form-control" data-jmask="number">
                                </div>
                              </div>
                          </div>
                       </div>

                       <?php
                       /*

                       <div class="form-group">
                          <label class="col-lg-2 control-label">Acomodações</label>
                          <div class="col-lg-10">
                              <div class="row">
                                <div class="col-xs-12 col-sm-2">
                                    <select name="n_acomodacoes_comparador" class="form-control">
                                        <option value="=">Igual a</option>
                                        <option value=">">Maior ou igual a</option>
                                        <option value="<">Menor ou igual a</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-10">
                                    <input type="text" placeholder="Número de acomodações" name="n_acomodacoes" class="form-control">
                                </div>
                              </div>
                          </div>
                       </div>

                       */
                       ?>

                       <div class="form-group">
                          <label class="col-lg-2 control-label">Características</label>
                          <div class="col-lg-10">
                              <?php
                              $i = 1;
                              foreach ($car as $item):
                                if ($i==1):
                                  ?>
                                    <div class="row">
                                  <?php
                                endif;
                                ?>
                                <div class="col-xs-4">
                                  <div class="checkbox c-checkbox">
                                     <label>
                                        <input type="checkbox" name="caracteristicas[]" value="<?php echo $item->nidtbxcar?>">
                                        <span class="fa fa-check"></span><?php echo $item->cnomecar?></label>
                                  </div>
                                </div>
                                <?php
                                if ($i==3):
                                  ?>
                                    </div>
                                  <?php
                                  $i = 1;
                                else:
                                  $i++;
                                endif;
                              endforeach;
                              if ($i!=1):
                                ?>
                                </div>
                                <?php
                              endif;
                              ?>
                          </div>
                       </div>

                    </div>
                 </div>
              </div>

               <div class="form-group">
                  <div class="col-xs-12 text-center">
                     <button type="submit" class="btn btn-lg btn-info" style="margin-top: 15px;">Pesquisar</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <!-- END panel-->
   </div>
</div>
<!-- END row-->
<!-- END panel-->
</div>