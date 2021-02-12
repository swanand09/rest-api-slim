<?php
namespace App\Controller;
Use App\Api\BookFetch;
use Psr\Http\Message\ResponseInterface as Response;

class ApiFetch {
	
	/**
	 * @param $funcName
	 * @param $response
	 * @param array $urlParams
	 * @return Response
	 * to execute the api fetch from various api functions
	 */
	public function execute($funcName,$response,$urlParams=[]) :Response
	{
		try{
			
			$books = $this->$funcName($urlParams);
			if(isset($books['error'])){
				throw new \ErrorException($books['error']);
			}
			
			$response->getBody()->write(json_encode($books,JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
			return $response
				->withHeader('Content-Type', 'application/json');
		} catch(\ErrorException $e){
			$response->getBody()->write(json_encode(["error"=>["text"=>$e->getMessage()]]));
			return $response
				->withHeader('Content-Type', 'application/json');
		}
	}
	
	
	private function listAllBooks($args)
	{
		// Get api object which executes doctrine functions
		$bookApi = new BookFetch();
		
		return $bookApi->listAllBooks();
	}
	
	private function listBookPerPage($args)
	{
		try {
			$number = (isset($args['number']) && !empty($args['number'])) ? (int)$args['number'] : 10;
			if ($number >= 1) {
				// Get api object which executes doctrine functions
				$bookApi = new BookFetch();
				
				return $bookApi->listBookPerPage($number);
				
			} else {
				throw new \ErrorException("Number should be an integer");
			}
		}catch(\ErrorException $e){
			return ["error"=>$e->getMessage()];
		}
	}
	
	
	private function listBookByPagenumber($args)
	{
		try {
			$number = (isset($args['number']) && !empty($args['number'])) ? (int)$args['number'] : 1;
			if($number >=1) {
				// Get api object which executes doctrine functions
				$bookApi = new BookFetch();
				
				return $bookApi->listBookByPagenumber($number);
				
			}else{
				
				throw new \ErrorException("Number should be an integer");
			}
		}catch(\ErrorException $e){
			
			return ["error"=>$e->getMessage()];
		}
	}
	
	private function searchBooks($args)
	{
		try {
			
			$term = (isset($args['term']) && !empty($args['term'])) ? $args['term'] : null;
			if(!is_null($term)){
				
				// Get api object which executes doctrine functions
				$bookApi = new BookFetch();
				return $bookApi->searchBooks($term);
				
			}else{
				
				throw new \ErrorException("Search term should not be empty");
			}
		}catch(\ErrorException $e){
			
			return ["error"=>$e->getMessage()];
		}
	}
	
	
	private function listBookByOriginal($args)
	{
		try {
			
			if($args['number'] ==="1" || $args['number']==="0") {
				
				$number = (isset($args['number']) && $args['number'] !== '') ? intval($args['number']) : null;
				if (!is_null($number) && ($number >= 0 && $number <= 1)) {
					
					// Get api object which executes doctrine functions
					$bookApi = new BookFetch();
					return $bookApi->listBookByOriginal($number);
				} else {
					
					throw new \ErrorException("second parameter should be either 1 or 0");
				}
			}else{
				
				throw new \ErrorException("second parameter should be either 1 or 0");
			}
		}catch(\ErrorException $e){
			
			return ["error"=>$e->getMessage()];
		}
	}
	
	private function listBookBySubject($args)
	{
		try {
			$identifier = (isset($args['identifier']) && $args['identifier']!=='') ? intval($args['identifier']) : null;
			if(!is_null($identifier) && $identifier >0){
				
				// Get api object which executes doctrine functions
				$bookApi = new BookFetch();
				return $bookApi->listBookBySubject($identifier);
			}else{
				
				throw new \ErrorException("Second parameter should not be empty and should be an integer");
			}
		}catch(\ErrorException $e){
			
			return ["error"=>$e->getMessage()];
		}
	}
}