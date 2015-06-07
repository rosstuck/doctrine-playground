<?php
$container = require_once __DIR__ . '/di.php';
/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = $container['entity_manager'];

// Put your sample code here!
echo "Let's rock.\n";
