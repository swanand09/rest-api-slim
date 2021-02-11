<?php
namespace App\Api;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
use App\Db\DoctrineConfig;
use Doctrine\Entities\Books;

class BookFetch
{
	
	private $doctrineConfig;
	
	private $entityManager;
	
	private $bookRepository;
	
	public function __construct()
	{
		$this->doctrineConfig = new DoctrineConfig();
		$this->entityManager = $this->doctrineConfig->getEntityManager();
		$this->bookRepository = $this->entityManager->getRepository(Books::class);
	}
	
	
	public function getEntityManager()
	{
		return $this->entityManager;
	}
	
	public function listAllBooks()
	{
		//$conn = $this->entityManager->getConnection();
		//$conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
		
		return $this->bookRepository->findAll();
	}
	
	public function listBookPerPage(int $number)
	{
		if($number <= 100){
			return $this->bookRepository->findBy([],[],$number);
		}
	}
	
	public function listBookByPagenumber(int $number)
	{
		$limit = $number*10;
		$offset = $limit-10;
		return $this->bookRepository->findBy([],[],$limit,$offset);
	}
	
	public function __destruct()
	{
	
	}
}
