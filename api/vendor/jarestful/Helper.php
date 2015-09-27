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