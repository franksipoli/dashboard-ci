<?php


class Imovel extends MY_Controller {

	public function __construct(){
	
		parent::__construct();
	
		$this->load->model('app/App_model');
		$this->load->model('dci/Tipoimovel_model');
		$this->load->model('dci/Finalidade_model');
		$this->load->model('dci/Tipopermuta_model');
		$this->load->model('dci/Tipoobservacao_model');
		$this->load->model('dci/Tipopacote_model');
		$this->load->model('cadgrl/Entidade_model');
		$this->load->model('cadgrl/Cadastro_model');
		$this->load->model('cadimo/Imovel_model');
		$this->load->model('cadimo/Imovelobservacao_model');
		$this->load->model('cadimo/Imoveldistancia_model');
		$this->load->model('cadimo/Proprietarioimovel_model');
		$this->load->model('cadimo/Angariadorimovel_model');
		$this->load->model('cadimo/Finalidadetipovalor_model');
		$this->load->model('cadimo/Enderecoimovel_model');
		$this->load->model('dci/Tipomidia_model');
		$this->load->model('dci/Midia_model');
		$this->load->model('dci/Midiatipomidia_model');
		$this->load->model('dci/Tipostatusconstrucao_model');
		$this->load->model('dci/Statusimovel_model');
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
		$this->load->model('dci/Referencia_model');
		$this->load->model('dep/Tipologradouro_model');

	}

	/**
	* Abre a tela para inserção de um novo registro
	*/

