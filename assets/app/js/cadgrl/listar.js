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

	$('#cadastro_lista.datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'bFilter': false
		,'order': [5,'desc']
		,'language': { url: '../../../assets/vendor/datatables/pt-br.json' }
		,'ajaxSource': '/cadgrl/Cadastro/listar_json?'+url
		,'columns': [
			{ 'render': render_vazio, data: 'cnomegrl' },
			{ 'render': render_vazio, data: 'ccpfcnpj' },
			{ 'render': render_rgie, data: {'crgie': 'crgie', 'nieisento': 'nieisento'} },
			{ 'render': render_email, data: 'cdescriemail' },
			{ 'render': render_vazio, data: 'cdescritel' },
			{ 'render': render_datetime, data: 'dtdatacriacao' },
			{ 'render': render_banco, data: 'nidcadgrl', sortable:false },
			{ 'render': render_edit, data: 'nidcadgrl', sortable:false },
			{ 'render': render_view, data: 'nidcadgrl', sortable:false },
			{ 'render': render_delete, data: 'nidcadgrl', sortable:false }
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
	    return '<a href="/cadgrl/cadastro/visualizar/'+data+'" title="Ver detalhes"><span class="fa fa-eye"></span></a>';
	}

    // email (render)
	function render_email(data, type, full){
		if (data == "" || data === undefined || data==null)
			return "Não preenchido";
	    return '<a href="mailto:'+data+'" target="_blank">'+data+'</a>';
	}


    // vazio (render)
	function render_vazio(data, type, full){
		if (data == "" || data === undefined || data==null)
			return "Não preenchido";
	    return data;
	}

    // rg/ie (render)
	function render_rgie(data, type, full){
		if (data.crgie == "" || data.crgie === undefined || data.crgie==null){
			if (data.nieisento == "1"){
				return "Isento";
			} else {
				return "Não preenchido";
			}
		}
	    return data.crgie;
	}

    // dados bancários (render)
	function render_banco(data, type, full){
	    return '<a href="/cadgrl/cadastro/dadosbancarios/'+data+'" title="Dados bancários"><span class="fa fa-usd"></span></a>';
	}

    // visualizar (render)
	function render_edit(data, type, full){
	    return '<a href="/cadgrl/cadastro/editar/'+data+'" title="Editar"><span class="fa fa-pencil"></span></a>';
	}

    // deletar (render)
	function render_delete(data){
	    return '<a href="/cadgrl/cadastro/remove/'+data+'" onclick="return confirm(\'Deseja realmente excluir este cadastro geral?\');" title="Excluir cadastro geral"><span class="fa fa-trash"></span></a>';
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
