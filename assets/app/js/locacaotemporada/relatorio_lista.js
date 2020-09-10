function openModalDepositos(locacao){
	var returnurl = $("#returnurl").val();
	$.get(baseurl + "/locacaotemporada/getDadosLocacaoDepositos/"+locacao, null, function(response){

		$("#modalDepositos #referenciaImovel").html(response.imovel.creferencia);
		$("#modalDepositos #tituloImovel").html(response.imovel.ctitulo);
		var nomes_proprietarios = new Array();

		for (i in response.proprietarios){
			nomes_proprietarios.push(response.proprietarios[i].cadgrl.cnomegrl);
		}

		$("#tableListaDepositosFazer tbody").html("");
		$("#tableListaDepositosReceber tbody").html("");


		$("#modalDepositos #proprietariosImovel").html(nomes_proprietarios.join(", "));
		$("#modalDepositos #periodoLocacao").html("De " + response.locacao.data_inicial + " a " + response.locacao.data_final);
		$("#modalDepositos #locatarioLocacao").html(response.locatario.cnomegrl);
		$("#modalDepositos #valortotalLocacao").html("R$"+response.locacao.nvalor.replace(".",","));
		
		var btn_alterar_valor = "";
		var btn_alterar_data = "";
		var btn_confirmar_pagamento = "";
		var btn_reimprimir_boleto = "";
		var btn_novo_boleto = "";
		var input_valor = "";
		var input_data = "";
		var total_depositos_receber = 0;
		var total_depositos_recebidos = 0;
		var total_depositos_pagar = 0;
		var total_depositos_pagos = 0;

		for (i in response.depositos_fazer){
			var deposito = response.depositos_fazer[i];
			btn_alterar_valor = "<div class='input-group-btn'><button type='button' class='btn btn-default alterar_valor' data-deposito='"+deposito.nidcadfin+"'>Alterar</button></div>";
			btn_alterar_data = "<div class='input-group-btn'><button type='button' class='btn btn-default alterar_data' data-deposito='"+deposito.nidcadfin+"'>Alterar</button></div>";
			if (deposito.pago == "1"){
				total_depositos_pagos += parseFloat(deposito.nvalor);
				btn_confirmar_pagamento = "<a href='#' title='Reverter pagamento' class='reverter' data-deposito='"+deposito.nidcadfin+"'><i class='fa fa-close'></i></a>";
				input_valor = "<input type='text' readonly='readonly' name='valor["+deposito.nidcadfin+"]' class='form-control inputValorDeposito' data-jmask='dinheiro' value='"+deposito.nvalor+"'>";
				input_data = "<input type='text' readonly='readonly' name='data_deposito["+deposito.nidcadfin+"]' class='inputDataDeposito form-control' value='"+deposito.ddatapagamento+"'>";
			} else {
				total_depositos_pagar += parseFloat(deposito.nvalor);
				btn_confirmar_pagamento = "<a href='#' title='Confirmar pagamento' class='confirmar' data-deposito='"+deposito.nidcadfin+"'><i class='fa fa-check'></i></a>";
				input_valor = "<input type='text' name='valor["+deposito.nidcadfin+"]' class='form-control inputValorDeposito' data-jmask='dinheiro' value='"+deposito.nvalor+"'>";
				input_data = "<input type='text' name='data_deposito["+deposito.nidcadfin+"]' class='inputDataDeposito form-control' value='"+deposito.ddatapagamento+"'>";
			}
			$("#modalDepositos #tableListaDepositosFazer").append("<tr><td width='10%'><span class='center-block label label-info'>"+deposito.forma_pagamento+"</span></td><td width='30%'><div class='input-group'><span class='input-group-addon'>R$</span>"+input_valor+btn_alterar_valor+"</div></td><td width='25%'><div class='input-group'>"+input_data+btn_alterar_data+"</div></td><td width='10%'><span class='center-block label label-primary'>"+deposito.tipo_financeiro+"</span></td><td width='10%'><span class='center-block label label-"+(deposito.status_pagamento_codigo == "ok" ? "success" : "danger")+"'>"+deposito.status_pagamento+"</span></td><td>"+btn_confirmar_pagamento+"</td></tr>");
		}

		for (i in response.depositos_receber){
			var deposito = response.depositos_receber[i];
			btn_alterar_valor = "<div class='input-group-btn'><button type='button' class='btn btn-default alterar_valor' data-deposito='"+deposito.nidcadfin+"'>Alterar</button></div>";
			btn_alterar_data = "<div class='input-group-btn'><button type='button' class='btn btn-default alterar_data' data-deposito='"+deposito.nidcadfin+"'>Alterar</button></div>";
			if (deposito.pago == "1"){
				total_depositos_recebidos += parseFloat(deposito.nvalor);
				input_valor = "<input type='text' readonly='readonly' name='valor["+deposito.nidcadfin+"]' class='form-control inputValorDeposito' data-jmask='dinheiro' value='"+deposito.nvalor+"'>";
				input_data = "<input type='text' readonly='readonly' name='data_deposito["+deposito.nidcadfin+"]' class='inputDataDeposito form-control' value='"+deposito.ddatapagamento+"'>";
				btn_confirmar_pagamento = "<a href='#' title='Reverter pagamento' class='reverter' data-deposito='"+deposito.nidcadfin+"'><i class='fa fa-close'></i></a>";
			} else {
				total_depositos_receber += parseFloat(deposito.nvalor);
				input_valor = "<input type='text' name='valor["+deposito.nidcadfin+"]' class='form-control inputValorDeposito' data-jmask='dinheiro' value='"+deposito.nvalor+"'>";
				input_data = "<input type='text' name='data_deposito["+deposito.nidcadfin+"]' class='inputDataDeposito form-control' value='"+deposito.ddatapagamento+"'>";
				btn_confirmar_pagamento = "<a href='#' title='Confirmar pagamento' class='confirmar' data-deposito='"+deposito.nidcadfin+"'><i class='fa fa-check'></i></a>";
				if (deposito.boleto){
					btn_reimprimir_boleto = "&nbsp;&nbsp;&nbsp;<a href='"+baseurl+"/boleto/boletocaixa?h="+deposito.boleto.chash+"' title='Reimprimir boleto' class='reimprimir-boleto' target='_blank'><i class='fa fa-barcode'></i></a>";
					btn_novo_boleto = "&nbsp;&nbsp;&nbsp;<a href='#' title='Novo boleto' class='novo-boleto' data-deposito='"+deposito.nidcadfin+"'><i class='fa fa-refresh'></i></a>";
				}
			}
			$("#modalDepositos #tableListaDepositosReceber").append("<tr><td width='10%'><span class='center-block label label-info'>"+deposito.forma_pagamento+"</span></td><td width='30%'><div class='input-group'><span class='input-group-addon'>R$</span>"+input_valor+btn_alterar_valor+"</div></td><td width='25%'><div class='input-group'>"+input_data+btn_alterar_data+"</div></td><td width='10%'><span class='center-block label label-primary'>"+deposito.tipo_financeiro+"</span></td><td width='10%'><span class='center-block label label-"+(deposito.status_pagamento_codigo == "ok" ? "success" : "danger")+"'>"+deposito.status_pagamento+"</span></td><td>"+btn_confirmar_pagamento+btn_reimprimir_boleto+btn_novo_boleto+"</td></tr>");
			if (deposito.boleto){
				$("#modalDepositos #tableListaDepositosReceber").append("<tr><td colspan='6'>Número do boleto: <span class='numero_boleto'>"+deposito.boleto.cnumerodocumento+"</span></td></tr>");
			}
		}

		for (i in response.despesas_receber){
			var deposito = response.despesas_receber[i];
			btn_alterar_valor = "<div class='input-group-btn'><button type='button' class='btn btn-default alterar_valor' data-deposito='"+deposito.nidcadfin+"'>Alterar</button></div>";
			btn_alterar_data = "<div class='input-group-btn'><button type='button' class='btn btn-default alterar_data' data-deposito='"+deposito.nidcadfin+"'>Alterar</button></div>";
			if (deposito.pago == "1"){
				total_depositos_recebidos += parseFloat(deposito.nvalor);
				input_valor = "<input type='text' readonly='readonly' name='valor["+deposito.nidcadfin+"]' class='form-control inputValorDeposito' data-jmask='dinheiro' value='"+deposito.nvalor+"'>";
				input_data = "<input type='text' readonly='readonly' name='data_deposito["+deposito.nidcadfin+"]' class='inputDataDeposito form-control' value='"+deposito.ddatapagamento+"'>";
				btn_confirmar_pagamento = "<a href='#' title='Reverter pagamento' class='reverter' data-deposito='"+deposito.nidcadfin+"'><i class='fa fa-close'></i></a>";
			} else {
				total_depositos_receber += parseFloat(deposito.nvalor);
				input_valor = "<input type='text' name='valor["+deposito.nidcadfin+"]' class='form-control inputValorDeposito' data-jmask='dinheiro' value='"+deposito.nvalor+"'>";
				input_data = "<input type='text' name='data_deposito["+deposito.nidcadfin+"]' class='inputDataDeposito form-control' value='"+deposito.ddatapagamento+"'>";
				btn_confirmar_pagamento = "<a href='#' title='Confirmar pagamento' class='confirmar' data-deposito='"+deposito.nidcadfin+"'><i class='fa fa-check'></i></a>";
			}
			$("#modalDepositos #tableListaDepositosReceber").append("<tr><td width='10%'><span class='center-block label label-info'>"+deposito.forma_pagamento+"</span></td><td width='30%'><div class='input-group'><span class='input-group-addon'>R$</span>"+input_valor+btn_alterar_valor+"</div></td><td width='25%'><div class='input-group'>"+input_data+btn_alterar_data+"</div></td><td width='10%'><span class='center-block label label-info'>"+deposito.tipo_financeiro+"</span></td><td width='10%'><span class='center-block label label-"+(deposito.status_pagamento_codigo == "ok" ? "success" : "danger")+"'>"+deposito.status_pagamento+"</span></td><td>"+btn_confirmar_pagamento+"</td></tr>");
		}

		$("#totalDepositosRecebidos").html("Recebido: R$"+total_depositos_recebidos.toFixed(2));
		$("#totalDepositosReceber").html("A receber: R$"+total_depositos_receber.toFixed(2));
		$("#totalDepositosPagos").html("Pagos: R$"+total_depositos_pagos.toFixed(2));
		$("#totalDepositosAPagar").html("A pagar: R$"+total_depositos_pagar.toFixed(2));

		$("#modalDepositos #tableListaDepositosFazer .inputDataDeposito, #modalDepositos #tableListaDepositosReceber .inputDataDeposito").datepicker({
			numberOfMonths: 1,
			dateFormat: 'dd/mm/yy',
		    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		    nextText: 'Próximo',
		    prevText: 'Anterior',
    	    beforeShow: function(i) {
		    	if ($(i).attr('readonly')) {
		    		return false;
		    	}
	    	}
		});

		resetDepositosButtons();

	}, "json")
}
function resetDepositosButtons(){
	/* Arrumar ações dos botões de alterar data e valor dos depósitos */
	var $ = jQuery;
	$("#modalDepositos #tableListaDepositosReceber .alterar_valor").unbind("click").click(function(){
		var deposito = $(this).attr("data-deposito");
		var valor = $(this).closest(".input-group").find(".inputValorDeposito").val();
		$.post(baseurl + "/locacaotemporada/alterarValor/"+deposito, {valor: valor}, function(response){
			alert(response);
			openModalDepositos($("#nidcadloc_deposito").val());
		}, "json");
	})
	$("#modalDepositos #tableListaDepositosReceber .alterar_data").unbind("click").click(function(){
		var deposito = $(this).attr("data-deposito");
		var data = $(this).closest(".input-group").find(".inputDataDeposito").val();
		$.post(baseurl + "/locacaotemporada/alterarData/"+deposito, {data: data}, function(response){
			alert(response);
			openModalDepositos($("#nidcadloc_deposito").val());
		}, "json");
	})
	$("#modalDepositos #tableListaDepositosReceber .novo-boleto").unbind("click").click(function(){
		var deposito = $(this).attr("data-deposito");
		var elemento = $(this);
		$.post(baseurl + "/locacaotemporada/novoBoleto/"+deposito, {nidcadfin: deposito}, function(response){
			alert(response.message);
			$(elemento).closest("tr").find(".numero_boleto").html(response.numero_boleto);
			openModalDepositos($("#nidcadloc_deposito").val());
		}, "json");
		return false;
	})
	$("#modalDepositos #tableListaDepositosFazer .alterar_valor").unbind("click").click(function(){
		var deposito = $(this).attr("data-deposito");
		var valor = $(this).closest(".input-group").find(".inputValorDeposito").val();
		$.post(baseurl + "/locacaotemporada/alterarValor/"+deposito, {valor: valor}, function(response){
			alert(response);
			openModalDepositos($("#nidcadloc_deposito").val());
		}, "json");
	})
	$("#modalDepositos #tableListaDepositosFazer .alterar_data").unbind("click").click(function(){
		var deposito = $(this).attr("data-deposito");
		var data = $(this).closest(".input-group").find(".inputDataDeposito").val();
		$.post(baseurl + "/locacaotemporada/alterarData/"+deposito, {data: data}, function(response){
			alert(response);
			openModalDepositos($("#nidcadloc_deposito").val());
		}, "json");
	})
	$("#modalDepositos .confirmar").unbind("click").click(function(){
		var deposito = $(this).attr("data-deposito");
		$.post(baseurl + "/locacaotemporada/confirmarPagamento/"+deposito, null, function(response){
			alert(response.message);
			openModalDepositos($("#nidcadloc_deposito").val());
		}, "json");
	})
	$("#modalDepositos .reverter").unbind("click").click(function(){
		var deposito = $(this).attr("data-deposito");
		if (confirm("Deseja realmente reverter o pagamento deste depósito?")){
			$.post(baseurl + "/locacaotemporada/reverterPagamento/"+deposito, null, function(response){
				alert(response.message);
				openModalDepositos($("#nidcadloc_deposito").val());
			}, "json");
		}
	})
}

