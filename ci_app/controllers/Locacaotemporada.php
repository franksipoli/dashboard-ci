<?php


class Locacaotemporada extends MY_Controller {

	public function __construct(){
	
		parent::__construct();
	
		$this->load->model('app/App_model');
		$this->load->model('dci/Tipoimovel_model');
		$this->load->model('dci/Finalidade_model');
		$this->load->model('dci/Tipopermuta_model');
		$this->load->model('dci/Tipopacote_model');
		$this->load->model('dci/Tipoobservacao_model');
		$this->load->model('cadgrl/Entidade_model');
		$this->load->model('cadgrl/Cadastro_model');
		$this->load->model('cadimo/Imovel_model');
		$this->load->model('cadimo/Locacaotemporada_model');
		$this->load->model('cadimo/Inquilino_model');
		$this->load->model('cadimo/Veiculo_model');
		$this->load->model('cadimo/Imovelobservacao_model');
		$this->load->model('cadimo/Imoveldistancia_model');
		$this->load->model('cadimo/Proprietarioimovel_model');
		$this->load->model('cadimo/Angariadorimovel_model');
		$this->load->model('cadimo/Finalidadetipovalor_model');
		$this->load->model('cadimo/Enderecoimovel_model');
		$this->load->model('cadimo/Tipocontrato_model');
		$this->load->model('cadimo/Contrato_model');
		$this->load->model('dci/Tipomidia_model');
		$this->load->model('dci/Midia_model');
		$this->load->model('dci/Midiatipomidia_model');
		$this->load->model('dci/Tipostatusconstrucao_model');
		$this->load->model('dep/Pais_model');
		$this->load->model('dep/Uf_model');
		$this->load->model('dep/Localidade_model');
		$this->load->model('dep/Bairro_model');
		$this->load->model('dep/Logradouro_model');
		$this->load->model('dep/Endereco_model');
		$this->load->model('dci/Tipodistancia_model');
		$this->load->model('dci/Tiporeferenciadistancia_model');
		$this->load->model('dci/Tipomedidadistancia_model');
		$this->load->model('dci/Tipocomissao_model');

	}

	/**
	* Abre a tela para inserção de um novo registro
	*/

