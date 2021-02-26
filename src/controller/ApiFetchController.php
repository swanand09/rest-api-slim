<?php
namespace App\Controller;
Use App\Api\BookFetch;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApiFetchController {
	
	/**
	 * @param $books
	 * @param Response $response
	 * @return Response
	 * to execute the api fetch from various api functions
	 */
	private function execute($books,Response $response) :Response
	{
		try{
			
			if(isset($books['error'])){
				throw new \ErrorException($books['error']);
			}
			
			$response->getBody()->write(json_encode($books,JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			return $response
				->withHeader('Content-Type', 'application/json')
				->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080')
				->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
				->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
		} catch(\ErrorException $e){
			$response->getBody()->write(json_encode(["error"=>["text"=>$e->getMessage()]]));
			return $response
				->withHeader('Content-Type', 'application/json');
		}
	}
	
	/**
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	public function listAllBooks(Request $request, Response $response) :Response
	{
		// Get api object which executes doctrine functions
		$bookApi = new BookFetch();
		
		return $this->execute($bookApi->listAllBooks(),$response);
	}
	
	/**
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	public function listBookPerPage(Request $request, Response $response) :Response
	{
		try {
			 //args are used when there are path params
			//$number = (isset($args['number']) && !empty($args['number'])) ? (int)$args['number'] : 10;
			
			$number = (int)$request->getQueryParams()['per_page'];
			if ($number >= 1) {
				// Get api object which executes doctrine functions
				$bookApi = new BookFetch();
				
				return $this->execute($bookApi->listBookPerPage($number),$response);
				
			} else {
				throw new \ErrorException("Number should be an integer");
			}
		}catch(\ErrorException $e){
			return $this->execute(["error"=>$e->getMessage()],$response);
		}
	}
	
	/**
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	public function listBookByPageNumber(Request $request, Response $response) :Response
	{
		try {
			// $number = (isset($args['number']) && !empty($args['number'])) ? (int)$args['number'] : 1;
			
			$number = (int)$request->getQueryParams()['page'];
			if($number >=1) {
				// Get api object which executes doctrine functions
				$bookApi = new BookFetch();
				
				return $this->execute($bookApi->listBookByPageNumber($number),$response);
				
			}else{
				
				throw new \ErrorException("Number should be an integer");
			}
		}catch(\ErrorException $e){
			
			return $this->execute(["error"=>$e->getMessage()],$response);
		}
	}
	
	/**
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	public function searchBooks(Request $request, Response $response) :Response
	{
		try {
			
			//$term = (isset($args['term']) && !empty($args['term'])) ? $args['term'] : null;
			
			$term = $request->getQueryParams()['search'];
			if(!is_null($term)){
				
				// Get api object which executes doctrine functions
				$bookApi = new BookFetch();
				return $this->execute($bookApi->searchBooks($term),$response);
				
			}else{
				
				throw new \ErrorException("Search term should not be empty");
			}
		}catch(\ErrorException $e){
			
			return $this->execute(["error"=>$e->getMessage()],$response);
		}
	}
	
	/**
	 * @param Request $request
	 * @param Response $response
	 * @param $args
	 * @return Response
	 */
	public function listBookByOriginal(Request $request, Response $response, $args) :Response
	{
		try {
			
			if($args['number'] ==="1" || $args['number']==="0") {
				
				$number = (isset($args['number']) && $args['number'] !== '') ? intval($args['number']) : null;
				if (!is_null($number) && ($number >= 0 && $number <= 1)) {
					
					// Get api object which executes doctrine functions
					$bookApi = new BookFetch();
					return $this->execute($bookApi->listBookByOriginal($number),$response);
				} else {
					
					throw new \ErrorException("second parameter should be either 1 or 0");
				}
			}else{
				
				throw new \ErrorException("second parameter should be either 1 or 0");
			}
		}catch(\ErrorException $e){
			
			return $this->execute(["error"=>$e->getMessage()],$response);
		}
	}
	
	/**
	 * @param Request $request
	 * @param Response $response
	 * @param $args
	 * @return Response
	 */
	public function listBookBySubject(Request $request, Response $response, $args) :Response
	{
		try {
			$identifier =  $request->getQueryParams()['subject'];
			if(!is_null($identifier) && $identifier >0){
				
				// Get api object which executes doctrine functions
				$bookApi = new BookFetch();
				return $this->execute($bookApi->listBookBySubject($identifier),$response);
			}else{
				
				throw new \ErrorException("Second parameter should not be empty and should be an integer");
			}
		}catch(\ErrorException $e){
			
			return $this->execute(["error"=>$e->getMessage()],$response);
		}
	}
}