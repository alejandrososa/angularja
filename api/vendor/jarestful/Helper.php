<?php

namespace Api;

class Helper {
       
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

    public function guardarImagen($archivo, $nombre, $carpeta = null){
        if ( !empty( $archivo ) ) {
            $tempPath = $archivo[ 'file' ][ 'tmp_name' ];
            $temp = explode(".", $archivo["file"]["name"]);
            $foto = $nombre . '.' . end($temp);
            //$foto = round(microtime(true)) . '.' . end($temp);

            $carpeta_destino = '';
            if(!empty($carpeta)){
                $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/assets/archivos/'.$carpeta.'/'.$foto;
            }else{
                $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/assets/archivos/'.$foto;
            }
            //$uploadPath =  $_SERVER['DOCUMENT_ROOT'] . '/assets/archivos/'.$foto; //. $archivo[ 'file' ][ 'name' ];
            move_uploaded_file( $tempPath, $carpeta_destino );

            return $foto;

            //$answer = array( 'answer' => 'File transfer completed' );
            //$json = json_encode( $answer );
            //echo $json;
            //$respo = $json;
        } else {
            //$respo = 'No files';
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