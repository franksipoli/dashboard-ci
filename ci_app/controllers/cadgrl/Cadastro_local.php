<?php


class Cadastro extends MY_Controller {

	public function __construct(){
	
		parent::__construct();
	
		$this->load->model('app/App_model');
		$this->load->model('dcg/Comochegou_model');
		$this->load->model('dcg/Estadocivil_model');
		$this->load->model('dcg/Tipocadastro_model');
		$this->load->model('dcg/Tiposervico_model');
		$this->load->model('dcg/Tipotelefone_model');
		$this->load->model('dcg/Tipoemail_model');
		$this->load->model('dcg/Entidadeemitente_model');
		$this->load->model('dcg/Profissao_model');
		$this->load->model('dcg/Atividade_model');
		$this->load->model('dcg/Tipoparentesco_model');
		$this->load->model('dcg/Parente_model');
		$this->load->model('dep/Tipoendereco_model');
		$this->load->model('dcg/Dadobancario_model');
		$this->load->model('dcg/Tipoconta_model');
		$this->load->model('dep/Pais_model');
		$this->load->model('dep/Uf_model');
		$this->load->model('dep/Localidade_model');
		$this->load->model('dep/Tipologradouro_model');
		$this->load->model('dep/Bairro_model');
		$this->load->model('dep/Logradouro_model');
		$this->load->model('dep/Endereco_model');
		$this->load->model('dep/Nacionalidade_model');
		$this->load->model('cadgrl/Cadastro_model');
		$this->load->model('cadgrl/Enderecocadastrogeral_model');
		$this->load->model('cadgrl/Telefonecadastrogeral_model');
		$this->load->model('cadgrl/Emailcadastrogeral_model');
		$this->load->model('cadgrl/Pessoafisica_model');
		$this->load->model('cadgrl/Pessoajuridica_model');
	
	}

	/**
	* Abre a tela para inserção de um novo registro
	*/

