<?php
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 
require_once __DIR__ . '/../vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controller\ApiFetch;

$app = AppFactory::create();
$app->addErrorMiddleware(false, false, false);

$app->get('/', function (Request $request, Response $response, $args) {
	
	$apiFetch = new ApiFetch();
	return $apiFetch->execute('listAllBooks',$response);
});

$app->get('/per_page[/{number:.*}]', function (Request $request, Response $response, $args) {
	
	$apiFetch = new ApiFetch();
	return $apiFetch->execute('listBookPerPage',$response,$args);
});

$app->get('/page[/{number:.*}]', function (Request $request, Response $response, $args) {
	
	$apiFetch = new ApiFetch();
	return $apiFetch->execute('listBookByPagenumber',$response,$args);
});

$app->get('/search[/{term:.*}]', function (Request $request, Response $response, $args) {
	
	$apiFetch = new ApiFetch();
	return $apiFetch->execute('searchBooks',$response,$args);
	
});

$app->get('/is_original[/{number:.*}]', function (Request $request, Response $response, $args) {
	
	$apiFetch = new ApiFetch();
	return $apiFetch->execute('listBookByOriginal',$response,$args);
});
	
	
$app->get('/subject[/{identifier:.*}]', function (Request $request, Response $response, $args) {
	
	$apiFetch = new ApiFetch();
	return $apiFetch->execute('listBookBySubject',$response,$args);
});

$app->run();