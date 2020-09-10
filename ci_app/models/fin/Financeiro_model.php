<?php
	class Financeiro_model extends MY_Model {

		/* Nome das tabelas no banco de dados */	
		protected static $_table = "cadfin";
		protected static $_idfield = "nidcadfin";
		
		public $tipo;
		public $nidcadfin;
		public $nidcadgrl;
		public $nidcadimo;
		public $nidtbxstp;
		public $nidtbxfpa;
		public $nidcadloc;
		public $nidcadven;
		public $data_pagamento;
		public $data_status;

		public $valor;
		public $tipo_transacao;
		public $descricao;
		public $observacoes;


		public function __construct(){
			parent::__construct();
			$this->load->model('fin/Tipofinanceiro_model');
			$this->load->model('dep/Formapagamento_model');
			$this->load->model('fin/Despesa_model');
		}

		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/

		public function validaInsercao(){
			if (!$this->nidcadimo){
				$this->error = "O cadastro de Imóvel é obrigatório";
				return false;
			}
			$cadimo = $this->db->where('nidcadimo', $this->nidcadimo)->get('cadimo')->row();
			if (!$cadimo){
				$this->error = "O Imóvel informado não foi encontrado";
				return false;
			}
			if (!$this->nidcadloc && !$this->nidcadven){
				$this->error = "O lançamento financeiro deve estar relacionado com uma venda ou locação";
				return false;
			}
			if ($this->nidcadloc){
				$cadloc = $this->db->where('nidcadloc', $this->nidcadloc)->get('cadloc')->row();
				if (!$cadloc){
					$this->error = "A locação informada não foi encontrada";
					return false;
				}
			} else {
				$cadven = $this->db->where('nidcadven', $this->nidcadven)->get('cadven')->row();
				if (!$cadven){
					$this->error = "A venda informada não foi encontrada";
					return false;
				}
			}
			if (!$this->nidtbxstp){
				$this->error = "O status do pagamento é obrigatório";
				return false;
			}
			$stp = $this->db->where('nidtbxstp', $this->nidtbxstp)->get('tbxstp')->row();
			if (!$stp){
				$this->error = "O status do pagamento informado não foi encontrado";
				return false;
			}
			if (!$this->nidtbxfpa){
				$this->error = "A forma de pagamento é obrigatória";
				return false;
			}
			$fpa = $this->db->where('nidtbxfpa', $this->nidtbxfpa)->get('tbxfpa')->row();
			if (!$fpa){
				$this->error = "A forma de pagamento informada não foi localizada";
				return false;
			}
			if (!$this->valor){
				$this->error = "O valor é obrigatório";
				return false;
			}
			if (!$this->tipo_transacao){
				$this->error = "O tipo de transação é obrigatório";
				return false;
			}
			return true;

		}

		public function save(){
			$data = array(
				'nidcadgrl'=>$this->nidcadgrl,
				'ctipotransacao'=>$this->tipo_transacao,
				'nidcadimo'=>$this->nidcadimo,
				'cdescricao'=>$this->descricao,
				'ddatapagamento'=>$this->data_pagamento,
				'ddatastatus'=>toDbdate($this->data_status),
				'nvalor'=>$this->valor,
				'nidtbxstp'=>$this->nidtbxstp,
				'nidtbxfpa'=>$this->nidtbxfpa,
				'cobservacoes'=>$this->observacoes,
				'nidtbxtpf'=>$this->tipo,
				'nidcadfin_pai'=>$this->nidcadfin
			);
			if ($this->nidcadloc){
				$data['nidcadloc'] = $this->nidcadloc;
			} else {
				$data['nidcadven'] = $this->nidcadven;
			}
			$this->db->insert('cadfin', $data);
			return $this->db->insert_id();
		}

		/**
		* Função que retorna os pagamentos a serem feitos pela Muraski através de uma locação
		* @param integer id da locação
		* @return array lista de depósitos a fazer
		* @access public
		*/

		public function getDepositosFazer($locacao_id){
			$tipo = Tipofinanceiro_model::getIdByCod("loc");
			$this->db->where('nidcadloc', $locacao_id);
			$this->db->where('ctipotransacao', 'D');
			$this->db->where('nidtbxtpf', $tipo);
			$this->db->order_by('ddatapagamento', 'ASC');
			$depositos = $this->db->get('cadfin')->result();			
			$result = array();
			foreach ($depositos as $deposito){
				$deposito->ddatapagamento = toUserDate($deposito->ddatapagamento);
				$deposito->nvalor = $deposito->nvalor;
				$deposito->forma_pagamento = $this->Formapagamento_model->getById($deposito->nidtbxfpa)->cnomefpa;
				$deposito->tipo_financeiro = $this->Tipofinanceiro_model->getById($deposito->nidtbxtpf)->cdescritpf;
				$status_pagamento = $this->db->where('nidtbxstp', $deposito->nidtbxstp)->get('tbxstp')->row();
				$deposito->cadgrl = $this->db->where('nidcadgrl', $deposito->nidcadgrl)->get('cadgrl')->row();
				$deposito->pago = $status_pagamento->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? "1" : "0";
				$deposito->status_pagamento = $status_pagamento->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? "Pago - ".$deposito->ddatapagamento : $status_pagamento->cdescricao;
				$deposito->status_pagamento_codigo = $status_pagamento->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? "ok" : "p";
				$result[] = $deposito;
			}
			return $result;			
		}

		/**
		* Função que retorna os pagamentos a serem recebidos pela Muraski através de uma locação
		* @param integer id da locação/venda
		* @return array lista de depósitos a receber
		* @access public
		*/

		public function getDepositosReceber($entidade_id, $finalidade){
			if ($finalidade == Parametro_model::get('finalidade_locacao_id')){
				$tipo = Tipofinanceiro_model::getIdByCod("loc");
				$this->db->where('nidcadloc', $entidade_id);
			} elseif ($finalidade == Parametro_model::get('finalidade_venda_id')){
				$tipo = Tipofinanceiro_model::getIdByCod("ven");
				$this->db->where('nidcadven', $entidade_id);
			}
			$this->db->where('ctipotransacao', 'C');
			$this->db->where('nidtbxtpf', $tipo);
			$this->db->order_by('ddatapagamento', 'ASC');
			$depositos = $this->db->get('cadfin')->result();	
			$result = array();
			foreach ($depositos as $deposito){
				$deposito->ddatapagamento = toUserDate($deposito->ddatapagamento);
				$deposito->nvalor = $deposito->nvalor;
				$deposito->forma_pagamento = $this->Formapagamento_model->getById($deposito->nidtbxfpa)->cnomefpa;
				$deposito->tipo_financeiro = $this->Tipofinanceiro_model->getById($deposito->nidtbxtpf)->cdescritpf;
				$status_pagamento = $this->db->where('nidtbxstp', $deposito->nidtbxstp)->get('tbxstp')->row();
				$deposito->cadgrl = $this->db->where('nidcadgrl', $deposito->nidcadgrl)->get('cadgrl')->row();
				$deposito->pago = $status_pagamento->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? "1" : "0";
				$deposito->status_pagamento = $status_pagamento->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? "Pago - ".$deposito->ddatapagamento : $status_pagamento->cdescricao;
				$deposito->status_pagamento_codigo = $status_pagamento->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? "ok" : "p";
				if ($deposito->nidtbxfpa == Parametro_model::get("id_forma_pagamento_boleto")){
					$this->db->where('nidcadfin', $deposito->nidcadfin);
					$this->db->where('nativo', 1);
					$boleto = $this->db->get('cadbol')->row();
					$deposito->boleto = $boleto;
				}
				$result[] = $deposito;
			}
			return $result;
		}

		/**
		* Função que retorna as despesas a serem recebidas pela Muraski através de uma locação
		* @param integer id da locação
		* @return array lista de despesas a receber
		* @access public
		*/

		public function getDespesasReceber($locacao_id){
			$tipo = Tipofinanceiro_model::getIdByCod("des");
			$this->db->where('nidcadloc', $locacao_id);
			$this->db->where('ctipotransacao', 'D');
			$this->db->where('nidtbxtpf', $tipo);
			$this->db->order_by('ddatapagamento', 'ASC');
			$despesas = $this->db->get('cadfin')->result();			
			$result = array();
			foreach ($despesas as $despesa){
				$despesa->ddatapagamento = toUserDate($despesa->ddatapagamento);
				$despesa->nvalor = $despesa->nvalor;
				$despesa->forma_pagamento = $this->Formapagamento_model->getById($despesa->nidtbxfpa)->cnomefpa;
				$despesa->tipo_financeiro = $this->Tipofinanceiro_model->getById($despesa->nidtbxtpf)->cdescritpf;
				$status_pagamento = $this->db->where('nidtbxstp', $despesa->nidtbxstp)->get('tbxstp')->row();
				$deposito->cadgrl = $this->db->where('nidcadgrl', $deposito->nidcadgrl)->get('cadgrl')->row();
				$despesa->pago = $status_pagamento->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? "1" : "0";
				$despesa->status_pagamento = $status_pagamento->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? "Pago - ".$despesa->ddatapagamento : $status_pagamento->cdescricao;
				$despesa->status_pagamento_codigo = $status_pagamento->nidtbxstp == Parametro_model::get('id_status_pagamento_pago') ? "ok" : "p";
				$result[] = $despesa;
			}
			return $result;
		}

		/**
		* Função que altera o valor de um depósito
		* @return string resultado da ação
		* @access public
		*/

		public function alterarValor(){
			
			$fin = $this->getById($this->nidcadfin);
			
			if ($fin->ddatapagamento){
				return "Só é possível alterar o valor caso o pagamento não estiver confirmado";
			}

			/* Validar alteração de valor */
			
			$data = array('nvalor'=>$this->valor);
			$this->db->where('nidcadfin', $this->nidcadfin);
			$this->db->update('cadfin', $data);
		
			return "Valor alterado com sucesso";
		
		}

		/**
		* Função que altera a data de um depósito
		* @return string resultado da ação
		* @access public
		*/

		public function alterarData(){
			$fin = $this->getById($this->nidcadfin);
			if ($fin->ddatapagamento){
				return "Só é possível alterar a data caso o pagamento não estiver confirmado";
			}
			/* Validar alteração de data */
			$data = array('ddatapagamento'=>$this->data_pagamento);
			$this->db->where('nidcadfin', $this->nidcadfin);
			$this->db->update('cadfin', $data);
			return "Data alterada com sucesso";
		}

		/**
		* Função que confirma o pagamento de um depósito
		* @return array resultado da ação
		* @access public
		*/

		public function confirmarPagamento(){
			$data = array('ddatapagamento'=>$this->data_pagamento,'ddatastatus'=>$this->data_status,'nidtbxstp'=>$this->nidtbxstp);
			$this->db->where('nidcadfin', $this->nidcadfin);
			$this->db->update('cadfin', $data);
			return array("status_acao"=>"ok","ddatapagamento"=>$this->data_pagamento,"message"=>"Pagamento confirmado com sucesso");
		}

		/**
		* Função que reverte o pagamento de um depósito
		* @return array resultado da ação
		* @access public
		*/

		public function reverterPagamento(){
			$data = array('ddatastatus'=>$this->data_status,'nidtbxstp'=>$this->nidtbxstp);
			$this->db->where('nidcadfin', $this->nidcadfin);
			$this->db->update('cadfin', $data);
			return array("status_acao"=>"ok","ddatapagamento"=>null,"message"=>"Pagamento revertido com sucesso");
		}

		/**
		* Função que retorna os depósitos
		* @param string status do depósito
		* @param integer Id do banco
		* @param date data inicial
		* @param date data final
		* @param string crédito ou débito
		* @return array lista de depósitos
		* @access public
		*/

		public function getDepositos($status = false, $banco = false, $data_inicial = false, $data_final = false, $pagar_receber = false){

			$this->load->model('dcg/Banco_model');

			if (!$banco){
				$bancos = $this->Banco_model->getAll();
			} else {
				$bancos = array($this->Banco_model->getById($banco));
			}

			foreach ($bancos as $banco){

				switch ($status){
					case "depositado":
						$this->db->where('nidtbxstp', Parametro_model::get('id_status_pagamento_pago'));
						break;
					case "pendente":
						$this->db->where('nidtbxstp', Parametro_model::get('id_status_pagamento_pendente'));
						break;
					case "pendenterec":
						$this->db->where('nidtbxstp', Parametro_model::get('id_status_pagamento_pendente'));
						$this->db->join('cadfin j', 'cadfin.nidcadfin_pai = j.nidcadfin', 'INNER');
						$this->db->where('j.nidtbxstp', Parametro_model::get('id_status_pagamento_pago'));
						break;
					case "pendente_naorec":
						$this->db->where('nidtbxstp', Parametro_model::get('id_status_pagamento_pendente'));
						$this->db->join('cadfin j', 'cadfin.nidcadfin_pai = j.nidcadfin', 'INNER');
						$this->db->where('j.nidtbxstp', Parametro_model::get('id_status_pagamento_pendente'));
						break;
					default:
						break;
				}

				switch ($pagar_receber){
					case "D":
						$this->db->where('ctipotransacao', 'D');
						break;
					case "C":
						$this->db->where('ctipotransacao', 'C');
						break;
					default:
						break;
				}

				if ($data_inicial){
					$this->db->where('ddatapagamento >=', toDbDate($data_inicial));
				}

				if ($data_final){
					$this->db->where('ddatapagamento <=', toDbDate($data_final));
				}

				$this->db->join('cadgrl c', 'cadfin.nidcadgrl = c.nidcadgrl', 'INNER');
				$this->db->join('tagbco t', 't.nidcadgrl = c.nidcadgrl', 'INNER');
				$this->db->join('tbxbco b', 't.nidtbxbco = b.nidtbxbco', 'INNER');

				$this->db->where('t.nprincipal', 1);

				$this->db->where('t.nidtbxbco', $banco->nidtbxbco);

				$result_query = $this->db->get('cadfin')->result();

				$result_item = array();

				foreach ($result_query as $item){
					$item->cadgrl = $this->db->where('nidcadgrl', $item->nidcadgrl)->get('cadgrl')->row();
					$result_item[] = $item;
				}

				$result[$banco->nidtbxbco] = $result_item;

			}

			return $result;

		}


	}