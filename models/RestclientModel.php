<?php
	class RestclientModel extends Model{
		public $tabela = "sintegra";
		public $campo_id = "id";

		public function retornaConsultas($id){
			$query = "SELECT * FROM " . $this->tabela . " WHERE idusuario = " . $id;
			$rs = $this->db->prepare($query);
			$rs->execute(array());
			$this->consultas = $rs->fetchAll(PDO::FETCH_ASSOC);

			return $this->consultas;
		}
	}
?>