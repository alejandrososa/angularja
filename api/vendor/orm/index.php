<?php
/**
 * Created by PhpStorm.
 * User: alejandro.sosa
 * Date: 06/11/2015
 * Time: 10:32
 */


Namespace Propel;
require_once __DIR__ . '/vendor/autoload.php';


require_once 'estructura/generated-conf/config.php';


//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;
//$defaultLogger = new Logger('defaultLogger');
//$defaultLogger->pushHandler(new StreamHandler( __DIR__ . '/logs/propel.log', Logger::WARNING));
//$defaultLogger->addWarning('test logs to loggly');

//

use JaCategoriasQuery;
use JaCategorias;

$categorias = JaCategoriasQuery::create()->find();


echo $categorias->exportTo('JSON');

print_r($categorias->toArray());
