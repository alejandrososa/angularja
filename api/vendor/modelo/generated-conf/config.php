<?php
use App\Config;
$configApp = new Config();
$entorno = $configApp->getBaseDatos();
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('default', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
    'dsn' => 'mysql:host='.$entorno['host'].';dbname='.$entorno['nombre'].';port='.$entorno['puerto'],
    'user' => $entorno['usuario'],
    'password' => $entorno['clave'],
    'settings' =>
        array (
          //'charset' => $entorno['charset'],
            'queries' =>
                array (
                ),
        ),
    'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
));
$manager->setName('default');
$serviceContainer->setConnectionManager('default', $manager);
$serviceContainer->setDefaultDatasource('default');