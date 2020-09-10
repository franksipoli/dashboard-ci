$(document).ready(function(){

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

	var nidcadloc = $("#imovel_lista.datatable").attr("data-nidcadloc");

	$('#imovel_lista.datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'bFilter': false
		,'order': [0,'desc']
		,'language': { url: '../../../assets/vendor/datatables/pt-br.json' }
		,'ajaxSource': '/locacaotemporada/contratos_json?nidcadloc='+nidcadloc+'&'+url
		,'columns': [
			{ 'render': render_datetime, data: 'data_criacao' },
			{ data: 'criado_por' },
			{ 'render': render_download, data: 'caminho', sortable:false }
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
	    return '<a href="/cadimo/imovel/visualizar/'+data+'" title="Ver detalhes"><span class="fa fa-eye"></span></a>';
	}

    // email (render)
	function render_email(data, type, full){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="mailto:'+data+'" target="_blank">'+data+'</a>';
	}

    // visualizar (render)
	function render_edit(data, type, full){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="/locacaotemporada/editar/'+data+'" title="Editar"><span class="fa fa-pencil"></span></a>';
	}

    // editar (contratos)
	function render_download(data, type, full){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="'+data+'" target="_blank" title="Abrir"><span class="fa fa-search"></span></a>';
	}

    // deletar (render)
	function render_delete(data){
		if (data == "" || data === undefined)
			return "";
	    return '<a href="/locacaotemporada/remove/'+data+'" onclick="return confirm(\'Deseja realmente excluir esta locação?\');" title="Excluir contrato"><span class="fa fa-trash"></span></a>';
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

    // data (render)
	function render_date(data){
		if (data == "" || data === undefined)
			return "";
	    var date = data.split('-').reverse().join('/');
	    return date;
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
