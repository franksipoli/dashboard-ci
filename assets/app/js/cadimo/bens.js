jQuery(document).ready(function(){
	var $ = jQuery;
	resetDrag();
	resetDrop();
	$(window).scroll(function(){
		if ($("body").scrollTop() > $(".container-grupos").offset().top){
			$(".container-grupos").css("padding-top", $("body").scrollTop() - $(".container-grupos").offset().top + 15);
		} else {
			$(".container-grupos").css("padding-top", 0);
		}
	})
	$("#modalBens").on('shown.bs.modal', function(){
		var cadimo = $("#nidcadimo").val();
		$.get(baseurl + "/cadimo/imovel/bensImpressao/"+cadimo, null, function(response){
			$("#modalBens .modal-body").html(response);
			$("#modalBens .print").click(function(){
				window.open(baseurl + "/cadimo/imovel/bens/"+cadimo+"?imprimir=1");
			})
		});
	})
	$("#inputNomeBem").on('keyup', function(){
		if ($(this).val() == ""){
			$(".lista-bens-alfabetica li").show();
		} else {
			$(".lista-bens-alfabetica li").hide();
			$(".lista-bens-alfabetica li[data-nome*='" + $(this).val().toUpperCase() + "']").show();
		}
	})
	$(".adicionar-bem").unbind("click").click(function(){
		var nome_bem = $("#inputAdicionarNomeBem").val();
		$.post(baseurl+"/cadimo/imovel/adicionarBem", {nome: nome_bem}, function(response){
			if (response.status == "ok"){
				$(".lista-bens-alfabetica").append("<li data-quantidade='1' data-nome='"+response.nome.toUpperCase()+"' data-bem='"+response.id+"'>"+response.nome+"</li>");
				$("#inputAdicionarNomeBem").val("");
				resetDrag();
				alert("Bem adicionado à lista");
			} else {
				alert(response.message);
			}
		}, "json");
	})
})

function atualizar_bens(){
	var cadimo = $("#nidcadimo").val();
	var params = new Array();
	$(".bens-imovel .grupo-bens").each(function(){
		var bens = new Array();
		$(this).find("li").each(function(){
			var informacoes = new Array();
			$(this).find("input[type=text]").each(function(){
				informacoes.push($(this).val());
			})
			bens.push({"nidtbxbem": $(this).attr("data-bem"), "quantidade": $(this).find("select").val(), "informacoes": informacoes.join("|")});
		})
		params.push({"grupo": $(this).attr("data-grupo"), "bens": bens});
	})
	$.post(baseurl + '/cadimo/imovel/atualizarbens/' + cadimo, {"params": params}, function(response){
	});
	$(".open-bens").unbind("click").click(function(){
		$(this).closest(".grupo-bens").find("ul").slideToggle();
		if ($(this).find("i").hasClass('fa-plus-square')){
			$(this).find("i").removeClass('fa-plus-square').addClass('fa-minus-square');
		} else {
			$(this).find("i").removeClass('fa-minus-square').addClass('fa-plus-square');
		}
		return false;
	})
}

function resetDrag(){
	$("li", $(" .lista-grupos .grupo-bens ul")).draggable({
		helper: 'clone',
		cursor: 'move',
		containment: 'document'
	});
	$(".grupo-bens", $(".content-wrapper .lista-grupos")).draggable({
		helper: 'clone',
		cursor: 'move',
		containment: 'document'
	});
	$("li", $(".lista-bens-alfabetica")).draggable({
		helper: 'clone',
		cursor: 'move',
		containment: 'document'
	})
}

