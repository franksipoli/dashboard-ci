function updateRemoverEnderecoButton(){
	
	$(".remover-endereco").unbind("click").click(function(){
		if ($(this).closest(".endereco").data("id") == "0"){
			$(this).closest(".endereco").find("input[type=text], select").val("");
			$(this).closest(".endereco").find(".idcidade").val("");
			checkEstados($(this).closest(".endereco").find("[name='pais[]']"));
		} else {
			$(this).closest(".endereco").slideUp("fast", function(){
				$(this).remove();
				resizeJquerySteps();
			})
		}
		return true;
	})
}

$(document).ready(function(){
	autocomplete_cidade();
	$(".adicionar-endereco").unbind("click").click(function(){
		var html = $(".endereco[data-id=0]").clone();
		var total = $(".endereco").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select").not("[name='pais[]']").val("");
		html.find(".resetarAutocompleteCidade").remove();
		html.find(".autocomplete-cidade").removeAttr("readonly").removeClass("ui-autocomplete-input");
		html.find(".idcidade").val("");
		html.prepend("<hr>");
		html.find(".select2-container").remove();
		html.find(".select-select2").removeClass("select2-hidden-accessible").removeAttr("tabindex").removeAttr("aria-hidden");
		// html.append('<div class="row"><div class="col-xs-12"><div class="form-group"><button type="button" class="remover-endereco btn btn-labeled btn-danger pull-right"><span class="btn-label"><i class="fa fa-times"></i></span>Remover este endereço</button></div></div></div>');
		$(".endereco").last().after(html);
		$(".endereco").last().find(".select-select2").select2();
		resizeJquerySteps();
		updateRemoverEnderecoButton();
		autocomplete_cidade();
		resetarAutocompleteCidade();
		checkEstados(html.find("[name='pais[]']"));
	})

	updateRemoverEnderecoButton();
	resetarAutocompleteCidade();

	updatePaisCheckEstados();

})

function resetarAutocompleteCidade(){
	var $ = jQuery;
	$(".resetarAutocompleteCidade").unbind("click").click(function(){
		var endereco = $(this).closest(".endereco");
		endereco.find(".autocomplete-cidade").removeAttr("readonly").val("");
		endereco.find(".idcidade").val("");
		$(this).remove();
		resizeJquerySteps();
		return false;
	})
}

function autocomplete_cidade(){
    $(".autocomplete-cidade").each(function(){
        var endereco = $(this).closest(".endereco");
        if ($(this).hasClass("ui-autocomplete-input"))
            return true;
        $(this).autocomplete({
          source: $(this).attr("data-action"),
          minLength: 2,
          select: function( event, ui ) {
            endereco.find(".idcidade").val(ui.item.id);
            endereco.find(".autocomplete-cidade").attr("readonly", "readonly").after('<a href="#" class="resetarAutocompleteCidade btn btn-danger btn-xs">[X]</a>');
            resetarAutocompleteCidade();
            resizeJquerySteps();
          }
        });
    })
}

function updatePaisCheckEstados(){
	checkEstados(null);
	$("[name='pais[]']").unbind('change').change(function(){
		checkEstados($(this));
	})
}

function checkEstados(pais_element){
	if (pais_element == null || pais_element === undefined){
		$(".endereco").each(function(){
			checkEstados($(this).find("[name='pais[]']").eq(0));
		})
	} else {
		var conta = $(pais_element).closest(".endereco");
		var pais = $(pais_element).val();
		var uf = $(conta).find("[name='uf']").val();
		var estado_atual = $(conta).find("[name='current_uf[]']").val();
		$(conta).find("[name='uf[]']").html("");
		$.get(baseurl+"/dep/uf/getByPais", { pais: pais }, function(response){
			$(conta).find("[name='uf[]']").append("<option></option>");
			for (i in response){
				if (response[i].nidtbxuf == estado_atual){
					var option = "<option value='"+response[i].nidtbxuf+"' selected='selected'>"+response[i].csiglauf+"</option>";
				} else {
					var option = "<option value='"+response[i].nidtbxuf+"'>"+response[i].csiglauf+"</option>";
				}
				$(conta).find("[name='uf[]']").append(option);
			}
		}, "json");
	}
}
