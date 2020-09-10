var passo;
var habilitar_clique = true;
function imoveisCarousel(){
	$("#carouselResultado").css("overflow-x", "hidden");
	passo = $(".carousel-resultado").width() / 10;
	$("#carouselResultado .controls .next").unbind("click").click(function(){
		if (!habilitar_clique)
			return false;
		habilitar_clique = false;
		$("#carouselResultado .carousel-wrapper").stop().animate({
			marginLeft: "-="+passo+"px"
		}, function(){
			checkBotoes();
			habilitar_clique = true;
		});
		return false;
	})
	$("#carouselResultado .controls .prev").unbind("click").click(function(){
		if (!habilitar_clique)
			return false;
		habilitar_clique = false;
		$("#carouselResultado .carousel-wrapper").stop().animate({
			marginLeft: "+="+passo+"px"
		}, function(){
			checkBotoes();
			habilitar_clique = true;
		});
		return false;
	})
	$("#carouselResultado .carousel-wrapper a").click(function(){
		$.post(baseurl + "/cadimo/imovel/getImovelAjaxViewVenda/"+$(this).attr("data-imovel"), {'data_inicial': $("#data_inicial").val(),'data_final': $("#data_final").val(),'neutralizar_calendario': $("#neutralizar_calendario").val() }, function(response){
			$("#panelImovel").fadeOut("fast", function(){
				$(this).html(response).fadeIn("fast");
				resetVendaButtons();
			})
		});
		return false;
	})
	checkBotoes();
	setInterval(function(){
		checkBotoes();
	}, 1000);
}

function checkBotoes(){
	var posicao_final = $("#carouselResultado .carousel-wrapper").offset().left + $("#carouselResultado .carousel-wrapper").width();
	var posicao_final_carousel = $("#carouselResultado").offset().left + $("#carouselResultado").width();
	if (posicao_final <= posicao_final_carousel){
		$("#carouselResultado .controls .next").addClass("disabled");
	} else {
		$("#carouselResultado .controls .next").removeClass("disabled");
	}
	var posicao_inicial = $("#carouselResultado .carousel-wrapper").offset().left;
	if (posicao_inicial >= 0){
		$("#carouselResultado .controls .prev").addClass("disabled");
	} else {
		$("#carouselResultado .controls .prev").removeClass("disabled");
	}
}

function calcularLarguraCarousel(){
	
	var $ = jQuery;

	var largura_total = 0;

	$(".carousel-resultado .carousel-wrapper img").each(function(){
		largura_total += $(this).width() + 4;
	})

	$(".carousel-resultado .carousel-wrapper").width(largura_total);

}

function checkCarouselInternoButtons(){
	$("#carouselImagensCliente .col-carousel-control .carouselint_next, #carouselImagensCliente .col-carousel-control .carouselint_prev").css("margin-top", $("#carouselImagensCliente .imgMain").height()/2 - 14);
	var active_img = $("#carouselImagensCliente .miniaturas .carouselFotosInternoWrapper").find(".active").first();
	if ($(active_img).index() > 0){
		$("#carouselImagensCliente .col-carousel-control .carouselint_prev").fadeIn();
	} else {
		$("#carouselImagensCliente .col-carousel-control .carouselint_prev").fadeOut();
	}
	if (($(active_img).index()+1) < $("#carouselImagensCliente .miniaturas .carouselFotosInternoWrapper").find("a").length){
		$("#carouselImagensCliente .col-carousel-control .carouselint_next").fadeIn();
	} else {
		$("#carouselImagensCliente .col-carousel-control .carouselint_next").fadeOut();
	}
}

