jQuery(document).ready(function($){
	var altura_maior = 0;
	$(".widgets-caixas .widget").each(function(){
		if ($(this).height() > altura_maior){
			altura_maior = $(this).height();
		}
	})
	$(".widgets-caixas .widget").height(altura_maior);
})