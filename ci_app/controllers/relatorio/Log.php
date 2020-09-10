<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function visualizar(){

		$this->load->model('adm/Log_model');

		$this->load->model('seg/Segusuario_model');

		$this->title = "Logs do sistema - Muraski";

		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		//$this->enqueue_style('app/css/mensagem.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/relatorio/log.js');

		$this->data['usuarios'] = $this->Segusuario_model->getAll();
		$this->loadview('relatorios/log');
	}

	/**
	*	Função para retornar a lista de locações excluídas em json
	*	@access public
	*	@return json lista de locações excluídas
	*/
	
	public function log_json()
	{

		$this->load->model('adm/Log_model');

		if ($this->input->get('usuario')){
			$params['usuario'] = $this->input->get('usuario');
		}

		if ($this->input->get('entidade')){
			$params['entidade'] = $this->input->get('entidade');
		}

		// paginação
		$start 	= $this->input->get('iDisplayStart');
		$length = $this->input->get('iDisplayLength');

		$parameters = ($params) ? $params : NULL;

		$records = $this->Log_model->listar_log_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidtaglog;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Log_model->listar_log_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Log_model->listar_log_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);

	}

}