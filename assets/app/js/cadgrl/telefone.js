function updateRemoverTelefoneButton(){
	$(".remover-telefone").unbind("click").click(function(){
		if ($(this).closest(".telefone").data('id') == '0'){
			$(this).closest(".telefone").find("input[type=text]").val("");
			$(this).closest(".telefone").find("select").val("");
		} else {
			$(this).closest(".telefone").slideUp("fast", function(){
				$(this).remove();
				resizeJquerySteps();
			})
		}
		return false;
	})
}

$(document).ready(function(){
	$(".adicionar-telefone").unbind("click").click(function(){
		var html = $(".telefone[data-id=0]").clone();
		var total = $(".telefone").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select").val("");
		html.prepend("<hr>");
		$(".telefone").last().after(html);
		resizeJquerySteps();
		updateRemoverTelefoneButton();
	})
	updateRemoverTelefoneButton();
})