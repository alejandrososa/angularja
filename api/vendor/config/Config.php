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
    static $WEBSITE_NAME = 'My New Website';
    static $IMAGE_DIR    = 'img';
    static $DEBUG        = true;
    static $DEBUG_SQL    = true;

    static $DIR_DATA     = '/data/';

    //LOGS
    static $LOG          = 'defaultLogger';
    static $RUTA_LOGS    = 'logs/api.log';

    //CONTENIDO ESTATICO
    static $TIPO_PORTADA = 'portada';
    static $TIPO_CONTACTO = 'contacto';

    //REDES SOCIALES
    static $FACEBOOK_API_URL    = 'https://graph.facebook.com/?ids=' ;
    static $TWITTER_API_URL     = 'https://urls.api.twitter.com/1/urls/count.json?url=' ;
    static $GOOGLE_API_URL      = 'https://plusone.google.com/_/+1/fastbutton?url=' ;
    static $LINKEDIN_API_URL    = 'https://www.linkedin.com/countserv/count/share?url=' ;
    static $PINTEREST_API_URL   = 'https://widgets.pinterest.com/v1/urls/count.json?callback=receiveCount&url=' ;
    static $XING_API_URL        = 'https://www.xing-share.com/app/share?op=get_share_button;counter=top;lang=de;url=' ;


    private $entorno;

    public function __construct(){
        $url = $this->getBaseApi();
        $url .= '/vendor/config/';

        if(!empty($_SERVER['APP_ENV'])){

            switch ($_SERVER['APP_ENV']) {

                case "desarrollo":
                    $this->entorno = include $url.'main_dev.php'; //'config/dev/';
                    break;
                case "test":
                    $this->entorno = include $url.'main_tst.php'; //'config/tst/';
                    break;
                case "produccion":
                    $this->entorno = include $url.'main_pro.php'; //'config/pro/';
                    break;
            }

        }else{
            $this->entorno = include $url.'main_dev.php';
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
        $baseDir = str_replace('\\', '/', $baseDir);
        return $baseDir . self::$DIR_DATA;
    }

    public function getEntorno(){
        return $this->entorno;
    }

    public function getBaseDatos(){
        $config = $this->getEntorno();
        return $config['db'];
    }

    public function getData(){
        $config = $this->getEntorno();
        return $config['data'];
    }

    public function getGeneral(){
        $config = $this->getEntorno();
        return $config['general'];
    }

    public static function getBaseAssets(){
        return $_SERVER['DOCUMENT_ROOT'] . '/assets/';
    }

    /**
     *  MENSAJES PARA ERRORES GENERICOS
     */
    public static function getMensajesErrores(){
        $mensajes = Array(
            'Est&aacute;s perdido?',
            'Uhhh, c&oacute;mo h&aacute;s llegado aqu&iacute;?',
            'No te has dado cuenta que algo no marcha bien?');
        return $mensajes[array_rand($mensajes)];
    }

    /**
     * CONTENIDO
     */

    public function getMaxCaracteres(){
        return 140;
    }
    public function getCantidadArticulosRecientes(){
        return 1;
    }
    public function getCantidadArticulosCategoria(){
        return 100;
    }
}