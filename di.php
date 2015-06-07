<?php
require_once 'vendor/autoload.php';
/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = require_once __DIR__ . '/bootstrap.php';
use Pimple\Container;
$container = new Container();



$container['entity_manager'] = function (Container $container) use ($entityManager) {
    return $entityManager;
};

$container['db_connection'] = function () use ($entityManager) {
    return $entityManager->getConnection();
};

return $container;