	public function inserir($imovel){
		$this->title = "Iniciar Locação - Yoopay - Soluções Tecnologicas";
		$this->load->model('dep/Formapagamento_model');
		$this->enqueue_script('vendor/jquery.steps/build/jquery.steps.js');
		$this->enqueue_script('app/js/locacaotemporada/wizard.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('app/js/locacaotemporada/locacao.js?v='.rand(1,9999));
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$data_inicial = $this->input->get('data_inicial');
		$data_final = $this->input->get('data_final');
		if ($data_inicial)
			$this->data['data_inicial'] = $data_inicial;
		if ($data_final)
			$this->data['data_final'] = $data_final;
		$this->data['tpp'] = $this->Tipopermuta_model->getAll();
		$this->data['tpi'] = $this->Tipoimovel_model->getAll();
		$this->data['ent'] = $this->Entidade_model->getAll();
		$this->data['fin'] = $this->Finalidade_model->getAll();
		$this->data['obs'] = $this->Tipoobservacao_model->getAll();
		$this->data['tsc'] = $this->Tipostatusconstrucao_model->getAll();
		$this->data['fva'] = $this->Finalidadetipovalor_model->getAllFront();
		$this->data['tpd'] = $this->Tipodistancia_model->getAll();
		$this->data['tmd'] = $this->Tipomedidadistancia_model->getAll();
		$this->data['trd'] = $this->Tiporeferenciadistancia_model->getAll();
		$this->data['cadimo'] = $this->Imovel_model->getById($imovel);
		$this->data['fpa'] = $this->Formapagamento_model->getAll();
		$this->data['taxa_administrativa'] = number_format($this->data['cadimo']->ntaxaadm, 2);
		$this->data['lista_uf'] = $this->Uf_model->getAll(array('nidtbxpas'=>'ASC', 'csiglauf'=>'ASC'));
 		$this->data['requiredfields'] = $this->App_model->getFieldsByAplicacao('Locação Temporada');
 		$this->data['quantidade_parcelas_locacao'] = Parametro_model::get('quantidade_parcelas_padrao_locacao');
		$this->loadview('locacaotemporada/inserir');
	}

	/**
	* Função para editar registro
	* @param integer ID do registro
	* @return view com os campos de edição ou redirect para a lista caso o objeto não exista
	* @access public
	*/

	public function editar($id)
	{

		/* Verifica se o Imóvel existe */

		if (!$this->Imovel_model->getById($id)){
			$this->session->set_flashdata('erro', 'Imóvel não localizado');
			redirect(makeUrl('cadimo', 'imovel', 'listar'));
			exit();
		}

		$this->title = "Editar Imóvel - Yoopay - Soluções Tecnologicas";
		$this->enqueue_script('vendor/jquery.steps/build/jquery.steps.js');
		$this->enqueue_script('app/js/cadimo/cadimo-wizard.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('app/js/cadimo/proprietario.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadimo/angariador.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadimo/observacao.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadimo/distancia.js?v='.rand(1,9999));

		$this->data['cadimo'] = $this->Imovel_model->getById( $id );

		$this->data['tpp'] = $this->Tipopermuta_model->getAll();
		$this->data['tpi'] = $this->Tipoimovel_model->getAll();
		$this->data['ent'] = $this->Entidade_model->getAll();
		$this->data['fin'] = $this->Finalidade_model->getAll();
		$this->data['obs'] = $this->Tipoobservacao_model->getAll();
		$this->data['tsc'] = $this->Tipostatusconstrucao_model->getAll();
		$this->data['fva'] = $this->Finalidadetipovalor_model->getAllFront();
		$this->data['tpd'] = $this->Tipodistancia_model->getAll();
		$this->data['tmd'] = $this->Tipomedidadistancia_model->getAll();
		$this->data['trd'] = $this->Tiporeferenciadistancia_model->getAll();
		$this->data['lista_uf'] = $this->Uf_model->getAll(array('nidtbxpas'=>'ASC', 'csiglauf'=>'ASC'));
 		$this->data['requiredfields'] = $this->App_model->getFieldsByAplicacao('Cadastro de Imóvel');
		$this->loadview('imovel/inserir');
	}

	public function listar()
	{
		$this->title = "Locações - Yoopay - Soluções Tecnologicas";

		$this->load->model('seg/Segusuario_model');
		
		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		//$this->enqueue_style('app/css/mensagem.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/locacaotemporada/listar.js');

		$this->data['usuarios'] = $this->Segusuario_model->getAll();

		$this->loadview('locacaotemporada/listar');
	}

	public function listar_json()
	{
		$offset = $this->input->get('start');
		$limit = $this->input->get('length');

		if($type = trim($this->input->get('tipo-data'))) $params['type'] = $type;

		if($type = trim($this->input->get('usuario'))) $params['usuario'] = $type;

		$date_start = (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', trim($this->input->get('datai')))) ? toDbDate(trim($this->input->get('datai'))) : NULL;
		$date_end = (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', trim($this->input->get('dataf')))) ? toDbDate(trim($this->input->get('dataf'))) : NULL;

		if($date_start && $date_end)
		{
			$params['datai'] = $date_start;
			$params['dataf'] = $date_end;
		}

		if ($this->input->get('referencia')) $params['referencia'] = $this->input->get('referencia');
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Locacaotemporada_model->listar_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadgrl;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Locacaotemporada_model->listar_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Locacaotemporada_model->listar_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);

	}

	/**
	* Função para registrar a locação via AJAX (utilizado no Wizard)
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

		}

	}

	/**
	* Função para registrar os dados básicos da locação via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function registerEtapaGeral( $params_array )
	{

		if ($params_array['nidcadloc']){
			
			return array(
				"error" => 1,
				"message" => "Locação já cadastrada"
			);

		}

		$this->Locacaotemporada_model->etapa = "geral";

		$this->Locacaotemporada_model->imovel = !empty($params_array['imovelid']) ? $params_array['imovelid'] : null;

		$this->Locacaotemporada_model->cliente = !empty($params_array['clienteid']) ? $params_array['clienteid'] : null;

		$this->Locacaotemporada_model->data_inicial = !empty($params_array['data_inicial']) ? $params_array['data_inicial'] : null;

		$this->Locacaotemporada_model->data_final = !empty($params_array['data_final']) ? $params_array['data_final'] : null;

		$this->Locacaotemporada_model->valor_total = $params_array['valor_total'];

		$this->Locacaotemporada_model->taxa_administrativa = $params_array['taxa_administrativa'];

		$this->Locacaotemporada_model->quantidade_parcelas = $params_array['quantidade_parcelas'];

		$this->Locacaotemporada_model->usuario_criacao = $this->getCurrentUser();

		$id = $this->Locacaotemporada_model->save();

		$comissoes = $this->Locacaotemporada_model->saveComissoes($id);

		$parcelamento = $this->Locacaotemporada_model->saveParcelas($id, $params_array);

		$result = array(
			"id" => $id,
			"success" => 1,
			"parcelamento"=>$parcelamento,
			"boletos"=>$this->Locacaotemporada_model->getBoletos($id)
		);

		echo json_encode($result);

		die();
	}

	/**
	* Remover locação
	*/

	public function remover($id){
		$loc = $this->Locacaotemporada_model->getById($id);
		/* Dependências */
		$this->Inquilino_model->removerPorLocacao($id);
		$this->Veiculo_model->removerPorLocacao($id);
		$this->Locacaotemporada_model->id = $id;
		$this->Locacaotemporada_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
		$this->Locacaotemporada_model->delete();
		$this->session->set_flashdata('sucesso', 'Locação excluída com sucesso');
		if ($this->input->get('returnurl')){
			redirect($this->input->get('returnurl'));
		} else {
			redirect(baseurl('locacaotemporada/listar'));
		}
	}

	/**
	* Adicionar inquilino
	*/

	private function inquilinos_adicionar( $id )
	{

		$this->Inquilino_model->nome = $this->input->post('nome');
		$this->Inquilino_model->idade = $this->input->post('idade');
		$this->Inquilino_model->responsavel = $this->input->post('responsavel');
		$this->Inquilino_model->telefone = $this->input->post('telefone');
		$this->Inquilino_model->rg = $this->input->post('rg');
		$this->Inquilino_model->cpf = $this->input->post('cpf');
		$this->Inquilino_model->telefone = $this->input->post('telefone');
		$this->Inquilino_model->data_nascimento = $this->input->post('data_nascimento');
		$this->Inquilino_model->cidade = $this->input->post('cidade');
		$this->Inquilino_model->uf = $this->input->post('uf');

		$this->Inquilino_model->locacao = $id;

		$this->Inquilino_model->save();

		$this->session->set_flashdata('sucesso', 'Inquilino adicionado com sucesso');

		redirect(makeUrl('locacaotemporada', 'inquilinos', $id));

	}

	/**
	* Adicionar veículo
	*/

	private function veiculos_adicionar( $id )
	{

		$this->Veiculo_model->modelo = $this->input->post('modelo');
		$this->Veiculo_model->placa = $this->input->post('placa');
		$this->Veiculo_model->cor = $this->input->post('cor');

		$this->Veiculo_model->locacao = $id;

		$this->Veiculo_model->save();

		$this->session->set_flashdata('sucesso', 'Veículo adicionado com sucesso');

		redirect(makeUrl('locacaotemporada', 'inquilinos', $id));

	}

	/**
	* Remover veículo
	*/

	public function veiculos_remove($id)
	{

		$veiculo = $this->Veiculo_model->getById($id);

		$this->Veiculo_model->id = $id;
		$this->Veiculo_model->delete();

		$this->session->set_flashdata('sucesso', 'Veículo removido com sucesso');
	
		redirect(makeUrl('locacaotemporada', 'inquilinos', $veiculo->nidcadloc));

	}

	/**
	* Função para pegar dados do locatário via ajax
	*/

	public function getDadosLocatario(){
		$this->Locacaotemporada_model->id = $this->input->get('nidcadloc');
		die($this->Locacaotemporada_model->getDadosLocatario());
	}

	/**
	* Alterar ficha de inquilinos
	*/

	public function inquilinos( $id )
	{

		if (!$this->Locacaotemporada_model->getById($id)){
			$this->session->set_flashdata('erro', 'Locação não encontrada');
			redirect(base_url("locacaotemporada/listar"));
		}

		if ($this->input->post()){

			if ($this->input->post('modelo')){

				$this->veiculos_adicionar( $id );

			} else {

				$this->inquilinos_adicionar( $id );

			}

			return;

		}

		$this->title = 'Ficha de Inquilinos - Yoopay - Soluções Tecnologicas';

		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/locacaotemporada/listar_inquilinos.js');

		$this->Locacaotemporada_model->id = $id;

		$this->data['cadloc'] = $this->Locacaotemporada_model->getById($id);

		$this->data['cadimo'] = $this->Imovel_model->getById($this->data['cadloc']->nidcadimo);

		$this->data['entidade'] = $this->Entidade_model->getById($this->data['cadimo']->nidtbxent);

		$this->data['inquilinos'] = array();

		$this->loadview('locacaotemporada/inquilinos');

	}

	/**
	* Remover inquilino
	*/

	public function inquilinos_remove($id)
	{

		$inquilino = $this->Inquilino_model->getById($id);

		$this->Inquilino_model->id = $id;
		$this->Inquilino_model->delete();

		$this->session->set_flashdata('sucesso', 'Inquilino removido com sucesso');
	
		redirect(makeUrl('locacaotemporada', 'inquilinos', $inquilino->nidcadloc));

	}

	/**
	* Lista de inquilinos
	*/

	public function inquilinos_listar_json($id)
	{
		$offset = $this->input->get('start');
		$limit = $this->input->get('length');

		$params['nidcadloc'] = $id;
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Inquilino_model->listar_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadinq;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Inquilino_model->listar_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Inquilino_model->listar_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);

	}

	/**
	* Lista de veículos
	*/

	public function veiculos_listar_json($id)
	{
		$offset = $this->input->get('start');
		$limit = $this->input->get('length');

		$params['nidcadloc'] = $id;
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Veiculo_model->listar_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadvei;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Veiculo_model->listar_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Veiculo_model->listar_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);

	}


	/**
	* Função para aplicar campos variáveis aos contratos
	* @param text conteúdo do contrato com variáveis
	* @return text conteúdo do contrato compilado
	* @access private
	*/

	private function aplicarCampos($conteudo)
	{

		$locacao = $this->Locacaotemporada_model;
		$imovel = $this->Imovel_model;
		$contrato = $this->Contrato_model;

		$this->load->model('dcg/Estadocivil_model');
		$this->load->model('dcg/Tipocadastro_model');
		$this->load->model('dcg/Tiposervico_model');
		$this->load->model('dcg/Tipotelefone_model');
		$this->load->model('dcg/Tipoemail_model');
		$this->load->model('dcg/Entidadeemitente_model');
		$this->load->model('dcg/Profissao_model');
		$this->load->model('dcg/Atividade_model');
		$this->load->model('dep/Tipoendereco_model');
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
		$this->load->model('cadimo/Enderecoimovel_model');

		$this->Locacaotemporada_model = new Locacaotemporada_model();
		$this->Imovel_model = new Imovel_model();
		$this->Contrato_model = new Contrato_model();

		$enderecos_imovel = $this->Enderecoimovel_model->getByImovel($imovel->nidcadimo);

		/* Dados do locatário */

		$this->data['cadgrl'] = $this->Cadastro_model->getById($locacao->nidcadgrl);

		$this->data['enderecos'] = $this->Enderecocadastrogeral_model->getByCadastroGeral( $locacao->nidcadgrl );

		$this->data['telefones'] = $this->Telefonecadastrogeral_model->getByCadastroGeral( $locacao->nidcadgrl );

		if ($this->data['cadgrl']->ctipopessoa == "f"){

			$this->data['cadfis'] = $this->Pessoafisica_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);

			$this->data['tbxest'] = $this->Estadocivil_model->getById($this->data['cadfis']->nidtbxest);

			$this->data['tbxcbo'] = $this->Profissao_model->getById($this->data['cadfis']->nidtbxcbo);

			$this->data['tbxemi'] = $this->Entidadeemitente_model->getById($this->data['cadfis']->nidtbxemi);

			$this->data['tbxnac'] = $this->Nacionalidade_model->getById($this->data['cadfis']->nidtbxnac);

		} else {

			$this->data['cadjur'] = $this->Pessoajuridica_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);

			$this->data['tbxatv'] = $this->Atividade_model->getById($this->data['cadjur']->nidtbxatv);

		}

