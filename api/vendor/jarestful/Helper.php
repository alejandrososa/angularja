<?php

namespace Api;

use App\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class Helper {

    private static $base = '../api/data/'; //'./vendor/jarestful/data/';
    public $categoriaJson;
    public $nombreJson;

    /**
     * Codificar en JSON
     * @param array $data
     * @return json encode
     */
    public function json($data){
        if(is_array($data)){
            return json_encode($data);
        }
    }

    private function getFunctionName() {
        $backtrace = debug_backtrace();
        return $backtrace[1]['function'];
    }

    public function baseApi(){
        $vendorDir = dirname(dirname(__FILE__));
        return dirname($vendorDir);

    }

    /**
     * @param null $mensaje
     * @param string $tipo
     */
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
            $tempPath = $archivo[ 'file' ][ 'tmp_name' ];
            $temp = explode(".", $archivo["file"]["name"]);
            $foto = $nombre . '.' . end($temp);

            $carpeta_destino = '';
            if(!empty($carpeta)){
                $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/assets/archivos/'.$carpeta.'/'.$foto;
            }else{
                $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/assets/archivos/'.$foto;
            }
            move_uploaded_file( $tempPath, $carpeta_destino );
            return $foto;
        }
    }

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

    public function convertirArrayAString($array){
        if(empty($array)){
            return null;
        }
        $string = '';
        $i = 0;
        foreach($array as $clave => $valor){
            $string .= $i != 0 ? ', ' . $valor : $valor;
            $i++;
        }

        return $string;
    }

    public function contieneDatos($array){
        $resultado = true;
        if(empty($array)){
            $resultado = false;
        }
        return $resultado;
    }


    private function existeCarpeta($ruta){
        $directorio = Config::getBaseData() . $ruta;
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
        if (file_exists($directorio)) {
            return true;
        }
        return false;
    }
    public function crearJson($datos){
        if(empty($this->nombreJson) || empty($datos)){
            return null;
        }
        $nombre = $this->nombreJson;
        $directorio = $this->categoriaJson;
        $archivo = Config::getBaseData() . $directorio .'/'. $nombre .'.json';
        file_put_contents($archivo, json_encode($datos), FILE_APPEND | LOCK_EX);
    }
    public function leerJson($array = false){
        if(empty($this->nombreJson)){
            return null;
        }
        $nombre = $this->nombreJson;
        $directorio = $this->categoriaJson;
        $archivo = Config::getBaseData() . $directorio .'/'. $nombre .'.json';
        if($array){
            return json_decode(file_get_contents($archivo, true), true);
        }else{
            return file_get_contents($archivo, true);
        }

    }

    /*
     * $fp = fopen('results.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
     * */

    /**
     * Get Nombre tabla
     * @param string $nombre
     * @return string nombre
     */
    public function tipo_tabla($nombre){
        $resultado = '';
        switch ($nombre) {
            case 'usuario':
                $resultado = tbl_usuarios;
                break;
            case 'pagina':
                $resultado = tbl_paginas;
                break;
            case 'paginameta':
                $resultado = tbl_paginasmeta;
                break;
            case 'configuracion':
                $resultado = tbl_usuarios;
                break;
        }
        return $resultado;
    }
}