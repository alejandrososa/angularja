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
     * Inicializaci�n Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aqu� realizar�amos la conexi�n a la BBDD con el m�todo que queramos
    }

    public function enlacesMenu(){
        $this->query = 'call '.self::$procidimiento.';';
        $array = [];

        foreach($this->seleccion() as $key => $enlace){

            //1 = nivel base
            if($enlace['nivel'] == 1) {

                $enlaces[] = array(
                    'id' => $enlace['id'],
                    'nombre' => $enlace['nombre'],
                    'enlace' => $enlace['enlace'],
                    'clase' => $enlace['clase'],
                    'tipp' => $enlace['tipo_enlace'],
                    'target' => $enlace['target'],
                    'nivel' => $enlace['nivel'],
                    'items' => $this->getItem($enlace['hijos'])
                );
            }

        }

        return $enlaces;
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
}