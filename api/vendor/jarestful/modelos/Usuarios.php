<?php
/**
 * Created by PhpStorm.
 * User: alejandro.sosa
 * Date: 23/09/2015
 * Time: 16:13
 */

namespace Api\Modelos;

use Api\Modelo;

class Usuarios extends Modelo
{

    private static $modelo = 'ja_usuarios';
    public $atributos = array();



    /**
     * Inicializaci�n Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aqu� realizar�amos la conexi�n a la BBDD con el m�todo que queramos
    }

    public function getUsuarios(){
        return $this->find_all(self::$modelo);
    }

    public function getUsuario(){
        $this->where = $this->atributos;
        $usuario = $this->find_one(self::$modelo);
        unset($usuario['clave']);
        return $usuario;
    }

}