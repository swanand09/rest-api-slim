<?php
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Db\MysqlDb;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();



$app->get('/', function (Request $request, Response $response, $args) {
	$sql = "SELECT * FROM books A INNER JOIN subject B on A.subject_id = B.id";
	
	try{
		// Get Database Object
		$mysqlDb = new MysqlDb();
		//Connect
		$mysqlDbConn = $mysqlDb->connect();
		$stmt = $mysqlDbConn->query($sql);
		$books = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$response->getBody()->write(json_encode($books));
		return $response
			->withHeader('Content-Type', 'application/json');
	} catch(PDOEception $e){
		echo '{"error": {"text":'.$e->getMessage().'}}';
	}
});

$app->run();