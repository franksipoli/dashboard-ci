<?php
	class Segusuario extends CI_Model {
		/* Variável estática que contém a instância do banco de dados */	
		private static $db;
		/* Variável que contém o login do usuário */
		public $login;
		/* Variável que contém o nome do usuário */
		public $nome;
		/* Variável que contém o tipo de usuário */
		public $tipo;
		/* Variável que contém a lista de erros */
		public $error;
		/* Variável que contém a senha pura do usuário */
		public $senha;
		/**
		 * Variável que contém o objeto do usuário para ser salvo na sessão
		 * @access private
		 */
		private $usuario;
		
		function __construct(){
			parent::__construct();
			self::$db = &get_instance()->db;
		}
		
		/**
		 * Função para fazer login do usuário
		 * @return array com o objeto do usuário e com informação que o login foi feito com sucesso.
		 * @return array com o erro na tentativa de login.
		 */
		
		function dologin(){
			/* Login em branco, retorna erro e mensagem */
			if (!$this->login)
				return array("error"=>1,"message"=>"O campo login é obrigatório");
			/* Senha em branco, retorna erro e mensagem */
			if (!$this->senha)
				return array("error"=>1,"message"=>"O campo senha é obrigatório");
			$usuario = $this->db->where('clogin',$this->login)->get('tbxsegusu')->row();
			/* Caso não for encontrado nenhum usuário com o login informado, retornar erro */
			if (!$usuario)
				return array("error"=>1,"message"=>"Usuário inválido");
			/* Caso o usuário encontrado no método acima tenha uma senha diferente da informada, retornar erro */
			if ($usuario->csenha != md5($this->senha))
				return array("error"=>1,"message"=>"A senha digitada para o usuário ".$this->login." está inválida");
			/* Armazenar usuário para fazer o login */
			$this->usuario = $usuario;
			/* Salvar dados do usuário na sessão */
			$this->logar();
			/* Retornar sucesso e objeto do usuário */
			return array("success"=>1,"usuario"=>$this->usuario);
		}

		/**
		 * Função para salvar dados do usuário na sessão
		 * @return null
		 */

		private function logar(){
			$data = array("nidtbxsegusu"=>$this->usuario->nidtbxsegusu,"clogin"=>$this->usuario->clogin,"nidtbxtipousu"=>$this->usuario->nidtbxtipousu,"cnome"=>$this->usuario->cnome);
			$this->session->set_userdata($data);
			return;
		}
		
		/**
		 * Função par acaptar todos os usuários
		 * @return lista de usuários
		 */
		
		public static function getAll(){
			$usuarios = $this->db->get('tbxsegusu')->result();
			return $usuarios;
		}
		
		/**
		 * Função para validar inserção de usuário no banco de dados
		 * @return true caso os dados estejam corretos
		 * @return false caso possua dado em branco ou se o tipo de usuário não existir ou se já existir um usuário com esse mesmo login no banco de dados
		 */
		
		public function validaInsercao(){
			/* Retorna false caso qualquer campo do usuário esteja em branco */
			if (!$this->nome || !$this->tipo || !$this->login || !$this->senha){
				$this->error = 'Campo em branco';
				return false;					
			}
			$this->load->model('seg/Segusuariotipo');
			/* Verifica se existe o tipo de usuário selecionado. Caso não existir, retorna false */
			if (!Segusuariotipo::getById($this->tipo)){
				$this->error = 'O tipo de usuário informado não existe';
				return false;
			}
			/* Verifica se já existe um usuário com o mesmo login. Caso existir, retorna false */
			$usuario = $this->db->where('clogin',$this->login)->get('tbxsegusu')->row();
			if ($usuario){
				$this->error = 'Já existe um usuário com este login';
				return false;
			}
			return true;
		}
		
		/**
		 * Função para salvar usuário no banco de dados
		 * @return ID do usuário
		 * @access public
		 */
		
		public function save(){
			$data = array(
				'nidtbxtipousu'=>$this->tipo,
				'cnome'=>$this->nome,
				'clogin'=>$this->login,
				'csenha'=>md5($this->senha)
			);
			$this->db->insert('tbxsegusu', $data);
			return $this->db->insert_id();
		}
	}
?>