<?php
namespace Framework;
use \Libs\QueryBuilder\QueryBuilder;

abstract class Model {
	private   $db;
	public    $query;
	protected $modulo;
	protected $universe;

	function __construct() {
		$this->db    = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
		$this->query = new QueryBuilder($this->db);
	}

	public function set_universe($universe){
		$this->universe = $universe;
		return $this;
	}

	public function set_modulo($modulo){
		$this->modulo = $modulo;
		return $this;
	}

	public function insert($table, array $data){
		$data    = $this->antes_insert($table, $data);
		$retorno = $this->db->insert($table, $data);
		$this->depois_insert($table, $data, $retorno);

		return $retorno;
	}

	public function update($table, array $data, array $where){
		$data    = $this->antes_update($table, $data, $where);
		$retorno = $this->db->update($table, $data, $where);
		$this->depois_update($table, $data, $where, $retorno);

		return $retorno;
	}

	public function delete($table, $where){
		$data = [
			'ativo' => 0,
		];

		$data    = $this->antes_delete($table, $data, $where);
		$retorno = $this->db->update($table, $data, $where);

		$this->depois_delete($table, $data, $where, $retorno);

		return $retorno;
	}

	public function update_relacao($table, $where, $id, $data){

		return $this->db->update($table, $data, [$where => $id]);
	}

	public function select($sql, $array = array(), $fetchMode = \PDO::FETCH_ASSOC){

		return $this->db->select($sql, $array = array(), $fetchMode = \PDO::FETCH_ASSOC);
	}

	public function execute($query){

		$this->db->execute($query);
	}

	public function load_active_list($table, $select = '*') {

		return $this->db->select('SELECT ' . $select . ' FROM ' . $table . ' WHERE ativo = 1');
	}

	public function full_load_by_id($table, $id, $seo = 'nao_retornar_seo'){
		return $this->query
			->select("
				{$table}.*,
				seo.robots,
				seo.revise,
				seo.title,
				seo.description,
				seo.keywords,
			")
			->from("{$table} $table")
			->leftJoin("seo seo ON seo.id_controller = {$table}.id AND seo.controller = '{$seo}'")
			->where("{$table}.id = {$id}")
			->fetchArray('first');
	}

	public function carregar_listagem($busca, $datatable){
		$select = "SELECT SQL_CALC_FOUND_ROWS " . implode(', ', $datatable['select'])
			. " FROM " . $datatable['from']
			. " WHERE ativo = 1";

		if(isset($busca['search']['value']) && !empty($busca['search']['value'])){
			$select .= ' AND ( ';

			foreach ($datatable['search'] as $indice => $column){

				if($indice == 0){
					$select .= " {$column} LIKE '%{$busca['search']['value']}%'";
				}else{
					$select .= " OR {$column} LIKE '%{$busca['search']['value']}%'";
				}
			}

			$select .= ' ) ';
		}

		if(isset($busca['order'][0])){
			$select .= " ORDER BY {$datatable['select'][$busca['order'][0]['column']]} {$busca['order'][0]['dir']}";
		}

		if(isset($busca['start']) && isset($busca['length'])){
			$select .= " LIMIT {$busca['start']}, {$busca['length']}";
		}

		return [
			'dados' => $this->db->select($select),
			'total' => $this->db->select('SELECT FOUND_ROWS() AS total')[0]['total']
		];
	}

	public function insert_update($from, array $where, array $data, $update = false){
		if(!empty($where)){
			$this->query->select("{$from}.id")
				->from("{$from} {$from}");

			foreach ($where as $indice => $item) {
				$this->query->where("{$from}.{$indice} =  '{$item}'", 'AND');
			}

			$registro_existe = $this->query->fetchArray();
		}

		if(empty($registro_existe[0]['id'])){
			$retorno['operacao'] = 'insert';
			$retorno            += $this->insert($from, $data);
			return $retorno;
		}

		if(empty($update) && !empty($registro_existe[0]['id'])){
			$retorno = [
				'operacao'   => 'get',
				'id'         => $registro_existe[0]['id'],
				'status'     => true,
				'error_code' => null,
				'erros_info' => null,
			];

			return $retorno;
		}

		$retorno['operacao']    = 'update';
		$retorno               += $this->update($from, $data, ['id' => $registro_existe[0]['id']]);
		$retorno['id']          = $registro_existe[0]['id'];
		$retorno['dados']['id'] = $registro_existe[0]['id'];


		return $retorno;
	}

	public function check_if_exists($id, $table = null){
		if(empty($table)){
			$table = isset($this->modulo['table']) ? $this->modulo['table'] : $this->modulo['modulo'];
		}

		if(empty($id)){
			throw new \Fail("ID do cadastro não indicado na verificação de existencia do cadastro - {$table}");
		}

		if(empty($this->select("SELECT id FROM {$table} WHERE id = {$id} AND ativo = 1"))){
			$this->view->alert_js(ucfirst($this->modulo['send']) . ' não existe...', 'erro');
			$this->redirect("/{$this->modulo['modulo']}");
		}
	}

	public function antes_insert($table, $data){
		return $data;
	}

	public function depois_insert($table, $data, $retorno){
		return $data;
	}

	public function antes_update($table, $data, $where){
		return $data;
	}

	public function depois_update($table, $data, $where, $retorno){
		return $data;
	}

	public function antes_delete($table, $data, $where){
		return $data;
	}

	public function depois_delete($table, $data, $where, $retorno){
		return $data;
	}
}