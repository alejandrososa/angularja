<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 06/12/2015
 * Time: 15:48
 */
$configAPP = [
    'general' => [
        'dominio'       => 'tst.cristianosja.com',
    ],


    //DATABASE
    'db' => [
        'charset'       => 'utf8',
        'driver'        => 'mysql',
        'nombre'        => 'tstja',
        'usuario'       => 'adoraxion',
        'clave'         => 'dilcia0386',
        'host'          => "localhost",
        'puerto'        => '3306'
    ],

    //DATA CACHE
    'data' => [
        'base'          => '/var/www/vhosts/cristianosja.com/httpdocs/tst.cristianosja.com/api/data/'
    ],

];

return $configAPP;