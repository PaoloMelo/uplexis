<?php
	class RedirectorHelper {
		protected $parameters = array();
		
		public function go($data) {
			//echo PATH . $data;exit;
			header('Location: ' . PATH . $data);
		}
		
		public function setUrlParameter($nome, $valor) {
			$this->parameters[$nome] = $valor;
			return $this;
		}
		
		protected function getUrlParameters() {
			$parms = '';
			foreach($this->parameters as $nome=>$valor) {
				$parms .= $nome . '/' . $valor . '/';
			}
			return $parms;
		}
		
		public function goToController($controller) {
			$this->go($controller . '/index/' . $this->getUrlParameters());
		}
		
		public function goToAction($action) {
			$this->go($this->getCurrentController() . '/' . $action . '/' . $this->getUrlParameters());
		}
		
		public function goToControllerAction($controller, $action) {
			$this->go($controller . '/' . $action . '/' . $this->getUrlParameters());
		}
		
		public function goToIndex() {
			$this->go('index');
		}
		
		public function goToUrl($url) {
			header('Location: ' . $url);
		}
		
		public function getCurrentController() {
			global $sistema;
			//return $sistema->_controller;
			return $sistema->getController();
		}
		
		public function getCurrentAction() {
			global $sistema;
			//echo $sistema->getAction(); exit;
			return $sistema->getAction();
		}
	}
?>