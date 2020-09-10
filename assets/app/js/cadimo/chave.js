jQuery(document).ready(function($){

	$("#btnRetirarChave").unbind("click").click(function(){
		var nidcadchv = $("#nidcadchv").val();
		$("#modalRetirarChave #ncodigo").val($("#ncodchv").val());
	})

	$("#btnDevolverChave").unbind("click").click(function(){
		var nidcadchv = $("#nidcadchv").val();
		$("#modalDevolverChave #ncodigo_devolucao").val($("#ncodchv").val());
	})

	$("#modalRetirarChave #btnConfirmarRetirada").unbind("click").click(function(){
		var nidcadchv = $("#nidcadchv").val();
		var idresponsavel = $("#modalRetirarChave .idresponsavel").val();
		var senha = $("#modalRetirarChave #senhaResponsavel").val();
		var observacoes = $("#modalRetirarChave #inputObservacoes").val();
		$.post(baseurl + "/cadimo/imovel/retirarchave/"+nidcadchv, {idresponsavel: idresponsavel, senha: senha, observacoes: observacoes}, function(response){
			if (response.success == 1){
				alert("Chave retirada com sucesso");
				location.reload();
			} else {
				alert(response.message);
			}
		}, "json");
	})

	$("#modalDevolverChave #btnConfirmarDevolucao").unbind("click").click(function(){
		var nidcadchv = $("#nidcadchv").val();
		var idresponsavel = $("#modalDevolverChave .idresponsavel_devolucao").val();
		var senha = $("#modalDevolverChave #senhaResponsavelDevolucao").val();
		$.post(baseurl + "/cadimo/imovel/devolverchave/"+nidcadchv, {idresponsavel: idresponsavel, senha: senha}, function(response){
			if (response.success == 1){
				alert("Chave devolvida com sucesso");
				location.reload();
			} else {
				alert(response.message);
			}
		}, "json");
	})

	/* DATATABLES */

	var url = window.location.search.substring(1);

	var nidcadchv = $("#nidcadchv").val();

	$('#chave_lista.datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'bFilter': false
		,'bPaginate': false
		,'order': [0,'asc']
		,'bSort': false
		,'language': { url: '../../../assets/vendor/datatables/pt-br.json' }
		,'ajaxSource': '/cadimo/imovel/chaves_ata_json/'+nidcadchv+'?'+url
		,'columns': [
			{ 'render': render_nome, data: 'dtdatacriacao' },
			{ 'render': render_nome, data: 'dtdatadevolucao' },
			{ 'render': render_nome, data: 'usuario_retirada' },
			{ 'render': render_nome, data: 'usuario_devolucao' },
			{ 'render': render_nome, data: 'cobservacoes' }
		]
		,'createdRow': function ( row, data, index ) {
        }
    });

    // nome (render)
	function render_nome(data, type, row){
		if (!data)
			return "-";
		return data;
	}

	/* Autocomplete no campo do nome de quem retira a chave */

	var source_autocomplete = $("#nomeresponsavel").attr("data-action");

    $("#nomeresponsavel").autocomplete({
      source: source_autocomplete,
      minLength: 2,
      select: function( event, ui ) {
      	$("#modalRetirarChave .idresponsavel").val(ui.item.id);
      }
    });

	/* Autocomplete no campo do nome de quem devolve a chave */

	var source_autocomplete_devolucao = $("#nomeresponsavel_devolucao").attr("data-action");

    $("#nomeresponsavel_devolucao").autocomplete({
      source: source_autocomplete_devolucao,
      minLength: 2,
      select: function( event, ui ) {
      	$("#modalDevolverChave .idresponsavel_devolucao").val(ui.item.id);
      }
    });

})