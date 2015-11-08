<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 08/11/2015
 * Time: 18:10
 */

namespace App;


class Config
{
    static $DB_SERVER    = 'localhost';
    static $DB_NAME      = 'abc';
    static $DB_USERNAME  = 'admin';
    static $DB_PASSWORD  = '12345';

    static $WEBSITE_NAME = 'My New Website';
    static $IMAGE_DIR    = 'img';
    static $DEBUG        = true;
    static $DEBUG_SQL    = false;

    static $DIR_DATA     = '/data/';

    //LOGS
    static $LOG          = 'defaultLogger';
    static $RUTA_LOGS    = 'logs/api.log';


    private $entorno;

    public function __construct(){
        if(!empty($_SERVER['APP_ENV'])){

            switch ($_SERVER['APP_ENV']) {

                case "desarrollo":
                    $this->entorno = 'config/dev/';
                    break;
                case "test":
                    $this->entorno = 'config/tst/';
                    break;
                case "produccion":
                    $this->entorno = 'config/pro/';
                    break;
            }

        }else{
            $this->entorno = 'config/tst/';
        }
    }

    public function getBaseApi(){
        $vendorDir = dirname(dirname(__FILE__));
        $baseDir = dirname($vendorDir);
        return $baseDir;
    }
    public function getBaseData(){
        $vendorDir = dirname(dirname(__FILE__));
        $baseDir = dirname($vendorDir);
        return $baseDir . self::$DIR_DATA;
    }

    public function getEntorno(){
        return $this->entorno;
    }

    public function getBaseDatos(){
        $config['char_set']     = 'utf8';
        $config['driver']       = 'mysql';
        $config['dbbd']         = 'appja';
        $config['dbusuario']    = 'root';
        $config['dbclave']      = "";
        $config['dbHost']       = "localhost";
        $config['dbpuerto']     = '';
        return $config;
    }
}