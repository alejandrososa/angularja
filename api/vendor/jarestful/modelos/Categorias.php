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



use Monolog\Logger;
use Monolog\Handler\StreamHandler;
//use Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;
use JaCategoriasQuery;
use JaCategorias;


class Categorias
{

    private static $modelo = 'ja_categorias';
    private $db;
    private $helper;
    public static $atributos = array();
    public static $setatributos = array();

    public function __construct() {
        $this->db = new JaCategoriasQuery();
        $this->helper = new Helper();


        $base = $this->helper->baseApi();
        $defaultLogger = new Logger('categorias');
        $defaultLogger->pushHandler(new StreamHandler($base. '/logs/api.log', Logger::WARNING));
        Propel::getServiceContainer()->setLogger('categorias', $defaultLogger);
    }


    /**
     * Inicializaci�n Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aqu� realizar�amos la conexi�n a la BBDD con el m�todo que queramos
    }

    public function demo(){

        $titulo = $this->atributos['titulo'];
        $id     = $this->atributos['id'];
        $slug   = $this->atributos['slug'];

        $categoria = JaCategoriasQuery::create()
            ->condition('id', 'ja_categorias.id = ?', $id)
            ->condition('titulo', 'ja_categorias.titulo like ?', $titulo.'%')
            ->condition('slug', 'ja_categorias.slug like ?', $slug.'%')
            ->combine(array('titulo', 'slug'), 'or', 'textos')
            ->where(array('id', 'textos'), 'or')
            ->find();

        return $categoria->toArray(); //array(Propel::getConnection()->getLastExecutedQuery());

        //return Propel::getServiceContainer()->getLogger();


        //Propel::log('uh-oh, something went wrong with ' . $df->getTitulo(), Logger::ERROR);

/*
        $con = Propel::getWriteConnection(JaCategoriasTableMap::DATABASE_NAME);
        $stmt = $con->prepare('SELECT * FROM my_obj WHERE name = :p1');
        $stmt->bindValue(':p1', 'foo');
        $stmt->execute();
        return $con->getLastExecutedQuery();
*/



        //$this->helper->log(__CLASS__ .'->'. __FUNCTION__, 'desde categorias', 'debug');
        //return 'hola';

    }

    public function buscadorCategorias(){
        $this->where = $this->atributos;
        return $this->buscar(self::$modelo);
    }

    public function todasCategorias(){
        $helper = new Helper();
        $helper->categoriaJson = 'categorias';
        $helper->nombreJson = 'categorias';
        $existeJson = $helper->existeJson('categorias');

        if($existeJson){
            return $helper->leerJson(true);
        }else{
            $categorias = $this->todos(self::$modelo);
            $helper->crearJson($categorias);
            return $helper->leerJson(true);
        }


    }

    public function unicaCategoria(){
        $this->where = $this->atributos;
        return $this->unico(self::$modelo);
    }

    public function crearCategoria(){
        return $this->insertar(self::$modelo, $this->atributos);
    }

    public function actualizarCategoria(){
        $this->where = $this->atributos;
        return $this->actualizar(self::$modelo, $this->setatributos);
    }

    public function eliminarCategoria(){
        $this->where = $this->atributos;
        return $this->eliminar(self::$modelo);
    }

    public function existeCategoria(){
        $this->where = $this->atributos;
        $datos = $this->unico(self::$modelo);
        $helper = new Helper();
        $resultado = array('existe'=>false);

        if($helper->contieneDatos($datos)){
            $resultado = array('existe'=>true, 'id'=>$datos['id'], 'titulo'=>$datos['titulo']);
        }
        return $resultado;
    }

    public function getNombreCategoria($id){
        if(empty($id)){
            return null;
        }
        $this->where = array('id'=>$id);
        $categoria = $this->unico(self::$modelo);
        return $categoria['titulo'];
    }

    public function getIdCategoria($nombre){
        if(empty($nombre)){
            return null;
        }
        $this->where = array('titulo'=>$nombre);
        $categoria = $this->unico(self::$modelo);
        return $categoria['id'];
    }

}