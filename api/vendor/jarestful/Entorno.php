<?php
namespace Api;


if(!empty($_SERVER['APP_ENV'])){

    switch ($_SERVER['APP_ENV']) {
        case "desarrollo":
            define("ESPACIO", 'config/dev/');
            break;
        case "test":
            define("ESPACIO", 'config/tst/');
            break;
        case "produccion":
            define("ESPACIO", 'config/pro/');
            break;
    }

}else{
    define("ESPACIO", 'config/tst/');
}



class Entorno {
    private $entorno;

    public function __construct(){
        if(!empty($_SERVER['APP_ENV'])){

            switch ($_SERVER['APP_ENV']) {

                case "desarrollo":
                    $this->entorno = 'config/dev/';
                    //define("ENTORNO", 'config/dev/');
                    break;
                case "test":
                    $this->entorno = 'config/tst/';
                    //define("ENTORNO", 'config/tst/');
                    break;
                case "produccion":
                    $this->entorno = 'config/pro/';
                    //define("ENTORNO", 'config/pro/');
                    break;
            }

        }else{
            //define("ENTORNO", 'config/tst/');
            $this->entorno = 'config/tst/';
        }
    }

    public function getEntorno(){
        return $this->entorno;
    }
}
