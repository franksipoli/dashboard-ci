var element_to_clone_angariador;

function updateRemoverAngariadorButton(){
	
	$(".remover-angariador").unbind("click").click(function(){
		if ($(this).closest(".angariador").data("id") == "0"){
			$(this).closest(".angariador").find("[name='nomeangariador[]'], [name='percentualangariador[]'], [name='idangariador[]']").val("");
			$(this).closest(".angariador").find(".resetarAutocompleteAngariador").remove();
			$(this).closest(".angariador").find(".autocomplete-nome").removeAttr("readonly");
		} else {
			$(this).closest(".angariador").slideUp("fast", function(){
				$(this).prev("hr").remove();
				$(this).remove();
				resizeJquerySteps();
			})
		}
		return true;
	})
}

function updatePercentualAngariador(){
	$(".angariador #percentualangariador").unbind("blur").blur(function(){
		var percentual = parseFloat($(this).val());
		if (!isNaN(percentual)){
			$(this).val(percentual.toFixed(2));
		}
	})
}

$(document).ready(function(){

	element_to_clone_angariador = $(".angariador[data-id=0]").clone();

	autocomplete_nome();

	$(".adicionar-angariador").unbind("click").click(function(){
		var total_percentual = 0;
		$(".angariador").each(function(){
			var percentual = parseFloat($(this).find("#percentualangariador").val());
			if (!isNaN(percentual))
				total_percentual += percentual;
		})
		var total_percentual_restante = 100 - total_percentual;
		var html = element_to_clone_angariador.clone();
		var total = $(".angariador").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select, input[type=hidden]").val("");
		html.find(".resetarAutocompleteAngariador").remove();
		html.find(".autocomplete-nome").removeAttr("readonly");
		html.prepend("<hr>");
		console.log(total_percentual);
		if (total_percentual_restante > 0){
			html.find("#percentualangariador").val(total_percentual_restante.toFixed(2));
		} else {
			html.find("#percentualangariador").val("0");
		}
		$(".angariador").last().after(html);
		autocomplete_nome();
		resizeJquerySteps();
		updateRemoverAngariadorButton();
		updatePercentualAngariador();
	})

	resetarAutocompleteAngariador();
	updateRemoverAngariadorButton();
	updatePercentualAngariador();

})

function resetarAutocompleteAngariador(){
	var $ = jQuery;
	$(".resetarAutocompleteAngariador").unbind("click").click(function(){
		var angariador = $(this).closest(".angariador");
		angariador.find(".autocomplete-nome").removeAttr("readonly").val("");
		angariador.find(".idangariador").val("");
		$(this).remove();
		resizeJquerySteps();
		return false;
	})
}

function autocomplete_nome(){
    $(".autocomplete-nome").each(function(){
        var angariador = $(this).closest(".angariador");
        if ($(this).hasClass("ui-autocomplete-input"))
            return true;
        $(this).autocomplete({
          source: $(this).attr("data-action"),
          minLength: 2,
          select: function( event, ui ) {
            angariador.find(".idangariador").val(ui.item.id);
            angariador.find(".autocomplete-nome").attr("readonly", "readonly").after('<a href="#" class="resetarAutocompleteAngariador btn btn-danger btn-xs">[X]</a>');
            resetarAutocompleteAngariador();
            resizeJquerySteps();
          }
        });
    })
}