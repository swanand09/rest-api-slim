<?php
namespace App\Db;
include_once "conf.php";
use PDO;

class MysqlDb{
	// Properties
	private $dbhost = CONFIG_DATABASE_MYSQL['dbhost'];
	private $dbuser = CONFIG_DATABASE_MYSQL['dbuser'];
	private $dbpass = CONFIG_DATABASE_MYSQL['dbpass'];
	private $dbname = CONFIG_DATABASE_MYSQL['dbname'];
	
	// Connect to DB
	public function connect(){
		$mysql_conn_string = "mysql:host=$this->dbhost;dbname=$this->dbname";
		$dbConnection = new \PDO($mysql_conn_string, $this->dbuser, $this->dbpass);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbConnection;
	}
}