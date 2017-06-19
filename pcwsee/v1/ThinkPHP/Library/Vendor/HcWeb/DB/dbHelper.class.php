<?php
require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/tool.class.php';
class dbHelper {
	private $db_host; 
	private $db_user; 
	private $db_pwd; 
	private $db_database; 
	private $conn;
	private $coding; 
	
	public function __construct() {
		$this->db_host = DB_HOST;
		$this->db_user = DB_USER;
		$this->db_pwd =DB_PASSWORD;
		$this->db_database = DB_NAME;
		$this->coding = DB_CODING;
		$this->conn = "";
		$this->connect();
	}
	public function connect() {
		if ($this->conn == "pconn") {
			$this->conn = mysql_pconnect($this->db_host, $this->db_user, $this->db_pwd);
		} else {
			$this->conn = mysql_connect($this->db_host, $this->db_user, $this->db_pwd,true);
		}
		if (!mysql_select_db($this->db_database, $this->conn)) {
		}
		mysql_query("SET NAMES $this->coding");
	}
	
	public function query($sql) {
		$result=Tools::$RES_FAILED;
		if ($sql != "") {
			$result = mysql_query($sql, $this->conn);
			if ($result) {
				$result=Tools::$RES_NONE;
				if(mysql_affected_rows()>0){
					$result=Tools::$RES_SUCESS;
				}
			}
		}
		return $result;
	}
	public function select($sql) {
		$data = array();
		if ($sql != "") {
			$result = mysql_query($sql, $this->conn);
			if ($result) {
				while(($rs = mysql_fetch_assoc($result))!=false){
					$data[] = $rs;
				}
			   mysql_free_result($result);
			}
		}
		return $data;
	}

	public function delete($sql) {
		return $this->query($sql);
	}
	
	public function insert($sql) {
		return $this->query($sql);
	}
	
	public function update($sql) {
		return $this->query($sql);
		
	}
	public function insert_id() {
		return mysql_insert_id();
	}
	public function db_affected_rows() {
		return mysql_affected_rows();
	}
	public function __destruct() {
		if(is_resource($this->conn)){
			mysql_close($this->conn);
		} 	
	} 		
}

?>