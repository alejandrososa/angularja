<?php
/**
 * Created by PhpStorm.
 * User: alejandro.sosa
 * Date: 23/09/2015
 * Time: 16:13
 */

namespace Api\Modelos;

use Api\Modelo;

class Paginas extends Modelo
{

    private static $modelo = 'ja_paginas';
    public static $atributos = array();
    public static $setatributos = array();


    /**
     * Inicialización Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aquí realizaríamos la conexión a la BBDD con el método que queramos
    }

    public function buscadorPaginas(){
        $this->where = $this->atributos;
        return $this->buscar(self::$modelo);
    }

    public function todasPaginas(){
        return $this->todos(self::$modelo);
    }

    public function unicaPagina(){
        $this->where = $this->atributos;
        return $this->unico(self::$modelo);
    }

    public function crearPaginas(){
        return $this->insertar(self::$modelo, $this->atributos);
    }

    public function actualizarPaginas(){
        $this->where = $this->atributos;
        return $this->actualizar(self::$modelo, $this->setatributos);
    }

    public function eliminarPaginas(){
        $this->where = $this->atributos;
        return $this->eliminar(self::$modelo);
    }

}