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

$container['event_dispatcher'] = function () {
    return new Tuck\EventDispatcher\BufferedEventDispatcher(
        new Tuck\EventDispatcher\SimpleEventDispatcher()
    );
};
$container['event_store'] = function ($c) {
    return new Broadway\EventStore\DBALEventStore(
        $c['db_connection'],
        new \Broadway\Serializer\SimpleInterfaceSerializer(),
        new \Broadway\Serializer\SimpleInterfaceSerializer(),
        'Events'
    );
};
$container['event_collector'] = function ($c) {
    $eventUoW = new \Tuck\DoctrineEventStore\UnitOfWork($c['event_store'], $c['event_dispatcher']);
    return new Tuck\DoctrineEventStore\EventCollector($eventUoW);
};
$entityManager->getEventManager()->addEventSubscriber($container['event_collector']);

return $container;
