function updateRemoverObservacaoButton(){
	$(".remover-observacao").unbind("click").click(function(){
		if ($(this).closest(".observacao").data("id") == "0"){
			$(this).closest(".observacao").find("select, input[type=text], textarea").val("");
		} else {
			$(this).closest(".observacao").slideUp("fast", function(){
				$(this).prev("hr").remove();
				$(this).remove();
				resizeJquerySteps();
			})
		}
		return true;
	})
}

$(document).ready(function(){
	$(".adicionar-observacao").unbind("click").click(function(){
		var html = $(".observacao[data-id=0]").clone();
		var total = $(".observacao").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select, textarea").val("");
		html.prepend("<hr>");
		$(".observacao").last().after(html);
		resizeJquerySteps();
		updateRemoverObservacaoButton();
	})
	resizeJquerySteps();
	updateRemoverObservacaoButton();
})