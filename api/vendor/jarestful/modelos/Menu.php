<?php
/**
 * Created by PhpStorm.
 * User: alejandro.sosa
 * Date: 23/09/2015
 * Time: 16:13
 */

namespace Api\Modelos;

use Api\Helper;
use Api\Modelo;


class Menu
{

    private static $modelo = 'ja_menu';
    private static $vista = 'v_getmenudetallado';
    private static $procidimiento = 'sp_getMenuJerarquia';
    private $categorias = array(
        'principal' =>1,
        'secundario'=>2,
        'superior'  =>3,
        'inferior'  =>4,
        'piepagina' =>5,
        'sinasignar'=>6
    );
    private $categoriaJson;
    public static $atributos = array();
    public static $setatributos = array();
    public static $categoria = 'null';



        /**
     * Inicializaci�n Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aqu� realizar�amos la conexi�n a la BBDD con el m�todo que queramos
    }

    public function buscadorEnlaces($tipo){
        $categoria = array_key_exists($tipo, $this->categorias) ? $this->categorias[$tipo] : 0;
        $categorias = $this->getCategorias();

        $this->where = $this->atributos + array('categoria'=>$categoria);
        $menu = $this->buscar(self::$vista);

        foreach($menu as $key => $enlace){

            $hijos = '';
            $hijos = !empty($enlace['hijos']) ? count(explode(",", $enlace['hijos'])) : '';

            $enlaces[] = array(
                'id' => $enlace['id'],
                'idcategoria' => $enlace['categoria'],
                'clavecategoria' => $categorias[$enlace['categoria']]['clave'],
                'categoria' => $categorias[$enlace['categoria']]['valor'],
                'nombre' => $enlace['nombre'],
                'enlace' => $enlace['enlace'],
                'clase' => $enlace['clase'],
                'padre' => $enlace['padre'],
                //'tipo' => $enlace['tipo_enlace'],
                'target' => $enlace['target'],
                //'nivel' => $enlace['nivel'],
                'hijos' => $hijos,
                //'items' => $this->getItem($enlace['hijos'])
            );

        }

        return $enlaces;
    }

    public function buscadorEnlacesPorCategoria($tipo){
        $categoria = array_key_exists($tipo, $this->categorias) ? $this->categorias[$tipo] : 0;
        $categorias = $this->getCategorias();

        $this->where = array('categoria'=>$categoria);
        $menu = $this->buscar(self::$vista);

        foreach($menu as $key => $enlace){

            $hijos = '';
            $hijos = !empty($enlace['hijos']) ? count(explode(",", $enlace['hijos'])) : '';

            $enlaces[] = array(
                'id' => $enlace['id'],
                'idcategoria' => $enlace['categoria'],
                'clavecategoria' => $categorias[$enlace['categoria']]['clave'],
                'categoria' => $categorias[$enlace['categoria']]['valor'],
                'nombre' => $enlace['nombre'],
                'enlace' => $enlace['enlace'],
                'clase' => $enlace['clase'],
                'padre' => $enlace['padre'],
                'target' => $enlace['target'],
                'hijos' => $hijos,
            );

        }

        return $enlaces;
    }

    public function getCategorias(){
        $categorias = array();
        $cats1 = array('sinasignar','piepagina');
        $cats2 = array('sin asignar','pie de pagina');

        foreach($this->categorias as $k => $v){
            $categorias[$v] = array(
                'id'=>$v,
                'clave'=>$k,
                'valor'=>ucfirst(strtolower(str_replace($cats1,$cats2,$k)))
            );
        }
        return $categorias;
    }

    public function getIdCategoria($nombre){
        return !empty($nombre) ? $this->categorias[$nombre] : 0;
    }

    public function enlacesMenu($tipo){
        $categoria = array_key_exists($tipo, $this->categorias) ? $this->categorias[$tipo] : 0;
        $categorias = $this->getCategorias();

        $helper = new Helper();
        $helper->categoriaJson = 'menu';
        $helper->nombreJson = $tipo;
        $existeJson = $helper->existeJson($tipo);

        if($existeJson){
            return $helper->leerJson(true);
        }else{
            $this->query = 'call sp_getMenuJerarquia('.$categoria.');';
            foreach($this->seleccion() as $key => $enlace){
                //1 = nivel base
                if($enlace['nivel'] == 1) {
                    $enlaces[] = array(
                        'id' => $enlace['id'],
                        'idcategoria' => $enlace['categoria'],
                        'clavecategoria' => $categorias[$enlace['categoria']]['clave'],
                        'categoria' => $categorias[$enlace['categoria']]['valor'],
                        'nombre' => $enlace['nombre'],
                        'enlace' => $enlace['enlace'],
                        'clase' => $enlace['clase'],
                        'tipo' => $enlace['tipo_enlace'],
                        'target' => $enlace['target'],
                        'nivel' => $enlace['nivel'],
                        'hijos' => (string)count($this->getItem($enlace['hijos'])),
                        'items' => $this->getItem($enlace['hijos'])
                    );
                }
            }

            $helper->crearJson($enlaces);
            return $helper->leerJson(true);
        }

    }

    public function todosEnlacesMenu($tipo){
        $categoria = array_key_exists($tipo, $this->categorias) ? $this->categorias[$tipo] : 0;
        $categorias = $this->getCategorias();
        //$menu = array();
        //$this->query = 'call sp_getMenuJerarquia('.$categoria.');';

        $this->where = array('categoria'=>$categoria);
        $menu = $this->unico(self::$vista, true);

        foreach($menu as $key => $enlace){

            $hijos = '';
            $hijos = !empty($enlace['hijos']) ? count(explode(",", $enlace['hijos'])) : '';

            $enlaces[] = array(
                'id' => $enlace['id'],
                'idcategoria' => $enlace['categoria'],
                'clavecategoria' => $categorias[$enlace['categoria']]['clave'],
                'categoria' => $categorias[$enlace['categoria']]['valor'],
                'nombre' => $enlace['nombre'],
                'enlace' => $enlace['enlace'],
                'clase' => $enlace['clase'],
                'padre' => $enlace['padre'],
                //'tipo' => $enlace['tipo_enlace'],
                'target' => $enlace['target'],
                //'nivel' => $enlace['nivel'],
                'hijos' => $hijos,
                //'items' => $this->getItem($enlace['hijos'])
            );

        }

        return $enlaces;
    }

    public function todosEnlaces(){
        $categorias = $this->getCategorias();
        $menu = $this->todos(self::$vista);

        foreach($menu as $key => $enlace){

            $hijos = '';
            $hijos = !empty($enlace->hijos) ? count(explode(",", $enlace->hijos)) : '';

            $enlaces[] = array(
                'id' => $enlace->id,
                'idcategoria' => $enlace->categoria,
                'clavecategoria' => $categorias[$enlace->categoria]['clave'],
                'categoria' => $categorias[$enlace->categoria]['valor'],
                'nombre' => $enlace->nombre,
                'enlace' => $enlace->enlace,
                'clase' => $enlace->clase,
                'padre' => $enlace->padre,
                'target' => $enlace->target,
                'hijos' => $hijos,
            );

        }

        return $enlaces;
    }

    private function procesar($array){
    }


    private function getItem($id) {
        //$this->where = array('id'=>$id);
        if(empty($id)){
            return null;
        }

        $this->query = 'select * from '.self::$vista.' where id in('.$id.')';
        return $this->seleccion();
    }

    public function getMenuDetallado() {
        $this->where = $this->atributos;
        if(empty($this->atributos['id'])){
            $menu = $this->todos(self::$vista);
        }else{
            $menu = $this->unico(self::$vista);
        }
        return $menu;
    }

    public function tieneHijosItems($id){
        $resultado = false;
        $menu = array();
        if(!empty($id)){
            $menu = self::getMenuDetallado($id);
            foreach ($menu as $m){
                $resultado = isset($m['hijos']) && $m['hijos'] != '' ? true : false;
            }
        }
        return $resultado;
    }

    public function unicoEnlace(){
        $categorias = $this->getCategorias();
        $this->where = $this->atributos;
        $datos = $this->unico(self::$modelo, true);
        $enlaces = array();

        foreach($datos as $key => $enlace){

            $hijos = '';
            $hijos = !empty($enlace['hijos']) ? count(explode(",", $enlace['hijos'])) : '';

            $enlaces = array(
                'id' => $enlace['id'],
                'idcategoria' => $enlace['categoria'],
                'clavecategoria' => $categorias[$enlace['categoria']]['clave'],
                'categoria' => $categorias[$enlace['categoria']]['valor'],
                'nombre' => $enlace['nombre'],
                'enlace' => $enlace['enlace'],
                'clase' => $enlace['clase'],
                'padre' => $enlace['padre'],
                'target' => $enlace['target'],
                'hijos' => $hijos,
            );
        }

        return $enlaces;
    }

    public function crearEnlace(){
        return $this->insertar(self::$modelo, $this->atributos);
    }

    public function actualizarEnlace(){
        $this->where = $this->atributos;
        return $this->actualizar(self::$modelo, $this->setatributos);
    }

    public function eliminarEnlace(){
        $this->where = $this->atributos;
        return $this->eliminar(self::$modelo);
    }
}