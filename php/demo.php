<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 20/09/2015
 * Time: 14:29
 */

include_once '../api/vendor/autoload.php';
use Api\Demo;

$demo = new Demo();
print_r($demo->getUltimosArticulos(1)); //