		$telefones = array();
		foreach ($this->data['telefones'] as $tel){
			$telefones[] = $tel['cdescritel'];
		}

		$conteudo = str_replace("%%referencia%%", $imovel->creferencia, $conteudo);
		$conteudo = str_replace("%%imovel_endereco%%", $enderecos_imovel[0]['cnometpl']." ".$enderecos_imovel[0]['cdescrilog'].", ".$enderecos_imovel[0]['cnumero'].($enderecos_imovel[0]['ccomplemento'] ? (", ".$enderecos_imovel[0]['ccomplemento']) : ""), $conteudo);
		$conteudo = str_replace("%%imovel_acomodacoes%%", $imovel->nacomodacoes, $conteudo);
		$conteudo = str_replace("%%locatario_nome%%", $locatario->cnomegrl, $conteudo);
		$conteudo = str_replace("%%locatario_nacionalidade%%", $this->data['tbxnac']->cdescrinac, $conteudo);
		$conteudo = str_replace("%%locatario_estadocivil%%", $this->data['tbxest']->cdescriest, $conteudo);
		$conteudo = str_replace("%%locatario_rg%%", $this->data['cadgrl']->crgie, $conteudo);
		$conteudo = str_replace("%%locatario_ufrg%%", $this->data['tbxemi']->cdescriemi, $conteudo);
		$conteudo = str_replace("%%locatario_cpf%%", $this->data['cadgrl']->ccpfcnpj, $conteudo);
		$conteudo = str_replace("%%locatario_endereco%%", $this->data['enderecos'][0]['cdescrilog'].", ".$this->data['enderecos'][0]['cnumero'].($this->data['enderecos'][0]['ccomplemento'] ? (", ".$this->data['enderecos'][0]['ccomplemento']) : ""), $conteudo);
		$conteudo = str_replace("%%locatario_cep%%", $this->data['enderecos'][0]['ccep_log'] ? $this->data['enderecos'][0]['ccep_log'] : $this->data['enderecos'][0]['ccep_loc'], $conteudo);
		$conteudo = str_replace("%%locatario_cidade%%", $this->data['enderecos'][0]['cdescriloc'], $conteudo);
		$conteudo = str_replace("%%locatario_uf%%", $this->data['enderecos'][0]['cdescriuf'], $conteudo);
		$conteudo = str_replace("%%locatario_telefones%%", implode(",", $telefones), $conteudo);

		/* Dados do proprietário */

		$proprietarios = $this->Imovel_model->getProprietarios($imovel->nidcadimo);

		$nomes_proprietarios = array();

		foreach ($proprietarios as $prop){
			$nomes_proprietarios[] = $prop['cadgrl']->cnomegrl;
		}

		$nome_proprietario = implode(", ", $nomes_proprietarios);

		$this->data['cadgrl'] = $this->Cadastro_model->getById($proprietarios[0]['cadgrl']->nidcadgrl);

		$this->data['enderecos'] = $this->Enderecocadastrogeral_model->getByCadastroGeral( $proprietarios[0]['cadgrl']->nidcadgrl );

		$this->data['telefones'] = $this->Telefonecadastrogeral_model->getByCadastroGeral( $proprietarios[0]['cadgrl']->nidcadgrl );

		if ($this->data['cadgrl']->ctipopessoa == "f"){

			$this->data['cadfis'] = $this->Pessoafisica_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);

			$this->data['tbxest'] = $this->Estadocivil_model->getById($this->data['cadfis']->nidtbxest);

			$this->data['tbxcbo'] = $this->Profissao_model->getById($this->data['cadfis']->nidtbxcbo);

			$this->data['tbxemi'] = $this->Entidadeemitente_model->getById($this->data['cadfis']->nidtbxemi);

