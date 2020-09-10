function updateRemoverContaButton(){
	$(".remover-conta").unbind("click").click(function(){
		if ($(this).closest(".conta").data('id') == 0){
			$(this).closest(".conta").find("input[type=text], input[type=hidden], select, input[type=number]").val("");
			$(this).closest(".conta").find("input[type=checkbox]").prop('checked', false);		
		} else {
			$(this).closest(".conta").slideUp("fast", function(){
				$(this).remove();
				resizeJquerySteps();
			})
		}
		return true;
	})
}

function setContaCheckbox(){
	var $ = jQuery;
	$("[name='principal[]']").each(function(){
		if ($(this).is(":checked")){
			$(this).closest(".conta").find("[name='principal_[]']").val("1");
		} else {
			$(this).closest(".conta").find("[name='principal_[]']").val("0");
		}
	})
	$("[name='principal[]']").change(function(){
		if ($(this).is(":checked")){
			$(this).closest(".conta").find("[name='principal_[]']").val("1");
		} else {
			$(this).closest(".conta").find("[name='principal_[]']").val("0");
		}
	})
}

$(document).ready(function(){
	setContaCheckbox();
	$(".adicionar-conta").unbind("click").click(function(){
		var html = $(".conta[data-id=0]").clone();
		var total = $(".conta").last().attr("data-id");
		html.attr("data-id", parseInt(total) + 1);
		html.find("input[type=text], select").val("");
		html.find("input[type=checkbox]").prop('checked', false).removeAttr("checked");
		html.find("input[name='principal_[]']").val("0");
		html.prepend("<hr>");
		$(".conta").last().after(html);
		resizeJquerySteps();
		updateRemoverContaButton();
		setContaCheckbox();
	})
	updateRemoverContaButton();
})