jQuery(document).ready(function(){
	var $ = jQuery;
	$(".apagar-locacao").unbind('click').click(function(){
		if (!confirm("Deseja realmente excluir a locação? Esta operação é irreversível.")){
			return false;
		}
	})
	$(".cadastrar-despesa").click(function(){
		var locacao = $(this).attr("data-locacao");
		var returnurl = $("#returnurl").val();
		$.get(baseurl + "/locacaotemporada/getdespesas/"+locacao, null, function(response){
			$("#tableListaDespesas tbody").html("");
			for (i in response){
				$("#tableListaDespesas").append("<tr><td>"+response[i].prestador.cnomegrl+"</td><td>"+response[i].despesa.descricao+"</td><td><span class='valor label label-danger'>R$"+response[i].despesa.valor_prestador+"</span></td><td><span class='valor label label-primary'>R$"+response[i].despesa.valor_cobrado+"</span></td><td><a href='"+baseurl + "/locacaotemporada/excluirdespesa/" + response[i].despesa.id + "?returnurl="+returnurl+"' class='excluir'><span class='fa fa-trash'></span></a></td></tr>");
			}
		}, "json");
		$("#nidcadloc_despesa").val(locacao);
	})
	$(".cadastrar-deposito").click(function(){
		var locacao = $(this).attr("data-locacao");
		$("#nidcadloc_deposito").val(locacao);
		openModalDepositos(locacao);
	})
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
	if ($(".cadastrar-despesa[data-autoopen=1]").length){
		$(".cadastrar-despesa[data-autoopen=1]").trigger("click");
	}
	if ($(".cadastrar-servico[data-autoopen=1]").length){
		$(".cadastrar-servico[data-autoopen=1]").trigger("click");
	}
	$("#inputDataDespesa,#inputDataServico").datepicker({
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