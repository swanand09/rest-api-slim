<?php
namespace App\Db;
include_once "conf.php";
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class DoctrineConfig
{
    private $paths;

    private $dbParams;

    private $configuration;
    //private $entityManager;
    private $driver;

    public function __construct()
    {
        $this->paths = $this->getPaths();
        $isDevMode = true;

        $this->dbParams = $this->getDbParams();

        $this->configuration = Setup::createConfiguration($isDevMode);
	    //Setup::createAnnotationMetadataConfiguration($this->dbParams, $isDevMode);
	    $this->driver = new AnnotationDriver(new AnnotationReader(), $this->paths);
	    // registering noop annotation autoloader - allow all annotations by default
	    AnnotationRegistry::registerLoader('class_exists');
	    $this->configuration->setMetadataDriverImpl( $this->driver);
    }

    public function getPaths()
    {
        return [
            __DIR__ . "/../src/doctrine/entities/"
        ];
    }


    public function getDbParams()
    {

        // the connection configuration
        return [
            'driver' => 'pdo_mysql',
            'user' => CONFIG_DATABASE_MYSQL['user'],
            'password' => CONFIG_DATABASE_MYSQL['pass'],
            'dbname' => CONFIG_DATABASE_MYSQL['name'],
            'host' => CONFIG_DATABASE_MYSQL['host']
        ];
    }

    public function getEntityManager()
    {
    	try {
		    $this->configuration->addEntityNamespace("entities", "Doctrine\\entities");
	
		    return EntityManager::create($this->dbParams, $this->configuration);
		
	    }catch(\Exception $e){
    	
	    }
    }
}