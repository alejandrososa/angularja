<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 06/12/2015
 * Time: 15:48
 */
$configAPP = [
    'general' => [
        'dominio'       => 'ja.dev',
    ],

    //DATABASE
    'db' => [
        'charset'       => 'utf8',
        'driver'        => 'mysql',
        'nombre'        => 'appja',
        'usuario'       => 'root',
        'clave'         => "",
        'host'          => "localhost",
        'puerto'        => '3306'
    ],

    //DATA CACHE
    'data' => [
        'base'          => 'api/data/'
    ],

];

return $configAPP;
?>