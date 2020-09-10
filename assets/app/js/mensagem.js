$(document).ready(function(){

	/* BUSCA */

	// intervalo de datas (show/hide)
	$('#date').change(function(){
		$('.intervalo').hide();
		if($(this).val() == 3) $('.intervalo').show();
	})

	// intervalo de datas (datepicker)
	$(function () {
		$('#datetimepicker_start, #datetimepicker_end').datetimepicker({
			locale:'pt'
			,format: 'L'
			,maxDate: moment()
			,defaultDate: moment()
			});
	});

	/* TABS */

	$('.nav-tabs a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	})

	/* DATATABLES */

	// mensagens recebidas
	$('#recebidas .datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'order': [[3,'asc']]
		,'language': { url: '../assets/vendor/datatables/pt-br.json' }
		,'ajax': '/index.php/msg/mensagem/list_inbox_ajax'
		,'columns': [
		{ 'render': render_view, data: 'msg_id', sortable:false }
			//,{ render: render_checkbox, data: 'msg_id', sortable:false }
			,{ data: 'subject' }
			,{ data: 'sender_name' }
			,{ render: render_datetime, data: 'send_date' }
			,{ render: render_delete, data: 'msg_id', sortable:false }
		]
		,'createdRow': function ( row, data, index ) {
            if ( data[5] = 'hugo' ) {
                $('tr', row).addClass('highlight');
            }
        }
    });

	// mensagens enviadas
	$('#enviadas .datatable').dataTable({
		'order': [[3,'asc']]
		,'searching': false
		,'language': { url: '../assets/vendor/datatables/pt-br.json' }
		,'ajax': '/index.php/msg/mensagem/list_send_ajax'
		,'columns': [
		{ 'render': render_view, data: 'msg_id', sortable:false }
			//,{ render: render_checkbox, data: 'msg_id', sortable:false }
			,{ data: 'subject' }
			,{ data: 'msg_total' }
			,{ render: render_datetime, data: 'send_date' }
		]
	});

    // selecionar todas (ação)
    $('.datatable .selectall input[type=checkbox]').on('click', function () { 
       var table = $(this).parents('table');
       var check = $('.msg_id', table);
       check.prop('checked', !check.prop('checked'));
	});

    // selectionar todas (render)
	function render_checkbox(data, type, row){
	    return '<input type="checkbox" name="msg_id[]" class="msg_id" value="'+data+'" />';
	}

    // visualizar mensagem (render)
	function render_view(data, type, full){
	    //return '<a href="/msg/mensagem/visualizar/'+data+'" title="Abrir mensagen"><span class="fa fa-eye"></span></a>';
	    return '<a href="/index.php/msg/mensagem/visualizar/'+data+'" title="Abrir mensagen"><span class="fa fa-eye"></span></a>';
	}

    // deletar mensagem (render)
	function render_delete(data){
	    return '<a href="#" onclick="if(confirm(\'Deseja realmente apagar esta mensagem?\')){ delete_msg('+data+'); return false; }" title="Excluir mensagem"><span class="fa fa-trash"></span></a>';
	}

    // total de mensagens enviadas (render)
	function render_total(data){
	    return '<a href="">'+data+' pessoa(s)</a>';
	}

    // data e hora (render)
	function render_datetime(data){
	    var datetime = data.split(' ');
	    var date = datetime[0].split('-').reverse().join('/');
	    var time = datetime[1].substring(0,5);
	    return date+' às '+time;
	}
})
