<?php
/**
 * Created by PhpStorm.
 * User: alejandro.sosa
 * Date: 23/09/2015
 * Time: 16:13
 */

namespace Api\Modelos;

use Api\Modelo;

class Menu extends Modelo
{

    private static $modelo = 'ja_menu';
    private static $vista = 'v_getmenudetallado';
    private static $procidimiento = 'sp_getMenuJerarquia';
    public static $atributos = array();
    public static $setatributos = array();


    /**
     * Inicialización Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aquí realizaríamos la conexión a la BBDD con el método que queramos
    }

    public function enlacesMenu(){
        $this->query = 'call '.self::$procidimiento.';';
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
}