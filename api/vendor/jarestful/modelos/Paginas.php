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
    private static $modelo_categorias = 'ja_categorias';
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

    public function todasPaginasCategoria(){
        $autor      = Usuarios::getInstance();
        $categoria  = Categorias::getInstance();

        $clave = [];

        $this->where = $this->atributos;
        foreach($this->unico(self::$modelo, true) as $c => $v){
            $clave[$c] = $v['id'];

            $paginas[] = array(
                'id'=> $v['id'],
                'titulo'=>$v['titulo'],
                'categoria'=>$categoria->getNombreCategoria($v['categoria']),
                'contenido'=>$v['contenido'],
                'imagen'=>empty($v['imagen']) ? '' : $v['imagen'],
                'leermas'=>$v['leermas'],
                'estado'=>$v['estado'],
                'tipo'=>$v['tipo'],
                'autor'=>$autor->getAutor($v['autor']),
                'padre'=>$v['padre'],
                'slug'=>$v['slug'],
                'meta_descripcion'=>$v['meta_descripcion'],
                'meta_palabras'=>$v['meta_palabras'],
                'meta_titulo'=>$v['meta_titulo'],
                'fecha_creado'=>$v['fecha_creado'],
                'fecha_modificado'=>$v['fecha_modificado'],
            );
        }

        array_multisort($clave, SORT_DESC, $paginas);

        return $paginas;
    }

    public function unicaPagina(){
        $this->where = $this->atributos;
        return $this->unico(self::$modelo);
    }

    public function crearPagina(){
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

    public function getCategorias(){
        $categorias = array();
        foreach($this->todos(self::$modelo_categorias) as $k => $v){
            $categorias[$v->id] = array(
                'id'=>$v->id,
                'clave'=>str_replace(" ", "-", strtolower($v->titulo)),
                'valor'=>ucfirst($v->titulo),
                'slug'=>$v->slug
            );
        }
        return $categorias;
    }

}