function resetDrop(){
	var $ = jQuery;
	$(".adicionar-caracteristica").unbind('click').click(function(){
		$(this).closest("li").append("<div class='row'><div class='col-xs-1 text-center'><a href='#' class='pull-right remover-caracteristica' style='line-height: 33px;'><i class='fa fa-minus-square' aria-hidden='true'></i></a></div><div class='col-xs-11'><input type='text' name='caracteristicas[]' class='caracteristicas-bem' value=''></div></div>");
		resetDrop();
		return false;
	})
	$(".remover-caracteristica").unbind('click').click(function(){
		$(this).closest(".row").remove();
		resetDrop();
		return false;
	})
	$(".bens-imovel .grupo-bens:not(.avulsos), .bens-imovel .grupo-bens li").append("<a href='#' class='removeItem'><i class='fa fa-times'></i></a>");
	$(".bens-imovel .grupo-bens li").each(function(){
		if ($(this).find("select").length){
			return true;
		}
		$(this).append("<select name='qtde[]'></select>");
		for (i=1; i<=99;i++){
			$(this).find("select").append("<option value='"+i+"'>"+i+"</option>");
		}
		$(this).find("select").val($(this).attr("data-quantidade"));
		$(this).append("<a href='#' class='pull-right adicionar-caracteristica'><i class='fa fa-plus-square' aria-hidden='true'></i></a>");
		if ($(this).attr("data-info")){
			var informacoes = $(this).attr("data-info").split("|");
		} else {
			var informacoes = new Array("");
		}
		for (j=1;j<=informacoes.length;j++){
			var informacao;
			if (informacoes[j-1]){
				informacao = informacoes[j-1];
			} else {
				informacao = "";
			}
			if (j > 1){
				$(this).append("<div class='row'><div class='col-xs-1'><a href='#' class='pull-right remover-caracteristica' style='line-height: 33px;'><i class='fa fa-minus-square' aria-hidden='true'></i></a></div><div class='col-xs-11'><input type='text' name='caracteristicas[]' class='caracteristicas-bem' value='"+informacao+"'></div></div>");
			} else {
				$(this).append("<div class='row'><div class='col-xs-12'><input type='text' name='caracteristicas[]' class='caracteristicas-bem' value='"+informacao+"'></div></div>");
			}
		}
		resetDrop();
	})
	$(".bens-imovel .grupo-bens").on("change", "select", function(){
		/*
		var nova_quantidade = $(this).val();
		var quantidade_atual = $(this).closest("li").find("input[type=text]").length;
		if (nova_quantidade == quantidade_atual){
			return;
		} else if (nova_quantidade > quantidade_atual){
			var a_criar = nova_quantidade - quantidade_atual;
			for (i=1; i<=a_criar; i++){
				$(this).closest("li").append("<input type='text' name='caracteristicas[]' class='caracteristicas-bem'>");
			}
		} else {
			for (j=quantidade_atual; j>nova_quantidade; j--){
				$(this).closest("li").find("input[type=text]").eq(j-1).remove();
			}
		}
		*/
		resetDrop();
	})
	$(".bens-imovel .grupo-bens input[type=text]").unbind("blur").blur(function(){
		atualizar_bens();
	})
	$(".removeItem").unbind("click").click(function(){
		if (confirm("Deseja realmente excluir este item?")){
			if ($(this).closest("li").length){
				$(this).closest("li").fadeOut("fast", function(){
					$(this).remove();
					atualizar_bens();
				})
			} else if ($(this).closest(".grupo-bens:not(.avulsos)").length){
				$(this).closest(".grupo-bens:not(.avulsos)").fadeOut("fast", function(){
					$(this).remove();
					atualizar_bens();
				});
			}
		}
		return false;
	})
	$(".bens-imovel, .bens-imovel .grupo-bens").droppable({
      accept: ".grupo-bens, .grupo-bens li, .lista-bens-alfabetica li",
      activeClass: "ui-state-hover",
      hoverClass: "ui-state-active",
      tolerance: 'pointer',
      greedy: true,
      drop: function( event, ui ) {
      	if ($(this).hasClass("bens-imovel")){
			if ($(ui.draggable).is("li")){
				$(".bens-imovel .grupo-bens.avulsos ul").append(ui.draggable.clone());
			} else {
				$(".bens-imovel").find(".grupo-bens.avulsos").before(ui.draggable.clone());
			}
      	} else if ($(this).hasClass("grupo-bens")){
      		if ($(ui.draggable).is("li")){
      			$(this).find("ul").append(ui.draggable.clone());
      		} else if($(this).is(".grupo-bens")){
  				$(".bens-imovel .grupo-bens.avulsos").before(ui.draggable.clone());
      		}
      	}
  		resetDrop();
      }
    });
    atualizar_bens();
    $(".bens-imovel li select").unbind("change").change(function(){
    	atualizar_bens();
    })
}