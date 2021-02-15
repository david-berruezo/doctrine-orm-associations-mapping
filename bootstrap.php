<?php
require_once "./vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("src");
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => '',
    'password' => '',
    //'password' => '',
    //'dbname'   => 'temp_inmobiliaria',
    //'dbname'    => 'phpandfr_inmobiliaria_dos',
    //'dbname'   => 'pisosenm_inmobiliaria_dos',
    'dbname'   => 'test_doctrine',
    //'dbname'   => 'phpandfr_inmobiliaria_dos',
    'host'     => 'localhost',
    'port'     => '3306',
    'charset'  => 'utf8'
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode,$proxyDir, $cache, $useSimpleAnnotationReader);
$entityManager = EntityManager::create($dbParams, $config);
?>