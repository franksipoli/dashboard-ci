jQuery(document).ready(function($){
	$(".btn-status-comissao").unbind('click').click(function(){
		var comissao = $(this).attr("data-comissao");
		var botao = $(this);
		if ($(this).hasClass("btn-confirmar")){
			if (confirm("Deseja realmente confirmar o pagamento desta comissão?")){
				/* Confirmar o pagamento da comissão */
				$.get(baseurl + "/venda/confirmarcomissao/"+comissao, null, function(response){
					$(botao).closest("tr").find(".data_confirmacao_comissao").html(response.dtdatapagamento);
					$(botao).closest("tr").find(".btn-status-comissao").removeClass("btn-confirmar").addClass("btn-cancelar");
					$(botao).closest("tr").find(".fa-check").removeClass("fa-check").addClass("fa-times");
					alert('Confirmação realizada com sucesso');
				}, "json");
			}
		} else {
			if (confirm("Deseja realmente reverter o pagamento desta comissão?")){
				/* Cancelar a confirmação do pagamento da comissão */
				$.get(baseurl + "/venda/cancelarcomissao/"+comissao, null, function(response){
					$(botao).closest("tr").find(".data_confirmacao_comissao").html(response.dtdatapagamento);
					$(botao).closest("tr").find(".btn-status-comissao").removeClass("btn-cancelar").addClass("btn-confirmar");
					$(botao).closest("tr").find(".fa-times").removeClass("fa-times").addClass("fa-check");
					alert('Cancelamento realizado com sucesso');
				}, "json");
			}
		}
		return false;
	})
})