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
	
	public function __construct()
	{
		$this->doctrineConfig = new DoctrineConfig();
		$this->entityManager = $this->doctrineConfig->getEntityManager();
	}
	
	
	public function getEntityManager()
	{
		return $this->entityManager;
	}
	
	public function listAllBooks()
	{
		//$conn = $this->entityManager->getConnection();
		//$conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
		$bookRepository = $this->entityManager->getRepository(Books::class);
		$books = $bookRepository->findAll();
		return $books;
	}
	
	public function __destruct()
	{
	
	}
}
