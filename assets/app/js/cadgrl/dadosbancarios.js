$(document).ready(function(){

	/* DATATABLES */

	var url = window.location.search.substring(1);

	$('#cadastro_lista.datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'bFilter': false
		,'order': [0,'asc']
		,'language': { url: '../../../assets/vendor/datatables/pt-br.json' }
		,'ajaxSource': '/cadgrl/Cadastro/listar_dadosbancarios_json/'+$("#nidcadgrl").val()+'?'+url
		,'columns': [
			{ 'render': render_icone, data: {'cicone': 'cicone'}, sortable:false},
			{ 'render': render_banco, data: {'cnomebco': 'cnomebco', 'nprincipal': 'nprincipal'}, sortable:false },
			{ 'render': render_vazio, data: 'ctitular', sortable:false },
			{ 'render': render_vazio, data: 'cagencia', sortable:false },
			{ 'render': render_vazio, data: 'cconta', sortable:false },
			{ 'render': render_vazio, data: 'cnometic', sortable:false },
			{ 'render': render_vazio, data: 'ccodtipoconta', sortable:false },
			{ 'render': render_principal, data: {'nidtagbco': 'nidtagbco', 'nprincipal': 'nprincipal'}, sortable:false },
			{ 'render': render_delete, data: 'nidtagbco', sortable:false }
		]
    });

    // banco (render)
	function render_banco(data, type, full){
		var result = "";
		if (data.nprincipal == 1){
			result += "<span class='label label-danger'>P</span> ";
		}
		result += data.cnomebco;
	    return result;
	}

	// ícone (render)
	function render_icone(data, type, full){
		if (data.cicone == "" || data.cicone == null)
			return "";
		return "<img src='"+baseurl + "/assets/app/img/banco/"+data.cicone+"' style='max-width: 36px; height: auto;'>";
	}

    // vazio (render)
	function render_vazio(data, type, full){
		if (data == "" || data === undefined || data==null)
			return "Não preenchido";
	    return data;
	}

	// principal (render)
	function render_principal(data){
	    if (data.nprincipal == 0){
			 return '<a href="/cadgrl/cadastro/tornarcontaprincipal/'+data.nidtagbco+'" onclick="if(confirm(\'Deseja realmente tornar esta conta a principal do cadastro?\')){ return true; }" title="Tornar principal"><span class="fa fa-star"></span></a>';
		} else {
			 return '<a href="/cadgrl/cadastro/desfazerprincipal/'+data.nidtagbco+'" onclick="if(confirm(\'Deseja realmente que esta conta não seja a principal do cadastro?\')){ return true; }" title="Tirar o título de principal"><span class="fa fa-star-o"></span></a>';
		}
	}

    // deletar (render)
	function render_delete(data){
	    return '<a href="/cadgrl/cadastro/removerdadobancario/'+data+'" onclick="return confirm(\'Deseja realmente excluir este dado bancário?\');" title="Excluir dado bancário"><span class="fa fa-trash"></span></a>';
	}

})
