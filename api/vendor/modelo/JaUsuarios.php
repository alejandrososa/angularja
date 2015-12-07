<?php

use Base\JaUsuarios as BaseJaUsuarios;

use Monolog\Logger;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Api\Helper;
use App\Config;

/**
 * Skeleton subclass for representing a row from the 'ja_usuarios' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class JaUsuarios extends BaseJaUsuarios
{
    private static $modelo = 'ja_usuarios';
    private static $vista = 'v_getusuarios';
    private static $vista_perfil = 'v_getperfilusuario';
    public static $atributos = array();
    public static $setatributos = array();
    private static $ruta = 'assets/archivos/usuarios/';
    private static $dominio = 'http://ja.dev';

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

    private function getToken($credencial){
        $config = new Config();
        $dominio = $config->getGeneral();
        $token = '';
        $token = (new Builder())->setIssuer($dominio['dominio']) // Configures the issuer (iss claim)
        ->setAudience($dominio['dominio']) // Configures the audience (aud claim)
        ->setId('jajwt', true) // Configures the id (jti claim), replicating as a header item
        ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
        ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
        ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
        ->set('sub', 1) // Configures a new claim, called "uid"
        ->set('user', $credencial->usuario)// Configures a new claim, called "uid"
        ->set('roles', $credencial->rol)// Configures a new claim, called "uid"
        ->getToken(); // Retrieves the generated token

        return (string)$token;
    }

    public function existeUsuario(){
        $this->where = $this->atributos;
        $usuario = $this->unico(self::$vista);
        return empty($usuario) ? true : false;

        $pagina = array('existe' => false);
        $tipo   = Config::$TIPO_PORTADA;

        $portada =  JaUsuarios::create()
            ->select('Id')
            ->addAsColumn('Existe', "if(ja_paginas.id > 0, 'true', false)")
            ->filterByCategoria(0, Criteria::EQUAL)
            ->filterByTipo($tipo, Criteria::EQUAL)
            ->find();

        if(Config::$DEBUG){
            $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
        }

        return $portada->isEmpty() == false ? true  : false;

    }

    public function getAutor($id){
        if(empty($id)){
            return null;
        }
        $this->where = array('id'=>$id);
        $usuario = $this->unico(self::$vista);
        return $usuario['nombre'].' '.$usuario['apellidos'];
    }

    public function getBiografiaAutor($id){
        if(empty($id)){
            return null;
        }
        $this->where = array('id'=>$id);
        $usuario = $this->unico(self::$vista);
        $bio = array(
            'nombre'=> $usuario['nombre'].' '.$usuario['apellidos'],
            'autor'=> $usuario['nombre'].' '.$usuario['apellidos'],
            'biografia'=> $usuario['biografia'],
            'imagen'=> $usuario['imagen'],
            'redessociales'=> $usuario['redessociales']
        );
        return $bio;
    }

    public function verificaCredenciales($credencial){
        $usuario    = isset($credencial->usuario) ? $credencial->usuario : '';
        $clave      = isset($credencial->clave) ? $credencial->clave : '';
        $valido     = false;

        //busco el usuario en bd
        $_usuario =  JaUsuariosQuery::create()
            ->filterByUsuario($usuario, Criteria::EQUAL)
            ->findOne();

        if(Config::$DEBUG){
            $this->log(__FUNCTION__ .' | '.$this->debug->getLastExecutedQuery(), Logger::DEBUG);
        }

        //valido clave
        if(!empty($_usuario)){
            $helper = new Helper();
            $valido = $helper->validarEncriptacion($clave, $_usuario->getClave());
        }

        if($valido){
            $credencialusuario = new \stdClass();
            $credencialusuario->usuario = $_usuario->getUsuario();
            $credencialusuario->rol = $this->getPerfilUsuario($_usuario->getId(), true);
            $usuarioactual = array('id'=>$_usuario->getId(),'nombre'=>$_usuario->getNombre().' '.$_usuario->getApellidos());
            $resultado = array('usuario'=>$usuarioactual, 'estado'=>true, 'token'=> $this->getToken($credencialusuario));
        }else{
            $resultado = array('estado'=>false);
        }
        return $resultado;
    }

    public function getPermisoUsuario($idusuario = 0, $idrecurso = 0){
        if($idusuario <= 0 && $idrecurso <= 0){
            return null;
        }

        $sql = 'call appja.sp_getPermisosUsuario('.$idusuario.', '.$idrecurso.');';
        $this->query = $sql;
        return $this->seleccion();
    }

    public function getPerfilUsuario($id = 0, $string = false){
        if($id <= 0){
            return null;
        }

        $_misperfiles = new JaAclUsuariosPerfiles();
        $perfiles = array();
        $_perfiles = '';
        $i = 0;

        print_r($_misperfiles->getPerfilesUsuario($id)); die();

        foreach($_misperfiles->getPerfilesUsuario($id) as $key => $perfil){
            $perfiles[] = $perfil['nombre'];
            $_perfiles .= $i != 0 ? ', ' . $perfil['nombre'] : $perfil['nombre'];
            $i++;
        }

        if($string === true){
            $resultado = $_perfiles;
        }else{
            $resultado = $perfiles;
        }
        return $resultado;
    }


}
