var element_to_clone;

function updateRemoverProprietarioButton(){
	
	$(".remover-proprietario").unbind("click").click(function(){
		if ($(this).closest(".proprietario").data("id") == "0"){
			$(this).closest(".proprietario").find("[name='nomecpfproprietario[]'], [name='percentualproprietario[]'], [name='idcpfproprietario[]']").val("");
			$(this).closest(".proprietario").find(".resetarAutocomplete").remove();
			$(this).closest(".proprietario").find(".autocomplete-nomecpf").removeAttr("readonly");
		} else {
			$(this).closest(".proprietario").slideUp("fast", function(){
				$(this).prev("hr").remove();
				$(this).remove();
				resizeJquerySteps();
			})
		}
		return true;
	})
}

function updatePercentual(){
	$(".proprietario #percentualproprietario").unbind("blur").blur(function(){
		var percentual = parseFloat($(this).val());
		if (!isNaN(percentual)){
			$(this).val(percentual.toFixed(2));
		}
	})
}

$(document).ready(function(){

	element_to_clone = $(".proprietario[data-id=0]").clone();

	autocomplete_nomecpf();

	$(".adicionar-proprietario").unbind("click").click(function(){
		var total_percentual = 0;
		$(".proprietario").each(function(){
			var percentual = parseFloat($(this).find("#percentualproprietario").val());
			if (!isNaN(percentual))
				total_percentual += percentual;
		})
		var total_percentual_restante = 100 - total_percentual;
		var html = element_to_clone.clone();
		var total = $(".proprietario").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select, input[type=hidden]").val("");
		html.find(".resetarAutocomplete").remove();
		html.find(".autocomplete-nomecpf").removeAttr("readonly");
		html.prepend("<hr>");
		console.log(total_percentual);
		if (total_percentual_restante > 0){
			html.find("#percentualproprietario").val(total_percentual_restante.toFixed(2));
		} else {
			html.find("#percentualproprietario").val("0");
		}
		$(".proprietario").last().after(html);
		autocomplete_nomecpf();
		resizeJquerySteps();
		updateRemoverProprietarioButton();
		updatePercentual();
	})

	updateRemoverProprietarioButton();
	updatePercentual();
	resetarAutocomplete();	

})

function resetarAutocomplete(){
	var $ = jQuery;
	$(".resetarAutocomplete").unbind("click").click(function(){
		var proprietario = $(this).closest(".proprietario");
		proprietario.find(".autocomplete-nomecpf").removeAttr("readonly").val("");
		proprietario.find(".idcpfproprietario").val("");
		$(this).remove();
		resizeJquerySteps();
		return false;
	})
}

function autocomplete_nomecpf(){
    $(".autocomplete-nomecpf").each(function(){
        var proprietario = $(this).closest(".proprietario");
        if ($(this).hasClass("ui-autocomplete-input"))
            return true;
        $(this).autocomplete({
          source: $(this).attr("data-action"),
          minLength: 2,
          select: function( event, ui ) {
            proprietario.find(".idcpfproprietario").val(ui.item.id);
            proprietario.find(".autocomplete-nomecpf").attr("readonly", "readonly").after('<a href="#" class="resetarAutocomplete btn btn-danger btn-xs">[X]</a>');
            resetarAutocomplete();
            resizeJquerySteps();
          }
        });
    })
}