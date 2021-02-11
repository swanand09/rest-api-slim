<?php
include_once "conf.php";
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DoctrineConfig
{
    private $paths;

    private $dbParams;

    private $configuration;

    public function __construct()
    {
        $this->paths = $this->getPaths();
        $isDevMode = true;

        $this->dbParams = $this->getDbParams();

        $this->configuration = Setup::createAnnotationMetadataConfiguration($this->dbParams, $isDevMode);

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
        $this->configuration->addEntityNamespace("entities", "Doctrine\\entities");
	
	    $conn = EntityManager::getConnection();
	    $conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        
        return EntityManager::create($this->dbParams, $this->configuration);
    }
}