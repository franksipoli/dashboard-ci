<?php


class Venda extends MY_Controller {

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
		$this->load->model('cadimo/Venda_model');
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
		$this->load->model('dci/Sinal_model');
		$this->load->model('dci/Proposta_model');

	}


	/**
	* Remover Imóvel da lista de avaliação
	*/

	public function removerImovelAvaliacao($id){
		$imovel_avaliar = $this->input->get('imovel_avaliar');
		$avaliacao_id = $this->input->get('avaliacao_id');
		$lista = $this->session->userdata("imoveis_avaliacao");
		$lista = unserialize($lista);
		foreach ($lista as $key=>$item){
			if ($item == $id){
				unset($lista[$key]);
			}
		}
		$lista = serialize($lista);
		$this->session->set_userdata("imoveis_avaliacao", $lista);
		$this->session->set_flashdata('sucesso', 'Imóvel removido da lista com sucesso');
		if ($imovel_avaliar){
			redirect(makeUrl('venda', 'avaliacao', $imovel_avaliar));
		} else {
			redirect(makeUrl('venda', 'avaliacao', null)."?avaliacao_id=".$avaliacao_id);
		}
		exit();
	}

	/**
	* Função para registrar a venda via AJAX (utilizado no Wizard)
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
	* Função para registrar os dados básicos da venda via AJAX (utilizado no wizard)
	* @access private
	* @param Array dados inputados no formulário
	* @return JSON com o resultado da inserção
	*/

	private function registerEtapaGeral( $params_array )
	{

		if ($params_array['nidcadven']){
			
			return array(
				"error" => 1,
				"message" => "Venda já cadastrada"
			);

		}

		$this->Venda_model->etapa = "geral";

		$this->Venda_model->imovel = !empty($params_array['imovelid']) ? $params_array['imovelid'] : null;

		$this->Venda_model->cliente = !empty($params_array['clienteid']) ? $params_array['clienteid'] : null;

		$this->Venda_model->sinal = !empty($params_array['sinalid']) ? $params_array['sinalid'] : null;

		$this->Venda_model->valor_total = $params_array['valor_total'];

		$this->Venda_model->quantidade_parcelas = $params_array['quantidade_parcelas'];

		$this->Venda_model->usuario_criacao = $this->getCurrentUser();

		$id = $this->Venda_model->save();

		$comissoes = $this->Venda_model->saveComissoes($id);

		$result = array(
			"id" => $id,
			"success" => 1,
			"parcelamento"=>$parcelamento,
			"boletos"=>$this->Venda_model->getBoletos($id)
		);

		echo json_encode($result);

		die();
	}

	/**
	* Avaliar Imóvel
	*/

	public function avaliacao($id = false){

		$this->data['returnurl'] = $this->input->get('returnurl');

		$lista = $this->session->userdata("imoveis_avaliacao");

		$lista = unserialize($lista);

		$this->load->model('cadimo/Avaliacao_model');

		$this->Avaliacao_model->usuario_criacao = $this->getCurrentUser();
		$this->Avaliacao_model->imoveis_ponderados = $lista;

		/* Verifica se o Imóvel existe */

		if ($id){

			$this->data['cadimo'] = $this->Imovel_model->getById($id);

			if (!$this->data['cadimo']){
				$this->session->set_flashdata('erro', 'Imóvel não localizado');
				redirect(makeUrl('cadimo', 'imovel', 'listar'));
				exit();
			}

			$this->Avaliacao_model->imovel = $id;

			$this->Avaliacao_model->save();

		} else {

			if ($this->input->post()){

				/* Os dados do Imóvel serão colocados na tela */

				$referencia = $this->input->post('referencia');

				$titulo = $this->input->post('titulo');

				$descricao = $this->input->post('descricao');

				$metragem = $this->input->post('metragem');

				$nidcadate = $this->input->post('nidcadate');

				$this->Avaliacao_model->referencia = $referencia;
				$this->Avaliacao_model->titulo = $titulo;
				$this->Avaliacao_model->descricao = $descricao;
				$this->Avaliacao_model->metragem = $metragem;
				$this->Avaliacao_model->atendimento = $nidcadate;


				$this->Avaliacao_model->save();

				$imovel = new stdClass();
				$imovel->creferencia = $referencia;
				$imovel->ctitulo = $titulo;
				$imovel->nareautil = $metragem;
				$imovel->tdescricao = $descricao;

				$this->data['cadimo'] = $imovel;

			}

		}

		$imoveis_lista = array();

		foreach ($lista as $imovel_id_lista){
			$imovel = $this->Imovel_model->getById($imovel_id_lista);
			if ($imovel){
				$imovel->valores = $this->Imovel_model->getValores($imovel_id_lista);
				$imoveis_lista[] = $imovel;
			}
		}

		$this->data['fva'] = $this->Finalidadetipovalor_model->getAllFront();

		$this->data['imoveis_lista'] = $imoveis_lista;

		$this->enqueue_script('app/js/venda/avaliacao.js?v='.rand(1,9999));

		$this->load->model('ate/Atendimento_model');

		$atendimentos = $this->Atendimento_model->getAbertos($this->getCurrentUser());
		foreach ($atendimentos as $key=>$atendimento){
			$atendimento->cadgrl = $this->Cadastro_model->getById($atendimento->nidcadgrl);
			$atendimentos[$key] = $atendimento;
		}

		$this->data['atendimentos'] = $atendimentos;

		$this->title = "Avaliar Imóvel - Yoopay - Soluções Tecnológicas";
		$this->loadview('venda/avaliacao');
	}

	/**
	* Avaliar Imóvel
	*/

	public function ver_avaliacao($id = false){

		$this->load->model('cadimo/Avaliacao_model');

		$avaliacao = $this->Avaliacao_model->getById($id);

		$this->data['avaliacao'] = $avaliacao;

		if ($avaliacao->nidcadimo){

			$this->data['cadimo'] = $this->Imovel_model->getById($avaliacao->nidcadimo);

		} else {

			$imovel = new stdClass();
			$imovel->creferencia = $avaliacao->creferencia;
			$imovel->ctitulo = $avaliacao->ctitulo;
			$imovel->nareautil = $avaliacao->nmetragem;
			$imovel->tdescricao = $avaliacao->tdescricao;

			$this->data['cadimo'] = $imovel;

		}

		$imoveis_lista = $this->Avaliacao_model->getImoveis($id);

		$this->data['fva'] = $this->Finalidadetipovalor_model->getAllFront();

		$this->data['imoveis_lista'] = $imoveis_lista;

		$this->enqueue_script('app/js/venda/avaliacao.js?v='.rand(1,9999));

		$this->load->model('ate/Atendimento_model');

		$this->title = "Avaliação - Yoopay - Soluções Tecnológicas";
		$this->loadview('venda/ver_avaliacao');
	}


	/**
	* Remover venda
	*/

	public function remover($id){
		$loc = $this->Venda_model->getById($id);
		/* Dependências */
		$this->Venda_model->id = $id;
		$this->Venda_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
		$this->Venda_model->delete();
		$this->session->set_flashdata('sucesso', 'Venda excluída com sucesso');
		if ($this->input->get('returnurl')){
			redirect($this->input->get('returnurl'));
		} else {
			redirect(baseurl('venda/listar'));
		}
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

		$this->loadview('venda/pesquisarimoveis');

	}

	/**
	* Resultado da pesquisa de imóveis
	*/

	public function resultadoimoveis()
	{

		$this->title = 'Venda - Yoopay - Soluções Tecnológicas';

		$this->data['fva'] = $this->Finalidadetipovalor_model->getAllFront();

		$this->data['tpd'] = $this->Tipodistancia_model->getAll();
		$this->data['tmd'] = $this->Tipomedidadistancia_model->getAll();
		$this->data['trd'] = $this->Tiporeferenciadistancia_model->getAll();

		$this->enqueue_style('vendor/jquery-ui/themes/smoothness/jquery-ui.min.css');

		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');		

		$this->enqueue_style('vendor/jquery-ui/themes/smoothness/theme.css');

		$this->enqueue_style('app/css/locacaotemporada/resultadoimoveis.css');

		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('http://maps.google.com/maps/api/js?sensor=false');

		$this->enqueue_script('app/js/venda/resultadobusca.js?v='.rand(1,9999));

		$finalidade_venda_id = Parametro_model::get("finalidade_venda_id");

		/* Tipo de Imóvel */

		$nidtbxtpi = $this->input->get('nidtbxtpi');

		/* Se o Imóvel tem área averbada ou não */

		$area_averbada = $this->input->get('area_averbada');

		/* Situação da venda (com ou sem opção assinada) */

		$situacao_locacao = $this->input->get('situacao_locacao');

		/* Se o Imóvel deve estar disponível para um pacote de 7 dias de venda */

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

		/* Verifica se este Imóvel já não está vendido */

		$this->db->where('NOT EXISTS(SELECT 1 FROM cadven v WHERE v.nidcadimo = i.nidcadimo AND v.nativo = 1)', null, false);

		/* Critérios */

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

		$this->db->where('i.nidtbxfin', $finalidade_venda_id);

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

		$this->load->model('dci/Statussinal_model');

		$this->load->model('dci/Tipoproposta_model');

		$this->data['ssi'] = $this->Statussinal_model->getAll();

		$this->data['tpr'] = $this->Tipoproposta_model->getAll();

		$this->enqueue_html('locacaotemporada/modal_adicionar_imovel_atendimento.php');

		$this->enqueue_html('locacaotemporada/modal_imovel_proprietario.php');

		$this->enqueue_html('venda/modal_imovel_sinal.php');

		$this->enqueue_html('venda/modal_imovel_proposta.php');

		$this->enqueue_html('locacaotemporada/modal_imovel_angariador.php');

		$this->loadview('venda/resultadoimoveis');

	}


	/**
	* Função para gerar o relatório unificado da venda
	*/

	public function unificado($venda_id){

		$this->data['returnurl'] = $_SERVER['HTTP_REFERER'];

		$this->load->model('fin/Financeiro_model');
		$this->load->model('dep/Formapagamento_model');
		$this->load->model('dep/Statuspagamento_model');
		$this->load->model('app/Documento_model');


		$venda = $this->Venda_model->getById($venda_id);

		if (!$venda){
			$this->session->set_flashdata('erro', 'Venda não encontrada');
			redirect($this->data['returnurl']);
		}

		$imovel = $this->Imovel_model->getById($venda->nidcadimo);

		$this->title = 'Extrato unificado de venda - Yoopay - Soluções Tecnológicas';

		$this->data['documentos'] = $this->Documento_model->getByAplicacao("Venda", $venda_id);
		$this->data['cadimo'] = $imovel;
		$this->data['cadven'] = $venda;
		$this->data['lcm'] = $this->Venda_model->getComissoes($venda_id);
		$this->data['sinais'] = $this->getSinais($venda->nidcadimo, false);
		$this->data['propostas'] = $this->getPropostas($venda->nidcadimo, false);
		$this->data['proprietario'] = $this->Proprietarioimovel_model->getByImovel($imovel->nidcadimo);
		$this->data['comprador'] = $this->Cadastro_model->getById($venda->nidcadgrl);

		$this->enqueue_script('app/js/venda/unificado.js?v='.rand(1,9999));
		
		$this->data['depositos_receber'] = $this->Financeiro_model->getDepositosReceber($venda_id, Parametro_model::get('finalidade_venda_id'));

		$this->loadview('venda/extrato_unificado');
	}

	/**
	* Função para listar documentos da venda
	*/

	public function documentos($venda_id){

		$this->load->model('seg/Segusuario_model');

		$this->load->model('app/Documento_model');

		$this->load->model('dep/Tipodocumento_model');

		$this->data['returnurl'] = $_SERVER['HTTP_REFERER'];

		$venda = $this->Venda_model->getById($venda_id);

		if (!$venda){
			$this->session->set_flashdata('erro', 'Venda não encontrada');
			redirect($this->data['returnurl']);
		}

		$imovel = $this->Imovel_model->getById($venda->nidcadimo);

		if ($this->input->post()){
			/* Cadastrar documento */
			$data = $this->input->post('data');
			$tipo = $this->input->post('nidtbxtdo');
			$observacoes = $this->input->post('observacoes');
			$arquivo = $_FILES['arquivo'];
			if (!$arquivo['tmp_name']){
				$this->session->set_flashdata('erro', 'É obrigatório fazer o upload de um arquivo');
				redirect(makeUrl('venda', 'documentos', $venda->nidcadven));
			}
			if (!is_dir('documentos_venda/'.$venda->nidcadven)){
				@mkdir('documentos_venda/'.$venda->nidcadven, 0777);
			}

			$newname = date('Y').'_'.date('m').'_'.date('d').'-'.date('H').'_'.date('i').'_'.date('s').'-'.$arquivo['name'];

			move_uploaded_file($arquivo['tmp_name'], 'documentos_venda/'.$venda->nidcadven.'/'.$newname);

			$this->Documento_model->app = "Venda";
			$this->Documento_model->entidade = $venda->nidcadven;
			$this->Documento_model->tipo = $tipo;
			$this->Documento_model->data = $data;
			$this->Documento_model->observacoes = $observacoes;
			$this->Documento_model->arquivo = $newname;
			$this->Documento_model->usuario_criacao = $this->getCurrentUser();
			$this->Documento_model->save();

			$this->session->set_flashdata('sucesso', 'Documento enviado com sucesso');
			redirect(makeUrl('venda', 'documentos', $venda->nidcadven));

		}

		$this->title = 'Documentação de venda - Yoopay - Soluções Tecnológicas';

		$this->data['tdo'] = $this->Tipodocumento_model->getByApp("Venda");
		$this->data['documentos'] = $this->Documento_model->getByAplicacao("Venda", $venda->nidcadven);
		$this->data['cadimo'] = $imovel;
		$this->data['cadven'] = $venda;
		$this->data['proprietario'] = $this->Proprietarioimovel_model->getByImovel($imovel->nidcadimo);
		$this->data['comprador'] = $this->Cadastro_model->getById($venda->nidcadgrl);

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$this->enqueue_script('app/js/venda/documentacao.js?v='.rand(1,9999));
		
		$this->loadview('venda/documentacao');
	}

	/**
	* Função para remover um documento
	*/

	public function removerdocumento($tbxdve){
		$this->load->model('app/Documento_model');
		$documento = $this->Documento_model->getById($tbxdve);
		if (!$documento){
			$this->session->set_flashdata('erro', 'Documento não encontrado');
			redirect(makeUrl('venda', 'relatorio'));
		}
		$this->Documento_model->id = $tbxdve;
		$this->Documento_model->nidtbxsegusu_exclusao = $this->getCurrentUser();
		$this->Documento_model->delete();
		$this->session->set_flashdata('sucesso', 'Documento removido com sucesso');
		redirect(makeUrl('venda', 'documentos', $documento->nidcadven));		
	}

	/**
	* Função para confirmar o pagamento de uma comissão
	*/

	public function confirmarcomissao($lcm){
		$this->Venda_model->confirmarComissao($lcm);
		die(json_encode(array('dtdatapagamento'=>toUserDatetime(date('Y-m-d H:i:s')))));
	}

	/**
	* Função para cancelar o pagamento de uma comissão
	*/

	public function cancelarcomissao($lcm){
		$this->Venda_model->cancelarComissao($lcm);
		die(json_encode(array('dtdatapagamento'=>null)));
	}

	/**
	* Função para cadastrar um sinal de negócio em uma venda
	*/

	public function cadastrarsinal($nidcadimo){
		$formdata = $this->input->post('formdata');
		$result = array();
		parse_str($formdata, $formdata);
		if ($nidcadimo){
			$this->Sinal_model->imovel = $formdata['nidcadimo'];
			$this->Sinal_model->comprador = $formdata['idcpfcomprador'];
			$this->Sinal_model->texto = $formdata['descricao'];
			$this->Sinal_model->data = toDbDate($formdata['data']);
			$this->Sinal_model->valor = toDbCurrency($formdata['valor_venda']);
			$this->Sinal_model->status = $formdata['status_sinal'];
			if ($formdata['nidtbxsin']){
				$this->Sinal_model->id = $formdata['nidtbxsin'];
				$validacao = $this->Sinal_model->validaAtualizacao();
				$message_success = "Sinal atualizado com sucesso";
				$this->Sinal_model->data_alteracao = date('Y-m-d H:i:s');
				$this->Sinal_model->usuario_alteracao = $this->getCurrentUser();
			} else {
				$this->Sinal_model->data_criacao = date('Y-m-d H:i:s');
				$this->Sinal_model->usuario_criacao = $this->getCurrentUser();
				$validacao = $this->Sinal_model->validaInsercao();
				$message_success = "Sinal cadastrado com sucesso";
			}
			if ($validacao){
				$id = $this->Sinal_model->save();
				if ($id && !$formdata['nidtbxsin']){
					$this->gerarContratoSinal($id);
				}
				$result["success"] = 1;
				$result["message"] = $message_success;
			} else {
				$result["message"] = $this->Sinal_model->error;
			}
		}
		die(json_encode($result));
	}

	private function aplicarCampos($conteudo)
	{

		$imovelid = $this->Imovel_model->nidcadimo;
		$sinalid = $this->Sinal_model->nidtbxsin;

		$this->Imovel_model = new Imovel_model();
		$this->Sinal_model = new Sinal_model();

		$imovel = $this->Imovel_model->getById($imovelid);
		$sinal = $this->Sinal_model->getById($sinalid);

		$proprietarios = $this->Imovel_model->getProprietarios($imovel->nidcadimo);

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

		$enderecos_imovel = $this->Enderecoimovel_model->getByImovel($imovelid);

		$this->data['cadgrl'] = $this->Cadastro_model->getById($sinal->nidcadgrl);

		$this->data['enderecos'] = $this->Enderecocadastrogeral_model->getByCadastroGeral( $sinal->nidcadgrl );

		$this->data['telefones'] = $this->Telefonecadastrogeral_model->getByCadastroGeral( $sinal->nidcadgrl );

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


		$nomes_proprietarios = array();

		foreach ($proprietarios as $prop){
			$nomes_proprietarios[] = $prop['cadgrl']->cnomegrl;
		}

		$nome_proprietario = implode(", ", $nomes_proprietarios);

		/* Campos */

		$conteudo = str_replace("%%nome%%", $this->data['cadgrl']->cnomegrl, $conteudo);
		$conteudo = str_replace("%%rg%%", $this->data['cadgrl']->crgie, $conteudo);
		$conteudo = str_replace("%%ufrg%%", $this->data['tbxemi']->cdescriemi, $conteudo);
		$conteudo = str_replace("%%cpf%%", $this->data['cadgrl']->ccpfcnpj, $conteudo);
		$conteudo = str_replace("%%profissao%%", $this->data['tbxcbo']->cdescricbo, $conteudo);
		$conteudo = str_replace("%%estadocivil%%", $this->data['tbxest']->cdescriest, $conteudo);
		$conteudo = str_replace("%%nacionalidade%%", $this->data['tbxnac']->cdescrinac, $conteudo);
		$conteudo = str_replace("%%endereco%%", $this->data['enderecos'][0]['cdescrilog'].", ".$this->data['enderecos'][0]['cnumero'].($this->data['enderecos'][0]['ccomplemento'] ? (", ".$this->data['enderecos'][0]['ccomplemento']) : ""), $conteudo);
		$conteudo = str_replace("%%bairro%%", $this->data['enderecos'][0]['cdescribai'], $conteudo);
		$conteudo = str_replace("%%cidade%%", $this->data['enderecos'][0]['cdescriloc'], $conteudo);
		$conteudo = str_replace("%%uf%%", $this->data['enderecos'][0]['cdescriuf'], $conteudo);
		$conteudo = str_replace("%%cep%%", $this->data['enderecos'][0]['ccep_log'] ? $this->data['enderecos'][0]['ccep_log'] : $this->data['enderecos'][0]['ccep_loc'], $conteudo);
		$conteudo = str_replace("%%telefone%%", $this->data['telefones'][0]['cdescritel'], $conteudo);
		$conteudo = str_replace("%%imovel_referencia%%", $imovel->creferencia, $conteudo);
		$conteudo = str_replace("%%imovel_matricula%%", $imovel->cmatricula, $conteudo);
		$conteudo = str_replace("%%imovel_cidade%%", $enderecos_imovel[0]['cdescriloc'], $conteudo);
		$conteudo = str_replace("%%imovel_endereco%%", $enderecos_imovel[0]['cnometpl']." ".$enderecos_imovel[0]['cdescrilog'].", ".$enderecos_imovel[0]['cnumero'].($enderecos_imovel[0]['ccomplemento'] ? (", ".$enderecos_imovel[0]['ccomplemento']) : ""), $conteudo);
		$conteudo = str_replace("%%sinal_descricao%%", $sinal->tdescricao, $conteudo);
		$conteudo = str_replace("%%proprietario_nome%%", $nome_proprietario, $conteudo);

		return $conteudo;

	}

	/**
	* Função para gerar o contrato de um sinal
	*/

	private function gerarContratoSinal($id){
		
		$oldmask = umask(0);

		$sinal = $this->Sinal_model->getById($id);

		$this->Sinal_model = $sinal;

		$this->load->model('cadimo/Tipocontrato_model');
		$this->load->model('cadimo/Contrato_model');

		$tipo_contrato = $this->Tipocontrato_model->getByCodigo("pro");

		$imovel = $this->Imovel_model->getById($sinal->nidcadimo);

		$this->Imovel_model = $imovel;

		if (!is_dir('contratos/'.$this->Imovel_model->creferencia)){

			mkdir('contratos/'.$this->Imovel_model->creferencia, 0777);

		}

		$hash = md5($this->Sinal_model->nidtbxsin.$this->Imovel_model->nidcadimo.$this->Imovel_model->creferencia.date('YmdHis').rand(1,9999));

		$this->Contrato_model->sinal = $this->Sinal_model->nidtbxsin;
		$this->Contrato_model->usuario_criacao = $this->getCurrentUser();
		$this->Contrato_model->tipo = $tipo_contrato->nidtbxcon;
		$this->Contrato_model->caminho = makeUrl('contratos/'.$this->Imovel_model->creferencia.'/'.$hash.".pdf");
		$this->Contrato_model->save();

		$this->load->library('pdf');

	    $pdf = $this->pdf->load();
	    $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
	    
	    $pdf->WriteHTML($this->aplicarCampos($tipo_contrato->tconteudo));
	   
	    $pdf->Output('contratos/'.$imovel->creferencia.'/'.$hash.'.pdf', 'F'); // save to file because we can
		umask($oldmask);
	
	}

	/**
	* Função para trazer os sinais de um Imóvel
	*/

	public function getSinais($nidcadimo, $die = true){
		$this->load->model('cadimo/Contrato_model');
		$this->load->model('dci/Statussinal_model');
		$sinais = $this->Sinal_model->getByImovel($nidcadimo);
		foreach ($sinais as $key=>$sinal){
			$contrato = $this->Contrato_model->getBySinal($sinal->nidtbxsin);
			$sinal->contrato = $contrato->ccaminho;
			$sinal->status = $this->Statussinal_model->getById($sinal->nidtbxssi);
			$sinais[$key] = $sinal;
		}
		if ($die){
			die(json_encode($sinais));
		} else {
			return $sinais;
		}
	}	

	/**
	* Função para obter um sinal
	*/

	public function getSinal($nidtbxsin){
		$sinal = $this->Sinal_model->getById($nidtbxsin);
		if ($sinal){
			$cadastro = $this->Cadastro_model->getById($sinal->nidcadgrl);
			$sinal->cadgrl = $cadastro;
			$sinal->data = toUserDate($sinal->dtdata);
			$sinal->valor = toUserCurrency($sinal->nvalor);
			$result = $sinal;
		} else {
			$result = array("error"=>1);
		}
		die(json_encode($result));
	}

	/**
	* Função para excluir um sinal de negócio
	*/

	public function excluirSinal($nidtbxsin){
		$this->Sinal_model->id = $nidtbxsin;
		$this->Sinal_model->nidtbxsegusu_exclusao = $this->getCurrentUser();
		$this->Sinal_model->delete();
		die(json_encode("OK"));
	}

	/**
	* Função para cadastrar uma proposta em uma venda
	*/

	public function cadastrarproposta($nidcadimo){
		$formdata = $this->input->post('formdata');
		$result = array();
		parse_str($formdata, $formdata);
		if ($nidcadimo){
			$this->Proposta_model->imovel = $formdata['nidcadimo'];
			$this->Proposta_model->cliente = $formdata['idcpfcliente'];
			$this->Proposta_model->texto = $formdata['descricao'];
			$this->Proposta_model->data = toDbDate($formdata['data']);
			$this->Proposta_model->tipo = $formdata['tipo_proposta'];
			$this->Proposta_model->status = $formdata['status_proposta'];
			if ($formdata['nidtbxpro']){
				$this->Proposta_model->id = $formdata['nidtbxpro'];
				$validacao = $this->Proposta_model->validaAtualizacao();
				$message_success = "Proposta atualizada com sucesso";
				$this->Proposta_model->data_alteracao = date('Y-m-d H:i:s');
				$this->Proposta_model->usuario_alteracao = $this->getCurrentUser();
			} else {
				$this->Proposta_model->data_criacao = date('Y-m-d H:i:s');
				$this->Proposta_model->usuario_criacao = $this->getCurrentUser();
				$validacao = $this->Proposta_model->validaInsercao();
				$message_success = "Proposta cadastrada com sucesso";
			}
			if ($validacao){
				$this->Proposta_model->save();
				$result["success"] = 1;
				$result["message"] = $message_success;
			} else {
				$result["message"] = $this->Proposta_model->error;
			}
		}
		die(json_encode($result));
	}

	/**
	* Função para trazer as propostas de um Imóvel
	*/

	public function getPropostas($nidcadimo, $die = true){
		$this->load->model('dci/Tipoproposta_model');
		$propostas = $this->Proposta_model->getByImovel($nidcadimo);
		if ($die){
			die(json_encode($propostas));
		} else {
			return $propostas;
		}
	}	

	/**
	* Função para obter uma proposta
	*/

	public function getProposta($nidtbxpro){
		$proposta = $this->Proposta_model->getById($nidtbxpro);
		if ($proposta){
			$cliente = $this->Cadastro_model->getById($proposta->nidcadgrl);
			$proposta->cadgrl = $cliente;
			$proposta->data = toUserDate($proposta->dtdata);
			$result = $proposta;
		} else {
			$result = array("error"=>1);
		}
		die(json_encode($result));
	}

	/**
	* Função para excluir uma proposta
	*/

	public function excluirProposta($nidtbxpro){
		$this->Proposta_model->id = $nidtbxpro;
		$this->Proposta_model->nidtbxsegusu_exclusao = $this->getCurrentUser();
		$this->Proposta_model->delete();
		die(json_encode("OK"));
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
		$this->load->model('dci/Tipoimovel_model');

		$this->data['tpi'] = $this->Tipoimovel_model->getAll();

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('app/js/venda/relatorio.js?v='.rand(1,9999));

		$this->data['usuarios'] = $this->Segusuario_model->getAll();

		$this->title = 'Relatório de vendas - Inserir parâmetros - Yoopay - Soluções Tecnológicas';

		if ($imovel){
			$this->data['nidcadimo'] = $imovel;
		}

		$this->loadview('venda/relatorio_pesquisa');
	}

	/**
	* Função para gerar o relatório de locações
	*/

	public function gerarRelatorio(){
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$data_inicio = $this->input->get('datan');
		$data_fim = $this->input->get('dataf');
		$usuario = $this->input->get('nidtbxsegusu_criacao');
		$corretor = $this->input->get('corretor');
		$tipo = $this->input->post('nidtbxtpi');
		$vendas = $this->Venda_model->getVendas($data_inicio, $data_fim, $usuario, $corretor, $tipo);
		$this->enqueue_script('app/js/venda/relatorio_lista.js?v='.rand(1,9999));
		$this->data['vendas'] = $vendas;
		$this->data['nidcadven'] = $this->session->flashdata('nidcadven');
		$this->title = 'Relatório de vendas - Yoopay - Soluções Tecnológicas';
		$this->enqueue_html('venda/relatorio_modal_depositos.php');
		$this->loadview('venda/relatorio');
	}

	/**
	* Função para obter dados da venda para o relatório
	*/

	public function getDadosVendaDepositos($venda_id){
		$this->load->model('fin/Financeiro_model');
		$result = new stdClass();
		$result->venda = $this->Venda_model->getById($venda_id);
		$result->imovel = $this->Imovel_model->getById($result->venda->nidcadimo);
		$result->comprador = $this->Cadastro_model->getById($result->venda->nidcadgrl);
		$result->proprietarios = $this->Proprietarioimovel_model->getByImovel($result->imovel->nidcadimo);
		die(json_encode($result));
	}

	/**
		* Fazer a venda do Imóvel
		* @param integer ID do sinal que gerou a venda
		* @access public
	*/

	public function vender($sinal_id){
		$sinal = $this->Sinal_model->getById($sinal_id);
		if (!$sinal){
			$this->session->set_flashdata('erro', 'Sinal não encontrado');
			redirect(makeUrl('venda', 'pesquisarimoveis'));
		}
		$venda = $this->Venda_model->getByImovel($sinal->nidcadimo);
		if ($venda){
			$this->session->set_flashdata('erro', 'Este Imóvel já está vendido');
			redirect(makeUrl('venda', 'pesquisarimoveis'));
		}
		$this->title = "Iniciar Venda - Yoopay - Soluções Tecnológicas";
		$this->load->model('dep/Formapagamento_model');
		$this->enqueue_script('vendor/jquery.steps/build/jquery.steps.js');
		$this->enqueue_script('app/js/venda/wizard.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('app/js/venda/venda.js?v='.rand(1,9999));
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
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
		$this->data['cadimo'] = $this->Imovel_model->getById($sinal->nidcadimo);
		$this->data['cadgrl'] = $this->Cadastro_model->getById($sinal->nidcadgrl);
		$this->data['sin'] = $sinal;
		$this->data['valores'] = $this->Imovel_model->getValores($sinal->nidcadimo);
		$this->data['fpa'] = $this->Formapagamento_model->getAll(null, null, Parametro_model::get('finalidade_venda_id'));
		$this->data['lista_uf'] = $this->Uf_model->getAll(array('nidtbxpas'=>'ASC', 'csiglauf'=>'ASC'));
 		$this->data['requiredfields'] = $this->App_model->getFieldsByAplicacao('Venda');
 		$this->data['quantidade_parcelas_venda'] = Parametro_model::get('quantidade_parcelas_padrao_venda');
		$this->loadview('venda/inserir');
	}

}

?>