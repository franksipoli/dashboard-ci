function updateRemoverEmailButton(){
	$(".remover-email").unbind("click").click(function(){
		if ($(this).closest(".email").data("id") == "0"){
			$(this).closest(".email").find("input[type=email]").val("");
			$(this).closest(".email").find("select").val("");
		} else {
			$(this).closest(".email").slideUp("fast", function(){
				$(this).remove();
				resizeJquerySteps();
			})
		}
		return false;
	})
}

$(document).ready(function(){
	$(".adicionar-email").unbind("click").click(function(){
		var html = $(".email[data-id=0]").clone();
		var total = $(".email").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select, input[type=email]").val("");
		html.prepend("<hr>");
		$(".email").last().after(html);
		resizeJquerySteps();
		updateRemoverEmailButton();
	})
	updateRemoverEmailButton();
})