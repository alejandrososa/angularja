<?php
/**
 * Created by PhpStorm.
 * User: alejandro.sosa
 * Date: 23/09/2015
 * Time: 16:13
 */

namespace Api\Modelos;

use Api\Modelo;
use Token\JWT\Builder;
use Token\JWT\ValidationData;
use Api\Helper;
use \stdClass;

class Usuarios extends Modelo
{

    private static $modelo = 'ja_usuarios';
    private static $vista = 'v_getusuarios';
    private static $vista_perfil = 'v_getperfilusuario';
    public static $atributos = array();
    public static $setatributos = array();
    private static $ruta = 'assets/archivos/usuarios/';
    private static $dominio = 'http://ja.dev';


    /**
     * Inicialización Base de datos
     * @abstract Modelo
     */
    protected static function initModelo() {
        // Aquí realizaríamos la conexión a la BBDD con el método que queramos
    }

    public function buscadorUsuarios(){
        $this->where = $this->atributos;
        $usuarios = $this->buscar(self::$vista);
        //unset($usuarios['clave']);

        return $usuarios;
    }

    public function todosUsuarios(){
        return $this->todos(self::$vista);
    }

    public function unicoUsuario(){
        $this->where = $this->atributos;
        $usuario = $this->unico(self::$vista);
        unset($usuario['clave']);
        return $usuario;
    }

    public function crearUsuario(){
        $resultado = $this->insertar(self::$modelo, $this->atributos);
        return $resultado;
    }

    public function actualizarUsuario(){
        $this->where = $this->atributos;
        $resultado = $this->actualizar(self::$modelo, $this->setatributos);
        return $resultado;
    }

    public function eliminarUsuario(){
        $this->where = $this->atributos;
        $resultado = $this->eliminar(self::$modelo);
        return $resultado;
    }



    public function existeUsuario(){
        $this->where = $this->atributos;
        $usuario = $this->unico(self::$vista);
        return empty($usuario) ? true : false;
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
        $this->where = array('usuario'=>$usuario);
        $persona = $this->unico(self::$modelo);

        //valido clave
        if(!empty($persona)){
            $helper = new Helper();
            $valido = $helper->validarEncriptacion($clave, $persona['clave']);
        }

        if($valido){
            $credencialusuario = new \stdClass();
            $credencialusuario->usuario = $persona['usuario'];
            $credencialusuario->rol = $this->getPerfilUsuario($persona['id'], true);
            $usuarioactual = array('id'=>$persona['id'],'nombre'=>$persona['nombre'].' '.$persona['apellidos']);
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

        $perfiles = array();
        $_perfiles = '';
        $i = 0;
        $this->query = 'select nombre from '.self::$vista_perfil.' where id = '.$id;
        foreach($this->seleccion() as $key => $perfil){
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

    private function getToken($usuario){
        $token = '';
        $token = (new Builder())->setIssuer(self::$dominio) // Configures the issuer (iss claim)
        ->setAudience(self::$dominio) // Configures the audience (aud claim)
        ->setId('jajwt', true) // Configures the id (jti claim), replicating as a header item
        ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
        ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
        ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
        ->set('sub', 1) // Configures a new claim, called "uid"
        ->set('user', $usuario->usuario)// Configures a new claim, called "uid"
        ->set('roles', $usuario->rol)// Configures a new claim, called "uid"
        ->getToken(); // Retrieves the generated token

        return (string)$token;
    }

}