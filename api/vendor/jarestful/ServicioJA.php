<?php

namespace Api;


	use Api\Demo;
	use Api\RestJA;
	use Api\Modelo;
	use Api\Sesion;
	use Api\Helper;
	use Api\Entorno;
    use App\Config;

    use Api\Modelos\Usuarios;
    use Api\Modelos\Categorias;
    use Api\Modelos\Paginas;
    use Api\Modelos\Menu;

    use JaCategorias;
    use JaPaginas;
    use JaUsuarios;
    use JaMenu;

    use Api\RedesSociales;

	class ServicioJA { //REST
        public $data      = "";
        private $sesion;
        private $rest;
        private $db       = NULL;
        private $mysqli   = NULL;
        private $helper;
        private $demo;
        private $modelUsuarios;
        private $modelCategorias = NULL;
        private $modelPaginas = NULL;
        private $modelMenu = NULL;
        private $mensajeError;

        /**
         * Inicializacion objetos
         */
        function __construct(){
            $this->rest      = new RestJA();
            $this->sesion    = new Sesion();
            $this->helper    = new Helper();
            //$this->demo      = new Demo();
            $this->modelUsuarios = new JaUsuarios(); //Usuarios::getInstance();
            $this->modelCategorias = new JaCategorias(); //Categorias::getInstance();
            $this->modelPaginas = new JaPaginas(); //Paginas::getInstance();
            $this->modelMenu = new JaMenu(); //Menu::getInstance();
            $this->mensajeError = Config::getMensajesErrores();
        }

        /**
         * METODO PRINCIPAL
         * @return response
         */
        public function iniciarServicio(){
            $req = isset($_REQUEST['x']) ? $_REQUEST['x'] : '';
            $func = strtolower(trim(str_replace("/","",$req)));
            if((int)method_exists($this,$func) > 0)
                $this->$func();
            else
                $this->rest->response($this->mensajeError,404);
        }



        /**
         * Login
         * @param string correo, clave
         * @return response json
         */
        private function credenciales(){
            if($this->rest->get_request_method() == "POST"){
                $credencial= json_decode(file_get_contents('php://input'));
                $resultado = $this->modelUsuarios->verificaCredenciales($credencial);

                if($resultado['estado']){
                    $this->rest->_token = $resultado['token'];
                    $this->rest->response($this->helper->json(array('usuario'=> $resultado['usuario'], 'tokenja'=> $resultado['token'], 'msg'=>'autorizado')), 200);
                }
                $this->rest->response($this->helper->json(array('tokenja'=>'invalido','message'=>'Usuario o clave incorrecto')), 401);

            }else{
                $this->rest->response('',404);
            }
        }



        /**
         * USUARIOS
         */

        private function buscadorUsuarios(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"));
            $filtro     = isset($post) ? $post->filtro : '';

            $this->modelUsuarios->atributos = array('id'=> (int)$filtro,'nombre'=> $filtro,'correo'=> $filtro,'usuario'=> $filtro,'telefono'=> $filtro);
            $resultado = $this->modelUsuarios->buscador();
            if(!empty($resultado)){
                $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function unicoUsuario(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"),true);
            $id         = isset($post['id']) ? (int)$post['id'] : 0;

            if(empty($id) || $id == 0){
                $this->rest->response($this->helper->json(array('mensaje'=>'estás perdido?')),204);
            }

            $usuarios = new JaUsuarios();
            $usuarios->atributos = array('id'=> $id);
            $resultado = $usuarios->unico();
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function todosUsuarios(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $usuarios = $this->modelUsuarios->todosUsuarios();
            if(isset($usuarios)){
                $this->rest->response($this->helper->json(array('resultado'=>$usuarios)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function existeDatoUsuario(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            //$post       = $this->rest->_request;
            $post = json_decode(file_get_contents("php://input"),true);

            $clave      = isset($post['clave']) ? $post['clave'] : '';
            $valor      = isset($post['valor']) ? $post['valor'] : '';

            if(empty($clave) || empty($valor)){
                $this->rest->response($this->helper->json(array('mensaje'=>$post['clave'])), 200);
            }

            $this->modelUsuarios->atributos = array($clave => $valor);
            $resultado = $this->modelUsuarios->existeUsuario();
            $this->rest->response($this->helper->json(array('existe'=>$resultado)), 200);
        }

        private function crearUsuario(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            //$datos      = json_decode(file_get_contents("php://input"),true);
            $datos      = $this->rest->_request;
            $usuario    = isset($datos['usuario']['usuario']) ? $datos['usuario']['usuario'] : '';
            $login      = isset($usuario['usuario']) ? $usuario['usuario'] : '';
            $imagen     = !empty( $_FILES ) ? $_FILES : '';
            $nombre     = isset($usuario['nombre']) ? $usuario['nombre'] : '';
            $apellidos  = isset($usuario['apellidos']) ? $usuario['apellidos'] : '';
            $correo     = isset($usuario['correo']) ? $usuario['correo'] : '';
            $clave      = isset($usuario['clave']) ? $usuario['clave'] : '';
            $tel        = isset($usuario['tel']) ? $usuario['tel'] : '';
            $direccion  = isset($usuario['direccion']) ? $usuario['direccion'] : '';
            $ciudad     = isset($usuario['ciudad']) ? $usuario['ciudad'] : '';
            $pais       = isset($usuario['pais']) ? $usuario['pais'] : '';

            $valores = [];

            if(empty($datos)){
                $this->rest->response($this->mensajeError, 204);
            }

            if(isset($login))      { $valores['usuario']    = $login; }
            //if(isset($imagen))     { $valores['imagen']     = $imagen; }
            if(isset($nombre))     { $valores['nombre']     = $nombre; }
            if(isset($apellidos))  { $valores['apellidos']  = $apellidos; }
            if(isset($correo))     { $valores['correo']     = $correo; }
            if(isset($tel))        { $valores['telefono']   = $tel; }
            if(isset($clave))      { $valores['clave']      = $this->helper->encriptar($clave); }
            if(isset($direccion))  { $valores['direccion']  = $direccion; }
            if(isset($ciudad))     { $valores['ciudad']     = $ciudad; }
            if(isset($pais))       { $valores['pais']       = $pais; }

            $this->modelUsuarios->atributos = $valores;
            $resultado = $this->modelUsuarios->crearUsuario();
            if(isset($resultado)){
                $nombre_imagen = 'usuario_'.$resultado;
                $archivo = $this->helper->guardarImagen($imagen, $nombre_imagen, 'usuarios');

                $this->modelUsuarios->atributos = array('id'=>$resultado);
                $this->modelUsuarios->setatributos = array('imagen'=>$archivo);
                $this->modelUsuarios->actualizarUsuario();

                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha creado el usuario con exito')), 200);
                //$this->rest->response($this->helper->json(array('resultado'=> $valores, 'mensaje'=>'Se ha creado el usuario con exito')), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function actualizarUsuario(){
            if($this->rest->get_request_method() != "PUT"){
                $this->rest->response('',406);
            }

            $datos      = json_decode(file_get_contents("php://input"),true);
            $id         = isset($datos['usuario']['id']) ? (int)$datos['usuario']['id'] : 0;
            $nombre     = isset($datos['usuario']['nombre']) ? $datos['usuario']['nombre'] : '';
            $apellidos  = isset($datos['usuario']['apellidos']) ? $datos['usuario']['apellidos'] : '';
            $correo     = isset($datos['usuario']['correo']) ? $datos['usuario']['correo'] : '';
            $clave      = isset($datos['usuario']['clave']) ? $datos['usuario']['clave'] : '';
            $tel        = isset($datos['usuario']['tel']) ? $datos['usuario']['tel'] : '';
            $direccion  = isset($datos['usuario']['direccion']) ? $datos['usuario']['direccion'] : '';
            $ciudad     = isset($datos['usuario']['ciudad']) ? $datos['usuario']['ciudad'] : '';
            $pais       = isset($datos['usuario']['pais']) ? $datos['usuario']['pais'] : '';

            $valores = [];



            if(empty($datos)){
                $this->rest->response($this->mensajeError, 204);
            }

            if(isset($nombre))     { $valores['nombre']     = $nombre; }
            if(isset($apellidos))  { $valores['apellidos']     = $apellidos; }
            if(isset($correo))     { $valores['correo']     = $correo; }
            if(isset($tel))        { $valores['telefono']   = $tel; }
            if(isset($clave))      { $valores['clave']      = $this->helper->encriptar($clave); }
            if(isset($direccion))  { $valores['direccion']  = $direccion; }
            if(isset($ciudad))     { $valores['ciudad']     = $ciudad; }
            if(isset($pais))       { $valores['pais']       = $pais; }

            $this->modelUsuarios->atributos = array('id'=>$id);
            $this->modelUsuarios->setatributos = $valores;
            $resultado = $this->modelUsuarios->actualizarUsuario();

            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha actualizado con exito')), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function eliminarUsuario(){
            if($this->rest->get_request_method() != "DELETE"){
                $this->rest->response('',406);
            }
            $id = isset($this->rest->_request['id']) ? (int)$this->rest->_request['id'] : 0;
            if($id > 0){
                $this->modelUsuarios->atributos = array('id' => $id);
                $resultado = $this->modelUsuarios->eliminarUsuario();
                $success = array('status' => "Success", "mensaje" => "Se ha eliminado el usuario ".$id);
                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response($this->mensajeError, 204);
            }
        }



        /**
         * CATEGORIAS
         */

        private function buscadorCategorias(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"));
            $filtro     = isset($post->filtro) ? $post->filtro : '';

            $categoria = new JaCategorias();
            $categoria->atributos = array('id'=> $filtro,'titulo'=> $filtro,'slug'=> $filtro);
            $resultado = $categoria->buscador();

            if(isset($resultado) && !empty($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->mensajeError,204);
        }

        private function unicaCategoria(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"));
            $id         = isset($post->id) ? (int)$post->id : 0;

            if(empty($id) || $id == 0){
                $this->rest->response($this->helper->json(array('mensaje'=> $this->mensajeError)),204);
            }

            $this->modelCategorias->atributos = array('id'=> $id);
            $resultado = $this->modelCategorias->unicaCategoria();
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->mensajeError,204);
        }

        private function todasCategorias(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $resultado = new JaCategorias();
            $categorias = $resultado->todas();
            if(isset($categorias) && !empty($categorias)){
                $this->rest->response($this->helper->json(array('resultado'=>$categorias)), 200);
            }
            $this->rest->response($this->mensajeError,204);
        }

        private function actualizarCategoria(){
            if($this->rest->get_request_method() != "PUT"){
                $this->rest->response('',406);
            }

            $datos      = json_decode(file_get_contents("php://input"),true);
            $id         = isset($datos['categoria']['id']) ? (int)$datos['categoria']['id'] : 0;
            $titulo     = isset($datos['categoria']['titulo']) ? $datos['categoria']['titulo'] : '';
            $slug       = isset($datos['categoria']['slug']) ? $datos['categoria']['slug'] : '';

            $valores = [];


            if(empty($datos)){
                $this->rest->response($this->mensajeError, 204);
            }

            if(isset($titulo))     { $valores['titulo']     = $titulo; }
            if(isset($slug))       { $valores['slug']       = $slug; }

            $this->modelCategorias->atributos = array('id'=>$id);
            $this->modelCategorias->setatributos = $valores;
            $resultado = $this->modelCategorias->actualizarCategoria();

            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha actualizado con exito')), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function crearCategoria(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $datos      = json_decode(file_get_contents("php://input"),true);
            $titulo     = isset($datos['categoria']['titulo']) ? $datos['categoria']['titulo'] : '';
            $slug       = isset($datos['categoria']['slug']) ? $datos['categoria']['slug'] : '';

            $valores = [];

            if(empty($datos)){
                $this->rest->response($this->mensajeError, 204);
            }

            if(isset($titulo))     { $valores['titulo']     = $titulo; }
            if(isset($slug))       { $valores['slug']       = $slug; }

            $this->modelCategorias->atributos = $valores;
            $resultado = $this->modelCategorias->crearCategoria();
            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha creado el usuario con exito')), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function eliminarCategoria(){
            if($this->rest->get_request_method() != "DELETE"){
                $this->rest->response('',406);
            }
            $id = isset($this->rest->_request['id']) ? (int)$this->rest->_request['id'] : 0;
            if($id > 0){
                $this->modelCategorias->atributos = array('id' => $id);
                $resultado = $this->modelCategorias->eliminarCategoria();
                $success = array('status' => "Success", "mensaje" => $id." Successfully deleted one record.".$resultado);
                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response($this->mensajeError, 204);
            }
        }


        /**
         * MENU
         */
        private function buscadorMenu(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"),true);
            $filtro     = isset($post['filtro']) ? $post['filtro'] : '';
            $categoria  = isset($post['tipo']) ? $post['tipo'] : '';


            $this->modelMenu->atributos = array('id'=> $filtro,'nombre'=> $filtro,'enlace'=> $filtro,'tipo_enlace'=> $filtro,'target'=> $filtro);

            $resultado = $this->modelMenu->buscadorEnlaces($categoria);
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function buscadorMenuCategoria(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"),true);
            $filtro     = isset($post['filtro']) ? $post['filtro'] : '';
            $categoria  = isset($post['tipo']) ? $post['tipo'] : '';

            $resultado = $this->modelMenu->buscadorEnlacesPorCategoria($categoria);
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function getMenu(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $tipo = $this->rest->_request['tipo'];

            $enlaces = $this->modelMenu->enlacesMenu($tipo);
            if(isset($enlaces)){
                $this->rest->response($this->helper->json(array('resultado'=>$enlaces)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function getTodosEnlaces(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $enlaces = $this->modelMenu->todosEnlaces();
            if(isset($enlaces)){
                $this->rest->response($this->helper->json(array('resultado'=>$enlaces)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function getTodosEnlacesMenu(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $tipo = $this->rest->_request['tipo'];

            $enlaces = $this->modelMenu->todosEnlacesMenu($tipo);
            if(isset($enlaces)){
                $this->rest->response($this->helper->json(array('resultado'=>$enlaces)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function getMenuDetallado(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $id = (int)$this->rest->_request['id'];

            $this->modelMenu->atributos = array('id'=>$id);
            $enlace = $this->modelMenu->getMenuDetallado();
            if(isset($enlace)){
                $this->rest->response($this->helper->json(array('resultado'=>$enlace)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function getMenuCategorias(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $categorias = $this->modelMenu->getCategorias();
            if(isset($categorias)){
                $this->rest->response($this->helper->json(array('resultado'=>$categorias)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function unicoEnlace(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"),true);
            $id         = isset($post['id']) ? (int)$post['id'] : 0;

            if(empty($id) || $id == 0){
                $this->rest->response($this->helper->json(array('mensaje'=>'est�s perdido?')),204);
            }

            $this->modelMenu->atributos = array('id'=> $id);
            $resultado = $this->modelMenu->unicoEnlace();
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function crearEnlace(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $datos      = json_decode(file_get_contents("php://input"),true);
            $nombre     = isset($datos['enlace']['nombre']) ? $datos['enlace']['nombre'] : '';
            $clase      = isset($datos['enlace']['clase']) ? $datos['enlace']['clase'] : '';
            $enlace     = isset($datos['enlace']['ruta']) ? $datos['enlace']['ruta'] : '';
            $target     = isset($datos['enlace']['target']) ? $datos['enlace']['target'] : '';
            $padre      = isset($datos['enlace']['padre']) ? $datos['enlace']['padre'] : '';
            $categoria  = isset($datos['enlace']['categoria']) ? $datos['enlace']['categoria'] : '';

            $valores = [];

            if(empty($datos)){
                $this->rest->response($this->mensajeError, 204);
            }

            if(isset($nombre))      { $valores['nombre']     = $nombre; }
            if(isset($clase))       { $valores['clase']      = $clase; }
            if(isset($enlace))      { $valores['enlace']     = $enlace; }
            if(isset($target))      { $valores['target']     = $target; }
            if(isset($padre))       { $valores['padre']      = $padre; }
            if(isset($categoria))   { $valores['categoria']  = $this->modelMenu->getIdCategoria($categoria); }

            $this->modelMenu->atributos = $valores;
            $resultado = $this->modelMenu->crearEnlace();
            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha creado el enlace con exito')), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function actualizarEnlace(){
            if($this->rest->get_request_method() != "PUT"){
                $this->rest->response('',406);
            }

            $datos      = json_decode(file_get_contents("php://input"),true);
            $id         = isset($datos['enlace']['nombre']) ? $datos['enlace']['id'] : '';
            $nombre     = isset($datos['enlace']['nombre']) ? $datos['enlace']['nombre'] : '';
            $clase      = isset($datos['enlace']['clase']) ? $datos['enlace']['clase'] : '';
            $enlace     = isset($datos['enlace']['ruta']) ? $datos['enlace']['ruta'] : '';
            $target     = isset($datos['enlace']['target']) ? $datos['enlace']['target'] : '';
            $padre      = isset($datos['enlace']['padre']) ? $datos['enlace']['padre'] : '';
            $categoria  = isset($datos['enlace']['categoria']) ? $datos['enlace']['categoria'] : '';

            $valores = [];

            if(empty($datos)){
                $this->rest->response($this->mensajeError, 204);
            }

            if(isset($id))          { $valores['id']         = $id; }
            if(isset($nombre))      { $valores['nombre']     = $nombre; }
            if(isset($clase))       { $valores['clase']      = $clase; }
            if(isset($enlace))      { $valores['enlace']     = $enlace; }
            if(isset($target))      { $valores['target']     = $target; }
            if(isset($padre))       { $valores['padre']      = $padre; }
            if(isset($categoria))   { $valores['categoria']  = $this->modelMenu->getIdCategoria($categoria); }

            $this->modelMenu->atributos = array('id'=>$id);
            $this->modelMenu->setatributos = $valores;
            $resultado = $this->modelMenu->actualizarEnlace();

            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha actualizado con exito')), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function eliminarEnlace(){
            if($this->rest->get_request_method() != "DELETE"){
                $this->rest->response('',406);
            }
            $id = isset($this->rest->_request['id']) ? (int)$this->rest->_request['id'] : 0;
            if($id > 0){
                $this->modelMenu->atributos = array('id' => $id);
                $this->modelMenu->eliminarEnlace();
                $success = array('status' => "Success", "mensaje" => "Eliminado con �xito");
                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response($this->mensajeError, 204);
            }
        }

        /**
         * PAGINAS
         */

        private function buscadorPaginas(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"));
            $filtro     = isset($post->filtro) ? $post->filtro : '';

            $this->modelPaginas->atributos = array('id'=> $filtro,'titulo'=> $filtro, 'nombre'=> $filtro,'slug'=> $filtro, 'stado'=> $filtro, 'autor'=> $filtro, 'fecha'=> $filtro);
            $resultado = $this->modelPaginas->buscadorPaginas();
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function unicaPagina(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"),true);
            $id         = isset($post['id']) ? (int)$post['id'] : 0;

            if(empty($id) || $id == 0){
                $this->rest->response($this->helper->json(array('mensaje'=>'est�s perdido?')),204);
            }

            $this->modelPaginas->atributos = array('id'=> $id);
            $resultado = $this->modelPaginas->unicaPagina();
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function todasPaginas(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $categorias = $this->modelPaginas->todasPaginas();
            if(isset($categorias)){
                $this->rest->response($this->helper->json(array('resultado'=>$categorias)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function todasPaginasPorCategoria(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $id = $this->rest->_request['categoria'];

            $this->modelPaginas->atributos = array('categoria'=> $id);
            $categorias = $this->modelPaginas->todasPaginasCategoria();
            if(isset($categorias)){
                $this->rest->response($this->helper->json(array('resultado'=>$categorias)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function PaginasPorCategoria(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"));
            $categoria         = isset($post->categoria) ? $post->categoria : '';

            if(empty($categoria)){
                $this->rest->response($this->helper->json(array('mensaje'=>$categoria.'estás perdido?')),204);
            }

            $obj = new JaCategorias();
            $obj->atributos = array('slug'=> $categoria);
            $resultado = $obj->existe();
            if(isset($resultado) && $resultado['existe'] == true){
                $obj2 = new JaPaginas();
                $obj2->atributos = array('categoria'=> (int)$resultado['id']);
                $datos = $obj2->articulosPorCategoria();
                $resultado['total'] = count($datos);
                $resultado['listado'] = $datos;
                $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
            }else{
                $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function existePortada(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }
            $obj = new JaPaginas();
            $resultado = $obj->existePortada();
            $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
        }

        private function obtenerPortada(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }
            $obj = new JaPaginas();
            $resultado = $obj->obtenerPortada();
            if(isset($resultado['metapalabras'])){
                $resultado['metapalabras'] = $this->helper->convertirStringAArray($resultado['metapalabras']);
            }
            if(isset($resultado['configuracion'])) {
                $resultado['configuracion'] = $this->helper->convertirJsonAArray($resultado['configuracion']);
            }

            if(!empty($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function guardarPortada(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $portada = json_decode(file_get_contents("php://input"));

            $pagina = new JaPaginas();
            $pagina->objecto = $portada;
            $resultado = $pagina->guardarPortada();
            $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
        }


        private function existeContacto(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"));
            $categoria         = isset($post->categoria) ? $post->categoria : '';

            $obj = new JaPaginas();
            $resultado = $obj->existeContacto();
            $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
        }


        private function compartir(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }
            $redes = new RedesSociales();

            $resultado = $redes->validarUrl();
            $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
        }



        private function detallePagina(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"));
            $categoria         = isset($post->categoria) ? $post->categoria : '';
            $slug              = isset($post->slug) ? $post->slug : '';

            if(empty($categoria) || empty($slug)){
                $this->rest->response($this->mensajeError, 204);
            }

            $obj = new JaPaginas();
            $obj->atributos = array('categoria'=> $categoria, 'slug'=>$slug);
            $resultado = $obj->detalleArticulo();
            if(isset($resultado) && $resultado['existe'] == true){
                $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
            }else{
                $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function PaginaEstatica(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"));
            $slug         = isset($post->slug) ? $post->slug : '';

            if(empty($slug)){
                $this->rest->response($this->mensajeError, 204);
            }

            $this->modelPaginas->atributos = array('slug'=>$slug);
            $resultado = $this->modelPaginas->detallePaginaEstatica();
            $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
            if(isset($resultado) && $resultado['existe'] == true){
                $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
            }else{
                $this->rest->response($this->helper->json(array('resultado'=>$resultado)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function crearPagina(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $datos      = json_decode(file_get_contents("php://input"));
            $titulo     = isset($datos->pagina->titulo) ? $datos->pagina->titulo : '';
            $contenido  = isset($datos->pagina->contenido) ? $datos->pagina->contenido : '';
            $leermas    = isset($datos->pagina->leermas) ? $datos->pagina->leermas : '';
            $estado     = isset($datos->pagina->estado) ? $datos->pagina->estado : '';
            $tipo       = isset($datos->pagina->tipo) ? $datos->pagina->tipo : '';
            $autor      = isset($datos->pagina->autor) ? $datos->pagina->autor : '';
            $padre      = isset($datos->pagina->padre) ? $datos->pagina->padre : '';
            $slug       = isset($datos->pagina->slug) ? $datos->pagina->slug : '';
            $meta_titulo        = isset($datos->pagina->seo->titulo) ? $datos->pagina->seo->titulo : '';
            $meta_descripcion   = isset($datos->pagina->seo->descripcion) ? $datos->pagina->seo->descripcion : '';
            $meta_palabras      = isset($datos->pagina->seo->palabrasclave) ? $datos->pagina->seo->palabrasclave : '';
            $fecha_creado       = isset($datos->pagina->fechacreado) ? $datos->pagina->fechacreado : '';
            $fecha_modificado   = isset($datos->pagina->fechamodificado) ? $datos->pagina->fechamodificado : '';

            $valores = [];

            if(empty($datos)){
                $this->rest->response($this->mensajeError, 204);
            }

            if(isset($titulo))          { $valores['titulo']        = $titulo; }
            if(isset($contenido))       { $valores['contenido']     = $contenido; }
            if(isset($leermas))         { $valores['leermas']       = $leermas; }
            if(isset($estado))          { $valores['estado']        = $estado; }
            if(isset($tipo))            { $valores['tipo']          = $tipo; }
            if(isset($autor))           { $valores['autor']         = $autor; }
            if(isset($padre))           { $valores['padre']         = $padre; }
            if(isset($slug))            { $valores['slug']          = $slug; }
            if(isset($meta_titulo))     { $valores['meta_titulo']   = $meta_titulo; }
            if(isset($meta_descripcion)){ $valores['meta_descripcion'] = $meta_descripcion; }
            if(isset($meta_palabras))   { $valores['meta_palabras'] = $this->helper->convertirArrayAString($meta_palabras); }
            if(isset($fecha_creado))    { $valores['fecha_creado']  = $fecha_creado; }
            if(isset($fecha_modificado)){ $valores['fecha_modificado'] = $fecha_modificado; }
            //if(isset($categoria))   { $valores['categoria']  = $this->modelMenu->getIdCategoria($categoria); }

            $this->modelPaginas->atributos = $valores;
            $resultado = $this->modelPaginas->crearPagina();
            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>$resultado.'Se ha creado la pagina con exito')), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function actualizarPagina(){
            if($this->rest->get_request_method() != "PUT"){
                $this->rest->response('',406);
            }

            $datos      = json_decode(file_get_contents("php://input"),true);
            $id         = isset($datos['usuario ']['id']) ? (int)$datos['usuario']['id'] : 0;
            $titulo     = isset($datos['usuario']['titulo']) ? $datos['usuario']['titulo'] : '';
            $slug       = isset($datos['usuario']['slug']) ? $datos['usuario']['slug'] : '';

            $valores = [];

            $filename = $_FILES['file']['name'];
            $destination = '../images/' . $filename;
            move_uploaded_file( $_FILES['file']['tmp_name'] , $destination );

            if(empty($datos)){
                $this->rest->response($this->mensajeError, 204);
            }

            if(isset($titulo))     { $valores['titulo']     = $titulo; }
            if(isset($slug))       { $valores['slug']       = $slug; }

            $this->modelPaginas->atributos = array('id'=>$id);
            $this->modelPaginas->setatributos = $valores;
            $resultado = $this->modelPaginas->actualizarPagina();

            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha actualizado con exito')), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function eliminarPagina(){
            if($this->rest->get_request_method() != "DELETE"){
                $this->rest->response('',406);
            }
            $id = isset($this->rest->_request['id']) ? (int)$this->rest->_request['id'] : 0;
            if($id > 0){
                $this->modelPaginas->atributos = array('id' => $id);
                $resultado = $this->modelPaginas->eliminarPagina();
                $success = array('status' => "Success", "mensaje" => $id." Successfully deleted one record.".$resultado);
                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response($this->mensajeError, 204);
            }
        }

        private function getPaginasCategorias(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $categorias = $this->modelPaginas->getCategorias();
            if(isset($categorias)){
                $this->rest->response($this->helper->json(array('resultado'=>$categorias)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }


        //frontend
        private function cargarPortada(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $respuesta = false;

            $obj = new JaPaginas();
            $resultado = $obj->obtenerPortada();

            if(isset($resultado['metapalabras'])){
                $resultado['metapalabras'] = $this->helper->convertirStringAArray($resultado['metapalabras']);
            }
            if(isset($resultado['configuracion'])) {
                $resultado['configuracion'] = $this->helper->convertirJsonAArray($resultado['configuracion']);
            }

            //bloque1 - ultimos articulos
            if(isset($resultado) && isset($resultado['configuracion']) && isset($resultado['configuracion']['principal']['bloque1'])){
                $paginas = new JaPaginas();
                $paginas->atributos = $resultado['configuracion']['principal']['bloque1']['numarticulos'];
                $paginas->ultimosArticulos();
                $respuesta = true;
            }

            //bloque1 - articulo principal con listado
            if(isset($resultado) && isset($resultado['configuracion']) && isset($resultado['configuracion']['principal']['bloque2'])){
                $paginas = new JaPaginas();
                $paginas->atributos = array('cantidad'=>$resultado['configuracion']['principal']['bloque2']['numarticulos'], 'categoria'=>$resultado['configuracion']['principal']['bloque2']['categoria']);
                $paginas->articulosPorCategoria();
                $respuesta = true;
            }

            if($respuesta){
                $this->rest->response($respuesta, 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }
        private function getArticulos(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $categoria = isset($this->rest->_request['categoria']) ? $this->rest->_request['categoria'] : 0;
            $cantidad = isset($this->rest->_request['cantidad']) ? (int)$this->rest->_request['cantidad'] : 0;

            $paginas = new JaPaginas();
            $paginas->atributos = array('cantidad'=>$cantidad, 'categoria'=>$categoria);
            $articulos = $paginas->articulosPorCategoria();

            if(isset($articulos)){
                $this->rest->response($this->helper->json($articulos), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }
        private function getUltimosArticulos(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $cantidad = !empty($this->rest->_request['cantidad']) ? (int)$this->rest->_request['cantidad'] : 0;
            $paginas = new JaPaginas();
            $paginas->atributos = $cantidad;
            $articulos = $paginas->ultimosArticulos();

            if(isset($articulos) && !empty($articulos)){
                $this->rest->response($this->helper->json($articulos), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }





        /**
         * DEMOS
         */




        private function getUltimasNoticias(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $cantidad = !empty($this->rest->_request) ? (int)$this->rest->_request['cantidad'] : 0;

            $noticias = $this->demo->getUltimasNoticias($cantidad);

            if(isset($noticias)){
                $this->rest->response($this->helper->json($noticias), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function getArticulosCategoria(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $cantidad = (int)$this->rest->_request['cantidad'];

            $articulos = $this->demo->getArticulosCategoria($cantidad);

            if(isset($articulos)){
                $this->rest->response($this->helper->json($articulos), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }

        private function demo(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            //$cantidad = (int)$this->rest->_request['cantidad'];

            $articulos = $this->modelCategorias->demo();

            if(isset($articulos)){
                $this->rest->response($this->helper->json(array('resultado'=>$articulos)), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }


        /**
         * FIN DEMOS
         */


        //PAGINAS
        /*
        private function getPortada(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }
            $datos = json_decode(file_get_contents("php://input"),true); //(int)$this->rest->_request['id'];
            $portada = $this->seleccionar_pagina_by('pagina', array('pagina_tipo' => $datos['tipo']));
            if(isset($portada)){
                $this->rest->response($this->helper->json($portada), 200);
            }
            $this->rest->response($this->mensajeError, 204);
        }



        private function crearPaginaDEMO(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $datos = json_decode(file_get_contents("php://input"),true); //'id', 'titulo', 'descripcion',
            $column_names = array('id', 'pagina_titulo', 'pagina_contenido',);

            $tipo = isset($datos['tipo']) ? $datos['tipo'] : '';
            $titulo = isset($datos['titulo']) ? $datos['titulo'] : '';
            $subtitulo = isset($datos['subtitulo']) ? $datos['subtitulo'] : '';
            $descripcion = isset($datos['descripcion']) ? $datos['descripcion'] : '';
            $razones = isset($datos['razones']) ? $datos['razones'] : '';

            $valores = array('pagina_tipo' => $tipo,
                'pagina_titulo' => $titulo,
                'pagina_contenido' => $descripcion,
            );

            $metas1 = array('meta_key' => 'subtitulo', 'meta_value' => $subtitulo);
            $metas2 = array('meta_key' => 'razones', 'meta_value' => json_encode($razones));

            if(isset($datos)){
                $idpost = $this->insertar_pagina('pagina', $valores);
                $r1 = $this->insertar_meta($idpost, $metas1);
                $r2 = $this->insertar_meta($idpost, $metas2);

                $success = array('status' => "�xito",
                    'datos' => array($idpost, $valores, $metas1, $metas2));

                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response('',204);	//"No Content" status
            }
        }

        private function editarPaginaDEMO(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $datos = json_decode(file_get_contents("php://input"), true); //'id', 'titulo', 'descripcion',


            $id = $datos['idpost'];
            $tipo = isset($datos['post']['tipo']) ? $datos['post']['tipo'] : '';
            $titulo = isset($datos['post']['titulo']) ? $datos['post']['titulo'] : '';
            $subtitulo = isset($datos['post']['subtitulo']) ? $datos['post']['subtitulo'] : '';
            $descripcion = isset($datos['post']['descripcion']) ? $datos['post']['descripcion'] : '';
            $razones = isset($datos['post']['razones']) ? $datos['post']['razones'] : '';

            $valores = array('pagina_tipo' => $tipo,
                'pagina_titulo' => $titulo,
                'pagina_contenido' => $descripcion,
            );

            $where0 = array('id' => $id, 'pagina_tipo' => $tipo);
            $where1 = array('post_id' => $id, 'meta_key' => 'subtitulo');
            $where2 = array('post_id' => $id, 'meta_key' => 'razones');

            $metas1 = array('meta_key' => 'subtitulo', 'meta_value' => $subtitulo);
            $metas2 = array('meta_key' => 'razones', 'meta_value' => json_encode($razones));



            if(isset($datos) && $id > 0){
                $this->editar_pagina('paginameta', $where1, $metas1);
                $this->editar_pagina('paginameta', $where2, $metas2);
                $this->editar_pagina('pagina', $where0, $valores);

                $success = array('status' => "�xito",
                );

                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response('',204);	//"No Content" status
            }
        }






        //USUARIOS
        private function customers(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $resultado = $this->seleccionar();


            if(!empty($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response('',204);
        }

        private function customer(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }
            $id = (int)$this->rest->_request['id'];
            if($id > 0){
                //$id = isset($this->parametros['datos']['id']) ? $this->parametros['datos']['id'] : '';
                $usuario = $this->seleccionar_by(array('customerNumber' => $id));

                if(!empty($usuario)){
                    $this->rest->response($this->helper->json($usuario), 200);
                }
            }
            $this->rest->response('',204);	// If no records "No Content" status
        }

        private function insertCustomer(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $datos = json_decode(file_get_contents("php://input"),true);
            $column_names = array('customerName', 'email', 'city', 'address', 'country');

            $customerName = isset($datos['customerName']) ? $datos['customerName'] : '';
            $email = isset($datos['email']) ? $datos['email'] : '';
            $city = isset($datos['city']) ? $datos['city'] : '';
            $address = isset($datos['address']) ? $datos['address'] : '';
            $country = isset($datos['country']) ? $datos['country'] : '';
            $valores = array('customerName' => $customerName,
                'email' => $email,
                'city' => $city,
                'address' => $address,
                'country' => $country);

            //$success = array('status' => "Success", "msg" => "Customer Created Successfully.", "data" => $valores);
            //$this->rest->response($this->helper->json($success),200);

            if(isset($datos)){
                $this->insertar($valores);
                $success = array('status' => "Success", "msg" => "Customer Created Successfully.", "datas" => $valores);
                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response('',204);	//"No Content" status
            }
        }

        private function updateCustomer(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }
            $datos = json_decode(file_get_contents("php://input"), true);
            $id = (int)$datos['id'];
            $customerName = isset($datos['customer']['customerName']) ? $datos['customer']['customerName'] : '';
            $email = isset($datos['customer']['email']) ? $datos['customer']['email'] : '';
            $city = isset($datos['customer']['city']) ? $datos['customer']['city'] : '';
            $address = isset($datos['customer']['address']) ? $datos['customer']['address'] : '';
            $country = isset($datos['customer']['country']) ? $datos['customer']['country'] : '';
            $valores = array('customerName' => $customerName,
                'email' => $email,
                'city' => $city,
                'address' => $address,
                'country' => $country);

            if($id > 0){
                $where = array('customerNumber' => $id);
                $this->editar($where, $valores);
                $success = array('status' => "Success", "msg" => "Actualizaci�n �xitosa.");
                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response('',204);	// "No Content" status
            }
        }

        private function deleteCustomer(){
            if($this->rest->get_request_method() != "DELETE"){
                $this->rest->response('',406);
            }
            $id = (int)$this->rest->_request['id'];
            if($id > 0){
                $r = $this->eliminar(array('customerNumber' => $id));
                $success = array('status' => "Success", "msg" => "Successfully deleted one record.".$r);
                $this->response($this->helper->json($success),200);
            }else{
                $this->response('',204);	// If no records "No Content" status
            }
        }








        private function seleccionar(){
            //$this->where = $parametros;
            $this->model_get_all_users(tbl_usuarios);
            return $this->resultado;
        }
        private function seleccionar_by($tipo='', $parametros = array()){
            $tabla = $this->helper->tipo_tabla($tipo);
            $this->where = $parametros;
            $this->model_get($tabla);
            return $this->resultado;
        }
        private function seleccionar_pagina_by($tipo='', $parametros = array()){
            $tabla = $this->helper->tipo_tabla($tipo);
            $this->where = $parametros;
            $this->model_get_pagina($tabla);
            return $this->resultado;
        }
        private function seleccionar_all(){
            //$this->where = $parametros;
            //$this->model_get(tbl_usuarios);
            //return $this->resultado;
        }

        private function insertar($tipo= '', $valores = '', $meta = ''){
            $tabla = $this->helper->tipo_tabla($tipo);
            $tablameta = $this->helper->tipo_tabla('paginameta');
            $this->model_insertar($tabla, $valores);
            return $this->resultado;
        }
        private function insertar_pagina($tipo= '', $valores = ''){
            $tabla = $this->helper->tipo_tabla($tipo);
            $this->model_insertar($tabla, $valores); //, array('tabla'=>$tablameta, 'valores'=>$meta)

            $idpost = $this->resultado;
            return $this->resultado;
        }
        private function editar_pagina($tipo = '', $where = '', $valores = ''){
            $tabla = $this->helper->tipo_tabla($tipo);
            $this->where = $where;
            $this->model_actualizar($tabla, $valores); //, array('tabla'=>$tablameta, 'valores'=>$meta)

            $idpost = $this->resultado;
            return $idpost; //$this->resultado;
        }


        //Meta valores pagina
        /*private function insertar_meta($idpost, $meta = ''){
            $tablameta = $this->helper->tipo_tabla('paginameta');
            $this->model_insertar_meta($idpost, $tablameta, $meta);
            return $this->resultado;
        }
        private function editar_meta($idpost, $meta = ''){
            $tablameta = $this->helper->tipo_tabla('paginameta');
            $this->model_actualizar_meta($idpost, $tablameta, $meta);
            return $this->resultado;
        }

        private function editar($parametros = array(), $valores = array()){
            $this->where = $parametros;
            $this->model_actualizar(tbl_usuarios, $valores);
            return $this->resultado;
        }*/
       /* private function eliminar($parametros = array()){
            $this->where = $parametros;
            $this->model_borrar(tbl_usuarios);
            return $this->resultado;
        }
*/


    }