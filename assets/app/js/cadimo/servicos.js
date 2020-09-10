$(document).ready(function(){

	autocomplete_prestador();

})

function autocomplete_prestador(){
	var source = $(".autocomplete-nomeprestador").attr("data-action");
    $(".autocomplete-nomeprestador").autocomplete({
      source: source,
      minLength: 2,
      select: function( event, ui ) {
        $("#nidcadgrl").val(ui.item.id);
      }
    });
}