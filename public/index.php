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

$app->get('/per_page[/{number:.*}]', function (Request $request, Response $response, $args) {
	
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

$app->get('/page[/{number:.*}]', function (Request $request, Response $response, $args) {
	
	try{
		$number = (isset($args['number']) && !empty($args['number'])) ? (int)$args['number'] : 1;
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

$app->get('/search[/{term:.*}]', function (Request $request, Response $response, $args) {
	
	try{
		$term = (isset($args['term']) && !empty($args['term'])) ? $args['term'] : null;
		if(!is_null($term)){
		// Get api object which executes doctrine functions
		$bookApi = new BookFetch();
		$books = $bookApi->searchBooks($term);
		
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

$app->get('/is_original[/{number:.*}]', function (Request $request, Response $response, $args) {
	
	try{
		$number = (isset($args['number']) && $args['number']!=='') ? intval($args['number']) : null;
		if(!is_null($number) && ($number >=0 && $number<=1)){
			// Get api object which executes doctrine functions
			$bookApi = new BookFetch();
			$books = $bookApi->listBookByOriginal($number);
			
			$response->getBody()->write(json_encode($books));
			return $response
				->withHeader('Content-Type', 'application/json');
		}else{
			throw new ErrorException("second parameter should be either 1 or 0");
		}
		
	} catch(Exception $e){
		echo json_encode(["error"=>["text"=>$e->getMessage()]]);
	}
});
	
	
$app->get('/subject[/{identifier:.*}]', function (Request $request, Response $response, $args) {
	
	try{
		$identifier = (isset($args['identifier']) && $args['identifier']!=='') ? intval($args['identifier']) : null;
		if(!is_null($identifier) && $identifier >0){
			// Get api object which executes doctrine functions
			$bookApi = new BookFetch();
			$books = $bookApi->listBookBySubject($identifier);
			
			$response->getBody()->write(json_encode($books));
			return $response
				->withHeader('Content-Type', 'application/json');
		}else{
			throw new ErrorException("Second parameter should not be empty and should be an integer");
		}
		
	} catch(Exception $e){
		echo json_encode(["error"=>["text"=>$e->getMessage()]]);
	}
});

$app->run();