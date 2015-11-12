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

        $max    = Config::getMaxCaracteres();
        $limite = Config::getCantidadArticulosRecientes();

        if($existeJson){
            return $this->helper->leerJson(true);
        }else{
            $articulos =  JaPaginasQuery::create()
                ->addJoin('ja_paginas.categoria', 'ja_categorias.id', Criteria::INNER_JOIN)
                ->addJoin('ja_paginas.autor', 'ja_usuarios.id', Criteria::INNER_JOIN)
                ->addAsColumn('Autor', "concat(ja_usuarios.Nombre, ' ', ja_usuarios.Apellidos)")
                ->addAsColumn('Categoria', 'ja_categorias.Titulo')
                ->addAsColumn('Estado', "if(length(Estado) = 0, 'pendiente', Estado)")
                ->addAsColumn('Leermas', "f_cortartexto(Leermas, Contenido, ".$max.")")
                ->filterByCategoria(0, Criteria::NOT_EQUAL)
                ->filterByCategoria(1, Criteria::NOT_EQUAL)
                ->orderByFechaCreado(Criteria::DESC)
                ->limit($limite)
                ->find();

            $this->helper->crearJson($articulos->toArray());

            if(Config::$DEBUG){
                $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
            }
            return $this->helper->leerJson(true);
        }
    }

    public function articulosPorCategoria(){
        $_idcategoria = $this->atributos['categoria'];
        $_nombrecategoria = JaCategorias::getNombre($_idcategoria);
        $_nombrecategoria = $this->helper->convertirAMinuscula($_nombrecategoria,true);
        $clave = [];

        $this->helper->categoriaJson = 'articulos';
        $this->helper->nombreJson = 'articulos_categoria_'.$_nombrecategoria;
        $existeJson = $this->helper->existeJson('articulos_categoria_'.$_nombrecategoria);

        $max    = Config::getMaxCaracteres();
        $limite = Config::getCantidadArticulosCategoria();

        if($existeJson){
            return $this->helper->leerJson(true);
        }else{
            $articulos =  JaPaginasQuery::create()
                ->addJoin('ja_paginas.categoria', 'ja_categorias.id', Criteria::INNER_JOIN)
                ->addJoin('ja_paginas.autor', 'ja_usuarios.id', Criteria::INNER_JOIN)
                ->addAsColumn('Autor', "concat(ja_usuarios.Nombre, ' ', ja_usuarios.Apellidos)")
                ->addAsColumn('Categoria', 'ja_categorias.Titulo')
                ->addAsColumn('Estado', "if(length(Estado) = 0, 'pendiente', Estado)")
                ->addAsColumn('Leermas', "f_cortartexto(Leermas, Contenido, ".$max.")")
                ->filterByCategoria(0, Criteria::NOT_EQUAL)
                ->filterByCategoria(1, Criteria::NOT_EQUAL)
                ->filterByCategoria($_idcategoria, Criteria::EQUAL)
                ->orderByFechaCreado(Criteria::DESC)
                ->limit($limite)
                ->find();

            $this->helper->crearJson($articulos->toArray());

            if(Config::$DEBUG){
                $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
            }
            return $this->helper->leerJson(true);
        }
    }

}