function resetVendaButtons(){
	var $ = jQuery;
	$(".sinal").click(function(){
		var imovel = $(this).attr("data-imovel");
		$("#modalImovelSinal #nidcadimo").val(imovel);
		$.get(baseurl + "/cadimo/imovel/getImovelAjax/"+imovel, function(response){
			$("#modalImovelSinal #inputImovelNome").val(response.imovel.creferencia + " - " + response.imovel.ctitulo);
		}, "json");
	})

	$(".proposta").click(function(){
		var imovel = $(this).attr("data-imovel");
		$("#modalImovelProposta #nidcadimo").val(imovel);
		$.get(baseurl + "/cadimo/imovel/getImovelAjax/"+imovel, function(response){
			$("#modalImovelProposta #inputImovelNome").val(response.imovel.creferencia + " - " + response.imovel.ctitulo);
		}, "json");
	})

	$(".avaliacao").click(function(){
		$.get(baseurl + "/cadimo/imovel/adicionarAmostragemAvaliacao/" + $(this).attr("data-imovel"), null, function(response){
			alert(response);
		}, "json");
		return false;
	})

	$(".adicionar-imovel-atendimento").click(function(){
		var imovel = $(this).attr("data-imovel");
		$("#modalImovelAtendimento #nidcadimo_atendimento").val(imovel);
		$.get(baseurl + "/ate/atendimento/getAtendimentosVenda", null, function(response){
			if (response.length == 0){
				$("#nidcadate_lista").after("<p class='alert alert-danger'>Não há atendimentos abertos para seu cadastro</p>").remove();
				$("#modalImovelAtendimento .adicionar-imovel-atendimento-action").hide();
			} else {
				$("#modalImovelAtendimento .adicionar-imovel-atendimento-action").show();
				$("#nidcadate_lista").html("");
				for (i in response){
					$("#nidcadate_lista").append("<option value='"+response[i].nidcadate+"'>"+response[i].data+" - "+response[i].cadgrl.cnomegrl+"</option>");
				}
			}
		}, "json");
	})

	$(".link-proprietario").unbind('click').click(function(){
		var imovel = $(this).attr("data-imovel");
		$("#modalImovelProprietario tbody").html("");
		$.get(baseurl + "/cadimo/imovel/getProprietarios", {nidcadimo: imovel}, function(response){
			for (i in response){
				$("#modalImovelProprietario tbody").append("<tr>"
					+"<td>"+response[i].cadgrl.cnomegrl+"</td>"
					+"<td>"+response[i].cadgrl.ccpfcnpj+"</td>"
					+"<td>"+response[i].ipr.npercentual+"%</td>"
					+"<td><a href='"+baseurl + "/cadgrl/cadastro/visualizar/"+response[i].cadgrl.nidcadgrl+"'>Visualizar cadastro</a></td>"
				+"</tr>");
			}
		}, "json");
	})

	$(".link-angariador").unbind('click').click(function(){
		var imovel = $(this).attr("data-imovel");
		$("#modalImovelAngariador tbody").html("");
		$.get(baseurl + "/cadimo/imovel/getAngariadores", {nidcadimo: imovel}, function(response){
			for (i in response){
				$("#modalImovelAngariador tbody").append("<tr>"
					+"<td>"+response[i].segusu.cnome+"</td>"
					+"<td>"+response[i].segusu.cnome+"</td>"
					+"<td>"+response[i].ang.npercentual+"%</td>"
					+"<td></td>"
				+"</tr>");
			}
		}, "json");
	})

	$("#modalImovelAtendimento .adicionar-imovel-atendimento-action").unbind("click").click(function(){
		var imovel = $("#modalImovelAtendimento #nidcadimo_atendimento").val();
		var atendimento = $("#modalImovelAtendimento #nidcadate_lista").val();
		$.post(baseurl + '/ate/atendimento/adicionarImovel/'+imovel, {'nidcadate': atendimento}, function(response){
			alert("Produto adicionado com sucesso");
			$("#modalImovelAtendimento").modal('hide');
		});
	})

	$(".fotos-cliente").unbind("click").click(function(){

		var imovel_id = $(this).attr("data-imovel");

		if ($("#carouselImagensCliente").length == 0){
			$("body").append("<div id='carouselImagensCliente'>"
					+"<div class='topo'>"
						+"<div class='container-fluid'>"
							+"<div class='row'>"
								+"<div class='col-xs-10 col-sm-11'>"
									+"<h2 class='imovel-titulo'></h2>"
								+"</div>"
							+"<div class='col-xs-2 col-sm-1'>"
								+"<a href='#' class='closeModalFotosImovel'><i class='fa fa-times-circle'></i></a>"
							+"</div>"
						+"</div>"
					+"</div>"
					+"<div class='meio'>"
						+"<div class='container-fluid'>"
							+"<div class='row'>"
								+"<div class='col-xs-12 col-sm-3 col-imovel-info'>"
									+"<div class='panel panel-info'>"
										+"<div class='panel-heading'>"
											+"Informações"
										+"</div>"
										+"<div class='container-fluid panel-content informacoes'>"
										+"</div>"
									+"</div>"
								+"</div>"
								+"<div class='col-xs-12 col-sm-1 col-carousel-control text-center' style='display: none;'>"
									+"<a href='#' class='carouselint_prev'><i class='fa fa-chevron-circle-left'></i></a>"
								+"</div>"
								+"<div class='col-xs-12 col-sm-6 col-imovel-foto'>"
									+"<div class='imgMain'>"
										+"<a href='#' style='display: block;'>"
										+"</a>"
									+"</div>"
								+"</div>"
								+"<div class='col-xs-12 col-sm-1 col-carousel-control text-center' style='display: none;'>"
									+"<a href='#' class='carouselint_next'><i class='fa fa-chevron-circle-right'></i></a>"
								+"</div>"
								+"<div class='col-xs-12 col-sm-3 col-imovel-mapa'>"
									+"<div class='panel panel-info'>"
										+"<div class='panel-heading'>"
											+"Mapa"
											+"<a href='#' target='_blank' title='Navegar' class='navegar-mapa pull-right' data-original-title='Navegar no mapa'>"
				                              +"<em class='fa fa-plus'></em>"
				                            +"</a>"
										+"</div>"
										+"<div class='panel-content'>"
											+'<input type="hidden" id="latitude" value="">'
							                +'<input type="hidden" id="longitude" value="">'
							                +'<div id="map" style="width: 100%; height: 300px"></div>'
										+"</div>"
									+"</div>"
								+"</div>"
							+"</div>"
						+"</div>"
					+"</div>"
					+"<div class='miniaturas'>"
						+"<div class='carouselFotosInterno'>"
							+"<div class='controls'>"
								+"<a href='#' class='prev'><i class='fa fa-chevron-circle-left'></i></a>"
								+"<a href='#' class='next'><i class='fa fa-chevron-circle-right'></i></a>"
							+"</div>"
							+"<div class='carouselFotosInternoWrapper'>"
								+"<div class='container-carousel'>"
								+"</div>"
							+"</div>"
						+"</div>"
					+"</div>"
				+"</div>"
			+"</div>");
		}

		checkCarouselInternoButtons();

		$("#carouselImagensCliente .col-carousel-control .carouselint_next").unbind("click").click(function(){
			var active_img = $("#carouselImagensCliente .miniaturas .carouselFotosInternoWrapper").find(".active").first();
			$(active_img).removeClass("active");
			var next_img = $(active_img).next();
			$(next_img).addClass("active");
			var url = $(next_img).find("img").first().attr("src");
			$("#carouselImagensCliente .imgMain a").fadeOut("fast", function(){
				$(this).find("img").attr("src", url);
				$(this).fadeIn("fast");
			})
			checkCarouselInternoButtons();
			return false;
		})

		$("#carouselImagensCliente .col-carousel-control .carouselint_prev").unbind("click").click(function(){
			var active_img = $("#carouselImagensCliente .miniaturas .carouselFotosInternoWrapper").find(".active").first();
			$(active_img).removeClass("active");
			var prev_img = $(active_img).prev();
			$(prev_img).addClass("active");
			var url = $(prev_img).find("img").first().attr("src");
			$("#carouselImagensCliente .imgMain a").fadeOut("fast", function(){
				$(this).find("img").attr("src", url);
				$(this).fadeIn("fast");
			})
			checkCarouselInternoButtons();
			return false;			
		})

		$("#carouselImagensCliente .closeModalFotosImovel").unbind("click").click(function(){
			$("body").css("overflow", "auto");
			$("#carouselImagensCliente").fadeOut("fast", function(){
				$(this).remove();
			})
		})

		$("html,body").stop().animate({scrollTop: 0}, function(){
			$("body").css("overflow", "hidden");
			$("#carouselImagensCliente").width($(window).width());
			$("#carouselImagensCliente").height($(window).height());
			$("#carouselImagensCliente").fadeIn();
			$.get(baseurl + "/cadimo/imovel/getImovelAjax/" + imovel_id, null, function(response){
				$("#carouselImagensCliente .imgMain a").html("<img src='"+response.fotos[0]+"' class='img-responsive center-block'>");
				$("#carouselImagensCliente .carouselFotosInternoWrapper .container-carousel").html("");
				for (i in response.fotos){
					var classes = "";
					if (i == 0){
						classes = "active";
					}
					$("#carouselImagensCliente .carouselFotosInternoWrapper .container-carousel").append("<a href='#' class='"+classes+"' data-url='"+response.fotos[i]+"'><img src='"+response.fotos[i]+"'></a>");
				}
				setInterval(function(){
					var largura_total = 0;
					var i = 0;
					$("#carouselImagensCliente .container-carousel img").each(function(){
						largura_total += Math.floor($(this).width() + 1);
						if (i > 0){
							largura_total += 5;
						}
						i++;
					});
					$("#carouselImagensCliente .carouselFotosInternoWrapper .container-carousel").width(largura_total);
					checkNextPrev();
					checkCarouselInternoButtons();
				}, 500);

				$("#carouselImagensCliente .imgMain a").unbind("click").click(function(){
					if ($(this).hasClass("active")){
						$(this).removeClass("active");
						$("#carouselImagensCliente .col-imovel-foto").removeClass("col-sm-10").addClass("col-sm-6");
						$("#carouselImagensCliente .col-carousel-control").hide();
						$("#carouselImagensCliente .col-imovel-info").show();
						$("#carouselImagensCliente .col-imovel-mapa").fadeIn();
						$(".carouselFotosInternoWrapper img").stop().animate({'height': 100}, "fast");
						$("#carouselImagensCliente .miniaturas").stop().animate({'height': 130, 'padding': '15px 0'}, "fast");
					} else {
						$("#carouselImagensCliente .col-imovel-info").fadeOut("fast");
						$("#carouselImagensCliente .col-imovel-mapa").fadeOut("fast", function(){
							$(".carouselFotosInternoWrapper img").stop().animate({'height': 0}, "fast");
							$("#carouselImagensCliente .miniaturas").stop().animate({'height': 0, 'padding': 0}, "fast");
							$("#carouselImagensCliente .col-carousel-control").fadeIn();
							$("#carouselImagensCliente .col-imovel-foto").removeClass("col-sm-6").addClass("col-sm-10");
						})
						$(this).addClass("active");
					}
				})
				
				$("#carouselImagensCliente .carouselFotosInternoWrapper a").unbind("click").click(function(){
					var url = $(this).attr("data-url");
					$("#carouselImagensCliente .carouselFotosInternoWrapper a").removeClass("active");
					$(this).addClass("active");
					$("#carouselImagensCliente .imgMain a").fadeOut("fast", function(){
						$(this).find("img").attr("src", url);
						$(this).fadeIn("fast");
					})
					return false;
				})
				$("#carouselImagensCliente .informacoes").html("");
				$("#carouselImagensCliente .informacoes").append("<p class='descricao'>"+response.imovel.tdescricao+"</p>");
				$("#carouselImagensCliente .meio, #carouselImagensCliente .imgMain").height($(window).height() - 250);
				
				$(".navegar-mapa").attr("href", "");

				if (response.latitude && response.longitude){

					var myOptions = {
				        zoom: 16,
				        center: new google.maps.LatLng(parseFloat(response.latitude), parseFloat(response.longitude)),
				        mapTypeId: google.maps.MapTypeId.ROADMAP
				    };

				    var map = new google.maps.Map(document.getElementById("map"), myOptions);

				    var myLatLng = {lat: parseFloat(response.latitude), lng: parseFloat(response.longitude)};

				    var marker = new google.maps.Marker({
					    position: myLatLng,
					    map: map
				  	});

				  	$(".navegar-mapa").attr("href", "http://maps.google.com/?ll="+response.latitude+","+response.longitude+"&q="+response.latitude+","+response.longitude+"&z="+16);

				}
				$("#carouselImagensCliente .controls .prev").unbind("click").click(function(){
					$("#carouselImagensCliente .carouselFotosInternoWrapper .container-carousel").stop().animate({'marginLeft': '+=138px'}, "fast", function(){
						checkNextPrev();
					});
					return false;
				})
				$("#carouselImagensCliente .controls .next").unbind("click").click(function(){
					$("#carouselImagensCliente .carouselFotosInternoWrapper .container-carousel").stop().animate({'marginLeft': '-=138px'}, "fast", function(){
						checkNextPrev();
					});
					return false;
				})
				checkNextPrev();
			}, "json");

			$("#carouselImagensCliente .imovel-titulo").html($("#panelImovel .imovel_titulo").html());
		})		

		return false;
	})
}