	public function inserir()
	{
		$this->load->model('dcg/Banco_model');
		$this->title = "Inserir Cadastro - Yoopay - Soluções Tecnológicas";
		$this->enqueue_script('vendor/jquery.steps/build/jquery.steps.js');
		$this->enqueue_script('app/js/cadgrl/cadgrl-wizard.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('app/js/cadgrl/endereco.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadgrl/telefone.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadgrl/email.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadgrl/parente.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadgrl/conta.js?v='.rand(1,9999));
		$this->data['tpl'] = $this->Tipologradouro_model->getAll(array('nordem'));
		$this->data['tcg'] = $this->Tipocadastro_model->getAll();
		$this->data['tps'] = $this->Tiposervico_model->getAll();
		$this->data['tpe'] = $this->Tipoendereco_model->getAll();
 		$this->data['chg'] = $this->Comochegou_model->getAll();
 		$this->data['tem'] = $this->Tipoemail_model->getAll();
 		$this->data['ttl'] = $this->Tipotelefone_model->getAll();
 		$this->data['est'] = $this->Estadocivil_model->getAll();
 		$this->data['emi'] = $this->Entidadeemitente_model->getAll();
 		$this->data['nac'] = $this->Nacionalidade_model->getAll();
 		$this->data['cbo'] = $this->Profissao_model->getAll();
 		$this->data['atv'] = $this->Atividade_model->getAll();
 		$this->data['tpt'] = $this->Tipoparentesco_model->getAll();
 		$this->data['bco'] = $this->Banco_model->getAll();
 		$this->data['tic'] = $this->Tipoconta_model->getAll();
 		$this->data['requiredfields'] = $this->App_model->getFieldsByAplicacao('Cadastro Geral');
		$this->data['lista_uf'] = $this->Uf_model->getAll(array('nidtbxpas'=>'ASC', 'csiglauf'=>'ASC'));
		$this->loadview('cadastro/inserir');
	}

	/**
	* Função para editar os dados bancários de um cadastro
	* @param integer ID do registro
	* @return view com os campos de edição de dados bancários
	*/

	public function dadosbancarios($id)
	{

		if ($this->input->post()){
			$this->salvarDadosBancarios($id);
			return;
		}

		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		//$this->enqueue_style('app/css/mensagem.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/cadgrl/dadosbancarios.js');

		$this->load->model('dcg/Banco_model');

		/* Verifica se o cadastro existe */

		if (!$this->Cadastro_model->getById($id)){
			$this->session->set_flashdata('erro', 'Cadastro geral não localizado');
			redirect(makeUrl('cadgrl', 'cadastro', 'listar'));
			exit();
		}

		$this->data['bco'] = $this->Banco_model->getAll();
		$this->data['tic'] = $this->Tipoconta_model->getAll();

		$this->title = "Dados Bancários - Yoopay - Soluções Tecnológicas";		
		$this->data['cadgrl'] = $this->Cadastro_model->getById($id);

		$this->loadview('cadastro/dadosbancarios');

	}

	/**
	* Função para salvar os dados bancários de um cadastro
	* @param integer ID do registro
	* @return redirect
	*/

	private function salvarDadosBancarios($id){

		$this->Dadobancario_model->cadastro = $id;
		$this->Dadobancario_model->principal = $this->input->post('principal');
		$this->Dadobancario_model->banco = $this->input->post('banco');
		$this->Dadobancario_model->titular = $this->input->post('titular');
		$this->Dadobancario_model->agencia = $this->input->post('cagencia');
		$this->Dadobancario_model->conta = $this->input->post('cconta');
		$this->Dadobancario_model->tipo_conta = $this->input->post('tipo_conta');
		$this->Dadobancario_model->codigo_tipo_conta = $this->input->post('codigo_tipo_conta');
		$this->Dadobancario_model->cliente_desde = $this->input->post('cliente_desde');

		if ($this->Dadobancario_model->validaInsercao()){
			$this->Dadobancario_model->save();
			$this->session->set_flashdata('sucesso','Dados cadastrados com sucesso');	
		} else {
			$this->session->set_flashdata('erro',$this->Dadobancario_model->error);	
		}

		redirect(makeUrl('cadgrl/cadastro', 'dadosbancarios', $id));

	}

	/**
	* Função para remover um dado bancário de um cadastro
	* @param integer ID do registro
	* @return redirect
	*/

	public function removerdadobancario($id){

		$dadobancario = $this->Dadobancario_model->getById($id);

		$this->Dadobancario_model->id = $id;

		$this->Dadobancario_model->delete();

		$this->session->set_flashdata('sucesso','Conta removida com sucesso');	

		redirect(makeUrl('cadgrl/cadastro', 'dadosbancarios', $dadobancario->nidcadgrl));

	}

	/**
	* Função para tornar uma conta principal
	* @param integer ID do registro
	* @return redirect
	*/

	public function tornarcontaprincipal($id){

		$dadobancario = $this->Dadobancario_model->getById($id);

		$this->Dadobancario_model->id = $id;

		$this->Dadobancario_model->tornarprincipal();

		$this->session->set_flashdata('sucesso','Operação realizada com sucesso');	

		redirect(makeUrl('cadgrl/cadastro', 'dadosbancarios', $dadobancario->nidcadgrl));

	}

	/**
	* Função para fazer uma conta deixar de ser principal
	* @param integer ID do registro
	* @return redirect
	*/

	public function desfazerprincipal($id){

		$dadobancario = $this->Dadobancario_model->getById($id);

		$this->Dadobancario_model->id = $id;

		$this->Dadobancario_model->desfazerprincipal();

		$this->session->set_flashdata('sucesso','Operação realizada com sucesso');	

		redirect(makeUrl('cadgrl/cadastro', 'dadosbancarios', $dadobancario->nidcadgrl));

	}

	/**
	* Função para editar registro
	* @param integer ID do registro
	* @return view com os campos de edição ou redirect para a lista caso o objeto não exista
	* @access public
	*/

	public function editar($id)
	{

		/* Verifica se o cadastro existe */

		if (!$this->Cadastro_model->getById($id)){
			$this->session->set_flashdata('erro', 'Cadastro geral não localizado');
			redirect(makeUrl('cadgrl', 'cadastro', 'listar'));
			exit();
		}

		$this->load->model('dcg/Banco_model');

		$this->title = "Editar Cadastro - Yoopay - Soluções Tecnológicas";
		$this->enqueue_script('vendor/jquery.steps/build/jquery.steps.js');
		$this->enqueue_script('app/js/cadgrl/cadgrl-wizard.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('app/js/cadgrl/endereco.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadgrl/telefone.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadgrl/parente.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadgrl/conta.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadgrl/email.js?v='.rand(1,9999));
		$this->data['cadgrl'] = $this->Cadastro_model->getById($id);

		if ($this->data['cadgrl']->ctipopessoa == 'f'){
			$this->data['cadfis'] = $this->Pessoafisica_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);
		} elseif($this->data['cadgrl']->ctipopessoa == 'j'){
			$this->data['cadjur'] = $this->Pessoajuridica_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);
		}

		$this->data['cadgrl_tpc'] = $this->Cadastro_model->getTiposCadastro($this->data['cadgrl']->nidcadgrl);
		$this->data['cadgrl_tps'] = $this->Cadastro_model->getTiposServico($this->data['cadgrl']->nidcadgrl);
		$this->data['enderecos'] = $this->Enderecocadastrogeral_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);
		$this->data['parentes'] = $this->Parente_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);
		$this->data['telefones'] = $this->Telefonecadastrogeral_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);
		$this->data['emails'] = $this->Emailcadastrogeral_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);
		$this->data['dadosbancarios'] = $this->Dadobancario_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);

		$this->data['tpl'] = $this->Tipologradouro_model->getAll(array('nordem'));
		$this->data['tcg'] = $this->Tipocadastro_model->getAll();
		$this->data['tps'] = $this->Tiposervico_model->getAll();
		$this->data['tpe'] = $this->Tipoendereco_model->getAll();
 		$this->data['chg'] = $this->Comochegou_model->getAll();
 		$this->data['tem'] = $this->Tipoemail_model->getAll();
 		$this->data['ttl'] = $this->Tipotelefone_model->getAll();
 		$this->data['est'] = $this->Estadocivil_model->getAll();
 		$this->data['emi'] = $this->Entidadeemitente_model->getAll();
 		$this->data['nac'] = $this->Nacionalidade_model->getAll();
 		$this->data['cbo'] = $this->Profissao_model->getAll();
 		$this->data['atv'] = $this->Atividade_model->getAll();
 		$this->data['tpt'] = $this->Tipoparentesco_model->getAll();
 		$this->data['bco'] = $this->Banco_model->getAll();
 		$this->data['tic'] = $this->Tipoconta_model->getAll();
 		$this->data['requiredfields'] = $this->App_model->getFieldsByAplicacao('Cadastro Geral');
		$this->data['lista_uf'] = $this->Uf_model->getAll(array('nidtbxpas'=>'ASC', 'csiglauf'=>'ASC'));
		$this->loadview('cadastro/inserir');
	}

	/**
	* Função para caso não seja chamado nenhum método diretamente
	*/

	public function index()
	{
		$this->inserir();
	}

	public function listar()
	{
		$this->title = "Cadastro - Yoopay - Soluções Tecnológicas";
		
		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		//$this->enqueue_style('app/css/mensagem.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/cadgrl/listar.js');

		$this->data['tipo_cadastro'] = $this->Tipocadastro_model->getAll();
		$this->data['estado_civil'] = $this->Estadocivil_model->getAll();

		$this->loadview('cadastro/listar');
	}

	public function listar_json()
	{
		// paginação
		$start 	= $this->input->get('iDisplayStart');
		$length = $this->input->get('iDisplayLength');

		// parâmetros avulsos
		$params['tipo_cadastro'] = ($type = trim($this->input->get('tipo_cadastro'))) ? $type : NULL;
		$params['estadocivil'] = ($type = trim($this->input->get('estadocivil'))) ? $type : NULL;

		// parâmetros de data
		$date_nasc = (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', trim($this->input->get('datan')))) ? toDbDate(trim($this->input->get('datan'))) : NULL;
		$date_start = (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', trim($this->input->get('datai')))) ? toDbDate(trim($this->input->get('datai'))) : NULL;
		$date_end = (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', trim($this->input->get('dataf')))) ? toDbDate(trim($this->input->get('dataf'))) : NULL;
		
		switch($this->input->get('tipo_data'))
		{
			case 'nascimento':
				$params['daten'] = $date_nasc;
				break;
			case 'cadastro':
				$params['date']['g.didata >='] = $date_start;
				$params['date']['g.didata <='] = $date_end;
				break;
			case 'atendimento':
				$params['date']['g.dudata >='] = $date_start;
				$params['date']['g.dudata <='] = $date_end;
				break;
		}

		// palavras chave
		$params['keyword'] = ($this->input->get('palavra')) ? trim($this->input->get('palavra')) : NULL;
		$keyword_field = ($this->input->get('campo')) ? trim($this->input->get('campo')) : NULL;

		if($params['keyword'])
		{
			switch ($keyword_field) {
				case 'nome'		: $params['like']['g.cnomegrl'] = $params['keyword']; break;
				case 'cpf'		: $params['like']['g.ccpfcnpj'] = cleanToNumber($params['keyword']); break;
				case 'rg'		: $params['like']['g.crgie'] = $params['keyword']; break;
				case 'obs'		: $params['like']['g.cobs'] = $params['keyword']; break;
				case 'email'	: $params['like']['e.cdescriemail'] = $params['keyword']; break;
				case 'telefone'	: $params['like']['t.cdescritel'] = $params['keyword']; break;
				case 'endereco'	: $params['like']['log.cdescrilog'] = $params['keyword']; break;
				case 'cidade'	: $params['like']['loc.cdescriloc'] = $params['keyword']; break;
				default:
					$params['like'] = array(
						'g.cnomegrl' => $params['keyword']
						,'g.ccpfcnpj' => cleanToNumber($params['keyword'])
						,'g.crgie' => $params['keyword']
						,'g.cobs' => $params['keyword']
						,'e.cdescriemail' => $params['keyword']
						,'t.cdescritel' => $params['keyword']
						,'log.cdescrilog' => $params['keyword']
						,'loc.cdescriloc' => $params['keyword']
						);
				break;
			}
		}
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Cadastro_model->listar_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadgrl;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Cadastro_model->listar_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Cadastro_model->listar_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);

	}

	public function listar_dadosbancarios_json($nidcadgrl){

		// paginação
		$start 	= $this->input->get('iDisplayStart');
		$length = $this->input->get('iDisplayLength');

		// parâmetros avulsos
		$params['nidcadgrl'] = $nidcadgrl;
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Cadastro_model->listar_dadosbancarios( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidtagbco;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Cadastro_model->listar_dadosbancarios( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Cadastro_model->listar_dadosbancarios( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);
	}

	/**
	* Abre um cadastro
	*/

	public function visualizar( $id )
	{
		$this->title = 'Visualizar cadastro - Yoopay - Soluções Tecnológicas';

		$this->load->model('seg/Segusuario_model');

		$this->data['cadgrl'] = $this->Cadastro_model->getById($id);

		$this->data['comochegou'] = $this->Comochegou_model->getById($this->data['cadgrl']->nidtbxchg);

		$this->data['enderecos'] = $this->Enderecocadastrogeral_model->getByCadastroGeral( $id );

		$this->data['emails'] = $this->Emailcadastrogeral_model->getByCadastroGeral( $id );

		$this->data['telefones'] = $this->Telefonecadastrogeral_model->getByCadastroGeral( $id );

		$this->data['tipos_cadastro'] = $this->Tipocadastro_model->getByCadastroGeral( $id );

		$this->data['tipos_servico'] = Tiposervico_model::getByPrestador( $id );

		if ($this->data['cadgrl']->ctipopessoa == "f"){

			$this->data['cadfis'] = $this->Pessoafisica_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);

			$this->data['tbxest'] = $this->Estadocivil_model->getById($this->data['cadfis']->nidtbxest);

			$this->data['tbxcbo'] = $this->Profissao_model->getById($this->data['cadfis']->nidtbxcbo);

			$this->data['tbxemi'] = $this->Entidadeemitente_model->getById($this->data['cadfis']->nidtbxemi);

			$this->data['tbxnac'] = $this->Nacionalidade_model->getById($this->data['cadfis']->nidtbxnac);

			$this->loadview('cadastro/visualizar_pf');
		
		} else {

			$this->data['cadjur'] = $this->Pessoajuridica_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);

			$this->data['tbxatv'] = $this->Atividade_model->getById($this->data['cadjur']->nidtbxatv);

			$this->loadview('cadastro/visualizar_pj');
		}

	}

	/**
	* Função para registrar os endereços do usuário via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado do update
	*/

	private function registerEtapaEndereco( $params_array )
	{

		$this->Cadastro_model->etapa = "endereco";
		$this->Cadastro_model->id = $params_array['nidcadgrl'];

			/* Verifica quantas chaves o array de endereço possui */

			$total_enderecos = count($params_array['tipoendereco']);

			/* Percorre cada uma das chaves e salve o endereço */

			for ($i=0; $i<$total_enderecos; $i++):

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Localidade_model = new Localidade_model();

				/* Verifica se a cidade escolhida já está cadastrada no banco. Se sim, utiliza essa para o cadastro de endereço. Se não, cadastra-a */

				$localidade_existente = $this->Localidade_model->getByNomeUF($params_array['uf'][$i], $params_array['cidade'][$i]);

				if ( $localidade_existente ) {
					
					$this->Localidade_model->id = $localidade_existente->nidtbxloc;
				
				} else {

					/* Cadastra a cidade */

					if ($params_array['cep_cidade'][$i] == 1){
						$this->Localidade_model->cep = $params_array['cep'][$i];
					}

					$this->Localidade_model->uf = $params_array['uf'][$i];
					$this->Localidade_model->descricao = $params_array['cidade'][$i];

					if ( $this->Localidade_model->validaInsercao() ) {
						$this->Localidade_model->save();
					} else {
						$erros[] = "Localidade não pode ser cadastrada. Info: ".$this->Localidade_model->error;
						// TODO erro na validação
					}
				}

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Bairro_model = new Bairro_model();

				/* Verifica se o bairro escolhido já está cadastrado no banco. Se sim, utiliza esse para o cadastro do endereço. Se não, cadastra-o */

				$bairro_existente = $this->Bairro_model->getByNomeCidade($this->Localidade_model->id, $params_array['bairro'][$i]);

				if ( $bairro_existente ) {

					$this->Bairro_model->id = $bairro_existente->nidtbxbai;

				} else {

					/* Cadastra o bairro */

					$this->Bairro_model->cidade = $this->Localidade_model->id;
					$this->Bairro_model->descricao = $params_array['bairro'][$i];

					if ( $this->Bairro_model->validaInsercao() ) {
						$this->Bairro_model->save();
					} else {
						$erros[] = "Bairro não pôde ser cadastrado. Info: ".$this->Bairro_model->error;
						// TODO erro na validação
					}
				
				}

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Logradouro_model = new Logradouro_model();

				/* Verifica se o endereço escolhido já está cadastrado no banco. Se sim, utiliza esse para o cadastro de endereço. Se não, cadastra-o */

				$logradouro_existente = $this->Logradouro_model->getByTipoNomeBairroCEP($params_array['nidtbxtpl'][$i], $this->Bairro_model->id, $params_array['endereco'][$i], $params_array['cep'][$i]);

				if ( $logradouro_existente ) {

					$this->Logradouro_model->id = $logradouro_existente->nidcadlog;

				} else {

					/* Cadastra o logradouro */

					$this->Logradouro_model->bairro = $this->Bairro_model->id;
					$this->Logradouro_model->descricao = $params_array['endereco'][$i];
					$this->Logradouro_model->tipo = $params_array['nidtbxtpl'][$i];

					if (!$params_array['cep_cidade'][$i]){

						/* Se o cep pertencer à cidade, não há um porquê de cadastrá-lo no endereço */

						$this->Logradouro_model->cep = $params_array['cep'][$i];

					}

					if ( $this->Logradouro_model->validaInsercao() ) {
						$this->Logradouro_model->save();
					} else {
						$erros[] = "Logradouro não pôde ser cadastrado. Info: ".$this->Logradouro->error;
						// TODO erro na validação
					}
				
				}

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Endereco_model = new Endereco_model();

				/* Inserir o endereço */
				$this->Endereco_model->tipoendereco = $params_array['tipoendereco'][$i];
				$this->Endereco_model->logradouro = $this->Logradouro_model->id;
				$this->Endereco_model->numero = $params_array['numero'][$i];
				$this->Endereco_model->complemento = $params_array['complemento'][$i];
				if ( $this->Endereco_model->validaInsercao() ){
					$this->Endereco_model->save();
				} else {
					$erros[] = "Endereço não pôde ser cadastrado. Info: ".$this->Endereco_model->error;
					// TODO erro no cadastro de endereço
				}

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Enderecocadastrogeral_model = new Enderecocadastrogeral_model();

				/* Conectar o endereço ao cadastro geral */
				$this->Enderecocadastrogeral_model->endereco = $this->Endereco_model->id;
				$this->Enderecocadastrogeral_model->cadastro = $this->Cadastro_model->id;
				if ( $this->Enderecocadastrogeral_model->validaInsercao() ){
					$this->Enderecocadastrogeral_model->save();
				} else {
					$erros[] = "Endereço não pôde ser vinculado a um cadastro geral. Info: ".$this->Enderecocadastrogeral_model->error;
					// TODO erro no cadastro de endereço
				}

			endfor;

		$result = array(
			"success" => 1,
			"id" => $this->Cadastro_model->id,
			"msg" => "Endereço cadastrado com sucesso",
			"erros" => $erros
		);

		return $result;

	}

	/**
	* Função para trazer a lista de prestadores de serviço através da busca por nome ou CPF via AJAX
	* @access public
	* @param none
	* @return json lista de objetos
	*/

	public function buscarPrestadorAjaxNome() {
		$term = $this->input->get('term');
		$results = $this->Tiposervico_model->getPrestadores($term);
		$ui = array();
		foreach ($results as $result){
			$ui[] = array("id"=>$result->nidcadgrl,"value"=>$result->cnomegrl,"label"=>$result->cnomegrl." | ".$result->ccpfcnpj);
		}
		die(json_encode($ui));
	}

	/**
	* Função para registrar os dados de contato do usuário via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function registerEtapaContatos( $params_array )
	{

		$this->Cadastro_model->etapa = "contato";
		$this->Cadastro_model->id = $params_array['nidcadgrl'];

		/* Verifica quantas chaves o array de telefone possui */

		$total_telefones = count($params_array['tipotelefone']);

		/* Percorre cada uma das chaves e salve o telefone */

		for ($i=0; $i<$total_telefones; $i++):

			/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

			$this->Telefonecadastrogeral_model = new Telefonecadastrogeral_model();

			/* Conectar o telefone ao cadastro geral */
			$this->Telefonecadastrogeral_model->tipo = $params_array['tipotelefone'][$i];
			$this->Telefonecadastrogeral_model->telefone = $params_array['telefone'][$i];
			$this->Telefonecadastrogeral_model->cadastro = $this->Cadastro_model->id;

			if ( $this->Telefonecadastrogeral_model->validaInsercao() ){
				$this->Telefonecadastrogeral_model->save();
			} else {
				// TODO erro no cadastro de telefone
			}			
		
		endfor;

		/* Verifica quantas chaves o array de e-mail possui */

		$total_emails = count($params_array['tipoemail']);

		/* Percorre cada uma das chaves e salve o e-mail */

		for ($i=0; $i<$total_emails; $i++):

			/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

			$this->Emailcadastrogeral_model = new Emailcadastrogeral_model();

			/* Conectar o e-mail ao cadastro geral */
			$this->Emailcadastrogeral_model->tipo = $params_array['tipoemail'][$i];
			$this->Emailcadastrogeral_model->email = $params_array['email'][$i];
			$this->Emailcadastrogeral_model->cadastro = $this->Cadastro_model->id;

			if ( $this->Emailcadastrogeral_model->validaInsercao() ){
				$this->Emailcadastrogeral_model->save();
			} else {
				// TODO erro no cadastro de telefone
			}			
		
		endfor;

		$result = array(
			"id" => $this->Cadastro_model->id,
			"success" => 1,
			"message" => "Contatos cadastrados com sucesso"
		);

		return $result;
	
	}

	/**
	* Função para registrar os dados bancários do usuário via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function registerDadosBancarios( $params_array )
	{

		$this->Cadastro_model->etapa = "dadosbancarios";
		$this->Cadastro_model->id = $params_array['nidcadgrl'];

		/* Verifica quantas chaves o array de dados bancários possui */

		$total_bancos = count($params_array['banco']);

		/* Percorre cada uma das chaves e salve o banco */

		for ($i=0; $i<$total_bancos; $i++):

			$this->Dadobancario_model->cadastro = $params_array['nidcadgrl'];
			$this->Dadobancario_model->principal = $params_array['principal'][$i] == 1 ? 1 : 0;
			$this->Dadobancario_model->banco = $params_array['banco'][$i];
			$this->Dadobancario_model->titular = $params_array['titular'][$i];
			$this->Dadobancario_model->agencia = $params_array['agencia'][$i];
			$this->Dadobancario_model->conta = $params_array['conta'][$i];
			$this->Dadobancario_model->tipo_conta = $params_array['tipo_conta'][$i];
			$this->Dadobancario_model->codigo_tipo_conta = $params_array['codigo'][$i];

			if ( $this->Dadobancario_model->validaInsercao() ){
				$this->Dadobancario_model->save();
			} else {
				// TODO erro no cadastro do dado bancário
			}			
		
		endfor;

		$result = array(
			"id" => $this->Cadastro_model->id,
			"success" => 1,
			"message" => "Dados Bancários cadastrados com sucesso"
		);

		return $result;
	
	} 

	/**
	* Função para registrar os dados básicos do usuário via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function registerEtapaGeral( $params_array )
	{

		if ($params_array['nidcadgrl']){
			
			return array(
				"error" => 1,
				"message" => "Cadastro já registrado"
			);

		}


		$this->Cadastro_model->etapa = "geral";

		if ( !isset($params_array['nidtbxtps']) ){
			$params_array['nidtbxtps'] = array();
		}

		$this->Cadastro_model->comochegou = $params_array['nidtbxchg'];

		/* Verifica o tipo de pessoa e o tipo de cadastro que serão enviados e então preenche os atributos respectivos no objeto */
		if ( $params_array['tipo_pessoa']=="f" ) {
			
			/* Pessoa física */

			$this->Cadastro_model->tipo_pessoa = "f";

			// TODO fazer as validações necessárias
			
			/* Faz o registro básico do cadastro geral */

			$this->Cadastro_model->nome = $params_array['nomecompleto'];
			$this->Cadastro_model->cpfcnpj = $params_array['cpf'];
			$this->Cadastro_model->rgie = $params_array['rg'];


		} elseif ( $params_array['tipo_pessoa']=="j" ) {

			$this->Cadastro_model->tipo_pessoa = "j";

			/* Pessoa jurídica */

			// TODO fazer as validações necessárias

			/* Faz o registro básico do cadastro geral */
		
			$this->Cadastro_model->nome = $params_array['razaosocial'];
			$this->Cadastro_model->cpfcnpj = $params_array['cnpj'];
			$this->Cadastro_model->rgie = $params_array['ie'];

		}

		$this->Cadastro_model->obs = $params_array['observacoes'];
		$this->Cadastro_model->creci = $params_array['creci'];
		$this->Cadastro_model->senha_chave = $params_array['csenhachave'];

		$this->Cadastro_model->usuario_criacao = $this->getCurrentUser();

		$id = $this->Cadastro_model->save();

		Log_model::save('cadgrl', $id, $this->getCurrentUser(), "Criou o registro");

		/* Registra os tipos de cadastro geral */

		$this->Cadastro_model->setTipoCadastroGeral( $params_array['nidtbxtcg'], $params_array['nidtbxtps'], Parametro_model::get('id_tipo_cadastro_prestador_servicos') );

		if ($params_array['tipo_pessoa'] == "f"){

			/* Salva o registro na tabela de pessoa física */

			$this->Pessoafisica_model->cadgrl = $this->Cadastro_model->id;
			$this->Pessoafisica_model->estado_civil = $params_array['nidtbxest'];
			$this->Pessoafisica_model->profissao = $params_array['nidtbxcbo'];
			$this->Pessoafisica_model->entidade_emitente = $params_array['nidtbxemi'];
			$this->Pessoafisica_model->nacionalidade = $params_array['nidtbxnac'];
			$this->Pessoafisica_model->data_emissao = toDbDate($params_array['data_emissao']);
			$this->Pessoafisica_model->data_nascimento = toDbDate($params_array['data_nascimento']);		

			if ($this->Pessoafisica_model->validaInsercao()){
				$this->Pessoafisica_model->save();
			}

		} elseif ($params_array['tipo_pessoa'] == "j"){

			/* Salva o registro na tabela de pessoa jurídica */

			$this->Pessoajuridica_model->cadgrl = $this->Cadastro_model->id;
			$this->Pessoajuridica_model->nome_fantasia = $params_array['cnomefant'];
			$this->Pessoajuridica_model->data_fundacao = $params_array['ddtfundacao'];
			$this->Pessoajuridica_model->atividade = $params_array['nidtbxatv'];
			$this->Pessoajuridica_model->capital_social = toDbCurrency($params_array['ncaptsocial']);

			if ($this->Pessoajuridica_model->validaInsercao()){
				$this->Pessoajuridica_model->save();
			}
			

		}


		$result = array(
			"id" => $id,
			"success" => 1
		);

		return $result;
	}

	/**
	* Função para atualizar os dados básicos do usuário via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function updateEtapaGeral( $params_array )
	{

		if ( !isset($params_array['nidtbxtps']) ){
			$params_array['nidtbxtps'] = array();
		}

		$this->Cadastro_model->id = $params_array['nidcadgrl'];

		$this->Cadastro_model->comochegou = $params_array['nidtbxchg'];

		/* Verifica o tipo de pessoa e o tipo de cadastro que serão enviados e então preenche os atributos respectivos no objeto */
		if ( $params_array['tipo_pessoa']=="f" ) {
			
			/* Pessoa física */

			$this->Cadastro_model->tipo_pessoa = "f";

			// TODO fazer as validações necessárias
			
			/* Faz o registro básico do cadastro geral */

			$this->Cadastro_model->nome = $params_array['nomecompleto'];
			$this->Cadastro_model->cpfcnpj = $params_array['cpf'];
			$this->Cadastro_model->rgie = $params_array['rg'];


		} elseif ( $params_array['tipo_pessoa']=="j" ) {

			$this->Cadastro_model->tipo_pessoa = "j";

			/* Pessoa jurídica */

			// TODO fazer as validações necessárias

			/* Faz o registro básico do cadastro geral */
		
			$this->Cadastro_model->nome = $params_array['razaosocial'];
			$this->Cadastro_model->cpfcnpj = $params_array['cnpj'];
			$this->Cadastro_model->rgie = $params_array['ie'];

		}

		$this->Cadastro_model->obs = $params_array['observacoes'];
		$this->Cadastro_model->creci = $params_array['creci'];
		if ($params_array['csenhachave']){
			$this->Cadastro_model->senha_chave = $params_array['csenhachave'];
		}

		$this->Cadastro_model->usuario_atualizacao = $this->getCurrentUser();

		$id = $this->Cadastro_model->save();

		/* Registra os tipos de cadastro geral */

		$this->Cadastro_model->setTipoCadastroGeral( $params_array['nidtbxtcg'], $params_array['nidtbxtps'], Parametro_model::get('id_tipo_cadastro_prestador_servicos') );

		if ($params_array['tipo_pessoa'] == "f"){

			/* Salva o registro na tabela de pessoa física */

			$this->Pessoafisica_model->cadgrl = $this->Cadastro_model->id;
			$this->Pessoafisica_model->estado_civil = $params_array['nidtbxest'];
			$this->Pessoafisica_model->profissao = $params_array['nidtbxcbo'];
			$this->Pessoafisica_model->entidade_emitente = $params_array['nidtbxemi'];
			$this->Pessoafisica_model->nacionalidade = $params_array['nidtbxnac'];
			$this->Pessoafisica_model->data_emissao = toDbDate($params_array['data_emissao']);
			$this->Pessoafisica_model->data_nascimento = toDbDate($params_array['data_nascimento']);		

			if ($this->Pessoafisica_model->validaAtualizacao()){
				$this->Pessoafisica_model->save();
			}

		}

		Log_model::save('cadgrl', $id, $this->getCurrentUser(), "Atualizou o registro");


		$result = array(
			"id" => $id,
			"success" => 1
		);

		return $result;
	}

	/**
	* Função para atualizar os endereços do usuário via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function updateEnderecos( $params_array )
	{
		
		$this->Enderecocadastrogeral_model->removeByCadastro($params_array['nidcadgrl']);
		$result = $this->registerEtapaEndereco($params_array);

		return $result;

	}	

	/**
	* Função para atualizar os contatos do usuário via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function updateContatos( $params_array )
	{
		
		$this->Telefonecadastrogeral_model->removeByCadastro($params_array['nidcadgrl']);
		$this->Emailcadastrogeral_model->removeByCadastro($params_array['nidcadgrl']);
		$result = $this->registerEtapaContatos($params_array);
		return $result;

	}	

	/**
	* Função para atualizar os dados bancários do usuário via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function updateDadosBancarios( $params_array )
	{
		
		$this->Dadobancario_model->removeByCadastro($params_array['nidcadgrl']);
		$result = $this->registerDadosBancarios($params_array);
		return $result;

	}	

	/**
	* Função para atualizar o cadastro geral via AJAX (utilizado no wizard)
	* @access public
	* @param none
	* @return JSON com o resultado da atualização
	*/
                           vbm,k67y7
	public function update()
	{

		/* Recebe as variáveis enviadas pelo serialize do jQuery */
		$params = $this->input->post("params");
		/* Transforma a query string em um array */
		parse_str($params, $params_array);

		$nidcadgrl = $params_array['nidcadgrl'];

		$cadastro = $this->Cadastro_model->getById($nidcadgrl);

		if (!$cadastro){
			die(json_encode(
				array(
					"error" => 1,
					"message" => "Cadastro não localizado"
				)
			));
		}

		$this->updateEtapaGeral($params_array);

		$this->updateEnderecos($params_array);

		$this->updateContatos($params_array);

		$this->updateDadosBancarios($params_array);

		die(json_encode($nidcadgrl));

	}
	
	/**
	* Função para registrar o usuário via AJAX (utilizado no Wizard)
	* @access public
	* @return ID do registro
	*/

	public function registerAjax()
	{
		/* Recebe as variáveis enviadas pelo serialize do jQuery */
		$params = $this->input->post("params");
		/* Transforma a query string em um array */
		parse_str($params, $params_array);

		if ($params_array['edit'] == 1){
			/* No caso de edição o sistema salvará tudo no final */
			die(json_encode("Na edição, os dados serão salvos ao final das etapas"));
		}

		/* Função que verifica a etapa atual do registro e salva no banco */

		if ($params_array['etapa'] == "geral"){

			/* Trata-se da primeira etapa do cadastro */

			$result = $this->registerEtapaGeral( $params_array );

			die(json_encode($result));

		} elseif ($params_array['etapa'] == "endereco") {

			/* Trata-se da segunda etapa do cadastro */

			$result = $this->registerEtapaEndereco( $params_array );

			die(json_encode($result));

		} elseif ($params_array['etapa'] == "contato") {

			/* Trata-se da terceira etapa do cadastro */

			$result = $this->registerEtapaContatos( $params_array );

			die(json_encode($result));

		} elseif ($params_array['etapa'] == "dadosbancarios") {

			$result = $this->registerDadosBancarios( $params_array );

			die(json_encode($result));

		}

	}

	/**
	* Função para remover um usuário do cadastro geral
	* @access public
	* @param ID do cadastro geral, oriundo da URL
	* @return redirect para a listagem de usuários
	*/

	public function remove ( $id ){

		/* Checa se o cadastro existe e está ativo */

		if (!$this->Cadastro_model->getById($id)){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('cadgrl','cadastro','listar'));
			exit();
		}

		$this->Cadastro_model->id = $id;
		$this->Cadastro_model->nidtbxsegusu_exclusao = $this->getCurrentUser();
		$this->Cadastro_model->delete();

		Log_model::save('cadgrl', $id, $this->getCurrentUser(), "Excluiu o registro");

		$this->session->set_flashdata('sucesso','Cadastro geral removido com sucesso');	
		redirect(makeUrl('cadgrl','cadastro','listar'));

	}

	/**
	* Função para trazer a lista de usuários através da busca por nome ou CPF via AJAX
	* @access public
	* @param none
	* @return json lista de objetos
	*/

	public function buscarAjaxNomeCPF() {
		$term = $this->input->get('term');
		if (!$term)
			die();
		$results = $this->Cadastro_model->getByNomeCPF($term);
		$ui = array();
		foreach ($results as $result){
			$ui[] = array("id"=>$result->nidcadgrl,"value"=>$result->cnomegrl,"label"=>$result->cnomegrl." | ".$result->ccpfcnpj);
		}
		die(json_encode($ui));
	}

}