<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atendimento extends MY_Controller {

	public function __construct(){
		parent::__construct();
		// Atendimento por externo
		$this->load->model('seg/Segusuariotipo_model');
		$this->load->model('seg/Segusuario_model');
		//
		$this->load->model('ate/Atendimento_model');
		$this->load->model('ate/Statusatendimento_model');
		$this->load->model('dci/Finalidade_model');
		$this->load->model('dci/Tipomidia_model');
		$this->load->model('dci/Midia_model');
		$this->load->model('cadimo/Imovel_model');
		$this->user_id = $this->session->userdata('nidtbxsegusu');
		$this->date = date('Y-m-d H:i:s');
	}

	/**
	* Função para listar os atendimentos
	*/

	public function index(){
		$this->title = "Atendimento - Yoopay - Soluções Tecnológicas";

		$this->data['sat'] = $this->Statusatendimento_model->getAll();

		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		
		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		$this->enqueue_style('app/css/atendimento.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/atendimento.js');

		$this->loadview('ate/Atendimento_view');
	}

	/**
	* Abre a tela para inserção de um novo registro
	*/

	public function adicionar()
	{
		$this->load->model('dcg/Tipotelefone_model');
		$this->load->model('dcg/Tipoemail_model');
		$this->load->model('dcg/Comochegou_model');
		$this->load->model('seg/Segusuario_model');
		
		$this->title = 'Adicionar atendimento - Yoopay - Soluções Tecnológicas';
		
		$this->enqueue_script('app/js/atendimento.js');
		$this->enqueue_style('app/css/atendimento.css');

		$this->data['fin'] = $this->Finalidade_model->getAll();

		$this->users = $this->Segusuario_model->list_all(2);
		$this->telefone_tipo = $this->Tipotelefone_model->getAll();
		$this->email_tipo = $this->Tipoemail_model->getAll();
		$this->como_chegou = $this->Comochegou_model->getAll();
		
		$this->loadview('ate/Adicionar_view');
	}


	/**
	* Função para gravar a mensagem na base de dados
	*/

	public function email_type($str)
	{
		if($str && $this->input->post('email_tipo') < 1)
		{
			$this->form_validation->set_message('email_type', 'Você precisa escolher um tipo de e-mail.');
			return false;
		}
		return true;
	}

	public function save()
	{
		$tipo_errors = array(
			'required'=>'O tipo é obrigatório.'
		);

		$nome_errors = array(
			'required'=>'O nome é obrigatório.'
			,'min_length'=>'O nome precisa ter no mínimo 3 caracteres.'
			,'max_length'=>'O nome não pode ter mais que 100 caracteres.'
		);

		$telefone_errors = array(
			'required'=>'O telefone é obrigatório.'
			,'min_length'=>'O telefone precisa ter no mínimo 9 dígitos além do DDD.'
			,'max_length'=>'O telefone não pode ter mais que 10 dígitos.'
			,'numeric'=>'O tipo de telefone deve ser um valor numérico.'
		);

		$telefone_tipo_errors = array(
			'required'=>'O tipo de telefone é obrigatório.'
		);

		$email_errors = array(
			'valid_email'=>'Insira um e-mail válido.'
		);

		$corretor_errors = array(
			'required'=>'O Atendente obrigatório.'
			,'numeric'=>'O Atendente deve ser um valor numérico.'
		);

		$this->form_validation->set_rules('tipo', 'Tipo', 'required', $tipo_errors);
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required|min_length[3]|max_length[100]', $nome_errors);
		$this->form_validation->set_rules('telefone', 'Telefone', 'trim|required|min_length[14]|max_length[15]', $telefone_errors);
		$this->form_validation->set_rules('telefone_tipo', 'Tipo de telefone', 'required|numeric', $telefone_tipo_errors);
		$this->form_validation->set_rules('email', 'E-mail', 'valid_email|callback_email_type', $email_errors);
		$this->form_validation->set_rules('corretor', 'Atendente', 'required|numeric', $corretor_errors);

		if ($this->form_validation->run() == FALSE)
		{
			$this->adicionar();

		}else{

			// dados do cadastro geral

			$como_chegou = ($this->input->post('como_chegou') > 0) 
							? $this->input->post('como_chegou') 
							: NULL;

			$cadgrl_data = array(
				'nidtbxchg' => $como_chegou
				,'cnomegrl' => $this->input->post('nome')
				,'cobs' => $this->input->post('obs')
				,'nidtbxsegusu_criacao' => $this->user_id
				,'dtdatacriacao' => $this->date
				,'eatendimento' => 1 // Flag para que o cadastro não seja listado na lista de cadastros gerais até que se converta em uma venda/locação
				,'ctipopessoa' => 'f'
				,'ccpfcnpj' => '99999999999'
				,'crgie' => '99999'				
			);
			$cadgrl = $this->Atendimento_model->saveData('cadgrl', $cadgrl_data);

			// Telefone do cadastro geral

			$tagtel_data = array(
				'nidtbxttl' => $this->input->post('telefone_tipo')
				,'nidcadgrl' => $cadgrl
				,'cdescritel' => $this->input->post('telefone')
				,'ddatacriacao' => substr($this->date,0,10)
			);
			$tagtel = $this->Atendimento_model->saveData('tagtel', $tagtel_data);

			// E-mail do cadastro geral

			$tagema_data = array(
				'nidtbxtem' => $this->input->post('email_tipo')
				,'nidcadgrl' => $cadgrl
				,'cdescriemail' => $this->input->post('email')
				,'ddatacriacao' => substr($this->date,0,10)
			);
			$tagema = $this->Atendimento_model->saveData('tagema', $tagema_data);

			// Dados do atendimento

			$cadate_data = array(
				'nidcadgrl' => $cadgrl
				,'nidtbxsegusu' => $this->input->post('corretor')
				,'nidtbxsat' => $this->Statusatendimento_model->getByCodigo('nov')->nidtbxsat
				,'ddatastatus' => $this->date
				,'nlibera' => 1
				,'nidtbxfin' => $this->input->post('tipo')
				,'didata' => $this->date
			);
		
			if($nidcadate = $this->Atendimento_model->saveData('cadate', $cadate_data))
			{
				redirect('/ate/atendimento/editar/'.$nidcadate);

			}else{

				show_404();

			}
		}
	}

	/**
	* Função para adicionar Imóvel ao atendimento
	*/

	public function adicionarImovel($id){

		$nidcadate = $this->input->post('nidcadate');
		if ($nidcadate){
			$atendimento = $nidcadate;
		}

		$imovel = $this->Imovel_model->getById($id);

		if (!$atendimento){

			$atendimentos = $this->Atendimento_model->getAbertos($this->session->userdata('nidtbxsegusu'), $imovel->nidtbxfin);

		} else {

			$atendimentos = array($this->Atendimento_model->getById($atendimento));

		}

		foreach ($atendimentos as $atendimento){

			if (!$this->Atendimento_model->temAtendimentoImovel($atendimento->nidcadate, $id)){

				$data = array('nidcadate'=>$atendimento->nidcadate, 'nidcadimo'=>$id);

				$this->Atendimento_model->salvarImovel($data);

			}

		}

		$this->session->set_flashdata('sucesso', 'Imóvel adicionado com sucesso');

		redirect($this->input->get('ref'));

	}

	/**
	* Função para remover Imóvel ao atendimento
	*/

	public function removerimovel($cadate){

		$imovel = $this->Imovel_model->getById($this->input->get("imovel"));

		$this->Atendimento_model->removerImovel($cadate, $imovel->nidcadimo);

		$this->session->set_flashdata('sucesso', 'Imóvel removido da lista');

		redirect(makeUrl('ate', 'atendimento/editar', $cadate));

	}

	/**
	* Função para listar as mensagem recebidas
	*/

	public function listar( $offset=0, $limit=10, $data_ini=NULL, $data_end=NULL, $keyword=NULL )
	{
		if($list = $this->Atendimento_model->listar( $offset, $limit, $data_ini, $data_end, $keyword ))
		{
			$count = 0;
			foreach($list['records'] as $r)
			{
				$list['records'][$count]->DT_RowId = 'row_'.$r->nidcadate;
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
	* Função para listar os atendimentos (para ajax)
	*/

	public function listar_ajax()
	{
		$offset = $this->input->get('start');
		$limit = $this->input->get('length');

		if($type = trim($this->input->get('tipo'))) $params['type'] = $type;
		$params['status'] = ($this->input->get('status')) ? trim($this->input->get('status')) : NULL;

		$keyword = ($this->input->get('palavra')) ? trim($this->input->get('palavra')) : NULL;
		$keyword_field = ($this->input->get('campo')) ? trim($this->input->get('campo')) : NULL;

		if($keyword)
		{
			switch ($keyword_field) {
				case 'nome'		: $params['like']['g.cnomegrl'] = $keyword; break;
				case 'obs'		: $params['like']['g.cobs'] = $keyword; break;
				case 'telefone'	: $params['like']['t.cdescritel'] = $keyword; break;
				case 'corretor'	: $params['like']['ug.cnomegrl'] = $keyword; break;
				default:
					$params['like'] = array(
						'g.cnomegrl' => $keyword
						,'g.cobs' => $keyword
						,'t.cdescritel' => $keyword
						,'ug.cnomegrl' => $keyword
						);
				break;
			}
		}

		$date_start = (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', trim($this->input->get('datai')))) ? toDbDate(trim($this->input->get('datai'))) : NULL;
		$date_end = (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', trim($this->input->get('dataf')))) ? toDbDate(trim($this->input->get('dataf'))) : NULL;

		if($date_start && $date_end)
		{
			switch($this->input->get('tipo-data'))
			{
				case 'cadastro':
					$params['date']['a.didata >='] = $date_start;
					$params['date']['a.didata <='] = $date_end;
					break;

				case 'atendimento':
					$params['date']['a.dudata >='] = $date_start;
					$params['date']['a.dudata <='] = $date_end;
					break;
			}
		}
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Atendimento_model->listar_data( 'records', $offset, $limit, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadate;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Atendimento_model->listar_data( 'recordsTotal', $offset, $limit, $params )
				,'recordsFiltered' => $this->Atendimento_model->listar_data( 'recordsFiltered', $offset, $limit, $params )
				,'data' => $records
				)
			)
		);

	}

	
	/**
	* Abre a tela para editar o registro
	*/

	public function editar($ate_id)
	{
		
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		$this->enqueue_style('app/css/atendimento.css');
		
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/atendimento.js');

		$this->load->model('dcg/Tipotelefone_model');
		$this->load->model('dcg/Tipoemail_model');
		$this->load->model('dcg/Comochegou_model');
		$this->load->model('seg/Segusuario_model');

		$this->data['fin'] = $this->Finalidade_model->getAll();
		
		$this->title = 'Editar atendimento - Yoopay - Soluções Tecnológicas';
		
		$this->data['imoveis'] = $this->Atendimento_model->getImoveis($ate_id);	

		$this->load->model('cadimo/Avaliacao_model');

		$this->data['avaliacoes'] = $this->Avaliacao_model->getByAtendimento($ate_id);

		$this->users = $this->Segusuario_model->list_all(2);
		$this->telefone_tipo = $this->Tipotelefone_model->getAll();
		$this->email_tipo = $this->Tipoemail_model->getAll();
		$this->como_chegou = $this->Comochegou_model->getAll();

		$this->data['sat'] = $this->Statusatendimento_model->getAll();

		if($this->ate = $this->Atendimento_model->visualizar( $ate_id )){
			$this->loadview('ate/Atualizar_view');
		}else{
			show_404();
		}

		
	}


	/**
	* Função para atualizar o registro
	*/
	public function update()
	{

		$tipo_errors = array(
			'required'=>'O tipo é obrigatório.'
		);

		$nome_errors = array(
			'required'=>'O nome é obrigatório.'
			,'min_length'=>'O nome precisa ter no mínimo 3 caracteres.'
			,'max_length'=>'O nome não pode ter mais que 100 caracteres.'
		);

		$telefone_errors = array(
			'required'=>'O telefone é obrigatório.'
			,'min_length'=>'O telefone precisa ter no mínimo 9 dígitos além do DDD.'
			,'max_length'=>'O telefone não pode ter mais que 10 dígitos.'
			,'numeric'=>'O tipo de telefone deve ser um valor numérico.'
		);

		$telefone_tipo_errors = array(
			'required'=>'O tipo de telefone é obrigatório.'
		);

		$email_errors = array(
			'valid_email'=>'Insira um e-mail válido.'
		);

		$corretor_errors = array(
			'required'=>'O corretor obrigatório.'
			,'numeric'=>'O corretor deve ser um valor numérico.'
		);

		$this->form_validation->set_rules('tipo', 'Tipo', 'required', $tipo_errors);
		$this->form_validation->set_rules('nome', 'Nome', 'trim|required|min_length[3]|max_length[100]', $nome_errors);
		$this->form_validation->set_rules('telefone', 'Telefone', 'trim|required|min_length[14]|max_length[15]', $telefone_errors);
		$this->form_validation->set_rules('telefone_tipo', 'Tipo de telefone', 'required|numeric', $telefone_tipo_errors);
		$this->form_validation->set_rules('email', 'E-mail', 'valid_email|callback_email_type', $email_errors);
		$this->form_validation->set_rules('corretor', 'Corretor', 'required|numeric', $corretor_errors);

		if ($this->form_validation->run() == FALSE)
		{
			$this->editar( $this->input->post('atendimento_id') );
		}else{

			$where = array( 'nidcadgrl' => $this->input->post('cadastro_id') );

			// dados do cadastro geral

			$como_chegou = ($this->input->post('como_chegou') > 0) 
							? $this->input->post('como_chegou') 
							: NULL;

			$cadgrl_data = array(
				'nidtbxchg' => $como_chegou
				,'cnomegrl' => $this->input->post('nome')
				//,'ccpfcnpj' => $this->input->post('cpf_cnpj')
				//,'crgie' => $this->input->post('rg_ie')
				,'cobs' => $this->input->post('obs')
				//,'ccreci' => $this->input-post('creci')
				,'nidtbxsegusu_atualizacao' => $this->user_id
				,'dtdataatualizacao' => $this->date
			);
			$this->Atendimento_model->updateData('cadgrl', $where, $cadgrl_data);

			// Telefone do cadastro geral

			$tagtel_data = array(
				'nidtbxttl' => $this->input->post('telefone_tipo')
				,'cdescritel' => $this->input->post('telefone')
				,'ddataatualizacao' => substr($this->date,0,10)
			);
			$this->Atendimento_model->updateData('tagtel', $where, $tagtel_data);

			// E-mail do cadastro geral

			$tagema_data = array(
				'nidtbxtem' => $this->input->post('email_tipo')
				,'cdescriemail' => $this->input->post('email')
				,'ddataatualizacao' => substr($this->date,0,10)
			);
			$this->Atendimento_model->updateData('tagema', $where, $tagema_data);

			// Dados do atendimento

			$cadate_data = array(
				'nidtbxsegusu' => $this->input->post('corretor')
				,'nidtbxsat' => $this->input->post('nidtbxsat')
				,'ddatastatus' => $this->date
				,'nlibera' => $this->input->post('liberar') ? 1 : 0
				,'nidtbxfin' => $this->input->post('tipo')
				,'dudata' => $this->date
			);

			if($this->Atendimento_model->updateData('cadate', $where, $cadate_data))
			{
				redirect('/ate/atendimento');
			}else{
				show_404();
			}

		}

	}


	/**
	* Função para encontrar todos os corretores cadastrados
	*/

	public function corretores()
	{
		return $this->Atendimento_model->corretores();
	}

	/**
	* Função que traz todos os atendimentos abertos do usuário atual
	*/

	public function getAtendimentosLocacao(){
		$atendimentos = $this->Atendimento_model->getAbertos($this->user_id, Parametro_model::get('finalidade_locacao_id'));
		$result = array();
		$this->load->model('cadgrl/Cadastro_model');
		foreach ($atendimentos as $atendimento){
			$atendimento->data = toUserDateTime($atendimento->didata);
			$atendimento->cadgrl = $this->Cadastro_model->getById($atendimento->nidcadgrl, false);
			$result[] = $atendimento;
		}
		die(json_encode($result));
	}

	/**
	* Função que traz todos os atendimentos abertos do usuário atual (venda)
	*/

	public function getAtendimentosVenda(){
		$atendimentos = $this->Atendimento_model->getAbertos($this->user_id, Parametro_model::get('finalidade_venda_id'));
		$result = array();
		$this->load->model('cadgrl/Cadastro_model');
		foreach ($atendimentos as $atendimento){
			$atendimento->data = toUserDateTime($atendimento->didata);
			$atendimento->cadgrl = $this->Cadastro_model->getById($atendimento->nidcadgrl, false);
			$result[] = $atendimento;
		}
		die(json_encode($result));
	}


/* Funcoes para REQUEST Externo */

	/**
	* Função para adicionar um cadastro/cliente via REQUEST Externa
	* Chamada de Front-End 
	*/
	public function adiciona_externo()
	{


		$this->title = 'Adicionar Novo - Yoopay - Soluções Tecnológicas';

		if(isset($_POST['data'])){echo "TEM";}
		
		//$data = $this->uri->segment_array();
		$data = $this->uri->segment(4);


		//$data = $_POST['data'];
		//$data = '{"nome":"Jason Jones", "email":"teste@gmail.com", "fone":"04421216464", "tipofone":"Residencial", "senha":"zoeria"}';
		//$objData = json_decode($data);
		$objData = $data;

		//$dadosTabLinhas = $objData->tabLinhas;
		$dadosTabLinhas = $objData;

		echo '##exibe array dados:<br /> <pre>';
		//echo $dadosTabLinhas;
		print_r($dadosTabLinhas);
		die();

		//string json contendo dados
		//$dados_json = '{"nome":"Jason Jones", "email":"teste@gmail.com", "fone":"04421216464", "tipofone":"Residencial", "senha":"zoeria"}';

		//echo "Mostra ==> ".json_encode($dados_json);
		//die();

		if(!isset($dados_json)){show_404();}else{print_r($dados_json,true);}

		//var_dump($dados_json);
		$array_json = json_decode($dados_json);
		
		$this->data['nome'] =	$array_json->nome;
		$this->data['email'] =	$array_json->email;
		$this->data['fone'] =	$array_json->fone;
		$this->data['tipofone'] =	$array_json->tipofone;
		$this->data['senha'] =	$array_json->senha;

		print_r($data);
		die();

		// dados do cadastro geral
		$como_chegou = 'AutoAtendimento';
		$id_chg = $this->db->select("nidtbxchg")
		->from("tbxchg")
		->where("cdescrichg",$como_chegou);

		$cadgrl_data = array(
			'nidtbxchg' => $id_chg
			,'cnomegrl' => $array_json->nome
			,'cobs' => ''
			,'nidtbxsegusu_criacao' => 1
			,'dtdatacriacao' => $this->date
			,'eatendimento' => 1 // Flag para que o cadastro não seja listado na lista de cadastros gerais até que se converta em uma venda/locação
			,'ctipopessoa' => 'f'
			,'ccpfcnpj' => '99999999999'
			,'crgie' => '99999'				
		);
		$cadgrl = $this->Atendimento_model->saveData('cadgrl', $cadgrl_data);

		// Telefone do cadastro geral

		$tipo_fone = $array_json->tipofone;
		$id_tpfone = $this->db->select("nidtbxtpf")
		->from("tbxtpf")
		->where("cdescritpf",$tipo_fone);

		$tagtel_data = array(
			'nidtbxttl' => $id_tpfone
			,'nidcadgrl' => $cadgrl
			,'cdescritel' => $array_json->tipofone
			,'ddatacriacao' => substr($this->date,0,10)
		);
		$tagtel = $this->Atendimento_model->saveData('tagtel', $tagtel_data);

		// E-mail do cadastro geral

		$tagema_data = array(
			'nidtbxtem' => 1
			,'nidcadgrl' => $cadgrl
			,'cdescriemail' => "Particular"
			,'ddatacriacao' => substr($this->date,0,10)
		);
		$tagema = $this->Atendimento_model->saveData('tagema', $tagema_data);

		// Dados para criaçao do usuario

		$tbxsegusu_data = array(
			'nidcadgrl' => $cadgrl
			,'cnome' => $array_json->nome
			,'clogin' => $array_json->email
			,'nidtbxtipousu' => 2
			,'senha' => md5($array_json->senha)
		);
		$tbxsegusu = $this->Atendimento_model->saveData('tbxsegusu', $tbxsegusu_data);

		// Coletanea de Dados do atendimento
		//
		// Usuario de Atendimento
		$id_useratende = $this->db->select("nidtbxsegusu")
		->from("tbxsegusu")
		->where("clogin","userweb");

		// Tipo de Cliente == Default (VENDA)
		$id_tipofin = $this->db->select("nidtbxfin")
		->from("tbxfin")
		->where("cnomefin","Venda");

		// Inclui Atendimento
		$cadate_data = array(
			'nidcadgrl' => $cadgrl
			,'nidtbxsegusu' => $id_useratende
			,'nidtbxsat' => $this->Statusatendimento_model->getByCodigo('nov')->nidtbxsat
			,'ddatastatus' => $this->date
			,'nlibera' => 1
			,'nidtbxfin' => $id_tipofin
			,'didata' => $this->date
		);
	
		if($nidcadate = $this->Atendimento_model->saveData('cadate', $cadate_data))
		{
			//redirect('/ate/atendimento/editar/'.$nidcadate);

		}else{

			show_404();

		}

		$this->loadview('ate/Visualizar_externo');
	}


	public function insert_usuario()
	{
		$this->Segusuario_model->nome = $this->input->post('cnome');
		$this->Segusuario_model->login = $this->input->post('clogin');
		$this->Segusuario_model->tipo = $this->input->post('nidtbxtipousu');
		$this->Segusuario_model->senha = $this->input->post('senha');

		if ($this->Segusuario_model->validaInsercao()){
			/* Caso a validação de inserção retorne true, salva o registro */
			$this->Segusuario_model->save();
			$this->session->set_flashdata('sucesso','Usuário cadastrado com sucesso');
			redirect(makeUrl('seg','usuario','visualizar'));
		} else {
			/* Caso a validação da inserção retorne false, salva os dados preenchidos na sessão e retorna para a tela de cadastro */
			$this->session->set_flashdata('erro',$this->Segusuario_model->error);
			$this->session->set_flashdata('nome',$this->Segusuario_model->nome);
			$this->session->set_flashdata('login',$this->Segusuario_model->login);
			$this->session->set_flashdata('tipo',$this->Segusuario_model->tipo);
			redirect(makeUrl('seg','usuario','inserir'));
			return;
		}
	}

/* Fim das Funcoes REQUEST Externo */

}
