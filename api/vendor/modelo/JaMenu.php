<?php

use Base\JaMenu as BaseJaMenu;

use Map\JaMenuTableMap;
use Monolog\Logger;
use Propel\Runtime\Propel;
use Api\Helper;
use App\Config;

/**
 * Skeleton subclass for representing a row from the 'ja_menu' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class JaMenu extends BaseJaMenu
{
    public $atributos = array();
    public $setatributos = array();
    private $tabla = 'ja_categorias';
    private $debug;
    private $helper;
    private static $vista = 'v_getmenudetallado';
    private static $procidimiento = 'sp_getMenuJerarquia';
    private $_categorias = array(
        'principal' =>1,
        'secundario'=>2,
        'superior'  =>3,
        'inferior'  =>4,
        'piepagina' =>5,
        'sinasignar'=>6
    );
    private $categoriaJson;
    //public static $categoria = 'null';

    public function __construct()
    {
        $this->helper = new Helper();
        $this->debug = Propel::getWriteConnection(\Map\JaMenuTableMap::DATABASE_NAME);
        $this->debug->setLogMethods(array(
            'exec',
            'query',
            'execute', // these first three are the default
            'beginTransaction',
            'commit',
            'rollBack',
            'bindValue'
        ));
        $this->debug->useDebug(Config::$DEBUG_SQL);
    }

    private function getCategorias(){
        $categorias = array();
        $cats1 = array('sinasignar','piepagina');
        $cats2 = array('sin asignar','pie de pagina');

        foreach($this->_categorias as $k => $v){
            $categorias[$v] = array(
                'id'=>$v,
                'clave'=>$k,
                'valor'=>ucfirst(strtolower(str_replace($cats1,$cats2,$k)))
            );
        }
        return $categorias;
    }

    public function enlacesMenu($tipo){
        $categoria = array_key_exists($tipo, $this->_categorias) ? $this->_categorias[$tipo] : 0;
        $categorias = $this->getCategorias();

        $this->helper = new Helper();
        $this->helper->categoriaJson = 'menu';
        $this->helper->nombreJson = $tipo;
        $existeJson = $this->helper->existeJson($tipo);

        if($existeJson){
            return $this->helper->leerJson(true);
        }else{
            $query = 'call sp_getMenuJerarquia('.$categoria.');';
            $con = Propel::getReadConnection(JaMenuTableMap::DATABASE_NAME);
            $stmt = $con->prepare($query);
            $menu = $stmt->execute();

            /*$formatter = new \PropelObjectFormatter();
            $formatter->setClass('JaMenu');
            $menu = $formatter->format($stmt);
*/
            JaMenuQuery::

            print_r($menu); die();

            foreach($menu as $key => $enlace){
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

            print_r($enlaces); die();

            $this->helper->crearJson($enlaces);
            return $this->helper->leerJson(true);
        }

    }
}
