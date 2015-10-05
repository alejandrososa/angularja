<?php
/**
 * Created by PhpStorm.
 * User: alejandro.sosa
 * Date: 23/09/2015
 * Time: 16:13
 */

namespace Api\Modelos;

use Api\Modelo;

class Categorias extends Modelo
{

    private static $modelo = 'ja_categorias';
    public static $atributos = array();
    public static $setatributos = array();


    /**
     * Inicializaci�n Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aqu� realizar�amos la conexi�n a la BBDD con el m�todo que queramos
    }

    public function todasCategorias(){
        return $this->todos(self::$modelo);
    }

    public function unicaCategoria(){
        $this->where = $this->atributos;
        return $this->unico(self::$modelo);
    }

    public function crearCategoria(){
        return $this->insertar(self::$modelo, $this->atributos);
    }

    public function actualizarCategoria(){
        $this->where = $this->atributos;
        return $this->actualizar(self::$modelo, $this->setatributos);
    }

    public function eliminarCategoria(){
        $this->where = $this->atributos;
        return $this->eliminar(self::$modelo);
    }

}