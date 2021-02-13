<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Controller\ApiFetchController;

$app = AppFactory::create();
$app->addErrorMiddleware(false, false, false);

$app->get('/',  ApiFetchController::class . ':listAllBooks');

$app->get('/per_page[/{number:.*}]',  ApiFetchController::class . ':listBookPerPage');

$app->get('/page[/{number:.*}]',  ApiFetchController::class . ':listBookByPageNumber');

$app->get('/search[/{term:.*}]',  ApiFetchController::class . ':searchBooks');

$app->get('/is_original[/{number:.*}]',  ApiFetchController::class . ':listBookByOriginal');

$app->get('/subject[/{identifier:.*}]',  ApiFetchController::class . ':listBookBySubject');

$app->run();