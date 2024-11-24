<?php

require __DIR__ . '/../vendor/autoload.php';

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\JsonFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$config = new JsonFile('migrations.json');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$paths = [__DIR__ . '/../src/Domain'];
//$paths = [__DIR__.'/lib/MyProject/Entities'];



$isDevMode = true;

$ORMconfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

$entityManager = EntityManager::create([
    'driver' => 'pdo_mysql',
    'host' => $_ENV['DB_HOST'],
    'dbname' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8mb4'
], $ORMconfig);

DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
return ConsoleRunner::createHelperSet($entityManager);
