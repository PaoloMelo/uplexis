<?php
	class AuthHelper {
		protected $sessionHelper, $redirectorHelper, $tableName = 'usuario', $userColumn = 'email',
				  $passColumn = 'senha', $user, $pass, $loginController = 'login', $loginAction = 'entrar',
				  $logoutController = 'login', $logoutAction = 'sair';
		
		public function __construct() {
			$this->sessionHelper = new SessionHelper();
			$this->redirectorHelper = new RedirectorHelper();
			return $this;
		}
		
		public function setTableName($valor) {
			$this->tableName = $valor;
			return $this;
		}
		
		public function setUserColumn($valor) {
			$this->userColumn = $valor;
			return $this;
		}
		
		public function setPassColumn($valor) {
			$this->passColumn = $valor;
			return $this;
		}
		
		public function setUser($valor) {
			$this->user = $valor;
			return $this;
		}
		
		public function setPass($valor) {
			$this->pass = $valor;
			return $this;
		}
		
		public function setLoginControllerAction($controller, $action) {
			$this->loginController = $controller;
			$this->loginAction = $action;
			return $this;
		}
		
		public function setLogoutControllerAction($controller, $action) {
			$this->logoutController = $controller;
			$this->logoutAction = $action;
			return $this;
		}
		
		public function login() {
			$db = new Model();
			$db->_tabela = $this->tableName;
			$where = $this->userColumn . " = '" . $this->user . "' AND " . $this->passColumn . " = '" . $this->pass . "'";
			$sql = $db->read(array(
				'where'=>$where,
				'limit'=>1
			));
		
			if(count($sql) == 0) {
				return FALSE;
			}
			else {
				$this->sessionHelper
					->createSession('userAuth', TRUE)
					->createSession('userData', $sql[0]);
				return TRUE;
			}
			
#			if(count($sql) > 0) {
#				$this->sessionHelper
#					->createSession('userAuth', TRUE)
#					->createSession('userData', $sql[0]);
#			}
			#else {
			#	die('Usuario nao existe.');
			#}
#			$this->redirectorHelper->goToControllerAction($this->loginController, $this->loginAction);
#			return $this;
		}
		
		public function logout() {
			$this->sessionHelper
								->deleteSession('userAuth')
								->deleteSession('userData');
			$this->redirectorHelper->goToControllerAction($this->loginController, $this->loginAction);
			return $this;
		}
		
		public function checkLogin($acao) {
			switch($acao) {
				case 'boolean':
					if(!$this->sessionHelper->checkSession('userAuth')) {
						return FALSE;
					}
					else {
						return TRUE;
					}
					break;
				case 'redirect':
					if(!$this->sessionHelper->checkSession('userAuth')) {
						if($this->redirectorHelper->getCurrentController() != $this->loginController || $this->redirectorHelper->getCurrentAction() != $this->loginAction) {
							$this->redirectorHelper->goToControllerAction($this->loginController, $this->loginAction);
						}
					}
					break;
				case 'stop':
					if(!$this->sessionHelper->checkSession('userAuth')) {
						exit;
					}
					break;
			}
		}
		
		public function userData($key) {
			$s = $this->sessionHelper->selectSession('userData');
			return $s[$key];
		}
	}
?>