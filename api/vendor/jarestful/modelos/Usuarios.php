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
    public static $atributos = array();
    public static $setatributos = array();


    /**
     * Inicialización Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aquí realizaríamos la conexión a la BBDD con el método que queramos
    }

    public function todosUsuarios(){
        return $this->todos(self::$modelo);
    }

    public function unicoUsuario(){
        $this->where = $this->atributos;
        $usuario = $this->unico(self::$modelo);
        unset($usuario['clave']);
        return $usuario;
    }

    public function crearUsuario(){
        $resultado = $this->insertar(self::$modelo, $this->atributos);
        return $resultado;
    }

    public function actualizarUsuario(){
        $this->where = $this->atributos;
        $resultado = $this->actualizar(self::$modelo, $this->setatributos);
        return $resultado;
    }

    public function eliminarUsuario(){
        $this->where = $this->atributos;
        $resultado = $this->eliminar(self::$modelo);
        return $resultado;
    }

}