	public function inserir(){
		$this->title = "Inserir Produtos - Yoopay - Soluções Tecnológicas";
		$this->enqueue_script('vendor/jquery.steps/build/jquery.steps.js');
		$this->enqueue_script('app/js/cadimo/cadimo-wizard.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('app/js/cadimo/proprietario.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadimo/angariador.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadimo/observacao.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadimo/distancia.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$this->Referencia_model->usuario_criacao = $this->getCurrentUser();
		$this->data['referencia'] = $this->Referencia_model->save();
		$this->data['comissoes_padrao'] = $this->Tipocomissao_model->getValoresAll();
		$this->data['tpl'] = $this->Tipologradouro_model->getAll(array('nordem'));
		$this->data['pac'] = $this->Tipopacote_model->getAll();
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
		$this->data['tcm'] = $this->Tipocomissao_model->getAll();
		$this->data['sti'] = $this->Statusimovel_model->getAll();
		$this->data['lista_uf'] = $this->Uf_model->getAll(array('nidtbxpas'=>'ASC', 'csiglauf'=>'ASC'));
 		$this->data['requiredfields'] = $this->App_model->getFieldsByAplicacao('Imóvel');

 		$this->enqueue_html('imovel/modal_latitude_longitude.php');
		$this->loadview('imovel/inserir');
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
			$this->session->set_flashdata('erro', 'Produto não localizado');
			redirect(makeUrl('cadimo', 'imovel', 'listar'));
			exit();
		}

		$this->title = "Editar Produto - Yoopay - Soluções Tecnológicas";
		$this->enqueue_script('vendor/jquery.steps/build/jquery.steps.js');
		$this->enqueue_script('app/js/cadimo/cadimo-wizard.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('app/js/cadimo/proprietario.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadimo/angariador.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadimo/observacao.js?v='.rand(1,9999));
		$this->enqueue_script('app/js/cadimo/distancia.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->data['cadimo'] = $this->Imovel_model->getById( $id );

		$this->data['tpl'] = $this->Tipologradouro_model->getAll(array('nordem'));
		$this->data['tpp'] = $this->Tipopermuta_model->getAll();
		$this->data['tpi'] = $this->Tipoimovel_model->getAll();
		$this->data['ent'] = $this->Entidade_model->getAll();
		$this->data['pac'] = $this->Tipopacote_model->getAll();
		$this->data['fin'] = $this->Finalidade_model->getAll();
		$this->data['obs'] = $this->Tipoobservacao_model->getAll();
		$this->data['tsc'] = $this->Tipostatusconstrucao_model->getAll();
		$this->data['fva'] = $this->Finalidadetipovalor_model->getAllFront();
		$this->data['tpd'] = $this->Tipodistancia_model->getAll();
		$this->data['tmd'] = $this->Tipomedidadistancia_model->getAll();
		$this->data['trd'] = $this->Tiporeferenciadistancia_model->getAll();
		$this->data['tcm'] = $this->Tipocomissao_model->getAll();
		$this->data['sti'] = $this->Statusimovel_model->getAll();
		$this->data['lista_uf'] = $this->Uf_model->getAll(array('nidtbxpas'=>'ASC', 'csiglauf'=>'ASC'));

		$this->data['permutas'] = $this->Imovel_model->getPermutas($id);
		$this->data['comissoes_padrao'] = $this->Tipocomissao_model->getValoresAll();
		$this->data['comissoes'] = $this->Imovel_model->getComissoes($id);
		$this->data['proprietarios'] = $this->Imovel_model->getProprietarios($id);
		$this->data['angariadores'] = $this->Imovel_model->getAngariadores($id);
		$this->data['valores'] = $this->Imovel_model->getValores($id);
		$this->data['observacoes'] = $this->Imovel_model->getObservacoes($id);
		$this->data['endereco'] = $this->Enderecoimovel_model->getByImovel($id);
		$this->data['distancias'] = $this->Imoveldistancia_model->getByImovel($id);
		$this->data['caracteristicas'] = $this->Imovel_model->getCaracteristicas($id);

		$this->enqueue_html('imovel/modal_latitude_longitude.php');

 		$this->data['requiredfields'] = $this->App_model->getFieldsByAplicacao('Imóvel');
		$this->loadview('imovel/inserir');
	}

	/* Pegar os proprietários do Imóvel */

	public function getProprietarios(){
		$id = $this->input->get('nidcadimo');
		$proprietarios = $this->Imovel_model->getProprietarios($id);
		echo json_encode($proprietarios);
		die();
	}

	/* Pegar os angariadores do Imóvel */

	public function getAngariadores(){
		$id = $this->input->get('nidcadimo');
		$angariadores = $this->Imovel_model->getAngariadores($id);
		echo json_encode($angariadores);
		die();
	}

	/**
	* Abre a tela para a inserção de imagens
	*/

	public function imagens($id){

		$this->title = "Imagens do Imóvel - Yoopay - Soluções Tecnológicas";
		$this->enqueue_style('app/css/uploadify.css');
		$this->enqueue_script('app/js/jquery.uploadify.min.js');
		$this->enqueue_script('app/js/cadimo/imagens.js');
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');

		$this->data['relacionados'] = $this->Imovel_model->getAllRelacionados($id);

		$this->data['nidcadimo'] = $id;

		$this->data['pasta_menor'] = $this->Tipomidia_model->getMenorLargura()->cfoldermid;

		$this->data['imagens'] = $this->Midia_model->getByImovel($id);

		$this->loadview('imovel/imagens');
	}

	/**
	* Abre a tela para a inserção de serviços ao Imóvel
	*/

	public function servicos($id){

		$this->load->model('dcg/Tiposervico_model');
		$this->load->model('cadimo/Imovelservico_model');

		$this->title = "Serviços no Produto - Yoopay - Soluções Tecnológicas";

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');

		$this->enqueue_script('app/js/cadimo/servicos.js');

		$this->data['nidcadimo'] = $id;

		$this->data['cadimo'] = $this->Imovel_model->getById($id);

		$this->data['servicos'] = $this->Imovelservico_model->getByImovel($id);

		$this->data['tps'] = $this->Tiposervico_model->getAll();

		$this->loadview('imovel/servicos');
	}

	/**
	* Inserir serviço
	*/

	public function insertservico(){
		$this->load->model('dcg/Tiposervico_model');
		$this->load->model('cadimo/Imovelservico_model');
		$this->Imovelservico_model->imovel = $this->input->post('nidcadimo');
		$this->Imovelservico_model->cadastro = $this->input->post('nidcadgrl');
		$this->Imovelservico_model->tipo = $this->input->post('nidtbxtps');
		$this->Imovelservico_model->valor = $this->input->post('nvalor');
		$this->Imovelservico_model->usuario = $this->getCurrentUser();
		if ($this->Imovelservico_model->validaInsercao()){
			$this->Imovelservico_model->save();
			Log_model::save("cadimo", $this->Imovelservico_model->imovel, $this->getCurrentUser(), "Criou um serviço");
			$this->session->set_flashdata('sucesso', 'Serviço inserido com sucesso');
		} else {
			$this->session->set_flashdata('erro', $this->Imovelservico_model->error);
		}	
		redirect(makeUrl("cadimo/imovel", "servicos", $this->Imovelservico_model->imovel));
	}

	/**
	* Excluir serviço
	*/

	public function excluirservico($id){
		$this->load->model('dcg/Tiposervico_model');
		$this->load->model('cadimo/Imovelservico_model');
		$ise = $this->Imovelservico_model->getById($id);
		$this->Imovelservico_model->id = $id;
		$this->Imovelservico_model->delete();
		Log_model::save("cadimo", $ise->nidcadimo, $this->getCurrentUser(), "Excluiu um serviço");
		$this->session->set_flashdata("sucesso", "Serviço excluído");
		redirect(makeUrl("cadimo/imovel", "servicos", $ise->nidcadimo));
	}

	/**
	* Ordenar imagens
	*/

	public function ordenar(){
		$posicoes = $this->input->post('posicoes');
		parse_str($posicoes);
		$this->Midia_model->setarOrdem($ordem);
		echo json_encode($ordem);
	}

	public function listar()
	{
		$this->title = "Produtos - Yoopay - Soluções Tecnológicas";
		
		$this->data['tpi'] = $this->Tipoimovel_model->getAll();
		$this->data['sti'] = $this->Statusimovel_model->getAll();

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');

		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		//$this->enqueue_style('app/css/mensagem.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/cadimo/listar.js');

		$this->loadview('imovel/listar');
	}

	/**
		* Função para o uploadify fazer o upload das imagens
	*/

	public function uploadFoto()
	{

		$this->load->model('ImageManipulation_model');

		$nidcadimo = $this->input->post('nidcadimo');

		$relacionados = $this->input->post('aplicar_relacionado');

		if (!$_FILES['Filedata']['name']){
			die(json_encode(array('error'=>1,'message'=>'Imagem não enviada')));
		}

		$tmpname = md5($_FILES['Filedata']['name'].date('YmdHis').rand(1,9999));

		move_uploaded_file($_FILES['Filedata']['tmp_name'], 'imagens/originais/'.$tmpname.".jpg");

		/* Cadastra a imagem na tabela de mídia */

		$imi = new Midia_model();

		$imi->imovel = $nidcadimo;

		$imi->extensao = "jpg";

		$imi->ordem = 1;

		$imi->save();

		$mid = $this->Tipomidia_model->getAll();

		$result = array();

		foreach ($mid as $tipomidia){

			$oldmask = umask(0);

			if (!is_dir("imagens/".$tipomidia->cfoldermid)){

				/* Cria a pasta da foto caso ela não exista */
				
				mkdir("imagens/".$tipomidia->cfoldermid, 0777);

			} 

			if (!is_dir("imagens/".$tipomidia->cfoldermid."/thumb")){

				/* Cria a pasta da miniatura da foto caso ela não exista */

				mkdir("imagens/".$tipomidia->cfoldermid."/thumb", 0777);

			}

			umask($oldmask);

			/* Salva o registro na tabela de mídia do Imóvel */

			$im2 = new Midiatipomidia_model();

			$im2->tipo = $tipomidia->nidtbxmid;

			$im2->midia = $imi->id;

			$im2->save();

			/* Gera a imagem maior */

			$im = new ImageManipulation_model();

			$im->loadResizeCropSave('imagens/originais/'.$tmpname.".jpg", 'imagens/'.$tipomidia->cfoldermid.'/'.$imi->id.'.jpg', $tipomidia->nwidth, $tipomidia->nheight);

			/* Gera a miniatura */

			$imthumb = new ImageManipulation_model();

			$imthumb->loadResizeCropSave('imagens/originais/'.$tmpname.".jpg", 'imagens/'.$tipomidia->cfoldermid.'/thumb/'.$imi->id.'.jpg', $tipomidia->nwidththu, $tipomidia->nheightthu);

		}

		unlink('imagens/originais/'.$tmpname.".jpg");

		$folder_menor = $this->Tipomidia_model->getMenorLargura()->cfoldermid;

		$result[] = array('url'=>'imagens/'.$folder_menor.'/thumb/'.$imi->id.'.jpg','id'=>$imi->id, 'relacionados'=>$relacionados);

		die(json_encode($result));

	}

	/**
		* Função para remover foto
	*/

	public function removerFoto()
	{

		$id = $this->input->get('nidtagimi');

		$this->Midia_model->id = $id;

		$this->Midia_model->delete();

		return;

	}

	public function listar_json()
	{
		// paginação
		$start 	= $this->input->get('iDisplayStart');
		$length = $this->input->get('iDisplayLength');

		// parâmetros avulsos
		$params['finalidade'] = ($type = trim($this->input->get('finalidade'))) ? $type : NULL;
		$params['tipo_imovel'] = ($type = trim($this->input->get('tipo_imovel'))) ? $type : NULL;
		$params['status'] = ($type = trim($this->input->get('status'))) ? $type : NULL;

		// palavras chave
		$params['keyword'] = ($this->input->get('palavra')) ? trim($this->input->get('palavra')) : NULL;
		$params['proprietario_id'] = ($this->input->get('proprietario_id')) ? $this->input->get('proprietario_id') : NULL;
		$keyword_field = ($this->input->get('campo')) ? trim($this->input->get('campo')) : NULL;

		if($params['keyword'])
		{
			switch ($keyword_field) {
				case 'titulo'		: $params['like']['i.ctitulo'] = $params['keyword']; break;
				case 'referencia'		: $params['like']['i.creferencia'] = $params['keyword']; break;
				default:
					$params['like'] = array(
						'i.ctitulo' => $params['keyword']
						,'i.creferencia' => $params['keyword']
					);
				break;
			}
		}
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Imovel_model->listar_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadgrl;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Imovel_model->listar_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Imovel_model->listar_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);

	}

	/**
	* Função para registrar o Imóvel via AJAX (utilizado no Wizard)
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

		} elseif ($params_array['etapa'] == "area") {

			/* Trata-se da segunda etapa do cadastro */

			$result = $this->registerEtapaArea ($params_array);

			die(json_encode($result));


		} elseif ($params_array['etapa'] == "permuta") {

			/* Trata-se da terceira etapa do cadastro */

			$result = $this->registerEtapaPermuta ($params_array);

			die(json_encode($result));

		} elseif ($params_array['etapa'] == "endereco") {

			/* Trata-se da quarta etapa do cadastro */

			$result = $this->registerEtapaEndereco ($params_array);

			die(json_encode($result));

		}

	}

	/**
	* Função para registrar os dados básicos do Imóvel via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function registerEtapaGeral( $params_array )
	{

		if ($params_array['nidcadimo']){
			
			return array(
				"error" => 1,
				"message" => "Produto já cadastrado"
			);

		}

		$this->Imovel_model->etapa = "geral";

		$this->Imovel_model->status = !empty($params_array['nidtbxsti']) ? $params_array['nidtbxsti'] : null;

		$this->Imovel_model->entidade = !empty($params_array['nidtbxent']) ? $params_array['nidtbxent'] : null;

		$this->Imovel_model->tipo_imovel = !empty($params_array['nidtbxtpi']) ? $params_array['nidtbxtpi'] : null;

		$this->Imovel_model->finalidade = !empty($params_array['nidtbxfin']) ? $params_array['nidtbxfin'] : null;

		if ( !isset($params_array['nidtagti2']) ){
			$params_array['nidtagti2'] = array();
		}

		$this->Imovel_model->tipos_secundarios = $params_array['nidtagti2'];

		$this->Imovel_model->titulo = $params_array['titulo'];

		$this->Imovel_model->referencia = $params_array['referencia'];

		$this->Imovel_model->data_inicio_contrato = $params_array['data_inicio_contrato'];

		$this->Imovel_model->data_fim_contrato = $params_array['data_fim_contrato'];

		$this->Imovel_model->construtora = $params_array['construtora'];

		$this->Imovel_model->ano_construcao = $params_array['ano_construcao'];

		$this->Imovel_model->status_construcao = $params_array['nidtbxtsc'];

		$this->Imovel_model->condominio = $params_array['condominio'];

		$this->Imovel_model->unidades = $params_array['unidades'];

		$this->Imovel_model->descricao = $params_array['descricao'];

		$this->Imovel_model->usuario_criacao = $this->getCurrentUser();

		$id = $this->Imovel_model->save();

		/* Salvar o Imóvel na referência */

		$this->Referencia_model->id = $params_array['referencia'];

		$this->Referencia_model->imovel = $id;

		$this->Referencia_model->save();

		$rel_a = array($id => $id);

		$rel_b = $this->Imovel_model->getIdsImoveisRelacionados();

		$relacionados = array_merge($rel_a, $rel_b);

		/* Registra os tipos de cadastro geral */

		$this->Imovel_model->setTipoImovelSecundario( $params_array['nidtagti2'] );

		/* Registra as características do Imóvel */

		$this->Imovel_model->setCaracteristicas( $params_array['nidtbxcar'] );

		/* Verifica quantas chaves o array de proprietários possui */

		$total_proprietarios = count($params_array['idcpfproprietario']);

		/* Percorre cada uma das chaves e salva o proprietário */

		$erros_proprietario = array();

		for ($i=0; $i<$total_proprietarios; $i++):

			foreach ($relacionados as $imo){

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Proprietarioimovel_model = new Proprietarioimovel_model();

				/* Conectar o proprietário ao cadastro de Imóvel */
				$this->Proprietarioimovel_model->percentual = $params_array['percentualproprietario'][$i];
				$this->Proprietarioimovel_model->cadastro = $params_array['idcpfproprietario'][$i];
				$this->Proprietarioimovel_model->imovel = $imo;

				if ( $this->Proprietarioimovel_model->validaInsercao() ){
					$this->Proprietarioimovel_model->save();
				} else {
					$erros_proprietario[] = $this->Proprietarioimovel_model->error;
				}

			}
		
		endfor;

		/* Verifica quantas chaves o array de angariadores possui */

		$total_angariadores = count($params_array['idangariador']);

		/* Percorre cada uma das chaves e salva o angariador */

		$erros_angariador = array();

		for ($i=0; $i<$total_angariadores; $i++):

			foreach ($relacionados as $imo){

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Angariadorimovel_model = new Angariadorimovel_model();

				/* Conectar o angariador ao cadastro de Imóvel */
				$this->Angariadorimovel_model->percentual = $params_array['percentualangariador'][$i];
				$this->Angariadorimovel_model->usuario = $params_array['idangariador'][$i];
				$this->Angariadorimovel_model->imovel = $imo;

				if ( $this->Angariadorimovel_model->validaInsercao() ){
					$this->Angariadorimovel_model->save();
				} else {
					$erros_angariador[] = $this->Angariadorimovel_model->error;
				}

			}
		
		endfor;

		Log_model::save('cadimo', $id, $this->getCurrentUser(), "Criou o registro");

		$result = array(
			"id" => $id,
			"success" => 1,
			"erros_proprietario" => $erros_proprietario,
			"erros_angariador" => $erros_angariador,
			"relacionados" => $relacionados,
			"rel_a" => $rel_a,
			"rel_b" => $rel_b
		);

		return $result;
	}

	/**
	* Função para atualizar os dados básicos do Imóvel via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function updateEtapaGeral( $params_array )
	{

		$this->Imovel_model->etapa = "geral";

		$this->Imovel_model->id = $params_array['nidcadimo'];

		$this->Imovel_model->edit = $params_array['edit'];

		$this->Imovel_model->status = !empty($params_array['nidtbxsti']) ? $params_array['nidtbxsti'] : null;

		$this->Imovel_model->entidade = !empty($params_array['nidtbxent']) ? $params_array['nidtbxent'] : null;

		$this->Imovel_model->tipo_imovel = !empty($params_array['nidtbxtpi']) ? $params_array['nidtbxtpi'] : null;

		$this->Imovel_model->finalidade = !empty($params_array['nidtbxfin']) ? $params_array['nidtbxfin'] : null;

		if ( !isset($params_array['nidtagti2']) ){
			$params_array['nidtagti2'] = array();
		}

		$this->Imovel_model->tipos_secundarios = $params_array['nidtagti2'];

		$this->Imovel_model->titulo = $params_array['titulo'];

		$this->Imovel_model->referencia = $params_array['referencia'];

		$this->Imovel_model->data_inicio_contrato = $params_array['data_inicio_contrato'];

		$this->Imovel_model->data_fim_contrato = $params_array['data_fim_contrato'];

		$this->Imovel_model->construtora = $params_array['construtora'];

		$this->Imovel_model->ano_construcao = $params_array['ano_construcao'];

		$this->Imovel_model->status_construcao = $params_array['nidtbxtsc'];

		$this->Imovel_model->condominio = $params_array['condominio'];

		$this->Imovel_model->descricao = $params_array['descricao'];

		$this->Imovel_model->usuario_criacao = $this->getCurrentUser();

		$id = $this->Imovel_model->save();

		/* Registra os tipos de cadastro geral */

		$this->Imovel_model->setTipoImovelSecundario( $params_array['nidtagti2'] );

		/* Registra as características do Imóvel */

		$this->Imovel_model->setCaracteristicas( $params_array['nidtbxcar'] );

		$this->Imovel_model->removeProprietarios();

		/* Verifica quantas chaves o array de proprietários possui */

		$total_proprietarios = count($params_array['idcpfproprietario']);

		/* Percorre cada uma das chaves e salva o proprietário */

		$erros_proprietario = array();

		for ($i=0; $i<$total_proprietarios; $i++):

			/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

			$this->Proprietarioimovel_model = new Proprietarioimovel_model();

			/* Conectar o proprietário ao cadastro de Imóvel */
			$this->Proprietarioimovel_model->percentual = $params_array['percentualproprietario'][$i];
			$this->Proprietarioimovel_model->cadastro = $params_array['idcpfproprietario'][$i];
			$this->Proprietarioimovel_model->imovel = $this->Imovel_model->id;

			if ( $this->Proprietarioimovel_model->validaInsercao() ){
				$this->Proprietarioimovel_model->save();
			} else {
				$erros_proprietario[] = $this->Proprietarioimovel_model->error;
			}
		
		endfor;

		$this->Imovel_model->removeAngariadores();

		/* Verifica quantas chaves o array de angariadores possui */

		$total_angariadores = count($params_array['idangariador']);

		/* Percorre cada uma das chaves e salva o angariador */

		$erros_angariador = array();

		for ($i=0; $i<$total_angariadores; $i++):

			/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

			$this->Angariadorimovel_model = new Angariadorimovel_model();

			/* Conectar o angariador ao cadastro de Imóvel */
			$this->Angariadorimovel_model->percentual = $params_array['percentualangariador'][$i];
			$this->Angariadorimovel_model->usuario = $params_array['idangariador'][$i];
			$this->Angariadorimovel_model->imovel = $this->Imovel_model->id;

			if ( $this->Angariadorimovel_model->validaInsercao() ){
				$this->Angariadorimovel_model->save();
			} else {
				$erros_angariador[] = $this->Angariadorimovel_model->error;
			}
		
		endfor;

		Log_model::save('cadimo', $id, $this->getCurrentUser(), "Atualizou o registro");

		$result = array(
			"id" => $id,
			"success" => 1
		);

		return $result;
	}

	/**
	* Função para atualizar o cadastro do Imóvel via AJAX (utilizado no wizard)
	* @access public
	* @param none
	* @return JSON com o resultado da atualização
	*/

	public function update()
	{

		/* Recebe as variáveis enviadas pelo serialize do jQuery */
		$params = $this->input->post("params");
		/* Transforma a query string em um array */
		parse_str($params, $params_array);

		$nidcadimo = $params_array['nidcadimo'];

		$imovel = $this->Imovel_model->getById($nidcadimo);

		if (!$imovel){
			die(json_encode(
				array(
					"error" => 1,
					"message" => "Produto não localizado"
				)
			));
		}

		$result_geral = $this->updateEtapaGeral($params_array);

		$result_area = $this->updateArea($params_array);

		$result_permuta = $this->updatePermuta($params_array);

		$result_endereco = $this->updateEndereco($params_array);

		$result = array("geral"=>$result_geral, "area"=>$result_area, "permuta"=>$result_permuta, "endereco"=>$result_endereco);

		die(json_encode($result));

	}

	/**
	* Função para registrar os dados de endereço do Imóvel via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function registerEtapaArea( $params_array )
	{

		$id = $params_array['nidcadimo'];

		$this->Imovel_model->etapa = "area";

		$this->Imovel_model->id = $params_array['nidcadimo'];

		$this->Imovel_model->area_construida = $params_array['area_construida'];

		$this->Imovel_model->area_averbada = $params_array['area_averbada'];

		$this->Imovel_model->area_terreno = $params_array['area_terreno'];

		$this->Imovel_model->area_util = $params_array['area_util'];

		$this->Imovel_model->area_privativa = $params_array['area_privativa'];

		$this->Imovel_model->area_comercial = $params_array['area_comercial'];

		$this->Imovel_model->quartos = $params_array['quartos'];

		$this->Imovel_model->acomodacoes = $params_array['acomodacoes'];

		$this->Imovel_model->suites = $params_array['suites'];

		$this->Imovel_model->valores = $params_array['valor'];

		$this->Imovel_model->taxa_administrativa = $params_array['taxa_administrativa'];

		$this->Imovel_model->comissoes = $params_array['comissao'];

		$this->Imovel_model->save();

		$result = array(
			"id" => $id,
			"success" => 1
		);

		return $result;

	}	

	/**
	* Função para atualizar os dados de endereço do Imóvel via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function updateArea( $params_array )
	{

		$id = $params_array['nidcadimo'];

		$this->Imovel_model->etapa = "area";

		$this->Imovel_model->edit = $params_array['edit'];

		$this->Imovel_model->id = $params_array['nidcadimo'];

		$this->Imovel_model->area_construida = $params_array['area_construida'];

		$this->Imovel_model->area_averbada = $params_array['area_averbada'];

		$this->Imovel_model->area_terreno = $params_array['area_terreno'];

		$this->Imovel_model->area_util = $params_array['area_util'];

		$this->Imovel_model->area_privativa = $params_array['area_privativa'];

		$this->Imovel_model->area_comercial = $params_array['area_comercial'];

		$this->Imovel_model->quartos = $params_array['quartos'];

		$this->Imovel_model->acomodacoes = $params_array['acomodacoes'];

		$this->Imovel_model->suites = $params_array['suites'];

		$this->Imovel_model->valores = $params_array['valor'];

		$this->Imovel_model->taxa_administrativa = $params_array['taxa_administrativa'];

		$this->Imovel_model->comissoes = $params_array['comissao'];

		$this->Imovel_model->save();

		$result = array(
			"id" => $id,
			"success" => 1
		);

		return $result;

	}

	/**
	* Função para registrar os dados de permuta do Imóvel via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function registerEtapaPermuta( $params_array )
	{

		$id = $params_array['nidcadimo'];

		$this->Imovel_model->etapa = "permuta";

		$this->Imovel_model->id = $params_array['nidcadimo'];

		$this->Imovel_model->aceita_permuta = $params_array['aceita_permuta'];

		$this->Imovel_model->tipos_permuta = $params_array['nidtbxtpp'];

		$this->Imovel_model->descricao_permuta = $params_array['cdescriipe'];

		$this->Imovel_model->matricula_luz = $params_array['matricula_luz'];

		$this->Imovel_model->luz_ligada = $params_array['luz_ligada'] ? 1 : 0;

		$this->Imovel_model->matricula_agua = $params_array['matricula_agua'];

		$this->Imovel_model->agua_ligada = $params_array['agua_ligada'] ? 1 : 0;

		$this->Imovel_model->matricula = $params_array['matricula'];

		$this->Imovel_model->lote = $params_array['lote'];

		$this->Imovel_model->quadra = $params_array['quadra'];

		$this->Imovel_model->planta = $params_array['planta'];

		$this->Imovel_model->save();

		$relacionados = array($this->Imovel_model->id);

		$relacionados = array_merge($relacionados, $this->Imovel_model->getIdsImoveisRelacionados());

		foreach ($relacionados as $imo){

			$this->Imovelobservacao_model->deleteByImovel($imo);

		}

		/* Verifica quantas chaves o array de observações possui */

		$total_observacoes = count($params_array['tipoobservacao']);

		/* Percorre cada uma das chaves e salve a observação */

		$resultado_observacoes = array();

		for ($i=0; $i<$total_observacoes; $i++):

			foreach ($relacionados as $imo){

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Imovelobservacao_model = new Imovelobservacao_model();

				/* Conectar a observação ao Imóvel */
				$this->Imovelobservacao_model->tipo = $params_array['tipoobservacao'][$i];
				$this->Imovelobservacao_model->observacao = $params_array['observacao'][$i];
				$this->Imovelobservacao_model->imovel = $imo;

				if ( $this->Imovelobservacao_model->validaInsercao() ){
					$this->Imovelobservacao_model->save();
					$resultado_observacoes[] = "A observação ".$params_array['observacao'][$i]." foi cadastrada";
				} else {
					$resultado_observacoes[] = "A observação ".$params_array['observacao'][$i]." não foi cadastrada (".$this->Imovelobservacao_model->error.")";
				}			

			}
		
		endfor;

		$result = array(
			"id" => $id,
			"success" => 1,
			"observacoes"=>$resultado_observacoes
		);

		return $result;

	}	

	/**
	* Função para atualizar os dados de permuta do Imóvel via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function updatePermuta( $params_array )
	{

		$id = $params_array['nidcadimo'];

		$this->Imovel_model->etapa = "permuta";

		$this->Imovel_model->edit = $params_array['edit'];

		$this->Imovel_model->id = $params_array['nidcadimo'];

		$this->Imovel_model->aceita_permuta = $params_array['aceita_permuta'];

		$this->Imovel_model->tipos_permuta = $params_array['nidtbxtpp'];

		$this->Imovel_model->descricao_permuta = $params_array['cdescriipe'];

		$this->Imovel_model->matricula_luz = $params_array['matricula_luz'];

		$this->Imovel_model->luz_ligada = $params_array['luz_ligada'] ? 1 : 0;

		$this->Imovel_model->matricula_agua = $params_array['matricula_agua'];

		$this->Imovel_model->agua_ligada = $params_array['agua_ligada'] ? 1 : 0;

		$this->Imovel_model->save();

		$this->Imovelobservacao_model->deleteByImovel($this->Imovel_model->id);

		/* Verifica quantas chaves o array de observações possui */

		$total_observacoes = count($params_array['tipoobservacao']);

		/* Percorre cada uma das chaves e salve a observação */

		$result_permuta = array();

		for ($i=0; $i<$total_observacoes; $i++):

			/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

			$this->Imovelobservacao_model = new Imovelobservacao_model();

			/* Conectar a observação ao Imóvel */
			$this->Imovelobservacao_model->tipo = $params_array['tipoobservacao'][$i];
			$this->Imovelobservacao_model->observacao = $params_array['observacao'][$i];
			$this->Imovelobservacao_model->imovel = $this->Imovel_model->id;

			if ( $this->Imovelobservacao_model->validaInsercao() ){
				$this->Imovelobservacao_model->save();
				$result_permuta[] = "A observação ".$params_array['observacao'][$i]." foi cadastrada";
			} else {
				$result_permuta[] = "A observação ".$params_array['observacao'][$i]." não foi cadastrada (".$this->Imovelobservacao_model->error.")";
			}			
		
		endfor;

		$result = array(
			"id" => $id,
			"success" => 1,
			"result" => $result_permuta
		);

		return $result;

	}

	/**
	* Função para registrar os endereços do Imóvel via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado do update
	*/

	private function registerEtapaEndereco( $params_array )
	{

		$this->Imovel_model->etapa = "endereco";
		$this->Imovel_model->id = $params_array['nidcadimo'];

		$this->Imovel_model->latitude = $params_array['latitude'];
		$this->Imovel_model->longitude = $params_array['longitude'];

		$this->Imovel_model->publicar_site = $params_array['publicar_site'];
		$this->Imovel_model->publicar_endereco = $params_array['publicar_endereco'];

		$this->Imovel_model->save();

		$relacionados = array($this->Imovel_model->id);

		$relacionados = array_merge($relacionados, $this->Imovel_model->getIdsImoveisRelacionados());

			/* Verifica quantas chaves o array de endereço possui */

			$total_enderecos = count($params_array['endereco']);

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

					$this->Logradouro_model->tipo = $params_array['nidtbxtpl'][$i];
					$this->Logradouro_model->bairro = $this->Bairro_model->id;
					$this->Logradouro_model->descricao = $params_array['endereco'][$i];

					if (!$params_array['cep_cidade'][$i]){

						/* Se o cep pertencer à cidade, não há um porquê de cadastrá-lo no endereço */

						$this->Logradouro_model->cep = $params_array['cep'][$i];

					}

					if ( $this->Logradouro_model->validaInsercao() ) {
						$this->Logradouro_model->save();
					} else {
						// TODO erro na validação
					}
				
				}

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Endereco_model = new Endereco_model();

				/* Inserir o endereço */
				$this->Endereco_model->logradouro = $this->Logradouro_model->id;
				$this->Endereco_model->numero = $params_array['numero'][$i];
				$this->Endereco_model->complemento = $params_array['complemento'][$i];
				if ( $this->Endereco_model->validaInsercao() ){
					$this->Endereco_model->save();
				} else {
					// TODO erro no cadastro de endereço
				}

				foreach ($relacionados as $imo){

					/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

					$this->Enderecoimovel_model = new Enderecoimovel_model();

					/* Conectar o endereço ao cadastro geral */
					$this->Enderecoimovel_model->endereco = $this->Endereco_model->id;
					$this->Enderecoimovel_model->imovel = $imo;
					if ( $this->Enderecoimovel_model->validaInsercao() ){
						$this->Enderecoimovel_model->save();
					} else {
						// TODO erro no cadastro de endereço
					}

				}

			endfor;

		foreach ($relacionados as $imo){

			$this->Imoveldistancia_model->deleteByImovel($imo);

		}

		/* Verifica quantas chaves o array de distâncias possui */

		$total_distancias = count($params_array['tipodistancia']);

		/* Percorre cada uma das chaves e salve a distância */

		for ($i=0; $i<$total_distancias; $i++):

			foreach ($relacionados as $imo){

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Imoveldistancia_model = new Imoveldistancia_model();

				/* Conectar a distância ao Imóvel */

				$this->Imoveldistancia_model->tipodistancia = $params_array['tipodistancia'][$i];
				$this->Imoveldistancia_model->tipomedida = $params_array['tipomedidadistancia'][$i];
				$this->Imoveldistancia_model->tiporeferencia = $params_array['tiporeferenciadistancia'][$i];
				$this->Imoveldistancia_model->distancia = $params_array['distancia'][$i];
				$this->Imoveldistancia_model->imovel = $imo;

				if ( $this->Imoveldistancia_model->validaInsercao() ){
					$this->Imoveldistancia_model->save();
				} else {
					// TODO erro no cadastro de telefone
				}	

				$erros[] = $this->Imoveldistancia_model->error;

			}

		endfor;

		$result = array(
			"success" => 1,
			"id" => $this->Imovel_model->id,
			"msg" => $erros
		);

		return $result;

	}

	/**
	* Função para registrar os endereços do Imóvel via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado do update
	*/

	private function updateEndereco( $params_array )
	{

		$this->Imovel_model->etapa = "endereco";
		$this->Imovel_model->edit = $params_array['edit'];
		$this->Imovel_model->id = $params_array['nidcadimo'];

		$this->Imovel_model->latitude = $params_array['latitude'];
		$this->Imovel_model->longitude = $params_array['longitude'];

		$this->Imovel_model->save();

		$relacionados = array($this->Imovel_model->id);

		$relacionados = array_merge($relacionados, $this->Imovel_model->getIdsImoveisRelacionados());

		$this->Enderecoimovel_model->deleteByImovel($this->Imovel_model->id);

			/* Verifica quantas chaves o array de endereço possui */

			$total_enderecos = count($params_array['endereco']);

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

					$this->Logradouro_model->tipo = $params_array['nidtbxtpl'][$i];
					$this->Logradouro_model->bairro = $this->Bairro_model->id;
					$this->Logradouro_model->descricao = $params_array['endereco'][$i];

					if (!$params_array['cep_cidade'][$i]){

						/* Se o cep pertencer à cidade, não há um porquê de cadastrá-lo no endereço */

						$this->Logradouro_model->cep = $params_array['cep'][$i];

					}

					if ( $this->Logradouro_model->validaInsercao() ) {
						$this->Logradouro_model->save();
					} else {
						// TODO erro na validação
					}
				
				}

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Endereco_model = new Endereco_model();

				/* Inserir o endereço */
				$this->Endereco_model->logradouro = $this->Logradouro_model->id;
				$this->Endereco_model->numero = $params_array['numero'][$i];
				$this->Endereco_model->complemento = $params_array['complemento'][$i];
				if ( $this->Endereco_model->validaInsercao() ){
					$this->Endereco_model->save();
				} else {
					// TODO erro no cadastro de endereço
				}

				/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

				$this->Enderecoimovel_model = new Enderecoimovel_model();

				/* Conectar o endereço ao cadastro geral */
				$this->Enderecoimovel_model->endereco = $this->Endereco_model->id;
				$this->Enderecoimovel_model->imovel = $this->Imovel_model->id;
				if ( $this->Enderecoimovel_model->validaInsercao() ){
					$this->Enderecoimovel_model->save();
				} else {
					// TODO erro no cadastro de endereço
				}

			endfor;



		$this->Imoveldistancia_model->deleteByImovel($this->Imovel_model->id);

		/* Verifica quantas chaves o array de distâncias possui */

		$total_distancias = count($params_array['tipodistancia']);

		/* Percorre cada uma das chaves e salve a distância */

		for ($i=0; $i<$total_distancias; $i++):

			/* Setando um novo objeto para dados não ficarem salvos de uma iteração para a outra */

			$this->Imoveldistancia_model = new Imoveldistancia_model();

			/* Conectar a distância ao Imóvel */

			$this->Imoveldistancia_model->tipodistancia = $params_array['tipodistancia'][$i];
			$this->Imoveldistancia_model->tipomedida = $params_array['tipomedidadistancia'][$i];
			$this->Imoveldistancia_model->tiporeferencia = $params_array['tiporeferenciadistancia'][$i];
			$this->Imoveldistancia_model->distancia = $params_array['distancia'][$i];
			$this->Imoveldistancia_model->imovel = $this->Imovel_model->id;

			if ( $this->Imoveldistancia_model->validaInsercao() ){
				$this->Imoveldistancia_model->save();
			} else {
				// TODO erro no cadastro de telefone
			}	

			$erros[] = $this->Imoveldistancia_model->error;

		endfor;

		$result = array(
			"success" => 1,
			"id" => $this->Imovel_model->id,
			"msg" => $erros
		);

		return $result;

	}

	/**
	* Abre um Imóvel
	*/

	public function visualizar( $id )
	{
		$this->title = 'Visualizar Produto - Yoopay - Soluções Tecnológicas';

		$this->Imovel_model->id = $id;

		$this->data['cadimo'] = $this->Imovel_model->getById($id);

		$this->data['entidade'] = $this->Entidade_model->getById($this->data['cadimo']->nidtbxent);

		$this->data['tipo_imovel'] = $this->Tipoimovel_model->getById($this->data['cadimo']->nidtbxtpi);

		$this->data['tipos_secundarios'] = $this->Imovel_model->getTiposSecundarios();

		$this->data['finalidade'] = $this->Finalidade_model->getById($this->data['cadimo']->nidtbxfin);

		$this->data['status_construcao'] = $this->Tipostatusconstrucao_model->getById($this->data['cadimo']->nidtbxtsc);

		$this->data['proprietarios'] = $this->Proprietarioimovel_model->getByImovel($id);

		$this->data['angariadores'] = $this->Angariadorimovel_model->getByImovel($id);

		$this->loadview('imovel/visualizar');

	}

	/**
	* Função para trazer a lista de imóveis através da busca por título ou referência via AJAX
	* @access public
	* @param none
	* @return json lista de objetos
	*/

	public function buscarAjaxReferencia() {
		$term = $this->input->get('term');
		if (!$term)
			die();
		$results = $this->Imovel_model->getByTituloReferencia($term);
		$ui = array();
		foreach ($results as $result){
			$ui[] = array("id"=>$result->nidcadimo,"value"=>$result->ctitulo." | ".$result->creferencia,"label"=>$result->ctitulo." | ".$result->creferencia);
		}
		die(json_encode($ui));
	}

	/**
	* Abre a tela para a exibição de imagens para o cliente
 	*/

	public function imagenscliente($id){

		$this->title = "Imagens do Produto - Yoopay - Soluções Tecnológicas";

		$this->data['imovel'] = $this->Imovel_model->getById($id);

		$this->data['entidade'] = $this->Entidade_model->getById($this->data['imovel']->nidtbxent);

		$this->enqueue_script('http://maps.google.com/maps/api/js?sensor=false&key='.Parametro_model::get('chave_api_maps'));

		$this->enqueue_script('app/js/cadimo/imagenscliente.js?v='.rand(1,9999));

		$this->data['nidcadimo'] = $id;

		$this->data['pasta_maior'] = $this->Tipomidia_model->getMaiorLargura()->cfoldermid;

		$this->data['maiorlargura'] = $this->Tipomidia_model->getMaiorLargura()->nwidth;

		$this->data['imagens'] = $this->Midia_model->getByImovel($id);

		$this->data['returnurl'] = $this->input->get('returnurl');

		$this->loadview('imovel/imagenscliente');
	}

	/**
	* Abre a tela para a exibição dos pacotes do Imóvel
 	*/

	public function pacotes($id){

		if ($this->input->post()){
			$this->atualizarpacotes($id);
			return;
		}

		$this->title = "Pacotes do Produto - Yoopay - Soluções Tecnológicas";

		$this->data['pacotes'] = $this->Tipopacote_model->getAll();

		$this->Imovel_model->id = $id;

		$this->data['pacotes_selecionados'] = $this->Imovel_model->getPacotes();

		$this->data['imovel'] = $this->Imovel_model->getById($id);

		$this->data['entidade'] = $this->Entidade_model->getById($this->data['imovel']->nidtbxent);

		$this->data['nidcadimo'] = $id;

		$this->data['valores'] = $this->Imovel_model->getValores($id);

		$this->enqueue_script('app/js/cadimo/pacotes.js?v='.rand(1,9999));

		$this->loadview('imovel/pacotes');
	}

	/**
	* Abre a tela para a exibição da aplicação de chaves do Imóvel
 	*/

	public function chaves($id){

		$this->load->model('dci/Localchave_model');
		$this->load->model('dci/Chave_model');

		$this->data['lch'] = $this->Localchave_model->getAll();

		$this->title = "Aplicação de Chaves - Yoopay - Soluções Tecnológicas";

		$this->Imovel_model->id = $id;

		$this->data['imovel'] = $this->Imovel_model->getById($id);

		$this->data['nidcadimo'] = $id;

		$this->enqueue_style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
		$this->enqueue_style('vendor/datatables-colvis/css/dataTables.colVis.css');
		$this->enqueue_style('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css');
		//$this->enqueue_style('app/css/mensagem.css');
		
		$this->enqueue_script('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
		$this->enqueue_script('vendor/datatables/media/js/jquery.dataTables.min.js');
		$this->enqueue_script('vendor/datatables-colvis/js/dataTables.colVis.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js');
		$this->enqueue_script('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js');
		$this->enqueue_script('app/js/cadimo/chaves.js?v='.rand(1,9999));

		$this->loadview('imovel/chaves');
	}

	/**
	* Ata de chaves
	*/

	public function chaves_ata($id)
	{

		$this->title = "Aplicação de Chaves - Yoopay - Soluções Tecnológicas";

		
		$this->load->model('dci/Localchave_model');
		$this->load->model('dci/Chave_model');
		$chave = $this->Chave_model->getById($id);
		
		if (!$chave){
			$this->session->set_flashdata('erro', 'Chave não encontrada');	
			redirect(makeUrl('cadimo/imovel','listar'));
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

		$this->enqueue_html('imovel/modal_retirar_chave');

		$this->enqueue_html('imovel/modal_devolver_chave');

		$this->enqueue_style('vendor/jquery-ui/themes/smoothness/jquery-ui.min.css');

		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');		

		$this->enqueue_style('vendor/jquery-ui/themes/smoothness/theme.css');

		$this->enqueue_script('app/js/cadimo/chave.js?v='.rand(1,9999));

		$imovel = $this->Imovel_model->getById($chave->nidcadimo);

		$this->data['disponivel_retirada'] = $this->Chave_model->disponivel($id);

		$this->data['chave'] = $chave;
		$this->data['imovel'] = $imovel;

		$this->loadview('imovel/ata_chaves');

	}

	/**
	* Atas de chave (JSON)
	*/

	public function chaves_ata_json($nidcadchv){
		$this->load->model('dci/Localchave_model');
		$this->load->model('dci/Chave_model');

		$chave = $this->Chave_model->getById($nidcadchv);

		$params['chave'] = $nidcadchv;
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Chave_model->listar_ata_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadata;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Chave_model->listar_ata_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Chave_model->listar_ata_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);		
	}
	
	/**
	* Retirar chave
	*/

	public function retirarchave($id){

		$this->load->model('dci/Localchave_model');
		$this->load->model('dci/Chave_model');

		$idresponsavel = $this->input->post('idresponsavel');
		$cadastro = $this->Cadastro_model->getById($idresponsavel);
		if (!$cadastro){
			die(json_encode(array("success"=>0,"message"=>"Usuário não encontrado")));
		}
		$senha = $this->input->post('senha');
		if (!$senha){
			die(json_encode(array("success"=>0,"message"=>"Senha em branco")));
		}
		if (!$cadastro->csenhachave){
			die(json_encode(array("success"=>0,"message"=>"Usuário não possui senha para retirada de chaves cadastrada")));
		}
		if ($cadastro->csenhachave != md5($senha)){
			die(json_encode(array("success"=>0,"message"=>"Senha inválida")));
		}
		if (!$this->Chave_model->disponivel($id)){
			die(json_encode(array("success"=>0,"message"=>"Esta chave não está disponível")));
		}
		$observacoes = $this->input->post('observacoes');
		$this->Chave_model->usuario_criacao = $this->getCurrentUser();
		$this->Chave_model->retirar($id, $idresponsavel, $observacoes);
		die(json_encode(array("success"=>1,"message"=>"Chave retirada com sucesso")));
	}

	/**
	* Devolver chave
	*/

	public function devolverchave($id){

		$this->load->model('dci/Localchave_model');
		$this->load->model('dci/Chave_model');

		$idresponsavel = $this->input->post('idresponsavel');
		$cadastro = $this->Cadastro_model->getById($idresponsavel);
		if (!$cadastro){
			die(json_encode(array("success"=>0,"message"=>"Usuário não encontrado")));
		}

		if (Parametro_model::get("requerer_senha_chave")){

			$senha = $this->input->post('senha');
			if (!$senha){
				die(json_encode(array("success"=>0,"message"=>"Senha em branco")));
			}
			if (!$cadastro->csenhachave){
				die(json_encode(array("success"=>0,"message"=>"Usuário não possui senha para retirada de chaves cadastrada")));
			}
			if ($cadastro->csenhachave != md5($senha)){
				die(json_encode(array("success"=>0,"message"=>"Senha inválida")));
			}

		}

		if ($this->Chave_model->disponivel($id)){
			die(json_encode(array("success"=>0,"message"=>"Esta chave já foi devolvida")));
		}
		$this->Chave_model->devolver($id, $idresponsavel);
		die(json_encode(array("success"=>1,"message"=>"Chave retirada com sucesso")));
	}

	/**
	* Obter lista de chaves (JSON)
	*/

	public function chaves_json($id)
	{
		$this->load->model('dci/Localchave_model');
		$this->load->model('dci/Chave_model');

		$params['imovel'] = $id;
		
		$parameters = ($params) ? $params : NULL;

		$records = $this->Chave_model->listar_data( 'records', $start, $length, $parameters );

		$count = 0;
		foreach($records as $r)
		{
			$records[$count]->DT_RowId = 'row_'.$r->nidcadchv;
			$count++;
		}

		die(json_encode(array(
				'recordsTotal' => $this->Chave_model->listar_data( 'recordsTotal', $start, $length, $params )
				,'recordsFiltered' => $this->Chave_model->listar_data( 'recordsFiltered', $start, $length, $params )
				,'data' => $records
				)
			)
		);

	}

	/**
	* Cadastrar chave
	*/

	public function cadastrarchave($nidcadimo){
		
		$this->load->model('dci/Chave_model');

		$nidtbxlch = $this->input->post('local');
		
		$this->Chave_model->imovel = $nidcadimo;
		$this->Chave_model->local = $nidtbxlch;
		$this->Chave_model->usuario_criacao = $this->getCurrentUser();

		if ($this->Chave_model->validaInsercao()){
			$this->Chave_model->save();
			$this->session->set_flashdata('sucesso','Chave cadastrada com sucesso');	
			Log_model::save('cadimo', $id, $this->getCurrentUser(), "Criou uma chave");
			redirect(makeUrl('cadimo/imovel','chaves', $nidcadimo));
		} else {
			$this->session->set_flashdata('erro',$this->Chave_model->error);	
			redirect(makeUrl('cadimo/imovel','chaves', $nidcadimo));
		}

	}

	/**
	* Abre a tela para a exibição da relação de bens do Imóvel
 	*/

 	public function bens($id){

 		$this->load->model('dci/Bem_model');
 		$this->load->model('dci/Grupobem_model');

 		$this->data['imovel'] = $this->Imovel_model->getById($id);

		if ($this->input->get('imprimir') == 1){
			$this->bensImpressao($id);
			return;
		}

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');

		$this->enqueue_html('imovel/modal_bens');

		$this->title = "Relação de Itens do Produto - Yoopay - Soluções Tecnológicas";

		$this->data['bens_alfabetica'] = $this->Bem_model->getAllAlfabetico();

		$this->data['bens'] = $this->Bem_model->getAll();

		$this->data['grupos'] = $this->Grupobem_model->getAll();

		$this->data['bens_imovel'] = $this->Bem_model->getByImovel($id);

		$this->Imovel_model->id = $id;

		$this->data['nidcadimo'] = $id;

		$this->enqueue_script('app/js/cadimo/bens.js?v='.rand(1,9999));

		$this->loadview('imovel/bens');
	}

	/* Relação de bens para impressão */

	public function bensImpressao($id){

		$imovel = $this->Imovel_model->getById($id);

		if ($this->input->get('imprimir')==1){
			?>
			<html>
			<body>
			<head>
				<title>Relação de Itens do Produto <?php echo $this->data['imovel']->creferencia?></title>
				<link rel="stylesheet" href="<?php echo base_url('assets/app/css/app.css')?>" id="maincss">
			</head>
			<body>
			<h1>Relação de Itens do Produto <?php echo $this->data['imovel']->creferencia?></h1>
			<?php
		}

		$this->load->model('dci/Bem_model');
 		$this->load->model('dci/Grupobem_model');

		$bens = $this->Bem_model->getByImovel($id);

		foreach ($bens as $gbi=>$dados){
			if (!$gbi){
				$avulsos = $dados;
				continue;
			}
			?>
			<h5><strong><?php echo $dados['nome']?></strong></h5>
			<ul>
				<?php
					foreach ($dados['bens'] as $item){
						?>
						<li>(<?php echo $item['quantidade']?>) <?php echo $item['nome']?>
							<?php
								$informacoes = $item['informacoes'];
								if ($informacoes):
									?>
									<ul>
										<?php
											foreach ($informacoes as $info):
												?>
													<li><?php echo $info->cinfo?></li>
												<?php
											endforeach;
										?>
									</ul>
									<?php
								endif;
							?>
						</li>
						<?php
					}
				?>
			</ul>
			<?php
		}

		?>

		<h5><strong>Avulsos</strong></h5>
		<ul>
			<?php
				foreach ($avulsos as $item){
					?>
					<li>(<?php echo $item['quantidade']?>) <?php echo $item['nome']?>
					<?php
								$informacoes = $item['informacoes'];
								if ($informacoes):
									?>
									<ul>
										<?php
											foreach ($informacoes as $info):
												?>
													<li><?php echo $info->cinfo?></li>
												<?php
											endforeach;
										?>
									</ul>
									<?php
								endif;
							?>
					</li>
					<?php
				}
			?>
		</ul>

		<?php

		if ($this->input->get('imprimir')==1){
			?>
			<script type="text/javascript">
				window.print();
			</script>
			</body>
			</html>
			<?php
		}

	}

	/* Atualiza os bens do Imóvel */

	public function atualizarbens($id){
		$params = $this->input->post('params');
		$this->Imovel_model->id = $id;
		$r = $this->Imovel_model->atualizarBens($params);
		Log_model::save('cadimo', $id, $this->getCurrentUser(), "Atualizou a lista de Itens");
		echo "Atualização realizada com sucesso. Result: ".json_encode($r)." / Produto: ".$id;
		die();
	}

	/* Adicionar um bem */

	public function adicionarBem(){
		$this->load->model('dci/Bem_model');
		$this->Bem_model->descricao = $this->input->post('nome');
		if ($this->Bem_model->validaInsercao()){
			$id = $this->Bem_model->save();
			echo json_encode(array('status'=>'ok', 'message'=>'Bem adicionado com sucesso', 'nome'=>$this->Bem_model->descricao, 'id'=>$id));
			die();
		} else {
			echo json_encode(array('status'=>'error', 'message'=>$this->Bem_model->error));
			die();
		}
		die();
	}

	/**
	* Função para atualizar os pacotes ligados a um Imóvel
	* @access private
	* @param int ID do Imóvel
	* @return true
	*/	

	private function atualizarpacotes($id){
		$ids_pacotes = $this->input->post('nidtbxpac');
		$valores_diarias = $this->input->post('nvlrdiaria');
		$minimo_dias = $this->input->post('nmindias');
		$valores_pacotes = $this->input->post('nvlrpacote');
		$this->Imovel_model->id = $id;
		$this->Imovel_model->savePacotes($ids_pacotes, $valores_diarias, $minimo_dias, $valores_pacotes);
		$this->session->set_flashdata('sucesso', 'Pacotes atualizados com sucesso');
		Log_model::save('cadimo', $id, $this->getCurrentUser(), "Atualizou os pacotes");
		redirect(base_url("cadimo/imovel/pacotes/".$id));
	}

	/**
	* Função para obter a view do Imóvel com ajax (locação)
	* @param integer id do Imóvel
	* @access public
	* @return view com os dados do Imóvel
	*/

	public function getImovelAjaxView($cadimo){
		$data = array();
		$data['neutralizar_calendario'] = $this->input->post('neutralizar_calendario');
		$data['data_inicial'] = $this->input->post('data_inicial');
		$data['data_final'] = $this->input->post('data_final');
		$data['imovel'] = $this->Imovel_model->getById($cadimo);
		$this->load->view('imovel/imovel_blank', $data);
	}

	/**
	* Função para obter a view do Imóvel com ajax (venda)
	* @param integer id do Imóvel
	* @access public
	* @return view com os dados do Imóvel
	*/

	public function getImovelAjaxViewVenda($cadimo){
		$data = array();
		$this->load->model('dci/Sinal_model');
		$this->load->model('dci/Proposta_model');
		$data['sinais'] = $this->Sinal_model->getByImovel($cadimo);
		$data['propostas'] = $this->Proposta_model->getByImovel($cadimo);
		$data['imovel'] = $this->Imovel_model->getById($cadimo);
		$this->load->view('imovel/imovel_blank_venda', $data);
	}

	/**
	* Função para trazer dados do Imóvel em formato JSON
	* @param integer id do Imóvel
	* @access public
	* @return json dados do Imóvel
	*/

	public function getImovelAjax($id){
		$data = array();
		$imovel = $this->Imovel_model->getById($id);
		$fotos = $this->Imovel_model->getFotos($id);
		$data['fotos'] = $fotos;
		$data['imovel'] = $imovel;
		$data['latitude'] = $imovel->clatitude;
		$data['longitude'] = $imovel->clongitude;
		die(json_encode($data));
	}

	/**
	* Função para excluir um Imóvel
	* @param integer id do Imóvel
	* @access public
	* @return true
	*/

	public function remove($id){
		$this->Imovel_model->id = $id;
		$this->Imovel_model->delete();
		$this->session->set_flashdata('sucesso','Produto removido com sucesso');	
		Log_model::save('cadimo', $id, $this->getCurrentUser(), "Excluiu o registro");
		redirect(makeUrl('cadimo','imovel','listar'));
	}

	/**
	* Função para adicionar um Imóvel à lista de amostragem para avaliação
	* @param integer ID do Imóvel
	* @return string resultado da inserção
	*/

	public function adicionarAmostragemAvaliacao($id){
		$lista = $this->session->userdata('imoveis_avaliacao');
		$lista = unserialize($lista);
		if (in_array($id, $lista)){
			echo json_encode("Este Produto já está na lista");
			die();
		}
		$lista[] = $id;
		$lista = serialize($lista);
		$this->session->set_userdata('imoveis_avaliacao', $lista);
		echo json_encode("Produto adicionado com sucesso à lista");
		die();
	}

	/**
	* Função para somar dias a uma data
	* @param string data
	* @param integer dias para somar
	*/

	public function somarData(){
		
		$this->load->model('dep/Feriado_model');

		$data_inicial = $this->input->post('data_inicial');
		$quantidade_dias = $this->input->post('quantidade_dias');

		$data_mysql = substr($data_inicial, 6, 4)."-".substr($data_inicial, 3, 2)."-".substr($data_inicial, 0, 2);

		$dias_somados = 0;

		$data_final = $data_mysql;

		while ($dias_somados < $quantidade_dias){
			$data_final = date("Y-m-d", strtotime($data_final." +1 day"));
			$data_final_s = date("w", strtotime($data_final." +1 day"));
			$feriado = $this->Feriado_model->getByData($data_final);
			if ($data_final_s != 0 && $data_final_s != 6 && !$feriado){
				$dias_somados++;
			}
		}

		$data_final = substr($data_final, 8, 2)."/".substr($data_final, 5, 2)."/".substr($data_final, 0, 4);

		die(json_encode($data_final));

	}


}

?>