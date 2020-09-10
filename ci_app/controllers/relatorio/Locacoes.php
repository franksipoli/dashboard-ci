<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locacoes extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function locacoesexcluidas(){
		$this->load->model('cadimo/Locacaotemporada_model');
		$this->load->model('seg/Segusuario_model');
		$locacoes = $this->Locacaotemporada_model->getExcluidas();
		$this->title = "Relatório de locações excluídas - Muraski";

		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		//$this->enqueue_style('app/css/mensagem.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/relatorio/locacoesexcluidas.js');

		$this->data['locacoes'] = $locacoes;
		$this->data['usuarios'] = $this->Segusuario_model->getAll();
		$this->loadview('relatorios/locacoesexcluidas');
	}

	/**
	*	Função para retornar a lista de locações excluídas em json
	*	@access public
	*	@return json lista de locações excluídas
	*/
	
	public function excluidas_json()
	{

		$this->load->model('cadimo/Locacaotemporada_model');

		if ($this->input->get('usuario')){
			$params['usuario'] = $this->input->get('usuario');
		}

		// paginação
		$start 	= $this->input->get('iDisplayStart');
		$length = $this->input->get('iDisplayLength');

		$parameters = ($params) ? $params : NULL;

		$records = $this->Locacaotemporada_model->listar_excluidas_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadgrl;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Locacaotemporada_model->listar_excluidas_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Locacaotemporada_model->listar_excluidas_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);

	}

}