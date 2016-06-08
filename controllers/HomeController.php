<?php
	class HomeController extends Controller{

		public function loginAction($get, $post){
			$this->variaveis_view['mensagem_erro'] = 0;

			if (!isset($get['act'])) {
				$act = @$post['act'];
				$lg = $post['login'];
				$sn = $post['senha'];
			} else {
				$act = @$get['act'];
				$lg = $get['login'];
				$sn = $get['senha'];
			}

			if($act == 'logar'){
				$login = new HomeModel();
				$id = $login->verificaUsuario($lg, $sn);

				if(count($id) > 0){
					$_SESSION['usuario'] = $id;
					$_SESSION['logado'] = 1;
					header("Location: ".PATH."home/index");
					exit;
				}else{
					$this->variaveis_view['erro'] = 2;
				}
			}
			session_destroy();
			$this->view('login');
		}

		public function logoutAction(){
			session_destroy();
			$this->view('index');
		}

		public function indexAction($get, $post){

			$this->view('index');
			
		}

	}
?>