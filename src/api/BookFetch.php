<?php
namespace App\Api;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
use App\Db\DoctrineConfig;
use Doctrine\Entities\Books;
use Doctrine\Entities\Subject;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

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
		}else{
			throw new ErrorException("Number should be a max of 100");
		}
	}
	
	public function listBookByPagenumber(int $number)
	{
		$limit = $number*10;
		$offset = $limit-10;
		return $this->bookRepository->findBy([],[],$limit,$offset);
	}
	
	public function searchBooks(string $term)
	{
		
		$rsm = new ResultSetMappingBuilder($this->entityManager);
		// Specify the object type to be returned in results
		$rsm->addRootEntityFromClassMetadata('Doctrine\Entities\Books', 'b');
		//$rsm->addJoinedEntityFromClassMetadata('Doctrine\Entities\Subject', 's', 'b', 'subject', array('id' => 'subject_id'));
		
		//$rsm = new ResultSetMapping();
		//$rsm->addEntityResult('Doctrine\Entities\Books', 'b');
	   //$rsm->addEntityResult('Doctrine\Entities\Subject', 's');
		
		$sql = "SELECT b.* FROM books b INNER JOIN subject s ON b.subject_id = s.id WHERE MATCH(b.title)AGAINST (:term IN NATURAL LANGUAGE MODE)
                OR MATCH(s.name) AGAINST (:term IN NATURAL LANGUAGE MODE) ORDER BY b.title ASC";
		$query = $this->entityManager->createNativeQuery($sql,$rsm);
		$query->setParameter('term',$term);
		return $query->getResult();
	}
	
	public function __destruct()
	{
	
	}
}
