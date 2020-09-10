<!-- Modal -->
<div class="modal fade" id="modalLatitudeLongitude" tabindex="-1" role="dialog" aria-labelledby="modalLatitudeLongitude">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalImovelAtendimentoLabel">Selecionar ponto no mapa</h4>
          </div>
          <div class="modal-body">
            <div id="mapLatitudeLongitudeContainer">
            </div>
            <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Parametro_model::get('chave_api_maps')?>" async defer></script>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary adicionar-latitude-longitude-action">Adicionar</button>
          </div>
      </div>
  </div>
</div>