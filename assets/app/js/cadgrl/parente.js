function updateRemoverParenteButton(){
	$(".remover-parente").unbind("click").click(function(){
		$(this).closest(".parente").slideUp("fast", function(){
			$(this).remove();
			if ($(".parente").not("[data-id=-1]").length == 0){
				$(".adicionar-parente").click();
			}
			resizeJquerySteps();
		})
		return true;
	})
}

$(document).ready(function(){
	autocomplete_parente();
	$(".adicionar-parente").unbind("click").click(function(){
		var html = $(".parente[data-id=-1]").clone();
		var total = $(".parente").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select").val("");
		html.prepend("<hr>");
		html.find("select[name='h_tipoparentesco[]']").attr("name", "tipoparentesco[]");
		html.find("input[name='h_nome_parente[]']").attr("name", "nome_parente[]");
		html.find("input[name='h_parente_id[]']").attr("name", "parente_id[]");
		html.append('<div class="row"><div class="col-xs-12"><div class="form-group"><button type="button" class="remover-parente btn btn-labeled btn-danger pull-right"><span class="btn-label"><i class="fa fa-times"></i></span>Remover este parente</button></div></div></div>');
		$(".parente").last().after(html);
		$(".parente[data-id="+(parseInt(total)+1)+"]").slideDown("fast", function(){
			resizeJquerySteps();
			updateRemoverParenteButton();
		});
		resizeJquerySteps();
		updateRemoverParenteButton();
		autocomplete_parente();
		resetarAutocompleteParente();
	})
	updateRemoverParenteButton();
	resetarAutocompleteParente();
})

function resetarAutocompleteParente(){
	var $ = jQuery;
	$(".resetarAutocompleteParente").unbind("click").click(function(){
		var parente = $(this).closest(".parente");
		parente.find(".autocomplete-parente").removeAttr("readonly").val("");
		parente.find(".idparente").val("");
		$(this).remove();
		resizeJquerySteps();
		return false;
	})
}

function autocomplete_parente(){
    $(".autocomplete-parente").each(function(){
        if ($(this).closest(".parente").attr("data-id") == "-1"){
        	return true;
        }
        var parente = $(this).closest(".parente");
        if ($(this).hasClass("ui-autocomplete-input"))
            return true;
        $(this).autocomplete({
          source: $(this).attr("data-action"),
          minLength: 2,
          select: function( event, ui ) {
            parente.find(".idparente").val(ui.item.id);
            parente.find(".autocomplete-parente").attr("readonly", "readonly").after('<a href="#" class="resetarAutocompleteParente btn btn-danger btn-xs">[X]</a>');
            resetarAutocompleteParente();
            resizeJquerySteps();
          }
        });
    })
}