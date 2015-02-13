<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

/**
 * Stop!
 *
 * This isn't the config file you're looking for: you need config/config.yml.
 *
 * This is just a required file to bootstrap Doctrine's command line tools.
 * Nothing to see here, move along citizen.
 */
return ConsoleRunner::createHelperSet(require __DIR__ . '/bootstrap.php');
