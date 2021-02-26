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
	
	private DoctrineConfig $doctrineConfig;
	
	private \Doctrine\ORM\EntityManager $entityManager;
	
	private $bookRepository;
	
	private $subjectRepository;
	
	private $bookPerPage;
	
	public function __construct()
	{
		$this->doctrineConfig = new DoctrineConfig();
		$this->entityManager = $this->doctrineConfig->getEntityManager();
		$this->bookRepository = $this->entityManager->getRepository(Books::class);
		$this->subjectRepository = $this->entityManager->getRepository(Subject::class);
		$this->bookPerPage = $_ENV['BOOKS_PER_PAGE'];
	}
	
	
	public function getEntityManager(): \Doctrine\ORM\EntityManager {
		return $this->entityManager;
	}
	
	/**
	 * @return Array
	 */
	public function listAllBooks() : Array
	{
		//$conn = $this->entityManager->getConnection();
		//$conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
		
		return $this->bookRepository->findAll();
	}
	
	/**
	 * @param int $number
	 * @return Array list the given number of Books per page
	 * list the given number of Books per page
	 * @throws \ErrorException
	 */
	public function listBookPerPage(int $number): Array
	{
		if($number <= 100){
			return $this->bookRepository->findBy([],[],$number);
		}else{
			throw new \ErrorException("Number should be a max of 100");
		}
	}
	
	/**
	 * @param int $number
	 * @return Array list 10 books on page given the number
	 * list 10 books on page given the number
	 */
	public function listBookByPageNumber(int $number) :Array
	{
		$limit = $number*$this->bookPerPage;
		$offset = $limit-$this->bookPerPage;
		return $this->bookRepository->findBy([],[],$limit,$offset);
	}
	
	/**
	 * @param string $term
	 * @return Array find books full text search on book.title and subject.name columns
	 * find books full text search on book.title and subject.name columns
	 */
	public function searchBooks(string $term) :Array
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
	
	/**
	 * @param $isOriginal
	 * @return Array list books by is_original
	 * list books by is_original
	 */
	public function listBookByOriginal($isOriginal):Array
	{
		return $this->bookRepository->findBy(['is_original'=>$isOriginal],['title'=>'ASC']);
	}
	
	/**
	 * @param $identifier
	 * @return Array List all books by subject identifier, e.g 001, 002
	 * List all books by subject identifier, e.g 001, 002
	 */
	public function listBookBySubject($identifier) :Array
	{
		$subjects = $this->subjectRepository->findBy(["identifier"=>$identifier]);
		
		return $subjects['books'];
	}
	
	public function __destruct()
	{
	
	}
}
