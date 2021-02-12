<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
 
require_once __DIR__ . '/../vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
Use App\Api\BookFetch;



$app = AppFactory::create();
//$app->addRoutingMiddleware();
//$app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, $args) {
	
	try{
		// Get api object which executes doctrine functions
		$bookApi = new BookFetch();
		
		$books = $bookApi->listAllBooks();
		
		$response->getBody()->write(json_encode($books));
		return $response
			->withHeader('Content-Type', 'application/json');
	} catch(Exception $e){
		echo json_encode(["error"=>["text"=>$e->getMessage()]]);
	}
});

$app->get('/per_page/{number}', function (Request $request, Response $response, $args) {
	
	try{
		$number = (isset($args['number']) && !empty($args['number'])) ? (int)$args['number'] : 10;
		if($number >=1) {
			// Get api object which executes doctrine functions
			$bookApi = new BookFetch();
			
			$books = $bookApi->listBookPerPage($number);
			
			$response->getBody()->write(json_encode($books));
			
			return $response
				->withHeader('Content-Type', 'application/json');
		}else{
			throw new ErrorException("Number should be an integer");
		}
	} catch(Exception $e){
		echo json_encode(["error"=>["text"=>$e->getMessage()]]);
	}
});

$app->get('/page/{number}', function (Request $request, Response $response, $args) {
	
	try{
		$number = (isset($args['number']) && !empty($args['number'])) ? (int)$args['number'] : 10;
		if($number >=1) {
		// Get api object which executes doctrine functions
		$bookApi = new BookFetch();
		
		$books = $bookApi->listBookByPagenumber($number);
		
		$response->getBody()->write(json_encode($books));
		return $response
			->withHeader('Content-Type', 'application/json');
		}else{
			throw new ErrorException("Number should be an integer");
		}
	} catch(Exception $e){
		echo json_encode(["error"=>["text"=>$e->getMessage()]]);
	}
});

$app->get('/search/{term}', function (Request $request, Response $response, $args) {
	
	try{
		if((isset($args['term']) && !empty($args['term']))){
		// Get api object which executes doctrine functions
		$bookApi = new BookFetch();
		$books = $bookApi->searchBooks($args['term']);
		
		$response->getBody()->write(json_encode($books));
		return $response
			->withHeader('Content-Type', 'application/json');
		}else{
			throw new ErrorException("Search term should not be empty");
		}
		
	} catch(Exception $e){
		echo json_encode(["error"=>["text"=>$e->getMessage()]]);
	}
});


$app->run();