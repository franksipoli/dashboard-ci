$(document).ready(function(){

	/* DATATABLES */

	var url = window.location.search.substring(1);

	var nidcadloc = $("#nidcadloc").val();

	$('#imovel_lista.datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'bFilter': false
		,'bPaginate': false
		,'order': [0,'asc']
		,'bSort': false
		,'language': { url: '../../../assets/vendor/datatables/pt-br.json' }
		,'ajaxSource': '/locacaotemporada/inquilinos_listar_json/'+nidcadloc+'?'+url
		,'columns': [
			{ 'render': render_nome, data: 'nome' },
			{ data: 'idade' },
			{ 'render': render_delete, data: 'nidcadinq', sortable:false }
		]
		,'createdRow': function ( row, data, index ) {
        }
    });

	$('#veiculo_lista.datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'bFilter': false
		,'bPaginate': false
		,'order': [0,'asc']
		,'bSort': false
		,'language': { url: '../../../assets/vendor/datatables/pt-br.json' }
		,'ajaxSource': '/locacaotemporada/veiculos_listar_json/'+nidcadloc+'?'+url
		,'columns': [
			{ data: 'modelo' },
			{ data: 'placa' },
			{ data: 'cor' },
			{ 'render': render_delete_veiculo, data: 'nidcadvei', sortable:false }
		]
		,'createdRow': function ( row, data, index ) {
        }
    });

    // nome (render)
	function render_nome(data, type, row){
		if (row.responsavel == 1){
			return "(Responsável) "+data;
		}
		return data;
	}

    // deletar (render)
	function render_delete(data){
	    return '<a href="/locacaotemporada/inquilinos_remove/'+data+'" onclick="return confirm(\'Deseja realmente excluir este inquilino?\');" title="Excluir inquilino"><span class="fa fa-trash"></span></a>';
	}

    // deletar (render)
	function render_delete_veiculo(data){
	    return '<a href="/locacaotemporada/veiculos_remove/'+data+'" onclick="return confirm(\'Deseja realmente excluir este veículo?\');" title="Excluir veículo"><span class="fa fa-trash"></span></a>';
	}

	$('#inquilinoResponsavel').on('change', function(event, state) {
		if ($(this).prop('checked')){
			$("#inquilinoResponsavelAdicionais").slideDown();
		} else {
			$("#inquilinoResponsavelAdicionais").slideUp();
		}
	});

	$('#inquilinoLocatarioResponsavel').on('change', function(event, state) {
		if ($(this).prop('checked')){
			$.get('/locacaotemporada/getDadosLocatario', {nidcadloc: $("#nidcadloc").val()}, function(response){
				$("#inquilinoNome").val(response.nome);
				$("#inquilinoIdade").val(response.idade);
				$("#inquilinoTelefone").val(response.telefone);
				$("#inquilinoRG").val(response.rg);
				$("#inquilinoCPF").val(response.cpf);
				$('#inquilinoCPF').mask('000.000.000-00', {reverse: true});
				$("#inquilinoDataNascimento").val(response.data_nascimento);
				$("#inquilinoCidade").val(response.cidade);
				$("#inquilinoUF").val(response.uf);
			}, "json");
		}
	});

})
