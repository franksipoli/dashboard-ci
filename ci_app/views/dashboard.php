<!-- Page content-->
 <div class="content-wrapper">
    <div class="content-heading">
       <?php echo $title?>
       <small data-localize="dashboard.WELCOME"></small>
    </div>
    <!-- START widgets box-->
    <div class="row widgets-caixas">
       <div class="col-lg-3 col-sm-6">
          <!-- START widget-->
          <div class="panel widget bg-primary">
             <div class="row row-table">
                <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                   <em class="icon-user fa-3x"></em>
                </div>
                <div class="col-xs-8 pv-lg">
                   <?php
                    $dados_carteira = Dashboard_model::getDadosCarteiras();
                   ?>
                   <div class="h2 mt0"><?php echo $dados_carteira->quantidade?></div>
                   <div class="text-uppercase">Cadastros</div>
                </div>
             </div>
          </div>
       </div>
       <div class="col-lg-3 col-sm-6">
          <!-- START widget-->
          <div class="panel widget bg-purple">
             <div class="row row-table">
                <div class="col-xs-4 text-center bg-purple-dark pv-lg">
                   <em class="icon-speech fa-3x"></em>
                </div>
                <div class="col-xs-8 pv-lg">
                    <?php
                    $dados_atendimento = Dashboard_model::getAtendimentosAbertos();
                    ?>
                   <div class="h2 mt0"><?php echo $dados_atendimento->quantidade?></div>
                   <div class="text-uppercase">Negocios em abertos</div>
                </div>
             </div>
          </div>
       </div>
       <div class="col-lg-3 col-md-6 col-sm-12">
          <!-- START widget-->
          <div class="panel widget bg-green">
             <div class="row row-table">
                <div class="col-xs-4 text-center bg-green-dark pv-lg">
                   <em class="icon-key fa-3x"></em>
                </div>
                <div class="col-xs-8 pv-lg">
                  <?php
                    $dados_locacoes_hoje = Dashboard_model::getLocacoesHoje();
                  ?>
                   <div class="h2 mt0"><?php echo $dados_locacoes_hoje->quantidade?></div>
                   <div class="text-uppercase">Transações realizadas em <?php echo date('d/m')?></div>
                </div>
             </div>
          </div>
       </div>
       <div class="col-lg-3 col-md-6 col-sm-12">
          <!-- START date widget-->
          <div class="panel widget">
             <div class="row row-table">
                <div class="col-xs-4 text-center bg-green pv-lg">
                   <!-- See formats: https://docs.angularjs.org/api/ng/filter/date-->
                   <div class="text-sm"><?php echo date('M')?></div>
                   <br>
                   <div data-now="" data-format="D" class="h2 mt0"></div>
                </div>
                <div class="col-xs-8 pv-lg">
                   <div class="h2 mt0"><?php echo date('H:i')?></div>
                </div>
             </div>
          </div>
          <!-- END date widget    -->
       </div>
    </div>
    <!-- END widgets box-->
    <div class="row">
       <!-- START dashboard main content-->
       <div class="col-lg-9">
          <!-- START chart-->
          <div class="row">
             <div class="col-lg-12">
                <!-- START widget-->
                <div id="panelChartVendas" class="panel panel-default panel-demo">
                   <div class="panel-heading">
                      <div class="panel-title">Transações no mês <?php echo date('m/Y')?></div>
                   </div>
                   <div class="panel-body">
                      <?php
                        for ($i=1; $i<=31; $i++){
                          if (strlen($i)==1){
                            $i = "0".$i;
                          }
                          ?>
                          <input type="hidden" id="vendas_<?php echo $i?>072016" value="<?php echo Dashboard_model::getNumeroVendasDia("2016-07-".$i)?>">
                          <?php
                        }
                      ?>
                      <div class="chart-spline-vendas flot-chart"></div>
                   </div>
                </div>
                <!-- END widget-->
             </div>
          </div>
          <div class="row">
             <div class="col-lg-12">
                <!-- START widget-->
                <div id="panelChart9" class="panel panel-default panel-demo">
                   <div class="panel-heading">
                      <div class="panel-title">Locações POS no mês <?php echo date('m/Y')?></div>
                   </div>
                   <div class="panel-body">
                      <?php
                        for ($i=1; $i<=31; $i++){
                          if (strlen($i)==1){
                            $i = "0".$i;
                          }
                          ?>
                          <input type="hidden" id="locacoes_<?php echo $i?>072016" value="<?php echo Dashboard_model::getNumeroLocacoesDia("2016-07-".$i)?>">
                          <?php
                        }
                      ?>
                      <div class="chart-spline flot-chart"></div>
                   </div>
                </div>
                <!-- END widget-->
             </div>
          </div>
          <!-- END chart-->
          <div class="row">
             <div class="col-lg-12">
                <div class="row">
                  <div class="col-xs-12 col-md-3">
                      <h3>Vendas</h3>
                         <!-- START list group-->
                         <div data-height="360" data-scrollable="" class="list-group">
                            <!-- START list group item-->
                            <a href="#" class="list-group-item">
                               <div class="media-box">
                                  <div class="pull-left">
                                     <img src="<?php echo base_url("assets/app/img/user/02.jpg")?>" alt="Image" class="media-box-object img-circle thumb32">
                                  </div>
                                  <div class="media-box-body clearfix">
                                     <strong class="media-box-heading text-primary">Fernando Rodrigues</strong>
                                  </div>
                               </div>
                            </a>
                          <!-- END list group item-->
                     </div>
                  </div>
                  <div class="col-xs-12 col-md-3">
                      <h3>Locações</h3>
                                              <!-- START list group-->
                         <div data-height="360" data-scrollable="" class="list-group">
                            <!-- START list group item-->
                            <a href="#" class="list-group-item">
                               <div class="media-box">
                                  <div class="pull-left">
                                     <img src="<?php echo base_url("assets/app/img/user/03.jpg")?>" alt="Image" class="media-box-object img-circle thumb32">
                                  </div>
                                  <div class="media-box-body clearfix">
                                     <strong class="media-box-heading text-primary">
                                        Patrícia</strong>
                                  </div>
                               </div>
                            </a>
                            <!-- END list group item-->
                     </div>
                  </div>
                  <div class="col-xs-12 col-md-3">
                      <h3>Telefone</h3>
                                              <!-- START list group-->
                         <div data-height="360" data-scrollable="" class="list-group">
                            <!-- START list group item-->
                            <a href="#" class="list-group-item">
                               <div class="media-box">
                                  <div class="pull-left">
                                     <img src="<?php echo base_url("assets/app/img/user/02.jpg")?>" alt="Image" class="media-box-object img-circle thumb32">
                                  </div>
                                  <div class="media-box-body clearfix">
                                     <strong class="media-box-heading text-primary">
                                        Fernando Rodrigues</strong>
                                  </div>
                               </div>
                            </a>
                            <!-- END list group item-->
                             <!-- START list group item-->
                            <a href="#" class="list-group-item">
                               <div class="media-box">
                                  <div class="pull-left">
                                     <img src="<?php echo base_url("assets/app/img/user/03.jpg")?>" alt="Image" class="media-box-object img-circle thumb32">
                                  </div>
                                  <div class="media-box-body clearfix">
                                     <strong class="media-box-heading text-primary">
                                        Patrícia</strong>
                                  </div>
                               </div>
                            </a>
                            <!-- END list group item-->
                     </div>
                  </div>
                  <div class="col-xs-12 col-md-3">
                      <h3>E-mail</h3>
                                              <!-- START list group-->
                         <div data-height="360" data-scrollable="" class="list-group">
                            <!-- START list group item-->
                            <a href="#" class="list-group-item">
                               <div class="media-box">
                                  <div class="pull-left">
                                     <img src="<?php echo base_url("assets/app/img/user/02.jpg")?>" alt="Image" class="media-box-object img-circle thumb32">
                                  </div>
                                  <div class="media-box-body clearfix">
                                     <strong class="media-box-heading text-primary">
                                        Fernando Rodrigues</strong>
                                  </div>
                               </div>
                            </a>
                            <!-- END list group item-->
                             <!-- START list group item-->
                            <a href="#" class="list-group-item">
                               <div class="media-box">
                                  <div class="pull-left">
                                     <img src="<?php echo base_url("assets/app/img/user/03.jpg")?>" alt="Image" class="media-box-object img-circle thumb32">
                                  </div>
                                  <div class="media-box-body clearfix">
                                     <strong class="media-box-heading text-primary">
                                        Patrícia</strong>
                                  </div>
                               </div>
                            </a>
                            <!-- END list group item-->
                     </div>
                  </div>
                </div>
              </div>
          </div>
       </div>
       <!-- END dashboard main content-->
       <!-- START dashboard sidebar-->
       <aside class="col-lg-3">
          <!-- START loader widget-->
          <div class="panel panel-default">
            <?php
                $dados_locacoes_ano = Dashboard_model::getLocacoesAno();
            ?>
             <div class="panel-body">
                <div class="text-info">Percentual de POS locados</div>
                <canvas data-classyloader="" data-percentage="<?php echo $dados_locacoes_ano->percentual?>" data-speed="20" data-font-size="40px" data-diameter="70" data-line-color="#2e3192" data-remaining-line-color="rgba(200,200,200,0.4)" data-line-width="10"
                data-rounded-line="true" class="center-block"></canvas>
             </div>
             <div class="panel-footer">
                <p class="text-muted">
                   <em class="fa fa-bar-chart"></em>
                   <span><?php echo date('Y')?></span>
                   <span class="text-dark"><?php echo $dados_locacoes_ano->total_locacoes_ano?></span>
                </p>
             </div>
          </div>
          <!-- END loader widget-->
          <!-- START messages and activity-->
          <div class="panel panel-default">
             <div class="panel-heading">
                <div class="panel-title">Quantidade de POS</div>
             </div>
             <!-- START list group-->
             <div class="list-group">
                <!-- START list group item-->
                <div class="list-group-item">
                   <div class="media-box">
                      <div class="pull-left">
                         <span class="fa-stack">
                            <em class="fa fa-circle fa-stack-2x text-info"></em>
                            <em class="fa fa-umbrella fa-stack-1x fa-inverse text-white"></em>
                         </span>
                      </div>
                      <div class="media-box-body clearfix">
                         <div class="media-box-heading"><a href="#" class="text-purple m0">LOCAÇÃO</a>
                         </div>
                         <p class="m0">
                            <small><?php echo Dashboard_model::getTotalImoveis("locacao")?>
                            </small>
                         </p>
                      </div>
                   </div>
                </div>
                <!-- END list group item-->
                <!-- START list group item-->
                <div class="list-group-item">
                   <div class="media-box">
                      <div class="pull-left">
                         <span class="fa-stack">
                            <em class="fa fa-circle fa-stack-2x text-info"></em>
                            <em class="fa fa-file-text-o fa-stack-1x fa-inverse text-white"></em>
                         </span>
                      </div>
                      <div class="media-box-body clearfix">
                         <div class="media-box-heading"><a href="#" class="text-info m0">VENDA</a>
                         </div>
                         <p class="m0">
                            <small><?php echo Dashboard_model::getTotalImoveis("venda")?>
                            </small>
                         </p>
                      </div>
                   </div>
                </div>
                <!-- END list group item-->
             </div>
             <!-- END list group-->
          </div>
          <!-- END messages and activity-->
       </aside>
       <!-- END dashboard sidebar-->
    </div>
 </div>