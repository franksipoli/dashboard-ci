$(document).ready(function(){

	//if ($.isFunction('datetimepicker')){

		$('#datetimepicker1,#datetimepicker2').datetimepicker({
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

	//}

    if ($("#imoveis_relacionados").length){

    	$("#imoveis_relacionados .remove a").unbind('click').click(function(){
    		if (!confirm("Deseja realmente remover este Produto da lista?")){
    			return false;
    		}
    		return true;
    	})

    }

	/* BUSCA */

	/*

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

	*/

    // Nome do atendimento (render)
	function render_title(data, type, row){
	    return '<a href="/ate/atendimento/editar/'+data.nidcadate+'">'+data.title+'</a>';
	}

    // Nome e email do corretor (render)
	function render_corretor(data, type, row){
	    return (data.cdescriemail) 
	    	? data.cnomegrl+' (<a href="mailto:'+data.cdescriemail+'">'+data.cdescriemail+'</a>)'
	    	: data.cnomegrl;
	}

    // data e hora (render)
	function render_datetime(data){
	    var datetime = data.split(' ');
	    var date = datetime[0].split('-').reverse().join('/');
	    var time = datetime[1].substring(0,5);
	    return date+' às '+time;
	}

    // deletar mensagem (render)
	function render_status(data){
	    return '<span class="label label-info">'+data+'</span>';
	}

    // visualizar mensagem (render)
	function render_view(data, type, full){
	    //return '<a href="/msg/mensagem/visualizar/'+data+'" title="Abrir mensagen"><span class="fa fa-eye"></span></a>';
	    return '<a href="/ate/atendimento/editar/'+data+'" title="Visualizar atendimento"><span class="fa fa-eye"></span></a>';
	}

	/* DATATABLES */

	if($('.datatable').size() > 0)
	{
		var url = window.location.search.substring(1);

		$('#atendimentos .datatable').dataTable({
			'processing': true
			,'bFilter': false
			,'serverSide': true
			,'order': [[3,'asc']]
			,'language': { url: '/assets/vendor/datatables/pt-br.json' }
			,'ajax': '/ate/atendimento/listar_ajax?'+url
			,'columns': 
				[
					 { render: render_title, data: {'nidcadate': 'nidcadate', 'title': 'cnomegrl'} }
					,{ data: 'cdescritel' }
					,{ render: render_corretor, data: {'cnomegrl': 'cnomegrl', 'cdescriemail': 'cdescriemail'} }
					,{ render: render_datetime, data: 'didata' }
					,{ render: render_status, data: 'cstatus' }
					,{ render: render_view, data: 'nidcadate', sortable:false }
				]
			/*,'createdRow': function ( row, data, index ) {
	            if ( data[5] = 'hugo' ) {
	                $('tr', row).addClass('highlight');
	            }
	        }*/
	    });

	    $('#encontrados .datatable').dataTable();


	}


	// VALIDAÇÃO

	$('#atendimento').validate({
		rules:{
			telefone_tipo: { required: { depends: function(e){ return $('#telefone').val().length } } }
			,email_tipo: { required: { depends: function(e){ return $('#email').val().length } } }
		}
		,messages:{
			telefone_tipo : 'Escolha um tipo de telefone'
			,email_tipo : 'Escolha um tipo de e-mail'
		}
	});

	/* SELECIONAR IMÓVEIS */

	$('#imoveis_encontrados input[type="checkbox"]').change( function(e){
		var context = $('#imoveis_encontrados');
		var checked = $('input[type="checkbox"]:checked', context).length
		if(checked==0){
			$('.relacionar input[type="button"]', context).attr('disabled','disabled');
		}else{
			$('.relacionar input[type="button"]', context).removeAttr('disabled');
		}
	})


})
