<?php
	class Log_model extends MY_Model {

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "taglog";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtaglog";
		
		/**
		* Função para salvar o log no banco
		* @param string local de inserção (cadgrl/cadimo/cadloc)
		* @param int ID da entidade
		* @param int ID do usuário
		* @param string ação a ser salva
		* @return none
		* @access public
		*/
		
		public static function save($local, $chave, $usuario, $acao)
		{
			$coluna = "";
			switch ($local){
				case "cadimo":
					$coluna = "nidcadimo";
					break;
				case "cadgrl":
					$coluna = "nidcadgrl";
					break;
				case "cadloc":
					$coluna = "nidcadloc";
					break;
			}
			if (!$coluna) return;
			$data = array($coluna=>$chave, "nidtbxsegusu"=>$usuario, "dtdata"=>date('Y-m-d H:i:s'), "cacao"=>$acao);
			$db = &get_instance()->db;
			$db->insert('taglog', $data);
			return;
		}

		/**
		* Função para obter a view de um log
		* @param string tipo de item do log (cadgrl/cadimo/cadloc)
		* @param int ID da entidade
		* @return view lista de itens do log
		* @access public
		*/

		public static function getViewLog($local, $chave){
			$ci = &get_instance();
			$db = &get_instance()->db;
			switch ($local){
				case "cadloc":
					$coluna = "nidcadloc";
					break;
				case "cadgrl":
					$coluna = "nidcadgrl";
					break;
				case "cadimo":
					$coluna = "nidcadimo";
					break;
				default:
					$coluna = "";
					break;
			}
			if (!$coluna){
				return;
			}
			$db->where($coluna, $chave);
			$db->order_by('dtdata', 'DESC');
			$data['results'] = array();
			$results = $db->get('taglog')->result();
			foreach ($results as $result){
				$db->where('nidtbxsegusu', $result->nidtbxsegusu);
				$usu = $db->get('tbxsegusu')->row()->cnome;
				$result->usuario = $usu;
				$data['results'][] = $result;
			}
			$ci->load->view('log/view_entidade', $data);
			return;
		}

		/**
		* Função para retornar dados de log por json
		* @param string fase (se deseja retornar todos os registros, a soma dos registros totais ou a soma dos filtrados)
		* @param integer início da paginação dos registros
		* @param integer quantidade de registros a retornar
		* @param array lista de parâmetros para busca
		* @return array lista de log
		*/

		public function listar_log_data( $fase='records', $offset=0, $limit=10, $params=NULL )
		{

			// Construção da consulta
			// campos
			$select = array(
				'l.nidtaglog',
				'l.cacao'
				,'l.nidcadimo'
				,'l.nidcadloc'
				,'l.nidcadgrl'
				,'l.dtdata',
				'u.cnome'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table.' l' )
				->join( 'tbxsegusu u' , 'l.nidtbxsegusu = u.nidtbxsegusu', 'INNER');

			if(isset($params['usuario'])) $sql->where(array('l.nidtbxsegusu'=>$params['usuario'])); // usuário
			if(isset($params['entidade'])){
				switch ($params['entidade']){
					case "cadgrl":
						$sql->where('l.nidcadgrl IS NOT NULL', null, false);
						break;
					case "cadimo":
						$sql->where('l.nidcadimo IS NOT NULL', null, false);
						break;
					case "cadloc":
						$sql->where('l.nidcadloc IS NOT NULL', null, false);
						break;
				}
			}
			if (isset($params['datai']) && isset($params['dataf'])){
				$sql->where("l.dtdata >= '".$params['datai']."' AND l.dtdata <= '".$params['dataf']."'", null, false);
			}

			switch ($fase) {
				case 'records':
					$query = $sql->order_by( 'l.dtdata', 'DESC' )
								->limit( $limit, $offset )
								->get();
					if($query){
						$result = $query->result();
						$return = array();
						foreach ($result as $item){
							$item->dtdata = toUserDateTime($item->dtdata);
							if ($item->nidcadloc){
								$item->centidade = "Locação";
								$this->db->where('nidcadloc', $item->nidcadloc);
								$locacao = $this->db->get('cadloc')->row();
								$this->db->where('nidcadimo', $locacao->nidcadimo);
								$imovel = $this->db->get('cadimo')->row();
								$item->citem = $imovel->creferencia." - De ".toUserDate($locacao->ddatainicial)." a ".toUserDate($locacao->ddatafinal);
							} elseif ($item->nidcadimo){
								$item->centidade = "Imóvel";
								$this->db->where('nidcadimo', $item->nidcadimo);
								$item->citem = $this->db->get('cadimo')->row()->creferencia;
							} elseif ($item->nidcadgrl){
								$item->centidade = "Cadastro Geral";
								$this->db->where('nidcadgrl', $item->nidcadgrl);
								$item->citem = $this->db->get('cadgrl')->row()->cnomegrl;
							}
							$return[] = $item;
						}
						return $return;
					}
					return false;
					break;

				case 'recordsFiltered':
					return $sql->count_all_results();
					break;

				case 'recordsTotal':
					return $this->db->count_all(self::$_table);
					break;
			}

		}

	}