			$this->data['tbxnac'] = $this->Nacionalidade_model->getById($this->data['cadfis']->nidtbxnac);

		} else {

			$this->data['cadjur'] = $this->Pessoajuridica_model->getByCadastroGeral($this->data['cadgrl']->nidcadgrl);

			$this->data['tbxatv'] = $this->Atividade_model->getById($this->data['cadjur']->nidtbxatv);

		}

		$telefones = array();
		foreach ($this->data['telefones'] as $tel){
			$telefones[] = $tel['cdescritel'];
		}

		$conteudo = str_replace("%%proprietario_nome%%", $nome_proprietario, $conteudo);
		$conteudo = str_replace("%%proprietario_nacionalidade%%", $this->data['tbxnac']->cdescrinac, $conteudo);
		$conteudo = str_replace("%%proprietario_profissao%%", $this->data['tbxcbo']->cdescricbo, $conteudo);
		$conteudo = str_replace("%%proprietario_estadocivil%%", $this->data['tbxest']->cdescriest, $conteudo);
		$conteudo = str_replace("%%proprietario_rg%%", $this->data['cadgrl']->crgie, $conteudo);
		$conteudo = str_replace("%%proprietario_ufrg%%", $this->data['tbxemi']->cdescriemi, $conteudo);
		$conteudo = str_replace("%%proprietario_cpf%%", $this->data['cadgrl']->ccpfcnpj, $conteudo);
		$conteudo = str_replace("%%proprietario_endereco%%", $this->data['enderecos'][0]['cdescrilog'].", ".$this->data['enderecos'][0]['cnumero'].($this->data['enderecos'][0]['ccomplemento'] ? (", ".$this->data['enderecos'][0]['ccomplemento']) : ""), $conteudo);
		$conteudo = str_replace("%%proprietario_cidade%%", $this->data['enderecos'][0]['cdescriloc'], $conteudo);
		$conteudo = str_replace("%%proprietario_uf%%", $this->data['enderecos'][0]['cdescriuf'], $conteudo);

		$conteudo = str_replace("%%locacao_quantidade_dias%%", floor((strtotime($locacao->ddatafinal) - strtotime($locacao->ddatainicial)) / (60*60*24)), $conteudo);
		$conteudo = str_replace("%%locacao_data_inicial%%", toUserDate($locacao->ddatainicial), $conteudo);
		$conteudo = str_replace("%%locacao_data_final%%", toUserDate($locacao->ddatafinal), $conteudo);
		$conteudo = str_replace("%%locacao_data_saida%%", date('d/m/Y', strtotime($locacao->ddatafinal." +1 day")), $conteudo);
		$conteudo = str_replace("%%locacao_data_retirada_chave%%", toUserDate($locacao->ddatainicial), $conteudo);
		$conteudo = str_replace("%%locacao_valor_total%%", number_format($locacao->nvalor, 2, ",", "."), $conteudo);
		$conteudo = str_replace("%%locacao_valor_diarias%%", number_format($locacao->nvalor - $locacao->ntaxaadm, 2, ",", "."), $conteudo);
		$conteudo = str_replace("%%locacao_taxa_administrativa%%", number_format($locacao->ntaxaadm, 2, ",", "."), $conteudo);
		$conteudo = str_replace("%%locacao_descricao_pagamento%%", $locacao->cdescricao, $conteudo);


		return $conteudo;

	}

	/**
	* Função para calcular os valores de uma locação com base no Imóvel e no período de locação
	* @access public
	* @return none
	*/

	public function calcularDatas(){

		$nidcadimo = $this->input->post('nidcadimo');

		$quantidade_parcelas = $this->input->post('quantidade_parcelas');

		if (!$quantidade_parcelas){
			$quantidade_parcelas = Parametro_model::get('quantidade_parcelas_padrao_locacao');
		}

		$taxa_administrativa = $this->input->post('taxa_administrativa');

		if (!$taxa_administrativa){
			$taxa_administrativa = 0;
		}


		$this->Imovel_model = $this->Imovel_model->getById($nidcadimo);

		if (!$this->Imovel_model){
			$result = array(
				"Imóvel não localizado"
			);
			echo json_encode($result);
			die();
		}

		$data_inicial = $this->input->post('data_inicial');
		$data_final = $this->input->post('data_final');

		$datetime_inicial = date_create(toDbdate($data_inicial));
		$datetime_final = date_create(toDbDate($data_final));

		$intervalo = date_diff($datetime_inicial, $datetime_final);

		$intervalo_dias = $intervalo->format('%d');

		if (!$intervalo_dias)
			$intervalo_dias = 1; // Caso a pessoa selecionar duas datas iguais

		$valor = Imovel_model::getMaiorDiaria($nidcadimo);

		$valor_diarias = $intervalo_dias * $valor;

		$result = array(
			"nidcadimo"=>$nidcadimo,
			"data_inicial"=>$data_inicial,
			"data_final"=>$data_final,
			"data_inicial_db"=>toDbDate($data_inicial),
			"data_final_db"=>toDbDate($data_final),
			"quantidade_parcelas"=>$quantidade_parcelas,
			"quantidade_dias"=>$intervalo_dias,
			"valor_diarias"=>$valor_diarias,
			"taxa_administrativa"=>$taxa_administrativa,
			"valor_total"=>$taxa_administrativa + $valor_diarias
		);

		echo json_encode($result);
		die();
	
	}

	/**
	* Função para gerar contrato
	* @param integer ID da locação
	* @param integer ID do tipo de contrato
	* @param text Conteúdo do contrato compilado
	* @access private
	* @return none
	*/

	private function gerarContrato($locacao_id, $tipo_contrato, $conteudo)
	{

		//$oldmask = umask(0);

		$this->Locacaotemporada_model = $this->Locacaotemporada_model->getById($locacao_id);

		$this->Tipocontrato_model = $this->Tipocontrato_model->getById($tipo_contrato);

		$this->Imovel_model = $this->Imovel_model->getById($this->Locacaotemporada_model->nidcadimo);

		$imovel = $this->Imovel_model;

		if (!is_dir('contratos/'.$this->Imovel_model->creferencia)){

			mkdir('contratos/'.$this->Imovel_model->creferencia, 0777);

		}

		$hash = md5($this->Locacaotemporada_model->nidcadloc.$this->Imovel_model->nidcadimo.$this->Imovel_model->creferencia.date('YmdHis').rand(1,9999));

		$this->Contrato_model->locacao = $this->Locacaotemporada_model->nidcadloc;
		$this->Contrato_model->usuario_criacao = $this->getCurrentUser();
		$this->Contrato_model->tipo = $this->Tipocontrato_model->nidtbxcon;
		$this->Contrato_model->caminho = makeUrl('contratos/'.$this->Imovel_model->creferencia.'/'.$hash.".pdf");
		$this->Contrato_model->save();

		$this->load->library('pdf');

	    $pdf = $this->pdf->load();
	    $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
	    
	    $pdf->WriteHTML($this->aplicarCampos($conteudo));
	   
	    $r = $pdf->Output('contratos/'.$imovel->creferencia.'/'.$hash.'.pdf', 'F'); // save to file because we can
		umask($oldmask);

		return;

	}

	/**
	* Abre os contratos de um Imóvel
	*/

	public function contratos( $id )
	{

		$funcao = $this->input->get('funcao');

		if ($funcao == "gerar"){

			$this->gerarContrato($id, $this->input->post('nidtbxcon'), $this->input->post('tconteudo'));

			$this->session->set_flashdata('sucesso', 'Contrato gerado com sucesso');

			redirect(makeUrl('locacaotemporada', 'contratos', $id));

		}

		$this->enqueue_script('vendor/bootstrap-wysiwyg/bootstrap-wysiwyg.js');
		$this->enqueue_script('vendor/bootstrap-wysiwyg/external/jquery.hotkeys.js');
		$this->enqueue_script('app/js/wysiwyg.js');

		$this->title = 'Visualizar Contratos - Yoopay - Soluções Tecnológicas';

		$this->Locacaotemporada_model = $this->Locacaotemporada_model->getById($id);

		$this->Imovel_model = $this->Imovel_model->getById($this->Locacaotemporada_model->nidcadimo);

		$tbxcon = $this->Tipocontrato_model->getByFinalidade( Parametro_model::get("finalidade_locacao_id") );

		foreach ($tbxcon as $item){

			$this->data['con'][] = $this->Tipocontrato_model->getById($item);

		}

		$this->data['cadloc'] = $this->Locacaotemporada_model;
		$this->data['cadimo'] = $this->Imovel_model;

		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/locacaotemporada/contratos.js');

		$this->data['contratos'] = $this->Contrato_model->getByLocacao($id);

		$this->loadview('locacaotemporada/contratos');

	}

	/* lista de contratos para o JSON */

	public function contratos_json()
	{
		// paginação
		$start 	= $this->input->get('iDisplayStart');
		$length = $this->input->get('iDisplayLength');

		// palavras chave
		$params['nidcadloc'] = ($this->input->get('nidcadloc')) ? trim($this->input->get('nidcadloc')) : NULL;
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Contrato_model->listar_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadcon;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Contrato_model->listar_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Contrato_model->listar_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);

	}

	/**
	* Pesquisa de imóveis
	*/

	public function pesquisarimoveis()
	{

		$this->load->model('dci/Caracteristica_model');

		$this->data['pacotes'] = $this->Tipopacote_model->getAll();

		$this->data['car'] = $this->Caracteristica_model->getAll();

		$this->data['bai'] = $this->Bairro_model->getAll();

		$this->data['uf'] = $this->Uf_model->getAll();

		$this->data['loc'] = $this->Localidade_model->getAll();

		$this->data['tpi'] = $this->Tipoimovel_model->getAll();

		$this->data['tpd'] = $this->Tipodistancia_model->getAll();

		$this->data['tmd'] = $this->Tipomedidadistancia_model->getAll();

		$this->data['trd'] = $this->Tiporeferenciadistancia_model->getAll();

		$this->data['fva'] = $this->Finalidadetipovalor_model->getAllFront();

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('app/js/locacaotemporada/pesquisarimoveis.js?v='.rand(1,9999));

		$this->title = 'Pesquisar Imóveis - Yoopay - Soluções Tecnológicas';

		$this->loadview('locacaotemporada/pesquisarimoveis');

	}

	/**
	* Resultado da pesquisa de imóveis
	*/

	public function resultadoimoveis()
	{

		$this->title = 'Locação Temporada - Yoopay - Soluções Tecnológicas';

		$this->data['fva'] = $this->Finalidadetipovalor_model->getAllFront();

		$this->data['tpd'] = $this->Tipodistancia_model->getAll();
		$this->data['tmd'] = $this->Tipomedidadistancia_model->getAll();
		$this->data['trd'] = $this->Tiporeferenciadistancia_model->getAll();

		$this->enqueue_style('vendor/jquery-ui/themes/smoothness/jquery-ui.min.css');

		$this->enqueue_style('vendor/jquery-ui/themes/smoothness/theme.css');

		$this->enqueue_style('app/css/locacaotemporada/resultadoimoveis.css');

		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('http://maps.google.com/maps/api/js?sensor=false');

		$this->enqueue_script('app/js/locacaotemporada/resultadobusca.js?v='.rand(1,9999));

		$finalidade_locacao_id = Parametro_model::get("finalidade_locacao_id");

		/* Data inicial */

		$data_inicial = $this->input->get('datan');

		$this->data['data_inicial'] = $data_inicial;

		/* Data final */

		$data_final = $this->input->get('dataf');

		$this->data['data_final'] = $data_final;

		/* Neutralizar calendário */

		$neutralizar_calendario = $this->input->get('neutralizar_calendario');

		/* Tipo de Imóvel */

		$nidtbxtpi = $this->input->get('nidtbxtpi');

		/* Se o Imóvel tem área averbada ou não */

		$area_averbada = $this->input->get('area_averbada');

		/* Situação da locação (com ou sem opção assinada) */

		$situacao_locacao = $this->input->get('situacao_locacao');

		/* Se o Imóvel deve estar disponível para um pacote de 7 dias de locação */

		$pacote_locacao = $this->input->get('pacote_locacao');

		/* Referência */

		$referencia = $this->input->get('referencia');

		/* Número de quartos */

		$n_quartos = $this->input->get('n_quartos');

		$n_quartos_comparador = $this->input->get('n_quartos_comparador');

		/* Pacote */

		$pacote = $this->input->get('nidtbxpac');

		/* Valor da diária */

		$diaria = $this->input->get('diaria');

		$diaria_comparador = $this->input->get('diaria_comparador');

		/* Endereço */

		$endereco = $this->input->get('endereco');

		$endereco_comparador = $this->input->get('endereco_comparador');

		$numero = $this->input->get('numero');

		$cep = $this->input->get('cep');

		/* Acomodações */

		$acomodacoes = $this->input->get('n_acomodacoes');

		$acomodacoes_comparador = $this->input->get('n_acomodacoes_comparador');

		/* Ordenação */

		$ordenar_por = $this->input->get('ordenar_por');

		/* Relação de Bens */

		$relacao_bens = $this->input->get('relacao_bens');

		/* Localização */

		$estado = $this->input->get('estado');

		$localizacao = $this->input->get('localizacao');

		$bairros = $this->input->get('bairros');

		/* Distâncias */

		$distancia = $this->input->get('distancia');

		$distancia_comparador = $this->input->get('distancia_comparador');

		$distancia_unidade = $this->input->get('distancia_unidade');

		/* Características */

		$caracteristicas = $this->input->get('caracteristicas');

		/* Montar query */

		$fields = array();

		$fields[] = 'i.nidcadimo';

		$this->db->select($fields);

		$this->db->from('cadimo i');

		$this->db->join('tagedi edi', 'edi.nidcadimo = i.nidcadimo', 'INNER');

		$this->db->join('tbxend end', 'edi.nidtbxend = end.nidtbxend', 'INNER');

		$this->db->join('cadlog log', 'end.nidcadlog = log.nidcadlog', 'INNER');

		$this->db->join('tbxbai bai', 'log.nidtbxbai = bai.nidtbxbai', 'INNER');

		$this->db->join('tbxloc loc', 'bai.nidtbxloc = loc.nidtbxloc', 'INNER');

		$this->db->join('tbxuf uf', 'loc.nidtbxuf = uf.nidtbxuf', 'INNER');

		/* Critérios */

		/* Disponibilidade */

		$this->data['neutralizar_calendario'] = $neutralizar_calendario;

		if (!$neutralizar_calendario && $data_inicial && $data_final){

			/* A opção de neutralizar calendário não foi selecionada e os campos de data foram preenchidos. Trazer somente imóveis disponíveis nesse período e exibir calendário no front */

			$data_inicial_mysql = toDbDate($data_inicial);

			$data_final_mysql = toDbDate($data_final);

			$this->db->where('NOT EXISTS(SELECT 1 FROM cadloc l WHERE l.nidcadimo = i.nidcadimo AND ddatainicial >= "'.$data_inicial_mysql.'" AND ddatainicial <= "'.$data_final_mysql.'")', null, false);

			$this->db->where('NOT EXISTS(SELECT 1 FROM cadloc l WHERE l.nidcadimo = i.nidcadimo AND ddatafinal <= "'.$data_final_mysql.'" AND ddatafinal >= "'.$data_inicial_mysql.'")', null, false);

			$this->db->where('NOT EXISTS(SELECT 1 FROM cadloc l WHERE l.nidcadimo = i.nidcadimo AND ddatainicial <= "'.$data_inicial_mysql.'" AND ddatafinal >= "'.$data_final_mysql.'")', null, false);

			$this->db->where('NOT EXISTS(SELECT 1 FROM cadloc l WHERE l.nidcadimo = i.nidcadimo AND ddatainicial >= "'.$data_inicial_mysql.'" AND ddatafinal <= "'.$data_final_mysql.'")', null, false);

		}

		if ($nidtbxtpi){

			$this->db->where('i.nidtbxtpi', $nidtbxtpi);

		}

		if ($area_averbada){

			$this->db->where('i.nareaaverbada >', 0);

		}

		if ($pacote){
			$this->db->where('EXISTS(SELECT 1 FROM tagpci p WHERE p.nidcadimo = i.nidcadimo AND p.nidtbxpac = "'.$pacote.'")', null, false);
		}

		if ($acomodacoes){

			if ($acomodacoes_comparador == "="){

				$this->db->where('i.nacomodacoes', $acomodacoes);

			} elseif ($acomodacoes_comparador == "<"){

				$this->db->where('i.nacomodacoes <', $acomodacoes);

			} elseif ($acomodacoes_comparador == ">"){

				$this->db->where('i.nacomodacoes >', $acomodacoes);

			}

		}

		if ($n_quartos){

			if ($n_quartos_comparador == "="){

				$this->db->where('i.nquartos', $n_quartos);

			} elseif ($n_quartos_comparador == "<"){

				$this->db->where('i.nquartos <', $n_quartos);

			} elseif ($n_quartos_comparador == ">"){

				$this->db->where('i.nquartos >', $n_quartos);

			}

		}

		if (is_array($diaria) && count($diaria) > 0){

			foreach ($diaria as $fva=>$valor){

				if ($valor > 0){

					if ($diaria_comparador[$fva] == "="){

						$this->db->where('EXISTS(SELECT 1 FROM tbxiva WHERE tbxiva.nidtagfva = "'.$fva.'" AND tbxiva.nidcadimo = i.nidcadimo AND tbxiva.nvalor = "'.$valor.'")');

					} elseif ($diaria_comparador[$fva] == ">"){

						$this->db->where('EXISTS(SELECT 1 FROM tbxiva WHERE tbxiva.nidtagfva = "'.$fva.'" AND tbxiva.nidcadimo = i.nidcadimo AND tbxiva.nvalor > "'.$valor.'")');

					} elseif ($diaria_comparador[$fva] == "<"){

						$this->db->where('EXISTS(SELECT 1 FROM tbxiva WHERE tbxiva.nidtagfva = "'.$fva.'" AND tbxiva.nidcadimo = i.nidcadimo AND tbxiva.nvalor < "'.$valor.'")');

					}

				}

			}

		}

		if (is_array($distancia) && count($distancia) > 0){

			foreach ($distancia as $tpd=>$distancia){

				if ($distancia > 0){

					if ($distancia_comparador[$tpd] == "="){

						$this->db->where('EXISTS(SELECT 1 FROM tagdii dii WHERE dii.nidcadimo = i.nidcadimo AND nidtbxtmd = "'.$distancia_unidade[$tpd].'" AND ndistancia = "'.$distancia[$tpd].'")');

					} elseif ($distancia_comparador[$tpd] == ">"){

						$this->db->where('EXISTS(SELECT 1 FROM tagdii dii WHERE dii.nidcadimo = i.nidcadimo AND nidtbxtmd = "'.$distancia_unidade[$tpd].'" AND ndistancia > "'.$distancia[$tpd].'")');

					} elseif ($distancia_comparador[$tpd] == "<"){

						$this->db->where('EXISTS(SELECT 1 FROM tagdii dii WHERE dii.nidcadimo = i.nidcadimo AND nidtbxtmd = "'.$distancia_unidade[$tpd].'" AND ndistancia < "'.$distancia[$tpd].'")');

					}

				}

			}

		}

		if ($endereco){

			$this->db->like('log.cdescrilog', $endereco);

		}

		if ($numero){

			$this->db->where('end.cnumero', $numero);

		}

		if ($cep){

			$this->db->where('(log.ccep = "'.$cep.'" OR loc.ccep = "'.$cep.'")');

		}

		if ($estado){

			$this->db->where('loc.nidtbxuf', $estado);

		}

		if ($localizacao){

			$this->db->where('loc.nidtbxloc', $localizacao);

		}

		if ($bairros){

			$this->db->where_in('bai.nidtbxbai', $bairros);

		}

		if ($referencia){

			$this->db->where('i.creferencia', $referencia);

		}

		if ($caracteristicas){

			$this->db->join('tagcim cim', 'cim.nidcadimo = i.nidcadimo', 'INNER');

			$this->db->where_in('cim.nidtbxcar', $caracteristicas);

		}

		$this->db->where('i.nidtbxfin', $finalidade_locacao_id);

		$ordenar_por = $this->input->get('ordenar_por');

		switch ($ordenar_por){
			case 'tipo':
				$this->db->join('tbxtpi tpi', 'tpi.nidtbxtpi = i.nidtbxtpi', 'INNER');
				$this->db->order_by('tpi.cnometpi', 'ASC');
				break;
			case 'ref':
				$this->db->order_by('i.creferencia', 'ASC');
				break;
			case 'ultimos_cadastros':
				$this->db->order_by('i.dtdatacriacao', 'DESC');
				break;
			case 'valor':
				$this->db->join('tbxiva iva', 'iva.nidcadimo = i.nidcadimo', 'INNER');
				$this->db->order_by('iva.nvalor', 'ASC');
				break;
			case 'valor_descrescente':
				$this->db->join('tbxiva iva', 'iva.nidcadimo = i.nidcadimo', 'INNER');
				$this->db->order_by('iva.nvalor', 'DESC');
				break;
			case 'metragem':
				$this->db->order_by('nareautil', 'ASC');
				break;
			case 'quartos':
				$this->db->order_by('nquartos', 'ASC');
				break;			
		}

		$this->db->group_by('i.nidcadimo');

		$results = $this->db->get()->result();

		foreach ($results as $item){

			$this->data['imoveis'][] = $this->Imovel_model->getById($item->nidcadimo);

		}

		$this->enqueue_html('locacaotemporada/modal_adicionar_imovel_atendimento.php');

		$this->enqueue_html('locacaotemporada/modal_imovel_proprietario.php');

		$this->enqueue_html('locacaotemporada/modal_imovel_angariador.php');

		$this->loadview('locacaotemporada/resultadoimoveis');

	}

	/**
	* Função de pesquisa para gerar o relatório de locações
	*/

	public function relatorio($imovel = false){

		if ($this->input->get()){
			/* Gerar relatório */
			$this->gerarRelatorio();
			return;
		}

		$this->load->model('seg/Segusuario_model');

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('app/js/locacaotemporada/relatorio.js?v='.rand(1,9999));

		$this->data['usuarios'] = $this->Segusuario_model->getAll();

		$this->title = 'Relatório de locação - Inserir parâmetros - Yoopay - Soluções Tecnológicas';

		if ($imovel){
			$this->data['nidcadimo'] = $imovel;
		}

		$this->loadview('locacaotemporada/relatorio_pesquisa');
	}

	/**
	* Função para gerar o relatório unificado da locação
	*/

	public function unificado($locacao_id){

		$this->data['returnurl'] = $_SERVER['HTTP_REFERER'];

		$this->load->model('fin/Financeiro_model');
		$this->load->model('dep/Formapagamento_model');
		$this->load->model('dep/Statuspagamento_model');

		$locacao = $this->Locacaotemporada_model->getById($locacao_id);

		if (!$locacao){
			$this->session->set_flashdata('erro', 'Locação não encontrada');
			redirect($this->data['returnurl']);
		}

		$imovel = $this->Imovel_model->getById($locacao->nidcadimo);

		$this->title = 'Extrato unificado de locação - Yoopay - Soluções Tecnológicas';

		$this->data['cadimo'] = $imovel;
		$this->data['cadloc'] = $locacao;
		$this->data['proprietario'] = $this->Proprietarioimovel_model->getByImovel($imovel->nidcadimo);
		$this->data['locatario'] = $this->Cadastro_model->getById($locacao->nidcadgrl);
		
		$this->data['depositos_receber'] = $this->Financeiro_model->getDepositosReceber($locacao_id, Parametro_model::get('finalidade_locacao_id'));
		$this->data['depositos_fazer'] = $this->Financeiro_model->getDepositosFazer($locacao_id);
		$this->data['despesas_receber'] = $this->Financeiro_model->getDespesasReceber($locacao_id);

		$this->loadview('locacaotemporada/extrato_unificado');
	}

	/**
	* Função de pesquisa de entradas em um período de datas
	*/

	public function relatorioentradas($imovel = false){

		if ($this->input->get()){
			/* Gerar relatório */
			$this->gerarRelatorioEntradas();
			return;
		}

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('app/js/locacaotemporada/relatorioentradas.js?v='.rand(1,9999));

		$this->title = 'Relatório de entradas - Inserir parâmetros - Yoopay - Soluções Tecnológicas';

		if ($imovel){
			$this->data['nidcadimo'] = $imovel;
		}

		$this->loadview('locacaotemporada/relatorio_entradas_pesquisa');
	}

	/**
	* Função de pesquisa de saídas em um período de datas
	*/

	public function relatoriosaidas($imovel = false){

		if ($this->input->get()){
			/* Gerar relatório */
			$this->gerarRelatorioSaidas();
			return;
		}

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('app/js/locacaotemporada/relatoriosaidas.js?v='.rand(1,9999));

		$this->title = 'Relatório de saídas - Inserir parâmetros - Yoopay - Soluções Tecnológicas';

		if ($imovel){
			$this->data['nidcadimo'] = $imovel;
		}

		$this->loadview('locacaotemporada/relatorio_saidas_pesquisa');
	}

	/**
	* Função de pesquisa os depósitos
	*/

	public function depositos(){

		$this->load->model('dcg/Banco_model');
		$this->load->model('dcg/Tipoconta_model');

		if ($this->input->get()){
			/* Gerar relatório */
			$this->gerarRelatorioDepositos();
			return;
		}

		$this->data['bco'] = $this->Banco_model->getAll();

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('app/js/locacaotemporada/relatoriodepositos.js?v='.rand(1,9999));

		$this->title = 'Relação de Depósitos - Inserir parâmetros - Yoopay - Soluções Tecnológicas';

		$this->loadview('locacaotemporada/relatorio_depositos_pesquisa');
	}

	/**
	* Função para gerar o relatório de depósitos
	*/

	public function gerarRelatorioDepositos(){

		$this->load->model('dep/Formapagamento_model');

		$this->load->model('dep/Statuspagamento_model');

		$this->load->model('fin/Financeiro_model');

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$this->title = 'Relação de Depósitos - Yoopay - Soluções Tecnológicas';
		
		$banco = $this->input->get('banco');
		$data_inicial = $this->input->get('datan');
		$data_final = $this->input->get('dataf');
		$pagar_receber = $this->input->get('pagar_receber');
		$status = $this->input->get('status');

		if ($banco){
			$this->data['bancos'] = array($this->Banco_model->getById($banco));
		} else {
			$this->data['bancos'] = $this->Banco_model->getAll();
		}

		$depositos = $this->Financeiro_model->getDepositos($status, $banco, $data_inicial, $data_final, $pagar_receber);

		$this->data['depositos'] = $depositos;

		$this->loadview('locacaotemporada/relatorio_depositos');
	}

	/**
	* Função para confirmar depósitos
	*/

	public function confirmardepositos(){
		$this->load->model('fin/Financeiro_model');
		$depositos = $this->input->post('nidcadfin');
		foreach ($depositos as $deposito){
			$this->Financeiro_model = new Financeiro_model();
			$this->Financeiro_model->nidcadfin = $deposito;
			$this->Financeiro_model->data_pagamento = date('Y-m-d');
			$this->Financeiro_model->data_status = date('Y-m-d');
			$this->Financeiro_model->nidtbxstp = Parametro_model::get("id_status_pagamento_pago");
			$this->Financeiro_model->confirmarPagamento();
		}
		$this->load->library('user_agent');
		$this->session->set_flashdata('sucesso', 'Depósitos confirmados com sucesso');
		redirect($this->agent->referrer());
	}

	/**
	* Função para gerar o relatório de entradas
	*/

	public function gerarRelatorioEntradas(){
		$this->load->model('dcg/Tiposervico_model');
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$this->data['tps'] = $this->Tiposervico_model->getAll();
		$this->data['prestadores'] = $this->Cadastro_model->getPrestadores();
		$data_inicio = $this->input->get('datan');
		$data_fim = $this->input->get('dataf');
		$locacoes = $this->Locacaotemporada_model->getEntradas($nidcadimo, $data_inicio, $data_fim);
		$this->enqueue_script('app/js/locacaotemporada/relatorio_entradas_lista.js?v='.rand(1,9999));
		$this->data['locacoes'] = $locacoes;
		$this->data['nidcadloc'] = $this->session->flashdata('nidcadloc');
		$this->data['abrir_modal_servicos'] = $this->session->flashdata('abrir_modal_servico');
		$this->title = 'Relatório de entradas - Yoopay - Soluções Tecnológicas';
		$this->enqueue_html('locacaotemporada/relatorio_modal_servicos.php');
		$this->loadview('locacaotemporada/relatorio_entradas');
	}

	/**
	* Função para gerar o relatório de saídas
	*/

	public function gerarRelatorioSaidas(){
		$this->load->model('dcg/Tiposervico_model');
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$this->data['tps'] = $this->Tiposervico_model->getAll();
		$this->data['prestadores'] = $this->Cadastro_model->getPrestadores();
		$data_inicio = $this->input->get('datan');
		$data_fim = $this->input->get('dataf');
		$locacoes = $this->Locacaotemporada_model->getSaidas($nidcadimo, $data_inicio, $data_fim);
		$this->enqueue_script('app/js/locacaotemporada/relatorio_saidas_lista.js?v='.rand(1,9999));
		$this->data['locacoes'] = $locacoes;
		$this->data['nidcadloc'] = $this->session->flashdata('nidcadloc');
		$this->data['abrir_modal_servicos'] = $this->session->flashdata('abrir_modal_servico');
		$this->title = 'Relatório de saídas - Yoopay - Soluções Tecnológicas';
		$this->enqueue_html('locacaotemporada/relatorio_modal_servicos.php');
		$this->loadview('locacaotemporada/relatorio_saidas');
	}

	/**
	* Função para gerar o relatório de locações
	*/

	public function gerarRelatorio(){
		$this->load->model('fin/Despesa_model');
		$this->load->model('dcg/Tiposervico_model');
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$this->data['tps'] = $this->Tiposervico_model->getAll();
		$this->data['prestadores'] = $this->Cadastro_model->getPrestadores();
		$data_inicio = $this->input->get('datan');
		$data_fim = $this->input->get('dataf');
		$campo = $this->input->get('campo');
		$usuario = $this->input->get('nidtbxsegusu_criacao');
		$nidcadimo = $this->input->get('nidcadimo');
		$referencia = $this->input->get('referencia');
		$locacoes = $this->Locacaotemporada_model->getByCampo($nidcadimo, $data_inicio, $data_fim, $campo, $usuario, $referencia);
		$this->enqueue_script('app/js/locacaotemporada/relatorio_lista.js?v='.rand(1,9999));
		$this->data['locacoes'] = $locacoes;
		$this->data['abrir_modal_despesas'] = $this->session->flashdata('abrir_modal_despesa');
		$this->data['abrir_modal_servicos'] = $this->session->flashdata('abrir_modal_servico');
		$this->data['nidcadloc'] = $this->session->flashdata('nidcadloc');
		$this->title = 'Relatório de locação - Yoopay - Soluções Tecnológicas';
		$this->enqueue_html('locacaotemporada/relatorio_modal_despesas.php');
		$this->enqueue_html('locacaotemporada/relatorio_modal_servicos.php');
		$this->enqueue_html('locacaotemporada/relatorio_modal_depositos.php');
		$this->loadview('locacaotemporada/relatorio');
	}

	/**
	* Função para cadastrar uma despesa
	*/

	public function cadastrardespesa(){
		$this->load->model('fin/Despesa_model');
		$this->load->model('fin/Tipofinanceiro_model');
		$this->load->model('fin/Financeiro_model');
		$this->Despesa_model->nidcadloc = $this->input->post('nidcadloc');
		$this->Despesa_model->nidcadgrl = $this->input->post('nidcadgrl');
		$this->Despesa_model->valor_cobrado = $this->input->post('valor_cobrado');
		$this->Despesa_model->valor_prestador = $this->input->post('valor_prestador');
		$this->Despesa_model->descricao = $this->input->post('descricao');
		$this->Despesa_model->data = toDbDate($this->input->post('data'));
		$this->Despesa_model->usuario_criacao = $this->session->userdata('nidtbxsegusu');
		if ($this->Despesa_model->validaInsercao()){
			$this->Despesa_model->save();
			$this->session->set_flashdata('sucesso', 'Despesa adicionada com sucesso');
		} else {
			$this->session->set_flashdata('erro', 'Erro ao adicionar a despesa');
		}
		$fin = new Financeiro_model();
		$locacao = $this->Locacaotemporada_model->getById($this->Despesa_model->nidcadloc);
		$imovel = $this->Imovel_model->getById($locacao->nidcadimo);
		$fin->nidcadloc = $this->input->post('nidcadloc');
		$fin->nidcadimo = $imovel->nidcadimo;
		$fin->nidtbxfpa = Parametro_model::get("id_forma_pagamento_despesa_padrao");
		$fin->nidtbxstp = Parametro_model::get("id_status_pagamento_pendente");
		$fin->valor = $this->Despesa_model->valor_cobrado;
		$fin->data_pagamento = toDbDate($this->input->post('data'));
		$fin->tipo_transacao = "D";
		$fin->tipo = Tipofinanceiro_model::getIdByCod("des");
		$fin->data_status = date('d/m/Y');
		$fin->descricao = 'Despesa - '.$this->input->post('descricao').' - '.$this->input->post('data');
		$fin->observacoes = '';
		if ($fin->validaInsercao()){
			$fin->save();
		}
		$this->session->set_flashdata('abrir_modal_despesa', 1);
		$this->session->set_flashdata('nidcadloc', $this->input->post('nidcadloc'));
		redirect($this->input->post('returnurl'));
	}

	/**
	* Função para pegar as despesas de uma locação (Ajax)
	*/

	public function getdespesas($locacao_id){
		$this->load->model('fin/Despesa_model');
		$despesas = $this->Despesa_model->getByLocacao($locacao_id);
		die(json_encode($despesas));
	}

	/**
	* Função para excluir uma despesa
	*/

	public function excluirdespesa($despesa_id){
		$this->load->model('fin/Despesa_model');
		$despesa = $this->Despesa_model->getById($despesa_id);
		if (!$despesa){
			$this->session->set_flashdata('erro', 'Despesa não encontrada');
			redirect($this->input->get('returnurl'));
		}
		$this->Despesa_model->id = $despesa_id;
		$this->Despesa_model->delete();
		$this->session->set_flashdata('nidcadloc', $despesa->nidcadloc);
		$this->session->set_flashdata('sucesso', 'Despesa excluída com sucesso');
		$this->session->set_flashdata('abrir_modal_despesa', 1);
		redirect($this->input->get('returnurl'));
	}

	/**
	* Função para cadastrar um serviço
	*/

	public function cadastrarservico(){
		$this->load->model('fin/Servico_model');
		$this->load->model('fin/Financeiro_model');
		$this->load->model('fin/Tipofinanceiro_model');
		$this->load->model('dcg/Tiposervico_model');
		$this->Servico_model->nidcadloc = $this->input->post('nidcadloc');
		$this->Servico_model->nidtbxtps = $this->input->post('nidtbxtps');
		$this->Servico_model->valor_cobrado = $this->input->post('valor_cobrado');
		$this->Servico_model->data = toDbDate($this->input->post('data'));
		$this->Servico_model->status_pagamento = Parametro_model::get("id_status_pagamento_pendente");
		$this->Servico_model->usuario_criacao = $this->session->userdata('nidtbxsegusu');
		if ($this->Servico_model->validaInsercao()){
			$this->Servico_model->save();
			$this->session->set_flashdata('sucesso', 'Serviço adicionado com sucesso');
		} else {
			$this->session->set_flashdata('erro', 'Erro ao adicionar o serviço');
		}
		$fin = new Financeiro_model();
		$locacao = $this->Locacaotemporada_model->getById($this->Servico_model->nidcadloc);
		$imovel = $this->Imovel_model->getById($locacao->nidcadimo);
		$fin->nidcadloc = $this->input->post('nidcadloc');
		$fin->nidcadimo = $imovel->nidcadimo;
		$fin->nidtbxfpa = Parametro_model::get("id_forma_pagamento_padrao");
		$fin->nidtbxstp = Parametro_model::get("id_status_pagamento_pendente");
		$fin->valor = $this->Servico_model->valor_cobrado;
		$fin->data_pagamento = '';
		$fin->tipo_transacao = "D";
		$fin->tipo = Tipofinanceiro_model::getIdByCod("srv");
		$fin->data_status = date('d/m/Y');
		$fin->descricao = 'Serviço de '.$this->Tiposervico_model->getById($this->input->post('nidtbxtps'))->cdescritps.' realizado em '.$this->input->post('data');
		$fin->observacoes = '';
		if ($fin->validaInsercao()){
			$fin->save();
		}
		$this->session->set_flashdata('abrir_modal_servico', 1);
		$this->session->set_flashdata('nidcadloc', $this->input->post('nidcadloc'));
		redirect($this->input->post('returnurl'));
	}

	/**
	* Função para pegar os serviços de uma locação (Ajax)
	*/

	public function getservicos($locacao_id){
		$this->load->model('fin/Servico_model');
		$servicos = $this->Servico_model->getByLocacao($locacao_id);
		die(json_encode($servicos));
	}

	/**
	* Função para excluir um serviço
	*/

	public function excluirservico($servico_id){
		$this->load->model('fin/Servico_model');
		$servico = $this->Servico_model->getById($servico_id);
		if (!$servico){
			$this->session->set_flashdata('erro', 'Serviço não encontrado');
			redirect($this->input->get('returnurl'));
		}
		$this->Servico_model->id = $servico_id;
		$this->Servico_model->delete();
		$this->session->set_flashdata('nidcadloc', $servico->nidcadloc);
		$this->session->set_flashdata('sucesso', 'Serviço excluído com sucesso');
		$this->session->set_flashdata('abrir_modal_servico', 1);
		redirect($this->input->get('returnurl'));
	}

	/**
	* Função para realizar o pagamento de um serviço
	*/

	public function pagamento($servico_id){
		$this->load->model('fin/Servico_model');
		$servico = $this->Servico_model->getById($servico_id);
		if (!$servico){
			$this->session->set_flashdata('erro', 'Serviço não encontrado');
			redirect($this->input->get('returnurl'));
		}
		$this->Servico_model->id = $servico_id;
		$this->Servico_model->status_pagamento = Parametro_model::get("id_status_pagamento_pago");
		$this->Servico_model->pagar();
		$this->session->set_flashdata('nidcadloc', $servico->nidcadloc);
		$this->session->set_flashdata('sucesso', 'Serviço pago com sucesso');
		$this->session->set_flashdata('abrir_modal_servico', 1);
		$this->session->set_flashdata('abrir_modal_recibo', 1);
		redirect($this->input->get('returnurl'));
	}

	/**
	* Função para obter dados da locação para o relatório de despesas
	*/

	public function getDadosLocacaoDepositos($locacao_id){
		$this->load->model('fin/Financeiro_model');
		$result = new stdClass();
		$result->locacao = $this->Locacaotemporada_model->getById($locacao_id);
		$result->locacao->data_inicial = toUserDate($result->locacao->ddatainicial);
		$result->locacao->data_final = toUserDate($result->locacao->ddatafinal);
		$result->imovel = $this->Imovel_model->getById($result->locacao->nidcadimo);
		$result->locatario = $this->Cadastro_model->getById($result->locacao->nidcadgrl);
		$result->proprietarios = $this->Proprietarioimovel_model->getByImovel($result->imovel->nidcadimo);
		$result->depositos_fazer = $this->Financeiro_model->getDepositosFazer($locacao_id);
		$result->depositos_receber = $this->Financeiro_model->getDepositosReceber($locacao_id, Parametro_model::get('finalidade_locacao_id'));
		$result->despesas_receber = $this->Financeiro_model->getDespesasReceber($locacao_id);
		die(json_encode($result));
	}

	/**
	* Função para alterar o valor de um depósito
	*/	

	public function alterarValor($deposito_id){
		$this->load->model('fin/Financeiro_model');
		$this->Financeiro_model->nidcadfin = $deposito_id;
		$this->Financeiro_model->valor = $this->input->post('valor');
		$result = $this->Financeiro_model->alterarValor();
		echo json_encode($result);
		die();
	}

	/**
	* Função para alterar a data de um depósito
	*/	

	public function alterarData($deposito_id){
		$this->load->model('fin/Financeiro_model');
		$this->Financeiro_model->nidcadfin = $deposito_id;
		$this->Financeiro_model->data_pagamento = toDbDate($this->input->post('data'));
		$result = $this->Financeiro_model->alterarData();
		echo json_encode($result);
		die();
	}

	/**
	* Função para confirmar um pagamento
	*/	

	public function confirmarPagamento($deposito_id){
		$this->load->model('fin/Financeiro_model');
		$this->Financeiro_model->nidcadfin = $deposito_id;
		$this->Financeiro_model->data_pagamento = date('Y-m-d');
		$this->Financeiro_model->data_status = date('Y-m-d');
		$this->Financeiro_model->nidtbxstp = Parametro_model::get("id_status_pagamento_pago");
		$result = $this->Financeiro_model->confirmarPagamento();
		echo json_encode($result);
		die();
	}

	/**
	* Função para reverter um pagamento
	*/	

	public function reverterPagamento($deposito_id){
		$this->load->model('fin/Financeiro_model');
		$this->Financeiro_model->nidcadfin = $deposito_id;
		$this->Financeiro_model->data_status = date('Y-m-d');
		$this->Financeiro_model->nidtbxstp = Parametro_model::get("id_status_pagamento_pendente");
		$result = $this->Financeiro_model->reverterPagamento();
		echo json_encode($result);
		die();
	}

	/**
	* Função para gerar um novo boleto
	*/	

	public function novoBoleto($deposito_id){
		$this->load->model('fin/Financeiro_model');
		$this->load->model('fin/Boleto_model');
		$this->Boleto_model->cadfin = $deposito_id;
		$this->Boleto_model->usuario_exclusao = $this->getCurrentUser();
		$result = $this->Boleto_model->gerarNovoBoleto();
		echo json_encode($result);
		die();
	}

}

?>