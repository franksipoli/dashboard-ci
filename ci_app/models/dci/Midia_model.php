<?php
	class Midia_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tagimi";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtagimi";

		public $imovel;
		public $extensao;
		public $ordem;
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
		{
			if (!$this->imovel){
				$this->error = 'Campo em branco';
				return false;					
			}
			/* Verifica se o Imóvel realmente existe */
			$imo = $this->db->where('nidcadimo',$this->imovel)->get(self::$_table)->row();
			if ($imo){
				$this->error = 'O Imóvel solicitado não existe';
				return false;
			}
			return true;
		}
		
		/**
		* Função que valida se o registro pode ser atualizado no banco de dados
		* @access public
		* @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		*/		
		
		public function validaAtualizacao()
		{
			if (!$this->imovel){
				$this->error = 'Campo em branco';
				return false;
			}
			/* Verifica se o Imóvel realmente existe */
			$imo = $this->db->where('nidcadimo',$this->imovel)->get(self::$_table)->row();
			if ($imo){
				$this->error = 'O Imóvel solicitado não existe';
				return false;
			}
			return true;
		}
		
		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/		
		
		public function save()
		{
			if ($this->id){
				/* Atualizar */
				$data = array(
					'nidcadimo'=>$this->imovel,
					'cextension'=>$this->extensao,
					'nord'=>$this->ordem
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
			} else {
				/* Criar */
				$data = array(
					'nidcadimo'=>$this->imovel,
					'cextension'=>$this->extensao,
					'nord'=>$this->ordem
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
			}
			return $this->id;
		}

		/**
		* Função que traz as fotos de um Imóvel
		* @param integer id do Imóvel
		* @access public
		*
		*/

		public function getByImovel($id)
		{
		
			$this->db->where('nidcadimo', $id);
			$this->db->where('nativo', 1);
			$this->db->where('nidtbxsegusu_exclusao IS NULL', null, false);
			$this->db->where('dtdataexc IS NULL', null, false);
			$this->db->order_by('nord', 'ASC');
			$images = $this->db->get('tagimi')->result();

			$result = array();

			foreach ($images as $img){

				$this->db->order_by('nwidth', 'ASC');
				$this->db->limit(1);
				$mid = $this->db->get('tbxmid')->row();

				$item = new stdClass;

				$item->nidtbxmid = $img->nidtbxmid;
				$item->cnomemid = $mid->cnomemid;
				$item->cfoldermid = $mid->cfoldermid;
				$item->nidtagimi = $img->nidtagimi;

				$result[] = $item;

			}

			return $result;

		}

		/**
		* Função que seta as posições das fotos de um Imóvel
		* @param integer id do Imóvel
		* @param array lista de ids ordenados por posição
		*/

		public function setarOrdem($posicoes)
		{

			$i = 1;

			foreach ($posicoes as $pos){

				$data = array('nord'=> $i++);

				$this->db->where('nidtagimi', $pos);

				$this->db->update('tagimi', $data);

			}

		}

		/**
		* Função para excluir a mídia de um Imóvel)
		*/

		public function delete()
		{

			$imi = $this->db->where(self::$_idfield, $this->id)->get(self::$_table)->row();

			$im2 = $this->db->where('nidtagimi', $imi->nidtagimi)->get('tagimi')->result();

			foreach ($im2 as $imagem){

				$mid = $this->db->where('nidtbxmid', $im2->nidtbxmid)->get('tbxmid')->row();

				unlink('imagens/'.$mid->cfoldermid.'/'.$imi->nidtagimi.'.jpg');

				unlink('imagens/'.$mid->cfoldermid.'/thumb/'.$imi->nidtagimi.'.jpg');

			}

			$this->db->where('nidtagimi', $this->id);

			$this->db->delete('tagim2');

			$this->db->where(self::$_idfield, $this->id);

			$this->db->delete(self::$_table);

		}

	}