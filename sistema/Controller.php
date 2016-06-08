<?php
	class Controller extends Sistema{
		protected $authHelper, $sessionHelper, $redirectorHelper, $sistema;
		public $variaveis_view;

		public function __construct() {
			global $sistema;
			$this->authHelper = new AuthHelper();
			$this->sessionHelper = new SessionHelper();
			$this->redirectorHelper = new RedirectorHelper();
			$this->sistema = $sistema;
		}

		public function init(){
			//printa('coisas que rodarao antes de todas as actions');
			if(isset($_SESSION['logado']) && $_SESSION['logado'] == TRUE) {
				$this->variaveis_view['logado'] = 1;
			}else {
				$this->variaveis_view['logado'] = 0;
			}


			if($this->variaveis_view['logado'] == 0 && !in_array($this->redirectorHelper->getCurrentAction(), array('loginAction','senhaAction'))
					&& !in_array($this->redirectorHelper->getCurrentController(), array('UsuarioController'))
				){
				$this->redirectorHelper->goToControllerAction('home', 'login');
			}else if($this->variaveis_view['logado'] == 1) {
				$_SESSION['usuario_id'] = $_SESSION['usuario'][0]['usuario_id'];
			}

		}

		public function view($view){
			if(is_array($this->variaveis_view) && count($this->variaveis_view) > 0) {
				extract($this->variaveis_view, EXTR_PREFIX_SAME, 'view');
			}

			$caminho_view = VIEWS . $view . '.php';
			return require_once $caminho_view;
		}
	}
?>