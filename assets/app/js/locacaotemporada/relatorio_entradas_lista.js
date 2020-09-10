jQuery(document).ready(function(){
	var $ = jQuery;
	$(".cadastrar-servico").click(function(){
		var locacao = $(this).attr("data-locacao");
		var returnurl = $("#returnurl").val();
		$.get(baseurl + "/locacaotemporada/getservicos/"+locacao, null, function(response){
			$("#tableListaServicos tbody").html("");
			for (i in response){
				var status_pagamento = response[i].status_pagamento.cdescricao;
				if (response[i].status_pagamento.clabel != "" && response[i].status_pagamento.clabel != null){
					status_pagamento = "<span class='valor label "+response[i].status_pagamento.clabel+"'>" + status_pagamento;
				}
				if (response[i].status_pagamento.cdescricao == "PAGO"){
					$("#tableListaServicos").append("<tr><td>"+response[i].servico.data_servico+"</td><td>"+response[i].tiposervico.cdescritps+"</td><td><span class='valor label label-danger'>R$"+response[i].servico.valor_cobrado+"</span></td><td>"+status_pagamento+"</td><td><a href='"+baseurl + "/locacaotemporada/pagamento/" + response[i].servico.id +"?returnurl="+returnurl+"' class='recibo' title='Recibo'><span class='fa fa-file-pdf-o'></span></a></td><td><a href='" + baseurl + "/locacaotemporada/excluirservico/" + response[i].servico.id +"?returnurl="+returnurl+"' class='excluir'><span class='fa fa-trash'></span></a></td></tr>");
				} else {
					$("#tableListaServicos").append("<tr><td>"+response[i].servico.data_servico+"</td><td>"+response[i].tiposervico.cdescritps+"</td><td><span class='valor label label-danger'>R$"+response[i].servico.valor_cobrado+"</span></td><td>"+status_pagamento+"</td><td><a href='"+baseurl + "/locacaotemporada/pagamento/" + response[i].servico.id +"?returnurl="+returnurl+"' class='pagamento' title='Pagamento'><span class='fa fa-usd'></span></a></td><td><a href='" + baseurl + "/locacaotemporada/excluirservico/" + response[i].servico.id +"?returnurl="+returnurl+"' class='excluir'><span class='fa fa-trash'></span></a></td></tr>");
				}
				if (response[i].status_pagamento.clabel != "" && response[i].status_pagamento.clabel != null){
					status_pagamento = status_pagamento + "</span>";
				}
				$("#tableListaServicos .pagamento").unbind("click").click(function(){
					return confirm("Deseja realmente fazer o pagamento deste serviço e gerar o recibo? Esta operação é irreversível");
				})
			}
		}, "json");
		$("#nidcadloc_servico").val(locacao);
	})
	if ($(".cadastrar-servico[data-autoopen=1]").length){
		$(".cadastrar-servico[data-autoopen=1]").trigger("click");
	}
	$("#inputDataServico").datepicker({
		numberOfMonths: 3,
		dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior'
	});
})