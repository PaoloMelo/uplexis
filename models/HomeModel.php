<?php
	class HomeModel extends Model{
		public $tabela = "usuario";
		public $campo_id = "id";
		public $login;

		public function verificaUsuario($login, $senha){
			$query = "SELECT * FROM " . $this->tabela . " WHERE usuario = '" . $login . "' AND senha = '" . $senha . "'";
			$rs = $this->db->prepare($query);
			$rs->execute(array());
			$this->login = $rs->fetchAll(PDO::FETCH_ASSOC);

			return $this->login;
		}
	}
?>