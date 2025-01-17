<?php

namespace App\Infraestructure\Persistence;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../..');
$dotenv->load();

//$config = ORMSetup::createAnnotationMetadataConfiguration(
//    paths: array(__DIR__ . "/../../../src"),
//    isDevMode: true,
//);
//
//$connection = DriverManager::getConnection([
//    'driver' => 'pdo_mysql',
//    'host' => $_ENV['DB_HOST'],
//    'dbname' => $_ENV['DB_NAME'],
//    'user' => $_ENV['DB_USER'],
//    'password' => $_ENV['DB_PASSWORD']
//], $config);
//
//try {
//    $entityManager = new EntityManager($connection, $config);
//    return $entityManager;
//} catch (\Doctrine\ORM\Exception\MissingMappingDriverImplementation $e) {
//    echo $e->getTraceAsString();
//}
//
class Context
{
    private static $context;

    public function __construct()
    {
    }

    public static function getContext()
    {
        if (self::$context) {
            return self::$context;
        }

        $config = ORMSetup::createAnnotationMetadataConfiguratioin(
            paths: array(__DIR__ . "/../../../src"),
            isDevMode: true,
        );

        $connection = DriverManager::getConnection([
            'driver' => 'pdo_mysql',
            'host' => $_ENV['DB_HOST'],
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD']
        ], $config);


        self::$context = new EntityManager($connection, $config);
        return self::$context;
    }
}
