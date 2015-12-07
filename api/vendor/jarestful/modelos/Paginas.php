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

class Paginas //extends Modelo
{

    private $db;
    private $helper;
    private static $modelo = 'ja_paginas';
    private static $modelo_categorias = 'ja_categorias';
    public static $atributos = array();
    public static $setatributos = array();

    public function __construct() {
        //$this->db = new JaCategoriasQuery();
        $this->helper = new Helper();


        $base = $this->helper->baseApi();
    }

    /**
     * Inicializaci�n Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aqu� realizar�amos la conexi�n a la BBDD con el m�todo que queramos
    }

    public function buscadorPaginas(){
        $this->where = $this->atributos;
        return $this->buscar(self::$modelo);
    }

    public function todasPaginas(){
        $helper = new Helper();
        $helper->categoriaJson = 'paginas';
        $helper->nombreJson = 'todasPaginas';
        $existeJson = $helper->existeJson('todasPaginas');

        if($existeJson){
            return $helper->leerJson(true);
        }else {
            $this->where = $this->atributos;
            $datos = $this->todos(self::$modelo);
            $helper->crearJson($datos);
            return $helper->leerJson(true);
        }
    }

    public function todasPaginasCategoria(){
        $autor      = Usuarios::getInstance();
        $categoria  = Categorias::getInstance();
        $_idcategoria = is_int($this->atributos['categoria']) ? $this->atributos['categoria'] : $categoria->getIdCategoria($this->atributos['categoria']);
        $_nombrecategoria = !is_int($this->atributos['categoria']) ? $this->atributos['categoria'] : $categoria->getNombreCategoria($this->atributos['categoria']);
        $clave = [];

        $helper = new Helper();
        $helper->categoriaJson = 'paginas';
        $helper->nombreJson = 'todasPaginasCategoria_'.$_nombrecategoria;
        $existeJson = $helper->existeJson('todasPaginasCategoria_'.$_nombrecategoria);

        if($existeJson){
            return $helper->leerJson(true);
        }else{
            $this->where = array('categoria'=> $_idcategoria);
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
            $helper->crearJson($paginas);
            return $helper->leerJson(true);
        }
    }

    public function detallePagina(){
        $pagina     = array('existe' => false);
        $autor      = Usuarios::getInstance();
        $categoria  = new Categorias(); //::getInstance();

        $categoria->atributos = array('slug'=>$this->atributos['categoria']);
        $existecategoria = $categoria->existeCategoria();


        if(!isset($existecategoria) || $existecategoria['existe'] == false){
            return $pagina;
        }

        $atributos = array(
            'categoria'=>$existecategoria['id'],
            'slug'=>$this->atributos['slug']
        );

        $this->where = $atributos;
        $v = $this->unico(self::$modelo);
        if(!empty($v)) {
            $pagina = array(
                'existe' => true,
                'id' => $v['id'],
                'titulo' => $v['titulo'],
                'categoria' => $categoria->getNombreCategoria($v['categoria']),
                'contenido' => $v['contenido'],
                'imagen' => empty($v['imagen']) ? '' : $v['imagen'],
                'leermas' => $v['leermas'],
                'estado' => $v['estado'],
                'tipo' => $v['tipo'],
                'autor' => $autor->getBiografiaAutor($v['autor']),
                'padre' => $v['padre'],
                'slug' => $v['slug'],
                'meta_descripcion' => $v['meta_descripcion'],
                'meta_palabras' => $v['meta_palabras'],
                'meta_titulo' => $v['meta_titulo'],
                'fecha_creado' => $v['fecha_creado'],
                'fecha_modificado' => $v['fecha_modificado'],
            );
        }

        return $pagina;
    }

    public function detallePaginaEstatica(){
        $pagina     = array('existe' => false);
        $autor      = Usuarios::getInstance();
        $categoria  = Categorias::getInstance();

        $atributos = array(
            'slug'=>$this->atributos['slug']
        );

        $this->where = $atributos;
        $v = $this->unico(self::$modelo);
        if(!empty($v)) {
            $pagina = array(
                'existe' => true,
                'id' => $v['id'],
                'titulo' => $v['titulo'],
                'categoria' => $categoria->getNombreCategoria($v['categoria']),
                'contenido' => $v['contenido'],
                'imagen' => empty($v['imagen']) ? '' : $v['imagen'],
                'leermas' => $v['leermas'],
                'estado' => $v['estado'],
                'tipo' => $v['tipo'],
                'autor' => $autor->getBiografiaAutor($v['autor']),
                'padre' => $v['padre'],
                'slug' => $v['slug'],
                'meta_descripcion' => $v['meta_descripcion'],
                'meta_palabras' => $v['meta_palabras'],
                'meta_titulo' => $v['meta_titulo'],
                'fecha_creado' => $v['fecha_creado'],
                'fecha_modificado' => $v['fecha_modificado'],
                'configuracion' => $v['configuracion']
            );
        }

        return $pagina;
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

        $helper = new Helper();
        $helper->categoriaJson = 'paginas';
        $helper->nombreJson = 'categorias';
        $existeJson = $helper->existeJson('categorias');

        if($existeJson){
            return $helper->leerJson(true);
        }else{
            foreach($this->todos(self::$modelo_categorias) as $k => $v){
                $categorias[$v->id] = array(
                    'id'=>$v->id,
                    'clave'=>str_replace(" ", "-", strtolower($v->titulo)),
                    'valor'=>ucfirst($v->titulo),
                    'slug'=>$v->slug
                );
            }
            $helper->crearJson($categorias);
            return $helper->leerJson(true);
        }
    }

}