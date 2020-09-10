function updateRemoverSocioButton(){
	$(".remover-socio").unbind("click").click(function(){
		$(this).closest(".socio").slideUp("fast", function(){
			$(this).remove();
			if ($(".socio").not("[data-id=-1]").length == 0){
				$(".adicionar-socio").click();
			}
			resizeJquerySteps();
		})
		return true;
	})
}

$(document).ready(function(){
	autocomplete_socio();
	$(".adicionar-socio").unbind("click").click(function(){
		var html = $(".socio[data-id=-1]").clone();
		var total = $(".socio").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select").val("");
		html.prepend("<hr>");
		html.find("input[name='h_nome_socio[]']").attr("name", "nome_socio[]");
		html.find("input[name='h_observacoes_socio[]']").attr("name", "observacoes_socio[]");
		html.find("input[name='h_socio_id[]']").attr("name", "socio_id[]");
		html.append('<div class="row"><div class="col-xs-12"><div class="form-group"><button type="button" class="remover-socio btn btn-labeled btn-danger pull-right"><span class="btn-label"><i class="fa fa-times"></i></span>Remover este sócio</button></div></div></div>');
		$(".socio").last().after(html);
		$(".socio[data-id="+(parseInt(total)+1)+"]").slideDown("fast", function(){
			resizeJquerySteps();
			updateRemoverSocioButton();
		});
		resizeJquerySteps();
		updateRemoverSocioButton();
		autocomplete_socio();
		resetarAutocompleteSocio();
	})
	updateRemoverSocioButton();
	resetarAutocompleteSocio();
})

function resetarAutocompleteSocio(){
	var $ = jQuery;
	$(".resetarAutocompleteSocio").unbind("click").click(function(){
		var socio = $(this).closest(".socio");
		socio.find(".autocomplete-socio").removeAttr("readonly").val("");
		socio.find(".idsocio").val("");
		$(this).remove();
		resizeJquerySteps();
		return false;
	})
}

function autocomplete_socio(){
    $(".autocomplete-socio").each(function(){
        if ($(this).closest(".socio").attr("data-id") == "-1"){
        	return true;
        }
        var socio = $(this).closest(".socio");
        if ($(this).hasClass("ui-autocomplete-input"))
            return true;
        $(this).autocomplete({
          source: $(this).attr("data-action"),
          minLength: 2,
          select: function( event, ui ) {
            socio.find(".idsocio").val(ui.item.id);
            socio.find(".autocomplete-socio").attr("readonly", "readonly").after('<a href="#" class="resetarAutocompleteSocio btn btn-danger btn-xs">[X]</a>');
            resetarAutocompleteSocio();
            resizeJquerySteps();
          }
        });
    })
}