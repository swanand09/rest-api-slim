<?php
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Csrf\Guard;
use App\Controller\ApiFetchController;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Middlewares\TrailingSlash;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../');
$dotenv->load();
    
// Start PHP session
session_start();

// Create Container
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();
$responseFactory = $app->getResponseFactory();

/*
    // Register Middleware On Container
    $container->set('csrf', function () use ($responseFactory) {
        return new Guard($responseFactory);
    });

    // Register Middleware To Be Executed On All Routes
    $app->add('csrf');

    $app->get('/foo', function ($request, $response, $args) {
        // CSRF token name and value
        $csrf = $this->get('csrf');
        $nameKey = $csrf->getTokenNameKey();
        $valueKey = $csrf->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);
*/
        /*
           Render HTML form which POSTs to /bar with two hidden input fields for the
           name and value:
           <input type="hidden" name="<?= $nameKey ?>" value="<?= $name ?>">
           <input type="hidden" name="<?= $valueKey ?>" value="<?= $value ?>">
         */
/*	});
*/

$app->add(new TrailingSlash(true));
//$app->addRoutingMiddleware();
    
// Define Custom Error Handler
$customErrorHandler = function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails,
    ?LoggerInterface $logger = null
) use ($app) {
    $logger->error($exception->getMessage());
    
    $payload = ['error' => $exception->getMessage()];
    
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );
    
    return $response;
};

//$errorMiddleware  =
$app->addErrorMiddleware(true, false, false);
    
//$errorMiddleware->setDefaultErrorHandler($customErrorHandler);
    
$middlewareHandleReq = function (Request $request, RequestHandler $handler) {
    try {
        $param = $request->getQueryParams();
        if (isset($param['per_page'])) {
            if (empty($param['per_page'])) {
                $param['per_page'] = 10;
                $request->withQueryParams($param);
            }
            
            return $handler->handle($request);
        }
        
        if (isset($param['page']) && !empty($param['page'])) {
            return $handler->handle($request);
        }
        
        if (isset($param['search']) && !empty($param['search'])) {
            return $handler->handle($request);
        }
        
        if (isset($param['is_original']) && !empty($param['is_original'])) {
            return $handler->handle($request);
        }
        
        if (isset($param['subject'])) {
            if (empty($param['subject'])) {
                $param['subject'] = null;
            } else {
                $param['subject'] = intval($param['subject']);
            }
            $request->withQueryParams($param);
            
            return $handler->handle($request);
        }
    } catch (\ErrorException $e) {
    }
};
$app->get('/', ApiFetchController::class . ':listAllBooks');//->add($middlewareHandleReq);
    
//$app->get('/per_page[/{number:.*}]',  ApiFetchController::class . ':listBookPerPage');  this is path param

// this is GET param with query parameter
$app->get('/list-per-page/[?per_page]', ApiFetchController::class . ':listBookPerPage')->add($middlewareHandleReq);

$app->get('/list-by-page/[?page]', ApiFetchController::class . ':listBookByPageNumber');

$app->get('/list-by-search/[?search]', ApiFetchController::class . ':searchBooks');

$app->get('/list-by-original/[?is_original]', ApiFetchController::class . ':listBookByOriginal');

$app->get('/list-by-subject/[?subject]', ApiFetchController::class . ':listBookBySubject')->add($middlewareHandleReq);

$app->run();