function checkNextPrev(){
	var $ = jQuery;
	var diferenca_inicio = $("#carouselImagensCliente .carouselFotosInternoWrapper .container-carousel").offset().left - $("#carouselImagensCliente .carouselFotosInternoWrapper").offset().left;
	if (diferenca_inicio >= 0){
		$("#carouselImagensCliente .controls .prev").hide();
	} else {
		$("#carouselImagensCliente .controls .prev").show();
	}
	var diferenca_final = $("#carouselImagensCliente .carouselFotosInternoWrapper .container-carousel").offset().left + $("#carouselImagensCliente .carouselFotosInternoWrapper .container-carousel").width() - $("#carouselImagensCliente .carouselFotosInternoWrapper").offset().left - $("#carouselImagensCliente .carouselFotosInternoWrapper").width();
	if (diferenca_final <= 0){
		$("#carouselImagensCliente .controls .next").hide();
	} else {
		$("#carouselImagensCliente .controls .next").show();
	}

}

/**
	* Função que trata dos itens da aplicação de sinal, na pesquisa de imóveis para venda
*/

function aplicacaoSinal(){

	$("#modalImovelSinal").on('show.bs.modal', function(e){
		e.stopPropagation();
		atualizaListaSinal();
	})

	$("#modalImovelSinal").on('hidden.bs.modal', function(e){
		e.stopPropagation();
		var nidcadimo = $("#modalImovelSinal #nidcadimo").val();
		$(".imovel-item[data-imovel="+nidcadimo+"]").click();
		cancelarEdicaoSinal();
	})

	/* Autocomplete no campo do nome do comprador */

	var source_autocomplete = $("#nomecomprador").attr("data-action");

    $("#nomecomprador").autocomplete({
      source: source_autocomplete,
      minLength: 2,
      select: function( event, ui ) {
      	$("#modalImovelSinal .idcpfcomprador").val(ui.item.id);
      }
    });

    /* Datapicker na data do sinal */

	$("#inputDataSinal").datepicker({
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

	/* Cancelar a edição de um sinal */

	function cancelarEdicaoSinal(){
		$("#modalImovelSinal #nomecomprador").val("");
		$("#modalImovelSinal .idcpfcomprador").val("");
		$("#modalImovelSinal #inputDescricao").val("");
		$("#modalImovelSinal #inputDataSinal").val("");
		$("#modalImovelSinal #inputValorVenda").val("");
		$("#inputStatusSinal").val($("#inputStatusSinal").find("option").first().attr("value"));
		$("#modalImovelSinal #nidtbxsin").remove();
		$("#modalImovelSinal .cancelaredicao").remove();
	}

	/* Submit do formulário de cadastro de sinal */

	$("#modalImovelSinal form").submit(function(){
		var form_data = $(this).serialize();
		$.post(baseurl + "/venda/cadastrarsinal/"+$("#modalImovelSinal #nidcadimo").val(), {formdata: form_data}, function(response){
			if (response.success){
				$("#modalImovelSinal #nomecomprador").val("");
				$("#modalImovelSinal .idcpfcomprador").val("");
				$("#modalImovelSinal #inputDescricao").val("");
				$("#modalImovelSinal #inputDataSinal").val("");
				$("#modalImovelSinal #inputValorVenda").val("");
				$("#inputStatusSinal").val($("#inputStatusSinal").find("option").first().attr("value"));
				$("#modalImovelSinal #nidtbxsin").remove();
				$("#modalImovelSinal .cancelaredicao").remove();
			}
			alert(response.message);
			atualizaListaSinal();
		}, "json");
		return false;
	})

	/* Função que traz os sinais do back para o front */

	function atualizaListaSinal(){
		var nidcadimo = $("#modalImovelSinal #nidcadimo").val();
		$("#modalImovelSinal #tableListaSinais tbody").html("");
		$.get(baseurl + "/venda/getSinais/"+nidcadimo, null, function(response){
			if (response.length > 0){
				for (i in response){
					var btn_vender = "";
					if (response[i].status.cdescricao == "Confirmado"){
						btn_vender = '<a href="'+baseurl+'/venda/vender/'+response[i].nidtbxsin+'" class="vender"><i class="fa fa-gavel" aria-hidden="true"></i></a>';
					}
					var btn_contrato = "";
					if (response[i].contrato){
						btn_contrato = '<a href="'+response[i].contrato+'" title="Contrato" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
					}
					$("#modalImovelSinal #tableListaSinais tbody").append("<tr>"
						+"<td>"+response[i].comprador.cnomegrl+"</td>"
						+"<td>"+response[i].data+"</td>"
						+"<td>R$"+response[i].valor+"</td>"
						+"<td>"+response[i].vendedor+"</td>"
						+"<td>"+response[i].status.cdescricao+"</td>"
						+"<td>"+response[i].tdescricao+"</td>"
						+"<td>"+btn_vender+"</td>"
						+"<td>"+btn_contrato+"</td>"
						+"<td>"+'<a href="#" class="editar" data-sinal="'+response[i].nidtbxsin+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'+"</td>"
						+"<td>"+'<a href="#" class="excluir" data-sinal="'+response[i].nidtbxsin+'"><i class="fa fa-trash" aria-hidden="true"></i></a>'+"</td>"
						+"</tr>");
				}
				sinalBotoes();
			}
		}, "json");
	}

	/* Função que gerencia os botões da aplicação de sinal */

	function sinalBotoes(){
		
		/* Excluir um sinal */

		$("#modalImovelSinal .excluir").unbind("click").click(function(){
			if (confirm("Deseja realmente excluir este sinal de negócio?")){
				var linha = $(this).closest("tr");
				var sinal = $(this).attr("data-sinal");
				$.get(baseurl + "/venda/excluirSinal/"+sinal, null, function(response){
					$(linha).slideUp("fast", function(){
						$(this).remove();
						alert("Sinal excluído com sucesso");
					})
				}, "json");
			} 
			return false;
		})

		/* Editar um sinal */

		$("#modalImovelSinal .editar").unbind("click").click(function(){
			var sinal = $(this).attr("data-sinal");
			$.get(baseurl + "/venda/getSinal/"+sinal, null, function(response){
				if (response.error){
					alert("Erro ao tentar editar o sinal");
				} else {
					$("#modalImovelSinal #nomecomprador").val(response.cadgrl.cnomegrl);
					$("#modalImovelSinal .idcpfcomprador").val(response.cadgrl.nidcadgrl);
					$("#modalImovelSinal #inputDescricao").val(response.tdescricao);
					$("#modalImovelSinal #inputDataSinal").val(response.data);
					$("#modalImovelSinal #inputValorVenda").val(response.nvalor);
					$("#modalImovelSinal #inputStatusSinal").val(response.nidtbxssi);
					$("#modalImovelSinal").find("#nidtbxsin").remove();
					$("#modalImovelSinal").find(".cancelaredicao").remove();
					$("#modalImovelSinal form").append('<input type="hidden" id="nidtbxsin" name="nidtbxsin" value="'+response.nidtbxsin+'">');
					$("#modalImovelSinal .modal-footer").prepend('<button type="button" class="cancelaredicao btn btn-default">Cancelar edição</button>');
					$("#modalImovelSinal .cancelaredicao").unbind("click").click(function(){
						if (confirm("Deseja realmente cancelar a edição?")){
							cancelarEdicaoSinal();
						}
					})
				}
			}, "json");
			return false;
		})

	}

}

/**
	* Função que trata dos itens da aplicação de propostas, na pesquisa de imóveis para venda
*/

function aplicacaoProposta(){

	$("#modalImovelProposta").on('show.bs.modal', function(e){
		e.stopPropagation();
		atualizaListaProposta();
	})

	$("#modalImovelProposta").on('hidden.bs.modal', function(e){
		e.stopPropagation();
		var nidcadimo = $("#modalImovelProposta #nidcadimo").val();
		$(".imovel-item[data-imovel="+nidcadimo+"]").click();
		cancelarEdicaoProposta();
	})

	/* Autocomplete no campo do nome do comprador */

	var source_autocomplete = $("#modalImovelProposta #nomecliente").attr("data-action");

    $("#modalImovelProposta #nomecliente").autocomplete({
      source: source_autocomplete,
      minLength: 2,
      select: function( event, ui ) {
      	$("#modalImovelProposta .idcpfcliente").val(ui.item.id);
      }
    });

    /* Cancelar a edição de uma proposta */

	function cancelarEdicaoProposta(){
		$("#modalImovelProposta #nomecliente").val("");
		$("#modalImovelProposta .idcpfcliente").val("");
		$("#modalImovelProposta #inputDescricao").val("");
		$("#modalImovelProposta #inputDataProposta").val("");
		$("#inputStatusProposta").val($("#inputStatusProposta").find("option").first().attr("value"));
		$("#inputTipoProposta").val($("#inputTipoProposta").find("option").first().attr("value"));
		$("#modalImovelProposta #nidtbxpro").remove();
		$("#modalImovelProposta .cancelaredicao").remove();
	}

    /* Datapicker na data do sinal */

	$("#inputDataProposta").datepicker({
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

	/* Submit do formulário de cadastro de sinal */

	$("#modalImovelProposta form").submit(function(){
		var form_data = $(this).serialize();
		$.post(baseurl + "/venda/cadastrarproposta/"+$("#modalImovelProposta #nidcadimo").val(), {formdata: form_data}, function(response){
			if (response.success){
				$("#modalImovelProposta #nomecliente").val("");
				$("#modalImovelProposta .idcpfcliente").val("");
				$("#modalImovelProposta #inputDescricao").val("");
				$("#modalImovelProposta #inputDataProposta").val("");
				$("#inputTipoProposta").val($("#inputTipoProposta").find("option").first().attr("value"));
				$("#modalImovelProposta #nidtbxpro").remove();
				$("#modalImovelProposta .cancelaredicao").remove();
			}
			alert(response.message);
			atualizaListaProposta();
		}, "json");
		return false;
	})

	/* Função que traz as propostas do back para o front */

	function atualizaListaProposta(){
		var nidcadimo = $("#modalImovelProposta #nidcadimo").val();
		$("#modalImovelProposta #tableListaPropostas tbody").html("");
		$.get(baseurl + "/venda/getPropostas/"+nidcadimo, null, function(response){
			if (response.length > 0){
				for (i in response){
					if (response[i].nstatus == 1){
						var status = "Ativa";
						var btn_status = "";
					} else {
						var status = "Desativada";
						var btn_status = "";
					}
					$("#modalImovelProposta #tableListaPropostas tbody").append("<tr>"
						+"<td>"+response[i].cliente.cnomegrl+"</td>"
						+"<td>"+response[i].data+"</td>"
						+"<td>"+response[i].tdescricao+"</td>"
						+"<td>"+response[i].tipo+"</td>"
						+"<td>"+response[i].vendedor+"</td>"
						+"<td>"+status+"</td>"
						+"<td>"+btn_status+"</td>"
						+"<td>"+'<a href="#" class="editar" data-proposta="'+response[i].nidtbxpro+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'+"</td>"
						+"<td>"+'<a href="#" class="excluir" data-proposta="'+response[i].nidtbxpro+'"><i class="fa fa-trash" aria-hidden="true"></i></a>'+"</td>"
						+"</tr>");
				}
				propostaBotoes();
			}
		}, "json");
	}

	/* Função que gerencia os botões da aplicação de proposta */

	function propostaBotoes(){
		
		/* Excluir uma proposta */

		$("#modalImovelProposta .excluir").unbind("click").click(function(){
			if (confirm("Deseja realmente excluir esta proposta?")){
				var linha = $(this).closest("tr");
				var proposta = $(this).attr("data-proposta");
				$.get(baseurl + "/venda/excluirProposta/"+proposta, null, function(response){
					$(linha).slideUp("fast", function(){
						$(this).remove();
						alert("Proposta excluída com sucesso");
					})
				}, "json");
			} 
			return false;
		})

		/* Editar uma proposta */

		$("#modalImovelProposta .editar").unbind("click").click(function(){
			var proposta = $(this).attr("data-proposta");
			$.get(baseurl + "/venda/getProposta/"+proposta, null, function(response){
				if (response.error){
					alert("Erro ao tentar editar a proposta");
				} else {
					$("#modalImovelProposta #nomecliente").val(response.cadgrl.cnomegrl);
					$("#modalImovelProposta .idcpfcliente").val(response.cadgrl.nidcadgrl);
					$("#modalImovelProposta #inputDescricao").val(response.tdescricao);
					$("#modalImovelProposta #inputDataProposta").val(response.data);
					$("#modalImovelProposta #inputTipoProposta").val(response.nidtbxtpr);
					$("#modalImovelProposta #inputStatusProposta").val(response.nstatus);
					$("#modalImovelProposta form").find(".cancelaredicao").remove();
					$("#modalImovelProposta form").find("#nidtbxpro").remove();
					$("#modalImovelProposta form").append('<input type="hidden" id="nidtbxpro" name="nidtbxpro" value="'+response.nidtbxpro+'">');
					$("#modalImovelProposta .modal-footer").prepend('<button type="button" class="cancelaredicao btn btn-default">Cancelar edição</button>');
					$("#modalImovelProposta .cancelaredicao").unbind("click").click(function(){
						if (confirm("Deseja realmente cancelar a edição?")){
							cancelarEdicaoProposta();
						}
					})
				}
			}, "json");
			return false;
		})

	}

}

jQuery(document).ready(function(){
	
	var $ = jQuery;

	resetVendaButtons();

	calcularLarguraCarousel();

	imoveisCarousel();

	$(".carousel-resultado a").first().click();

	/*setInterval(function(){
		calcularLarguraCarousel()
	}, 1000);*/

	$("body").addClass("aside-collapsed");

	aplicacaoSinal();

	aplicacaoProposta();

})