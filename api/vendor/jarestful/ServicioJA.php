<?php

namespace Api;


	use Token\JWT\Builder;
    use Token\JWT\ValidationData;

	use Api\Demo;
	use Api\RestJA;
	use Api\Modelo;
	use Api\Sesion;
	use Api\Helper;
	use Api\Entorno;

    use Api\Modelos\Usuarios;
    use Api\Modelos\Categorias;
    use Api\Modelos\Paginas;
    use Api\Modelos\Menu;

	class ServicioJA { //REST
        public $data      = "";
        private $sesion;
        private $rest;
        private $db       = NULL;
        private $mysqli   = NULL;
        private $helper;
        private $demo;
        private $modelUsuarios = NULL;
        private $modelCategorias = NULL;
        private $modelPaginas = NULL;
        private $modelMenu = NULL;

        /**
         * Inicialización objetos
         */
        function __construct(){
            $this->rest      = new RestJA();
            $this->sesion    = new Sesion();
            $this->helper    = new Helper();
            $this->demo      = new Demo();
            $this->modelUsuarios = Usuarios::getInstance();
            $this->modelCategorias = Categorias::getInstance();
            $this->modelPaginas = Paginas::getInstance();
            $this->modelMenu = Menu::getInstance();
        }

        /**
         * Llamadas a metodos dinamicamente
         * @return response
         */
        public function iniciarServicio(){
            //$this->init_rest();

            $req = isset($_REQUEST['x']) ? $_REQUEST['x'] : '';
            $func = strtolower(trim(str_replace("/","",$req)));
            if((int)method_exists($this,$func) > 0)
                $this->$func();
            else
                $this->rest->response('',404); // If the method not exist with in this class "Page not found".
        }

        private function getToken($usuario){
            $token = '';
            $token = (new Builder())->setIssuer('http://ja.dev') // Configures the issuer (iss claim)
            ->setAudience('http://ja.dev/') // Configures the audience (aud claim)
            ->setId('jajwt', true) // Configures the id (jti claim), replicating as a header item
            ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
            ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
            ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
            ->set('sub', 1) // Configures a new claim, called "uid"
            ->set('user', $usuario['usuario'])// Configures a new claim, called "uid"
            ->set('role', $usuario['rol'])// Configures a new claim, called "uid"
            ->getToken(); // Retrieves the generated token


            return (string)$token;
        }

        /**
         * Login
         * @param string correo, clave
         * @return response json
         */
        private function login(){
            if($this->rest->get_request_method() == "POST"){
                $dato       = json_decode(file_get_contents('php://input'));  //get user from
                //$correo     = isset($user->correo) ? $user->correo : '';
                //$pass       = isset($user->pass) ? $user->pass : '';
                //$usuario    = $this->seleccionar_by('usuario', array('email' => $correo, 'password' => $pass));

                $usuario    = isset($dato->usuario) ? $dato->usuario : '';
                $clave      = isset($dato->clave) ? $dato->clave : '';
                $usuariodb  = array('id'=> 1,'usuario' => 'admin', 'clave' => '1234', 'rol'=>'lector');

                if($usuario == $usuariodb['usuario'] && $clave == $usuariodb['clave']){
                    //$uid = $this->sesion->sesion_init();
                    $token = $this->getToken(array('usuario' => 'admin', 'clave' => '1234', 'rol'=>'lector'));
                    $this->rest->_token = $token;
                    $this->rest->response($this->helper->json(array('tokenja'=> $token, 'msg'=>'autorizado', 'uid'=> $dato)), 200);
                }
                $this->rest->response($this->helper->json(array('tokenja'=>'invalido','message'=>'Usuario o clave incorrecto')), 401);

            }else{
                $this->rest->response('',404);
            }
        }



        /**
         * USUARIOS
         */

        public function buscadorUsuarios(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"),true);
            $filtro     = isset($post['filtro']) ? $post['filtro'] : '';

            $this->modelUsuarios->atributos = array('id'=> $filtro,'nombre'=> $filtro,'correo'=> $filtro,'usuario'=> $filtro,'telefono'=> $filtro);
            $resultado = $this->modelUsuarios->buscadorUsuarios();
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);	// If no records "No Content" status
        }

        public function unicoUsuario(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"),true);
            $id         = isset($post['id']) ? (int)$post['id'] : 0;

            if(empty($id) || $id == 0){
                $this->rest->response($this->helper->json(array('mensaje'=>'estás perdido?')),204);
            }

            $this->modelUsuarios->atributos = array('id'=> $id);
            $resultado = $this->modelUsuarios->unicoUsuario();
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);	// If no records "No Content" status
        }

        private function todosUsuarios(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $usuarios = $this->modelUsuarios->todosUsuarios();
            if(isset($usuarios)){
                $this->rest->response($this->helper->json(array('resultado'=>$usuarios)), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);	// If no records "No Content" status
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

            $filename = $_FILES['file']['name'];
            $destination = '../images/' . $filename;
            move_uploaded_file( $_FILES['file']['tmp_name'] , $destination );

            if(empty($datos)){
                $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);
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
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);
        }

        private function crearUsuario(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $datos      = json_decode(file_get_contents("php://input"),true);
            $usuario    = isset($datos['usuario']['usuario']) ? $datos['usuario']['usuario'] : '';
            $imagen     = isset($datos['usuario']['imagen']) ? $datos['usuario']['imagen'] : '';
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
                $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);
            }

            if(isset($usuario))    { $valores['usuario']    = $usuario; }
            if(isset($imagen))     { $valores['imagen']     = $imagen; }
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
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha creado el usuario con exito')), 200);
            }
            $this->response($this->helper->json(array('mensaje'=>'sin valor')),204);
        }

        private function eliminarUsuario(){
            if($this->rest->get_request_method() != "DELETE"){
                $this->rest->response('',406);
            }
            $id = isset($this->rest->_request['id']) ? (int)$this->rest->_request['id'] : 0;
            if($id > 0){
                $this->modelUsuarios->atributos = array('id' => $id);
                $resultado = $this->modelUsuarios->eliminarUsuario();
                $success = array('status' => "Success", "mensaje" => $id." Successfully deleted one record.".$resultado);
                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response($id.'',204);	// If no records "No Content" status
            }
        }



        /**
         * CATEGORIAS
         */

        public function unicaCategoria(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"),true);
            $id         = isset($post['id']) ? (int)$post['id'] : 0;

            if(empty($id) || $id == 0){
                $this->rest->response($this->helper->json(array('mensaje'=>'estás perdido?')),204);
            }

            $this->modelCategorias->atributos = array('id'=> $id);
            $resultado = $this->modelCategorias->unicaCategoria();
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);	// If no records "No Content" status
        }

        private function todasCategorias(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $categorias = $this->modelCategorias->todasCategorias();
            if(isset($categorias)){
                $this->rest->response($this->helper->json(array('resultado'=>$categorias)), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);	// If no records "No Content" status
        }

        private function actualizarCategoria(){
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
                $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);
            }

            if(isset($titulo))     { $valores['titulo']     = $titulo; }
            if(isset($slug))       { $valores['slug']       = $slug; }

            $this->modelCategorias->atributos = array('id'=>$id);
            $this->modelCategorias->setatributos = $valores;
            $resultado = $this->modelCategorias->actualizarCategoria();

            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha actualizado con exito')), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);
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
                $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);
            }

            if(isset($titulo))     { $valores['titulo']     = $titulo; }
            if(isset($slug))       { $valores['slug']       = $slug; }

            $this->modelCategorias->atributos = $valores;
            $resultado = $this->modelCategorias->crearCategoria();
            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha creado el usuario con exito')), 200);
            }
            $this->response($this->helper->json(array('mensaje'=>'sin valor')),204);
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
                $this->rest->response($id.'',204);	// If no records "No Content" status
            }
        }

        /**
         * MENU
         */

        private function getMenu(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $enlace = $this->modelMenu->enlacesMenu();
            if(isset($enlace)){
                $this->rest->response($this->helper->json(array('resultado'=>$enlace)), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);	// If no records "No Content" status
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
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);	// If no records "No Content" status
        }



        /**
         * PAGINAS
         */

        public function unicaPagina(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $post = json_decode(file_get_contents("php://input"),true);
            $id         = isset($post['id']) ? (int)$post['id'] : 0;

            if(empty($id) || $id == 0){
                $this->rest->response($this->helper->json(array('mensaje'=>'estás perdido?')),204);
            }

            $this->modelPaginas->atributos = array('id'=> $id);
            $resultado = $this->modelPaginas->unicaPagina();
            if(isset($resultado)){
                $this->rest->response($this->helper->json($resultado), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);	// If no records "No Content" status
        }

        private function todasPaginas(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $categorias = $this->modelPaginas->todasPaginas();
            if(isset($categorias)){
                $this->rest->response($this->helper->json(array('resultado'=>$categorias)), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);	// If no records "No Content" status
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
                $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);
            }

            if(isset($titulo))     { $valores['titulo']     = $titulo; }
            if(isset($slug))       { $valores['slug']       = $slug; }

            $this->modelPaginas->atributos = array('id'=>$id);
            $this->modelPaginas->setatributos = $valores;
            $resultado = $this->modelPaginas->actualizarPagina();

            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha actualizado con exito')), 200);
            }
            $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);
        }

        private function crearPagina(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }

            $datos      = json_decode(file_get_contents("php://input"),true);
            $titulo     = isset($datos['categoria']['titulo']) ? $datos['categoria']['titulo'] : '';
            $slug       = isset($datos['categoria']['slug']) ? $datos['categoria']['slug'] : '';

            $valores = [];

            if(empty($datos)){
                $this->rest->response($this->helper->json(array('mensaje'=>'sin valor')),204);
            }

            if(isset($titulo))     { $valores['titulo']     = $titulo; }
            if(isset($slug))       { $valores['slug']       = $slug; }

            $this->modelPaginas->atributos = $valores;
            $resultado = $this->modelPaginas->crearPagina();
            if(isset($resultado)){
                $this->rest->response($this->helper->json(array('mensaje'=>'Se ha creado el usuario con exito')), 200);
            }
            $this->response($this->helper->json(array('mensaje'=>'sin valor')),204);
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
                $this->rest->response($id.'',204);	// If no records "No Content" status
            }
        }


        /**
         * DEMOS
         */


        public function getUltimosArticulos(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $cantidad = (int)$this->rest->_request['cantidad'];

            $articulos = $this->demo->getUltimosArticulos($cantidad);

            if(isset($articulos)){
                $this->rest->response($this->helper->json($articulos), 200);
            }
            $this->rest->response($this->helper->json(array('resultado'=>'sin valor')),204);	// If no records "No Content" status
        }

        public function getUltimasNoticias(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $cantidad = (int)$this->rest->_request['cantidad'];

            $noticias = $this->demo->getUltimasNoticias($cantidad);

            if(isset($noticias)){
                $this->rest->response($this->helper->json($noticias), 200);
            }
            $this->rest->response($this->helper->json(array('resultado'=>'sin valor')),204);	// If no records "No Content" status
        }

        public function getArticulosCategoria(){
            if($this->rest->get_request_method() != "GET"){
                $this->rest->response('',406);
            }

            $cantidad = (int)$this->rest->_request['cantidad'];

            $articulos = $this->demo->getArticulosCategoria($cantidad);

            if(isset($articulos)){
                $this->rest->response($this->helper->json($articulos), 200);
            }
            $this->rest->response($this->helper->json(array('resultado'=>'sin valor')),204);	// If no records "No Content" status
        }


        /**
         * FIN DEMOS
         */


        //PAGINAS
        public function getPortada(){
            if($this->rest->get_request_method() != "POST"){
                $this->rest->response('',406);
            }
            $datos = json_decode(file_get_contents("php://input"),true); //(int)$this->rest->_request['id'];
            $portada = $this->seleccionar_pagina_by('pagina', array('pagina_tipo' => $datos['tipo']));
            if(isset($portada)){
                $this->rest->response($this->helper->json($portada), 200);
            }
            $this->rest->response($this->helper->json(array('resultado'=>'sin valor')),204);	// If no records "No Content" status
        }



        public function crearPaginaDEMO(){
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

                $success = array('status' => "éxito",
                    'datos' => array($idpost, $valores, $metas1, $metas2));

                $this->rest->response($this->helper->json($success),200);
            }else{
                $this->rest->response('',204);	//"No Content" status
            }
        }

        public function editarPaginaDEMO(){
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

                $success = array('status' => "éxito",
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
                $success = array('status' => "Success", "msg" => "Actualización éxitosa.");
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
            $this->where = $parametros;
            $this->model_get(tbl_usuarios);
            return $this->resultado;
        }
        /*
        private function insertar($tipo= '', $valores = '', $meta = ''){
            $tabla = $this->helper->tipo_tabla($tipo);
            $tablameta = $this->helper->tipo_tabla('paginameta');
            $this->model_insertar($tabla, $valores);
            return $this->resultado;
        }*/
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
        private function insertar_meta($idpost, $meta = ''){
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
        }
       /* private function eliminar($parametros = array()){
            $this->where = $parametros;
            $this->model_borrar(tbl_usuarios);
            return $this->resultado;
        }
*/


    }