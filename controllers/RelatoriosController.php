<?php
	class RelatoriosController extends Controller{

		public function consultasEfetuadasAction($get, $post){
			$Relatorio = new RestclientModel();

			$this->variaveis_view["dados"] = $Relatorio->retornaConsultas($_SESSION['usuario'][0]['id']);

			$this->view('lista');
		}

	}
?>