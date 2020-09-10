jQuery(document).ready(function(){
	var $ = jQuery;
	
	/* DATATABLES */

	var url = window.location.search.substring(1);

	var nidcadimo = $("#nidcadimo").val();

	$('#chave_lista.datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'bFilter': false
		,'bPaginate': false
		,'order': [0,'asc']
		,'bSort': false
		,'language': { url: '../../../assets/vendor/datatables/pt-br.json' }
		,'ajaxSource': '/cadimo/imovel/chaves_json/'+nidcadimo+'?'+url
		,'columns': [
			{ 'render': render_nome, data: 'cnomelch' },
			{ 'render': render_codigo, data: {'creferencia': 'creferencia', 'nidcadchv': 'nidcadchv', 'nunidade': 'nunidade'} },
			{ 'render': render_nome, data: 'dtdatacriacao' },
			{ 'render': render_controle, data: {'nidcadchv': 'nidcadchv', 'ncontrole': 'ncontrole'}, sortable:false },
			{ 'render': render_delete, data: 'nidcadchv', sortable:false }
		]
		,'createdRow': function ( row, data, index ) {
        }
    });

    // nome (render)
	function render_nome(data, type, row){
		return data;
	}

	// controle (render)
	function render_controle(data, type, row){
		if (data.ncontrole != "1"){
			return "";
		}
		return '<a href="/cadimo/imovel/chaves_ata/'+data.nidcadchv+'" title="Ata da chave"><span class="fa fa-key"></span></a>';
	}

	// código (render)
	function render_codigo(data, type, row){
		if (!data.nunidade){
			data.nunidade = 1;
		}
		return data.creferencia + "." + data.nunidade + "." + data.nidcadchv;
	}

    // deletar (render)
	function render_delete(data){
	    return '<a href="/locacaotemporada/inquilinos_remove/'+data+'" onclick="return confirm(\'Deseja realmente excluir este inquilino?\');" title="Excluir inquilino"><span class="fa fa-trash"></span></a>';
	}

})