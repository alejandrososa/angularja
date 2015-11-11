<?php

use Base\JaCategorias as BaseJaCategorias;

use Monolog\Logger;
use Propel\Runtime\Propel;
use Api\Helper;
use App\Config;


class JaCategorias extends BaseJaCategorias
{
    public $atributos = array();
    public $setatributos = array();
    private $tabla = 'ja_categorias';
    private $debug;
    private $helper;

    public function __construct()
    {
        $this->helper = new Helper();
        $this->debug = Propel::getWriteConnection(\Map\JaCategoriasTableMap::DATABASE_NAME);
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

    public function existe(){
        $categoria = $this->atributos['categoria'];

        $datos = JaCategoriasQuery::create()
            ->filterByTitulo($categoria)
            ->findOne();

        $helper = new Helper();
        $resultado = array('existe'=>false);

        if($helper->contieneDatos($datos)){
            $resultado = array('existe'=>true, 'id'=>$datos['id'], 'titulo'=>$datos['titulo']);
        }
        return $datos;
    }

    public function buscador(){
        $titulo = $this->atributos['titulo'];
        $id     = $this->atributos['id'];
        $slug   = $this->atributos['slug'];

        $categoria = JaCategoriasQuery::create()
            ->condition('id', $this->tabla . '.id = ?', $id)
            ->condition('titulo', $this->tabla . '.titulo like ?', $titulo.'%')
            ->condition('slug', $this->tabla . '.slug like ?', $slug.'%')
            ->combine(array('titulo', 'slug'), 'or', 'textos')
            ->where(array('id', 'textos'), 'or')
            ->find();

        if(Config::$DEBUG){
            $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
        }

        return $categoria->toArray();
    }

    public function todas(){
        $this->helper->categoriaJson = 'categorias';
        $this->helper->nombreJson = 'categorias';
        $existeJson = $this->helper->existeJson('categorias');

        if($existeJson){
            return $this->helper->leerJson(true);
        }else{
            $categorias = JaCategoriasQuery::create()->find();
            $this->helper->crearJson($categorias->toArray());

            if(Config::$DEBUG){
                $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
            }

            return $categorias->toArray();
            return $this->helper->leerJson(true);
        }
    }

}