<?php
	class Model{
		public $tabela; // guardaremos o nome da tabela
		public $campo_id; // guardaremos o nome do campo id da tabela
		public $dados = array();
		public $db; // também declarei o $db que está sendo setado na __construct

		public function __construct($valor = null){
			$this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_BASE, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;"));
			$this->get($this->campo_id, $valor);
		}

		public function get($campo = null, $valor = null){
			// verifico se recebeu os valores certos
			if (!is_null($campo) && !is_null($valor)){
				// monto a query
				$query = "SELECT * FROM " . $this->tabela . " WHERE " . $campo . " = :campo_busca LIMIT 1;";
				$rs = $this->db->prepare($query);
				// coloco o campo buscado aqui no PDO
				$rs->execute(array(
					'campo_busca' => $valor
				));
				// pego o retorno e jogo no array $dados
				$this->dados = $rs->fetch(PDO::FETCH_ASSOC);
			}
		}

		public function set($campo, $valor){
			// jogo o valor no campo, dentro do array $dados
			$this->dados[$campo] = $valor;
			// retorno o objeto para podermos chamar outro metodo em seguida
			return $this;
		}

		public function insert(){
			// crio dois arrays, eles serao usados na query
			$campos = array();
			$valores = array();

			// percorro os campos e populo os arrays. to fazendo isso para usar o PDO da maneira correta
			foreach ($this->dados as $k => $v) {
				$campos[] = $k;
				$valores[] = ':' . $k;
			}

			// monto a query
			$query = "INSERT INTO " . $this->tabela . " (" . implode(', ', $campos) . ") VALUES (" . implode(', ', $valores) . ");";
			// preparo a query
			$rs = $this->db->prepare($query);
			// coloco os valores na query pelo PDO
			$rs->execute($this->dados);
			// pego o id inserido
			$id = $this->db->lastInsertId();
			// jogo o id no nosso objeto
			$this->dados[$this->campo_id] = $id;
			// retorno o id
			return $id;
		}

		public function update(){
			// guardo o ID em uma variavel
			$id = $this->dados[$this->campo_id];
			// e retiro o ID do $dados
			unset($this->dados[$this->campo_id]);

			$campos = array();

			foreach ($this->dados as $k => $v) {
				$campos[] = $k . ' = ' . ':' . $k;
			}

			// monto a query
			$query = "UPDATE " . $this->tabela . " SET " . implode(', ', $campos) . " WHERE " . $this->campo_id . " = :" . $this->campo_id . ";";
			// preparo a query
			$rs = $this->db->prepare($query);
			// devolvo o ID pro $dados
			$this->dados[$this->campo_id] = $id;
			// coloco os valores na query pelo PDO e ja retorno
			return $rs->execute($this->dados);
		}

		public function delete(){
			// guardo o ID em uma variavel
			$id = $this->dados[$this->campo_id];

			// monto a query
			$query = "DELETE FROM " . $this->tabela . " WHERE " . $this->campo_id . " = :" . $this->campo_id . ";";
			// preparo a query
			$rs = $this->db->prepare($query);
			// reseto o array $dados
			$this->dados = array();
			// coloco o ID pelo PDO e ja retorno
			return $rs->execute(array(
				$this->campo_id => $id,
			));
		}

		public function salvar(){
			// verificamos se existe o ID no array $dados
			if (isset($this->dados[$this->campo_id])){
				// faremos um update
				return $this->update();
			}else{
				// faremos um inser
				return $this->insert();
			}
		}

		public function deletar(){
			return $this->delete();
		}
	}