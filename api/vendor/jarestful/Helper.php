<?php

namespace Api;

use App\Config;
use Propel\Runtime\Propel;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class Helper {

    private static $base = '../api/data/'; //'./vendor/jarestful/data/';
    public $categoriaJson;
    public $nombreJson;

    //METODOS
    private function getFunctionName() {
        $backtrace = debug_backtrace();
        return $backtrace[1]['function'];
    }

    //RUTAS
    public function baseApi(){
        $vendorDir = dirname(dirname(__FILE__));
        return dirname($vendorDir);
    }

    //LOG
    public function log($metodo, $mensaje = null, $tipo = null){
        $vendorDir = dirname(dirname(__FILE__));
        $baseDir = dirname($vendorDir);

        $var = $this->getFunctionName();

        $metodo     = empty($metodo) ? 'app' : $metodo;
        $mensaje    = empty($mensaje) ? 'Ha ocurrido una incidencia en el codigo' : $mensaje . ' - '. $var;

        switch($tipo){
            case 'info':
                $tipo = Logger::INFO;
                break;
            case 'alert':
                $tipo = Logger::ALERT;
                break;
            case 'warning':
                $tipo = Logger::WARNING;
                break;
            case 'debug':
                $tipo = Logger::DEBUG;
                break;
            case 'notice':
                $tipo = Logger::NOTICE;
                break;
            case 'critical':
                $tipo = Logger::CRITICAL;
                break;
            case 'error':
                $tipo = Logger::ERROR;
                break;
            case 'emergency':
                $tipo = Logger::EMERGENCY;
                break;
            default:
                $tipo = Logger::WARNING;

        }



        $defaultLogger = new Logger($metodo);
        $defaultLogger->pushHandler(new StreamHandler( $baseDir . '/logs/error.log', $tipo));
        $defaultLogger->addWarning($mensaje);


    }
    public function guardarImagen($archivo, $nombre, $carpeta = null){
        if ( !empty( $archivo ) ) {
            $_carpeta = $carpeta != '' ? $carpeta : '';
            $_assets = Config::getBaseAssets().'archivos/'. $_carpeta;
            $tempPath = $archivo[ 'tmp_name' ]; //[ 'file' ][ 'tmp_name' ]
            $temp = explode(".", $archivo["name"]); //$archivo["file"]["name"]
            $foto = $nombre . '.' . end($temp);
            $tipo = $archivo['type'];
            $size = $archivo['size'];

            $carpeta_destino = '';
            if(!empty($carpeta)){
                $this->existeCarpeta($_assets);
                $carpeta_destino = $_assets . '/'.$foto;
            }else{
                $carpeta_destino = $_assets . '/'.$foto;
            }
            move_uploaded_file( $tempPath, $carpeta_destino );

            $imagen = array(
                'name'=> $foto,
                'ruta'=> $_assets,
                'type'=> $tipo,
                'size'=> $size,
            );
            return $imagen;
            //return $this->convertirArrayAJson($imagen);
            //return $foto;
        }
    }

    //CREDENCIALES
    public function encriptar($string){
        $hash = '';
        if(isset($string)){
            $options = [
                'cost' => 11,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $hash = password_hash($string, PASSWORD_BCRYPT, $options);
        }
        return $hash;
    }
    public function validarEncriptacion($clave, $hash){
        $resultado = false;
        if(isset($clave) && isset($hash)){
            if ( password_verify($clave, $hash) ) {
                $resultado = true;
            }
        }
        return $resultado;
    }

    //JSON
    /**
     * Codificar en JSON
     * @param array $data
     * @return json encode
     */
    public function json($datos){
        $str = false;
        $_datos = array();

        if(is_array($datos)){
            if($this->es_ArrayMultidimensional($datos)) {
                foreach ($datos as $array) {
                    $_datos[] = array_change_key_case($array, CASE_LOWER);
                }
            }else{
                $_datos = array_change_key_case($datos, CASE_LOWER);
            }
            $str = json_encode($_datos, JSON_NUMERIC_CHECK);
        }
        return $str;
    }
    private function existeCarpeta($ruta, $raiz = false){
        //true base es raiz, false base es api
        $directorio = $raiz ? Config::getBaseData() . $ruta : $ruta;
        if (!file_exists(Config::getBaseData())) {
            mkdir(Config::getBaseData(), 0777);
        }

        if (!file_exists($directorio)) {
            mkdir($directorio, 0777);
            return true;
            exit;
        } else {
            return true;
        }
    }
    public function existeJson($archivo){
        $directorio = $this->categoriaJson;
        $this->existeCarpeta($directorio);
        $directorio = Config::getBaseData() . $directorio .'/'. $archivo .'.json';
        if(file_exists($directorio)) {
            return true;
        }
        return false;
    }
    public function leerJson($array = false){
        if(empty($this->nombreJson)){
            return null;
        }
        $nombre = $this->nombreJson;
        $directorio = $this->categoriaJson;
        $archivo = Config::getBaseData() . $directorio ."/". $nombre .".json";

        if(!file_exists($archivo)) {
            return null;
        }

        if($array){
            return array_change_key_case(json_decode(file_get_contents($archivo, true), true), CASE_LOWER);
        }else{
            return file_get_contents($archivo, true);
        }
    }
    public function crearJson($datos, $multidimensional = true){
        if(empty($this->nombreJson) || empty($datos)){
            return null;
        }
        $nombre = $this->nombreJson;
        $directorio = $this->categoriaJson;
        $_directorio = Config::getBaseData() . $directorio;
        $archivo = Config::getBaseData() . $directorio .'/'. $nombre .'.json';

        $_datos = array();
        //fix claves minusculas
        if(is_array($datos)) {
            if($this->es_ArrayMultidimensional($datos)) {
                foreach ($datos as $array) {
                    $_datos[] = array_change_key_case($array, CASE_LOWER);
                }
            }else{
                $_datos = array_change_key_case($datos, CASE_LOWER);
            }
        }
        //$_datos = mb_convert_encoding($datos, 'UTF-8', 'OLD-ENCODING');
        $this->existeCarpeta($_directorio);
        file_put_contents($archivo, json_encode($_datos,JSON_NUMERIC_CHECK), LOCK_EX);
    }
    public function eliminarJson($archivo){
        $directorio = $this->categoriaJson;
        $directorio = Config::getBaseData() . $directorio .'/'. $archivo .'.json';
        if (file_exists($directorio)) {
            unlink($directorio);
        }
    }

    //VALIDACIONES
    public function contieneDatos($array){
        $resultado = true;
        if(empty($array)){
            $resultado = false;
        }
        return $resultado;
    }
    public function es_ArrayMultidimensional($array){
        $resultado = true;
        if (count($array) == count($array, COUNT_RECURSIVE)){
            $resultado = false;
        }

        if(is_array(array())) {
            foreach ($array as $elm) {
                if (!is_array($elm)) {
                    $resultado = false;
                    break;
                }
            }
        }
        return $resultado;
    }

    //CONVERSORES
    public function convertirArrayAString($array){
        if(empty($array)){
            return null;
        }
        $string = '';
        $i = 0;
        foreach($array as $clave => $valor){
            $string .= $i != 0 ? ',' . $valor : $valor;
            $i++;
        }

        return $string;
    }
    public function convertirArrayAJson($array){
        if(empty($array)){
            return null;
        }
        return json_encode($array, JSON_NUMERIC_CHECK);

    }

    public function convertirJsonAArray($json){
        if(empty($json)){
            return null;
        }
        return json_decode($json, true);
    }

    public function convertirStringAArray($string){
        if(empty($string)){
            return null;
        }
        return explode(',', preg_replace('/\s+/', ' ',$string));
    }

    public function convertirObjectAString($object){
        if(empty($object)){
            return null;
        }
        return json_encode($object, JSON_NUMERIC_CHECK);
    }

    /**
     * @param $string
     * @param bool|false $sinespacio
     * @return mixed|null|string
     */
    public function convertirAMinuscula($string, $sinespacio = false){
        if(!isset($string)){
            return null;
        }
        return $sinespacio == true ? preg_replace('/\s+/', '', strtolower($string)) : strtolower($string);
    }

    public function convertirKeysMinuscula($array){
        if(!$this->contieneDatos($array)){
            return null;
        }
        return array_change_key_case($array, CASE_LOWER);
    }

    //FECHAS Y HORAS
    public function fechaActual(){
        return date("Y-m-d H:i:s");
    }

    //SQL
    public function consultaSQL($query, $todos = true){
        if(!isset($query)){
            return null;
        }

        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        //2 fetch assoc
        return $todos ? $stmt->fetchAll(2) : $stmt->fetch();
    }

}