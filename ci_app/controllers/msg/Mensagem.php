<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensagem extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	/**
	* Função para listar as mensagens recebidas
	*/

	public function index(){
		$this->title = "Mensagens - Yoopay - Soluções Tecnológicas";
		
		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		$this->enqueue_style('app/css/mensagem.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/mensagem.js');

		if(!$this->data['show_tab']) $this->data['show_tab'] = 'inbox';

		$this->loadview('msg/mensagem_view');	
	}

	/**
	* Abre uma mensagem
	*/

	public function visualizar( $msg_id )
	{
		$this->title = 'Visualizar Mensagem - Yoopay - Soluções Tecnológicas';
		$this->msg = $this->Mensagem_model->visualizar( $msg_id );

		if( $this->msg->sender_id == $this->session->userdata('nidtbxsegusu')) $this->msg->sender_name = 'mim';
		$this->loadview('msg/visualizar_view');
	}

	/**
	* Abre a tela para inserção de um novo registro
	*/

	public function adicionar()
	{
		$this->load->model('seg/Segusuario_model');
		
		$this->title = 'Adicionar Mensagem - Yoopay - Soluções Tecnológicas';
		
		$this->enqueue_style('app/css/mensagem.css');
		$this->users = $this->Segusuario_model->list_all();
		$this->loadview('msg/adicionar_view');
	}

	/**
	* Função para gravar a mensagem na base de dados
	*/

	public function save()
	{
		$assunto_errors = array(
			'required'=>'O assunto é obrigatório.'
			,'min_length'=>'O assunto precisa ter no mínimo 5 caracteres.'
			,'max_length'=>'O assunto não pode ter mais que 100 caracteres.'
		);

		$mensagem_errors = array(
			'required'=>'A mensagem é obrigatóra.'
			,'min_length'=>'A mensagem precisa ter no mínimo 5 caracteres.'
			,'max_length'=>'A mensagem não pode ter mais que 500 caracteres.'
		);

		$this->form_validation->set_rules('assunto', 'Assunto', 'required|min_length[5]|max_length[100]', $assunto_errors);
		$this->form_validation->set_rules('mensagem', 'Mensagem', 'required|min_length[5]|max_length[500]', $mensagem_errors);
		$this->form_validation->set_rules('destinatarios', 'Destinatários', 'callback_hasDestinatarios');

		if ($this->form_validation->run() == FALSE)
		{
			$this->adicionar();
		}else{
			$this->Mensagem_model->assunto = $this->input->post('assunto');
			$this->Mensagem_model->msg_txt = $this->input->post('mensagem');
			$this->Mensagem_model->destinatarios = $this->input->post('destinatarios');
			
			$this->data['show_tab'] = 'outbox';

			if($this->Mensagem_model->save()){
				$this->index();
			}else{
				return false;
			}
		}
	}

	public function hasDestinatarios()
	{
		if(isset($_POST['destinatarios']) && count($_POST['destinatarios'] > 0) ) return true;
		$this->form_validation->set_message('hasDestinatarios', 'Escolha pelo menos um destinatário.');
		return false;
	}

	/**
	* Função para listar as mensagem recebidas
	*/

	public function list_inbox( $offset=0, $limit=10, $keyword=NULL )
	{
		if($list = $this->Mensagem_model->list_inbox( $offset, $limit, $keyword ))
		{
			$count = 0;
			foreach($list['records'] as $r)
			{
				$list['records'][$count]->DT_RowId = 'row_'.$r->msg_id;
				$list['records'][$count]->DT_RowClass = (!$r->readed) ? 'warning non-readed' : NULL;
				$count++;
			}

			$result['records'] = $list['records'];
			$result['recordsTotal'] = $list['recordsTotal'];
			$result['recordsFiltered'] = $list['recordsFiltered'];
			return $result;
		}
		return false;
	}

	/**
	* Função para listar as mensagem recebidas (para ajax)
	*/

	public function list_inbox_ajax()
	{
		$offset = $this->input->get('start');
		$limit = $this->input->get('length');
		$keyword = $this->input->get('search');

		$list = $this->list_inbox( $offset, $limit, $keyword['value'] );
		die(json_encode(array(
				'recordsTotal' => $list['recordsTotal']
				,'recordsFiltered' => $list['recordsFiltered']
				,'data' => $list['records']
				)
			)
		);

	}

	/**
	* Função checar novas mensagem recebidas (para ajax)
	*/

	public function check( $limit=5 )
	{
		$list = $this->Mensagem_model->check();
		$total = count($list);
		$rest = ($total-$limit > 0) ? $total-$limit : 0;

		die(json_encode(array(
				'total' => $total
				,'rest' => $rest
				,'data' => array_slice($list, 0, $limit)
				)
			)
		);

	}

	/**
	* Função para listar as mensagem enviadas
	*/

	private function list_send( $offset=0, $limit=10, $keyword=NULL )
	{
		return $this->Mensagem_model->list_send( $offset, $limit, $keyword );
	}


	/**
	* Função para listar as mensagem enviadas (para ajax)
	*/

	public function list_send_ajax($offset=0, $limit=10, $keyword=NULL )
	{
		$list = $this->list_send( $offset, $limit, $keyword );
		die(json_encode(array('data'=>$list)));

	}


	/**
	* Função para marcar a mensagem como lida
	*/

	public function mark_as_read()
	{
		$this->Mensagem_model->mensagem_id = $this->input->post('mensagem_id');
		return $this->Mensagem_model->mark_as_read();
	}

	/**
	* Função para marcar a mensagem como não lida
	*/

	public function mark_as_unread()
	{
		$this->Mensagem_model->mensagem_id = $this->input->post('mensagem_id');
		return $this->Mensagem_model->mark_as_unread();
	}

	/**
	* Função para "excluir" a mensagem na base de dados
	*/

	public function delete()
	{
		return $this->Mensagem_model->del( $this->input->post('msg_id') );
	}
	
}
