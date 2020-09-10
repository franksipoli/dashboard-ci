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
		$.post(baseurl + "/cadimo/imovel/getImovelAjaxView/"+$(this).attr("data-imovel"), {'data_inicial': $("#data_inicial").val(),'data_final': $("#data_final").val(),'neutralizar_calendario': $("#neutralizar_calendario").val() }, function(response){
			$("#panelImovel").fadeOut("fast", function(){
				$(this).html(response).fadeIn("fast");
				resetDatePicker();
				resetLocacaoButtons();
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

function resetLocacaoButtons(){
	var $ = jQuery;

	$(".adicionar-imovel-atendimento").click(function(){
		var imovel = $(this).attr("data-imovel");
		$("#modalImovelAtendimento #nidcadimo_atendimento").val(imovel);
		$.get(baseurl + "/ate/atendimento/getAtendimentosLocacao", null, function(response){
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

jQuery(document).ready(function(){
	
	var $ = jQuery;

	resetLocacaoButtons();

	calcularLarguraCarousel();

	imoveisCarousel();

	$(".carousel-resultado a").first().click();

	setInterval(function(){
		calcularLarguraCarousel()
	}, 1000);

	$("body").addClass("aside-collapsed");
	
	resetDatePicker();

})

function resetDatePicker(){
	var $ = jQuery;
if ($("#neutralizar_calendario").val() == "0"){
	
		$(".datepicker_container").each(function(){

			var dias_ocupados = $(this).attr("data-ocupado");
			var data_inicial = $("#data_inicial").val();

			if (!data_inicial || data_inicial === undefined){

				data_inicial = new Date();

			} else {

				var dt1   = parseInt(data_inicial.substring(0,2));
				var mon1  = parseInt(data_inicial.substring(3,5));
				var yr1   = parseInt(data_inicial.substring(6,10));
				data_inicial = new Date(yr1, mon1-1, dt1);
				data_inicial = new Date(data_inicial);

			}

			$(this).datepicker({
				numberOfMonths: [2, 1],
				dateFormat: 'dd/mm/yy',
			    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
			    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
			    defaultDate: data_inicial,
			    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
			    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
			    nextText: 'Próximo',
			    prevText: 'Anterior',
			    beforeShowDay: function(date) {

			    	var array_dias_ocupados = dias_ocupados.split(",");

			    	// GET YYYY, MM AND DD FROM THE DATE OBJECT
					var yyyy = date.getFullYear().toString();
					var mm = (date.getMonth()+1).toString();
					var dd  = date.getDate().toString();
					 
					// CONVERT mm AND dd INTO chars
					var mmChars = mm.split('');
					var ddChars = dd.split('');
					 
					// CONCAT THE STRINGS IN YYYY-MM-DD FORMAT
					var datestring = yyyy + '-' + (mmChars[1]?mm:"0"+mmChars[0]) + '-' + (ddChars[1]?dd:"0"+ddChars[0]);

			        if (array_dias_ocupados.indexOf(datestring) > -1) {
			            return [false, "ocupado"];
			        } else {
			            return [true, "livre"];
			        }
		    	}
			});
		});

	}
}