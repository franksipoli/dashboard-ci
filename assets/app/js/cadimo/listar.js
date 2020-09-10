$(document).ready(function(){

	  var url_proprietario = $("#input-nome-proprietario").attr("data-action");
	  $("#input-nome-proprietario").autocomplete({
	    source: url_proprietario,
	    minLength: 2,
	    select: function( event, ui ) {
	      $("#proprietarioid").val(ui.item.id);
	    }
	  });

	/* DATE PICKER */

	$('#datetimepicker0,#datetimepicker1,#datetimepicker2').datetimepicker({
		locale: moment.locale('pt-br'),
		format: 'DD/MM/YYYY',
		icons: {
			time: 'fa fa-clock-o',
			date: 'fa fa-calendar',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'fa fa-crosshairs',
			clear: 'fa fa-trash',
		}
    });

	/* DATATABLES */

	var url = window.location.search.substring(1);

	$('#imovel_lista.datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'bFilter': false
		,'order': [3,'desc']
		,'language': { url: '../../../assets/vendor/datatables/pt-br.json' }
		,'ajaxSource': '/cadimo/imovel/listar_json?'+url
		,'columns': [
			{ 'render': render_referencia, data: {'creferencia': 'creferencia', 'nunidade': 'nunidade'}, sortable: false },
			{ data: 'cnomefin' },
			{ data: 'cnometpi' },
			{ data: 'ctitulo' },
			{ 'render': render_datetime, data: 'dtdatacriacao' },
			//{ 'render': render_images, data: 'nidcadimo', sortable:false },
			//{ 'render': render_chaves, data: {'nidcadimo': 'nidcadimo'}, sortable:false },
			//{ 'render': render_pacotes, data: {'nidcadimo': 'nidcadimo'}, sortable:false },
			//{ 'render': render_relacao_bens, data: {'nidcadimo': 'nidcadimo'}, sortable:false },
			//{ 'render': render_servicos, data: {'nidcadimo': 'nidcadimo'}, sortable:false },
			{ 'render': render_edit, data: 'nidcadimo', sortable:false },
			{ 'render': render_view, data: 'nidcadimo', sortable:false },
			{ 'render': render_delete, data: 'nidcadimo', sortable:false }
		]
		,'createdRow': function ( row, data, index ) {
        }
    });

    // selecionar todos os registros (ação)
    $('.datatable .selectall input[type=checkbox]').on('click', function () { 
       var table = $(this).parents('table');
       var check = $('.msg_id', table);
       check.prop('checked', !check.prop('checked'));
	});

    // selecionar todos os registros (render)
	function render_checkbox(data, type, row){
		if (data == "" || data === undefined)
			return "";
	    return '<input type="checkbox" name="msg_id[]" class="msg_id" value="'+data+'" />';
	}

    // visualizar (render)
	function render_view(data, type, full){
		if (data == "" || data === undefined)
			return "";
	    return '<a href= "/cadimo/imovel/visualizar/'+data+'" title="Ver detalhes"><span class="fa fa-eye"></span></a>';
	}

    // email (render)
	function render_email(data, type, full){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="mailto:'+data+'" target="_blank">'+data+'</a>';
	}

    // referência (render)
	function render_referencia(data, type, full){
		if (data == "" || data === undefined)
			return "";
		if (data.nunidade == "" || data.nunidade === undefined || data.nunidade == null){
			return data.creferencia;
		} else {
			return data.creferencia + "&nbsp;<span class='label label-danger'>"+data.nunidade+"</span>";
		}
	}

    // serviços (render)
	function render_servicos(data, type, full){
		if (data == "" || data === undefined || data.codigo_finalidade != "loc")
			return "";
	    return '<a href="/cadimo/imovel/servicos/'+data.nidcadimo+'" title="Serviços"><span class="fa fa-wrench"></span></a>';
	}

    // visualizar (render)
	function render_edit(data, type, full){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="/cadimo/imovel/editar/'+data+'" title="Editar"><span class="fa fa-pencil"></span></a>';
	}

    // editar (images)
	function render_images(data, type, full){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="/cadimo/imovel/imagens/'+data+'" title="Editar imagens"><span class="fa fa-camera"></span></a>';
	}

	// editar (relação de bens)
	function render_relacao_bens(data, type, full){
		if (data == "" || data === undefined || data.codigo_finalidade != "loc")
			return "";
		return '<a href="/cadimo/imovel/bens/'+data.nidcadimo+'" title="Relação de bens"><span class="fa fa-cutlery"></span></a>';
	
	}
    // editar (chaves)
	function render_chaves(data, type, full){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="/cadimo/imovel/chaves/'+data.nidcadimo+'" title="Chaves"><span class="fa fa-key"></span></a>';
	}

    // editar (pacotes)
	function render_pacotes(data, type, full){
		if (data == "" || data === undefined || data.codigo_finalidade != "loc")
			return "";
	    return '<a href="/cadimo/imovel/pacotes/'+data.nidcadimo+'" title="Editar pacotes"><span class="fa fa-cubes"></span></a>';
	}

    // deletar (render)
	function render_delete(data){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="/cadimo/imovel/remove/'+data+'" onclick="return confirm(\'Deseja realmente excluir este Produto?\');" title="Excluir Produto"><span class="fa fa-trash"></span></a>';
	}

    // total (render)
	function render_total(data){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="">'+data+' pessoa(s)</a>';
	}

    // data e hora (render)
	function render_datetime(data){
		if (data == "" || data === undefined)
			return "";
	    var datetime = data.split(' ');
	    var date = datetime[0].split('-').reverse().join('/');
	    var time = datetime[1].substring(0,5);
	    return date+' às '+time;
	}



	/* TIPOS DE DATA */

	change_date($('#input-tipo-data'));
	$('#input-tipo-data').change(function(){ change_date($(this)) })

	function change_date(e){
		var tipo = e.val();
		$('.df1, .df2').hide();
		$('.date-field').hide();

		switch(tipo)
		{
			case 'nascimento':
				$('.df0').show();
				break;
			default:
				$('.df1, .df2').show();
				break;
		}
	}


})
