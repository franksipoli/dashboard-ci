$(document).ready(function(){

	/* DATE PICKER */

	$("#data_inicial").datepicker({
		numberOfMonths: 3,
		dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior',
	    onClose: function( selectedDate ) {
        	$( "#data_final" ).datepicker( "option", "minDate", selectedDate );
      	}
	});

	$("#data_final").datepicker({
		numberOfMonths: 3,
		dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior',
	    onClose: function( selectedDate ) {
        	$( "#data_inicial" ).datepicker( "option", "maxDate", selectedDate );
      	}
	});

	checkBairros();

	$("select[name=localizacao]").change(function(){
		checkBairros();
	})

	$(".open-list").click(function(){
		var lista = $(this).attr("data-list");
		if ($("#list-"+lista).hasClass("active")){
			$("#list-"+lista).slideUp("fast", function(){
				$(this).removeClass("active");
			});
		} else {
			$("#list-"+lista).slideDown("fast", function(){
				$(this).addClass("active");
			})
		}
		return false;
	})

})

function checkBairros(){
	var $ = jQuery;
	var loc = $("select[name=localizacao]").val();
	$(".bairro[data-localidade='"+loc+"']").show();
	$(".bairro").not("[data-localidade='"+loc+"']").hide();
}