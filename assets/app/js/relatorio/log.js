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

	$('#log_lista.datatable').dataTable({
		'processing': true
		,'serverSide': true
		,'bFilter': false
		,'language': { url: '../../../assets/vendor/datatables/pt-br.json' }
		,'ajaxSource': '/relatorio/log/log_json?'+url
		,'columns': [
			{ 'render': render_vazio, data: 'dtdata', sortable:false },
			{ 'render': render_vazio, data: 'cnome', sortable:false },
			{ 'render': render_vazio, data: 'centidade', sortable:false },
			{ 'render': render_vazio, data: 'citem', sortable:false },
			{ 'render': render_vazio, data: 'cacao', sortable:false }
		]
    });


    // vazio (render)
	function render_vazio(data, type, full){
		if (data == "" || data === undefined || data==null)
			return "Não preenchido";
	    return data;
	}


})
