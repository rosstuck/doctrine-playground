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

// And that's it! Create the EntityManager
return \Doctrine\ORM\EntityManager::create(
    $config['doctrine'],
    $setup
);


// This part of the code is boring and just reads in the connection details
// from the YAML file.
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
