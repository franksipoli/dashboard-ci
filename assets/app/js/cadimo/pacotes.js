jQuery(document).ready(function(){
	var $ = jQuery;
	verificarCheckbox();
	$(".pacote input[type=checkbox]").change(function(){
		verificarCheckbox();
	})
})

function verificarCheckbox(){

	var $ = jQuery;
	$(".pacote").each(function(){
		if ($(this).find("input[type=checkbox]").is(":checked")){
			$(this).find("[readonly=readonly]").removeAttr("readonly");
			$(this).find("input[type=text]").attr("required", "required");
		} else {
			$(this).find("input[type=text]").attr("readonly", "readonly");
			$(this).find("input[type=text]").removeAttr("required");
		}
	})

}