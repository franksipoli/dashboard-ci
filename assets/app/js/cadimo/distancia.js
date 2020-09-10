function updateRemoverDistanciaButton(){
	$(".remover-distancia").unbind("click").click(function(){
		if ($(this).closest(".distancia").data("id") == "0"){
			$(this).closest(".distancia").find("input[type=text], select").val("");
		} else {
			$(this).closest(".distancia").slideUp("fast", function(){
				$(this).prev("hr").remove();
				$(this).remove();
				resizeJquerySteps();
			})
		}
		return true;
	})
}

$(document).ready(function(){
	$(".adicionar-distancia").unbind("click").click(function(){
		var html = $(".distancia[data-id=0]").clone();
		var total = $(".distancia").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select").val("");
		html.prepend("<hr>");
		$(".distancia").last().after(html);
		resizeJquerySteps();
		updateRemoverDistanciaButton();
	})
	resizeJquerySteps();
	updateRemoverDistanciaButton();
})