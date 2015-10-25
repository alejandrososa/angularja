<?php
/**
 * Created by PhpStorm.
 * User: alejandro.sosa
 * Date: 23/09/2015
 * Time: 16:13
 */

namespace Api\Modelos;

use Api\Modelo;
use Api\Helper;

class Categorias extends Modelo
{

    private static $modelo = 'ja_categorias';
    public static $atributos = array();
    public static $setatributos = array();


    /**
     * Inicialización Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aquí realizaríamos la conexión a la BBDD con el método que queramos
    }

    public function buscadorCategorias(){
        $this->where = $this->atributos;
        return $this->buscar(self::$modelo);
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

    public function existeCategoria(){
        $this->where = $this->atributos;
        $datos = $this->unico(self::$modelo);
        $helper = new Helper();
        $resultado = array('existe'=>false);

        if($helper->contieneDatos($datos)){
            $resultado = array('existe'=>true, 'id'=>$datos['id'], 'titulo'=>$datos['titulo']);
        }
        return $resultado;
    }

    public function getNombreCategoria($id){
        if(empty($id)){
            return null;
        }
        $this->where = array('id'=>$id);
        $categoria = $this->unico(self::$modelo);
        return $categoria['titulo'];
    }

}