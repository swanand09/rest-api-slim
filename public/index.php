<?php
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 
require_once __DIR__ . '/../vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
Use App\Api\BookFetch;



$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
	
	try{
		// Get Database Object
		$bookApi = new BookFetch();
		
		$books = $bookApi->listAllBooks();
		
		$response->getBody()->write(json_encode($books));
		return $response
			->withHeader('Content-Type', 'application/json');
	} catch(PDOEception $e){
		echo '{"error": {"text":'.$e->getMessage().'}}';
	}
});

$app->run();