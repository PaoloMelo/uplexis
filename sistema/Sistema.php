<?php
	class Sistema{
		private $url;
		private $explode;
		private $controller;
		private $action;
		private $parametros;

		public function __construct(){
			$this->setaUrl();
			$this->setaExplode();
			$this->setaController();
			$this->setaAction();
			$this->setaParametros();
			$this->limpar();
		}

		public function setaUrl(){
			// simplesmente pego a GET URL e coloco no atributo $this->url
			$this->url = isset($_GET['url']) ? $_GET['url'] : '';
		}

		public function getAction(){
			return $this->action;
		}

		public function getController(){
			return $this->controller;
		}

		public function executar(){
			// montamos o nome do arquivo da controller
			$caminho_controller = CONTROLLERS . $this->controller . '.php';

			if (file_exists($caminho_controller)){
				// controller existe
				// estancio o objeto da controller
				$controller = new $this->controller();
				//printa($controller);

				// verifico se o metodo "action" existe
				$action = $this->action;
				if (method_exists($controller, $action)){
					// metodo existe
					$controller->init();
					$get = $this->parametros;
					$post = isset($_POST) ? $_POST : array();
					$controller->$action($get, $post);
				}else{
					// action nao existe
					// gera mensagem de erro 404
					echo 'Erro 404 - da action';
				}
			}else{
				// controller nao existe
				// gera mensagem de erro 404
				echo 'Erro 404 - ';
			}
		}

		public function setaExplode(){
			// dou um explode na url
			$this->explode = explode('/', $this->url);
			// pego o ultimo item desse array
			$ultimo = trim(end($this->explode));
			// se ele estiver vazio...
			if ($ultimo == ''){
				// retiramos ele do array
				array_pop($this->explode);
			}
		}

		public function ordenaExplode(){
			$tmp = array();
			foreach ($this->explode as $e) {
				$tmp[] = $e;
			}
			$this->explode = $tmp;
		}

		public function setaController(){
			// verificamos se existe um item no nosso explode
			if (isset($this->explode[0])) {
				// se existe, então colocamos esse ite no $this->controller
				$this->controller = $this->explode[0];
				// depois tiramos ele do nosso array
				unset($this->explode[0]);
				// aqui eu reordeno o $this->explode, para sempre existir um indice "0" nele
				$this->ordenaExplode();
			}else{
				// se nao existir um item na explode, setamos um controller default
				$this->controller = CONTROLLER_DEFAULT;
			}
		}

		public function setaAction(){
			if (isset($this->explode[0])) {
				$this->action = $this->explode[0];
				unset($this->explode[0]);
				$this->ordenaExplode();
			}else{
				$this->action = ACTION_DEFAULT;
			}
		}

		public function setaParametros(){
			// primeiro eu seto o atributo como um array
			$this->parametros = array();

			// depois eu percorro os itens que sobraram no $this->explode
			foreach ($this->explode as $k => $v) {
				// $k é o indice do item, começando pelo 0
				// se $k for par (zero é par), colocamos $v em uma variavel chamada $key
				if ($k % 2 == 0){
					$key = $v;
				}else{
					// e se $k for impar, colocamos o $v no $this->parametros, so que o indice será a variavel $key que criamos acima
					$this->parametros[$key] = $v;
				}
			}
		}

		public function limpar(){
			$this->formataController();
			$this->formataAction();
		}

		public function formataController(){
			// deixo a controller minuscula
			$this->controller = strtolower($this->controller);
			// quebro a controller pelos "-"
			$this->controller = explode('-', $this->controller);
			// executo o "ucfirst" (deixa as primeiras letras maiusculas) de todo o array
			$this->controller = array_map('ucfirst', $this->controller);
			// junto as palavras
			$this->controller = implode('', $this->controller);
			// concatena a palavra Controller no final de cada nome de controller
			$this->controller = $this->controller . 'Controller';
		}

		public function formataAction(){
			// deixo a action minuscula
			$this->action = strtolower($this->action);
			// quebro a action pelos "-"
			$this->action = explode('-', $this->action);
			// executo o "ucfirst" (deixa as primeiras letras maiusculas) de todo o array
			$this->action = array_map('ucfirst', $this->action);
			// deixo a primeira palavra minuscula por completo
			$this->action[0] = strtolower($this->action[0]);
			// junto as palavras
			$this->action = implode('', $this->action);
			// concatena a palavra Action no final de cada nome de Action
			$this->action = $this->action . 'Action';
		}

	}
?>