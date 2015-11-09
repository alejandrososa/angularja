<?php

use Base\JaPaginas as BaseJaPaginas;

use Monolog\Logger;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Api\Helper;
use App\Config;
/**
 * Skeleton subclass for representing a row from the 'ja_paginas' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class JaPaginas extends BaseJaPaginas
{
    public $atributos = array();
    public $setatributos = array();
    private $tabla = 'ja_paginas';
    private $debug;
    private $helper;

    public function __construct()
    {
        $this->helper = new Helper();
        $this->debug = Propel::getWriteConnection(\Map\JaPaginasTableMap::DATABASE_NAME);
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

    public function buscador(){
        $titulo = $this->atributos['titulo'];
        $id     = $this->atributos['id'];
        $slug   = $this->atributos['slug'];

        $categoria = JaPaginasQuery::create()
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

    public function ultimosArticulos(){
        $this->helper->categoriaJson = 'portada';
        $this->helper->nombreJson = 'ultimosarticulos';
        $existeJson = $this->helper->existeJson('ultimosarticulos');

        if($existeJson){
            return $this->helper->leerJson(true);
        }else{

            //JaCategoriasQuery::create('Categorias');

            $articulos =  JaPaginasQuery::create()
                ->addJoin('ja_paginas.categoria', 'ja_categorias.id', Criteria::INNER_JOIN)
                ->withColumn('ja_categorias.id', 'categoria')
                //->recientes()
                //->setIgnoreCase(true)
                ->find()
                ;



            $this->helper->crearJson($articulos->toArray());

            if(Config::$DEBUG){
                $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
            }

            return $articulos->toArray();
            return $this->helper->leerJson(true);
        }
    }

}
