<?php
/**
 * Created by PhpStorm.
 * User: alejandro.sosa
 * Date: 06/11/2015
 * Time: 10:32
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/modelo/generated-conf/config.php';


//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;
//$defaultLogger = new Logger('defaultLogger');
//$defaultLogger->pushHandler(new StreamHandler( __DIR__ . '/logs/propel.log', Logger::WARNING));
//$defaultLogger->addWarning('test logs to loggly');

/*
use App\Config;
$entorno = new Config();
$vars = $entorno->getBaseDatos();
echo '<pre>';
print_r($vars['nombre']);
echo '</pre>';
*/

$categorias = JaCategoriasQuery::create()->find();
echo $categorias->exportTo('JSON');
print_r($categorias->toArray());


/*
use App\Config;
$config = new Config();
echo '<pre>';
print_r($config->getBaseDatos());
echo '</pre>';
*/