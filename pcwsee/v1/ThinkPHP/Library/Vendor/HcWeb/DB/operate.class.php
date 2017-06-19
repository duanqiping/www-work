<?php
   require_once dirname(__FILE__).'/dbHelper.class.php';
   class operate {	
   	  protected $dbHelper;
   	  protected $table;
	  function __construct($tb) {
	  	$this->table=$tb;
	  	$this->dbHelper=new dbHelper();
	  }
	  public function startTransaction(){
	  	return $this->dbHelper->query("BEGIN");
	  }
	  public function commitTransaction(){
	  	return $this->dbHelper->query("COMMIT");
	  }
	  public function rollbackTransaction(){
	  	return $this->dbHelper->query("ROLLBACK");
	  }
	  public function endTransaction(){
	  	return $this->dbHelper->query("END");
	  }
	  public function query($sql){
	  	return $this->dbHelper->query($sql);
	  }  
	  
  }

?>