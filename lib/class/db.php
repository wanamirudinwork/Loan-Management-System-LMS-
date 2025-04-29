<?php
class db {
	var $connection, $db, $tableName, $insertColumn, $insertValue, $updateArrayValue, $whereArrayValue, $query;
	
	public function __construct($db_host, $db_user, $db_pass, $db_name, $db_port = '3357'){
		$this->connection = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
		
		if ($this->connection->connect_error) {
			throw new Exception('Error: ' . $this->connection->error . '<br />Error No: ' . $this->connection->errno);
		}
		
		$this->connection->set_charset("utf8");
		$this->connection->query("SET SQL_MODE = ''");
	}
	
	public function table($table){
		$this->tableName = $table;
	}
	
	public function insertArray($array){
		foreach($array as $column => $value){
			$columns[] = $column;
			$values[] = $this->checkSQLValue($value);
		}
		$this->insertColumn = implode(',',$columns);
		$this->insertValue = implode(',',$values);
	}
	
	public function updateArray($array){
		foreach($array as $column => $value){
			$arrays[] = $column." = ".$this->checkSQLValue($value);
		}
		$this->updateArrayValue = implode(',',$arrays);
	}
	
	public function whereArray($array){
		foreach($array as $column => $value){
			$arrays[] = $column." = ".$this->checkSQLValue($value);
		}
		$this->whereArrayValue = implode(' AND ',$arrays);
	}
	
	public function insert(){
		$query = "INSERT INTO ".$this->tableName." (".$this->insertColumn.") VALUES (".$this->insertValue.")";
		$this->queryOrDie($query);
	}
	
	public function insertid(){
		return $this->connection->insert_id;
	}
	
	public function update(){
		$query = "UPDATE ".$this->tableName." SET ".$this->updateArrayValue." WHERE ".$this->whereArrayValue;
		$this->queryOrDie($query);
	}
	
	public function delete(){
		$query = "DELETE FROM ".$this->tableName." WHERE ".$this->whereArrayValue;
		$this->queryOrDie($query);
	}
		
	public function query($query){
		$this->query = $query;
	}
	
	public function getRowList(){	
		$query = $this->connection->query($this->query);

		if (!$this->connection->errno) {
			if ($query instanceof \mysqli_result) {
				$data = array();

				while ($row = $query->fetch_assoc()) {
					$data[] = $row;
				}

				$result = new \stdClass();
				$result->num_rows = $query->num_rows;
				$result->row = isset($data[0]) ? $data[0] : array();
				$result->rows = $data;

				$query->close();

				return $result->rows;
			} else {
				return true;
			}
		} else {
			throw new \Exception('Error: ' . $this->connection->error  . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
		}
	}
	
	public function getSingleRow(){
		$query = $this->connection->query($this->query);

		if (!$this->connection->errno) {
			if ($query instanceof \mysqli_result) {
				$data = array();

				while ($row = $query->fetch_assoc()) {
					$data[] = $row;
				}

				$result = new \stdClass();
				$result->num_rows = $query->num_rows;
				$result->row = isset($data[0]) ? $data[0] : array();
				$result->rows = $data;

				$query->close();

				return $result->row;
			} else {
				return true;
			}
		} else {
			throw new \Exception('Error: ' . $this->connection->error  . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
		}
	}

	public function getValue($query){
		$query = $this->connection->query($query);

		if (!$this->connection->errno) {
			if ($query instanceof \mysqli_result) {
				$data = array();

				while ($row = $query->fetch_assoc()) {
					$data[] = $row;
				}

				$result = new \stdClass();
				$result->num_rows = $query->num_rows;
				$result->row = isset($data[0]) ? $data[0] : array();
				$result->rows = $data;

				return current($result->row);
			} else {
				return true;
			}
		} else {
			throw new \Exception('Error: ' . $this->connection->error  . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
		}
	}
	
	public function __destruct(){
		$this->connection->close();
	}
	
	public function escape($value){
		//if(get_magic_quotes_gpc()){
		//	$value = stripslashes($value);
		//}

		$value = addslashes($value);

		if(!is_numeric($value)){
			return "'".$this->connection->real_escape_string($value)."'";
		}else{
			return "'".$value."'";
		}
	}
		
	private function checkSQLValue($value){
		if(!is_numeric($value) && $value == "NOW()"){
			return "NOW()";
		}else{
			return $this->escape($value);
		}
	}
	
	public function queryOrDie($sql){
		$query = $this->connection->query($sql);

		if ($this->connection->errno) {
			$this->queryError($query);
		}
	}
	
	private function queryError($query){
		throw new \Exception('Error: ' . $this->connection->error  . '<br />Error No: ' . $this->connection->errno . '<br />' . $query);
	}
}

?>
