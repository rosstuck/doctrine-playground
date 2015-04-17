<?php
use Symfony\Component\Yaml\Parser;
use Doctrine\ORM\Tools\Setup;

require_once __DIR__.'/vendor/autoload.php';

// Get our config for the playground
$config = getConfig();

// This is a factory doctrine ships with to make the setup easier. It might
// look like a lot of arguments but they're almost all optional.
$setup = Setup::createAnnotationMetadataConfiguration([__DIR__.'/src/'], true, null, null, false);

// We can optionally attach a logger here, which echoes out whatever SQL
// Doctrine is sending. You might find that handy with some examples.
if ($config['playground']['display_sql'] === true) {
    $setup->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
}

if (!empty($config['playground']['types'])) {
    registerCustomTypes($config['playground']['types']);
}

// Create the EntityManager we'll use to communicate with the database
$entityManager = \Doctrine\ORM\EntityManager::create(
    $config['doctrine'],
    $setup
);

// Test and return it.
testConnection($entityManager);
return $entityManager;


// This part of the code from here is boring config file reading and connection testing. Just ignore! //////////////////
function getConfig()
{
    $configFile = __DIR__ . '/config/config.yml';

    if (!is_readable($configFile)) {
        echo "Couldn't find config/config.yml. Copy the config/config.yml.dist file over to config/config.yml and fill in the database details. Then we can begin to rock.";
        die;
    }

    $yamlParser = new Parser();
    $config = $yamlParser->parse(file_get_contents($configFile));
    return $config;
}

function testConnection(\Doctrine\ORM\EntityManager $entityManager)
{
    try {
        $entityManager->getConnection()->connect();
    } catch(Exception $e) {
        echo "We tried to connect to your database but it seems the connection isn't configured correctly. Check your details in config/config.yml and try again.\n";
        echo "If it helps, the raw error message we received was: \n\n".$e->getMessage();
        die;
    }
}

function registerCustomTypes($customTypeClassNames)
{
    foreach ($customTypeClassNames as $className) {
        if (!class_exists($className)) {
            echo "Tried to register custom type $className but it doesn't seem to exist\n";
            die;
        }
        Doctrine\DBAL\Types\Type::addType($className::NAME, $className);
    }
}
