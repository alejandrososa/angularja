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
    public $objecto;
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

    public function existePortada(){
        $pagina = array('existe' => false);
        $tipo   = Config::$TIPO_PORTADA;

        $portada =  JaPaginasQuery::create()
            ->select('Id')
            ->addAsColumn('Existe', "if(ja_paginas.id > 0, 'true', false)")
            ->filterByCategoria(0, Criteria::EQUAL)
            ->filterByTipo($tipo, Criteria::EQUAL)
            ->find();

        if(Config::$DEBUG){
            $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
        }

        return $portada->isEmpty() == false ? $this->helper->convertirKeysMinuscula($portada->getFirst())  : $pagina;
    }

    public function guardarPortada(){
        $tipo   = Config::$TIPO_PORTADA;
        $objeto = $this->objecto->pagina;

        $titulo         = isset($objeto->titulo) ? $objeto->titulo : '';
        $contenido      = isset($objeto->contenido) ? $objeto->contenido : '';
        $autor          = isset($objeto->autor) ? $objeto->autor : '';
        $configuracion  = isset($objeto->configuracion) ? $this->helper->convertirObjectAString($objeto->configuracion) : '';
        $seotitulo      = isset($objeto->metatitulo) ? $objeto->metatitulo : '';
        $seodescripcion = isset($objeto->metadescripcion) ? $objeto->metadescripcion : '';
        $seopalabras    = isset($objeto->metapalabras) ? $this->helper->convertirArrayAString($objeto->metapalabras) : '';

        //buscar portada
        $portada =  JaPaginasQuery::create()
            ->filterByCategoria(0, Criteria::EQUAL)
            ->findOneByTipo($tipo);

        //si no existe crea el objecto $portada
        //si existe actualiza el objecto $portada
        if(empty($portada)){
            $portada = new JaPaginas();
            $portada->setFechaCreado($this->helper->fechaActual());
        }

        $portada->setTitulo($titulo);
        $portada->setContenido($contenido);
        $portada->setAutor($autor);
        $portada->setCategoria(0);
        $portada->setTipo($tipo);
        $portada->setConfiguracion($configuracion);
        $portada->setMetaTitulo($seotitulo);
        $portada->setMetaDescripcion($seodescripcion);
        $portada->setMetaPalabras($seopalabras);
        $portada->setFechaModificado($this->helper->fechaActual());
        $resultado = $portada->save();

        //eliminar json existente
        $this->helper->categoriaJson = 'portada';
        $this->helper->eliminarJson('ultimosarticulos');
        $this->helper->eliminarJson('paginainicio');
        $this->obtenerPortada();


        if(Config::$DEBUG){
            $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
        }

        return $resultado != 0 ? true : false;
    }

    public function obtenerPortada(){
        $tipo   = Config::$TIPO_PORTADA;
        $this->helper->categoriaJson = 'portada';
        $this->helper->nombreJson = 'paginainicio';
        $existeJson = $this->helper->existeJson('paginainicio');


        if($existeJson){
            return $this->helper->leerJson(true);
        }else{
            $portada =  JaPaginasQuery::create()
                ->filterByCategoria(0, Criteria::EQUAL)
                ->addAsColumn('Existe', "if(ja_paginas.id > 0, 'true', false)")
                ->filterByCategoria(0, Criteria::EQUAL)
                ->filterByTipo($tipo, Criteria::EQUAL)
                ->findOne();

            $this->helper->crearJson($portada->toArray(), false);

            if(Config::$DEBUG){
                $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
            }

            return $this->helper->leerJson(true);
        }
    }


    public function existeContacto(){
        $pagina = array('existe' => false);
        $tipo   = Config::$TIPO_CONTACTO;

        $contacto =  JaPaginasQuery::create()
            ->select('Id')
            ->addAsColumn('Existe', "if(ja_paginas.id > 0, 'true', false)")
            ->filterByCategoria(0, Criteria::EQUAL)
            ->filterByTipo($tipo, Criteria::EQUAL)
            ->find();

        if(Config::$DEBUG){
            $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
        }

        return $contacto->isEmpty() == false ? $this->helper->convertirKeysMinuscula($contacto->getFirst())  : $pagina;
    }


    public function ultimosArticulos(){
        $this->helper->categoriaJson = 'portada';
        $this->helper->nombreJson = 'ultimosarticulos';
        $existeJson = $this->helper->existeJson('ultimosarticulos');

        $max    = Config::getMaxCaracteres();
        $limite = !empty($this->atributos) ? $this->atributos : Config::getCantidadArticulosRecientes();

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
        $_cantidad = $this->atributos['cantidad'];
        $_nombrecategoria = JaCategorias::getNombre($_idcategoria);
        $_nombrecategoria = $this->helper->convertirAMinuscula($_nombrecategoria,true);
        $clave = [];

        $this->helper->categoriaJson = 'articulos';
        $this->helper->nombreJson = 'articulos_categoria_'.$_nombrecategoria;
        $existeJson = $this->helper->existeJson('articulos_categoria_'.$_nombrecategoria);

        $max    = Config::getMaxCaracteres();
        $limite = isset($_cantidad) && is_int($_cantidad) ? $_cantidad : Config::getCantidadArticulosCategoria();

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

    public function detalleArticulo(){
        $_idcategoria = 0;
        $_slugcategoria = $this->atributos['categoria'];
        $_slugarticulo = $this->atributos['slug'];
        $pagina = array('existe' => false);

        $obj = new JaCategorias();
        $obj->atributos = array('slug'=> $_slugcategoria);
        $resultado = $obj->existe();
        if(!isset($resultado) && $resultado['existe'] != true){
            return $pagina;
        }

        //id categoria
        $_idcategoria = $resultado['id'];

        $articulos =  JaPaginasQuery::create()
            ->addJoin('ja_paginas.categoria', 'ja_categorias.id', Criteria::INNER_JOIN)
            ->addJoin('ja_paginas.autor', 'ja_usuarios.id', Criteria::INNER_JOIN)
            ->addJoin('ja_paginas.autor', 'v_getusuarios.id', Criteria::INNER_JOIN)
            ->addAsColumn('Autor', "concat(ja_usuarios.Nombre, ' ', ja_usuarios.Apellidos)")
            ->addAsColumn('autorimagen', "v_getusuarios.Imagen")
            ->addAsColumn('autorbiografia', "v_getusuarios.Biografia")
            ->addAsColumn('autorredessociales', "v_getusuarios.Redessociales")
            ->addAsColumn('Categoria', 'ja_categorias.Titulo')
            ->addAsColumn('Estado', "if(length(Estado) = 0, 'pendiente', Estado)")
            ->addAsColumn('Existe', "if(ja_paginas.id > 0, 'true', false)")
            ->filterByCategoria(0, Criteria::NOT_EQUAL)
            ->filterByCategoria(1, Criteria::NOT_EQUAL)
            ->filterByCategoria($_idcategoria, Criteria::EQUAL)
            ->filterBySlug($_slugarticulo)
            ->findOne();

        if(Config::$DEBUG){
            $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
        }

        return !empty($articulos) ? $articulos->toArray() : $pagina;
    }

}
