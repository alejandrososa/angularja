<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once('app_entorno.php');
	require_once(ENTORNO.'app_global.php');
 	require_once("app_rest.php");
	require_once("app_modelo.php");
	require_once("app_sesion.php");
	require_once("app_helper.php");
	require_once("app_demo.php");

    use Lcobucci\JWT\Builder;
    use Lcobucci\JWT\ValidationData;
	
	class API extends Modelo{ //REST
		public $data      = "";
		private $sesion;
		private $rest;
		private $db       = NULL;
		private $mysqli   = NULL;
		private $helper;
		private $demo;
		
		/**
		 * Inicialización objetos
		 */
		private function init_rest(){
			$this->rest      = new Rest();
			$this->sesion    = new Session(); 
			$this->helper    = new Helper();
			$this->demo      = new Demo();
		}
		
		/**
		 * Inicialización Base de datos
		 * @abstract Modelo
		 */
		protected static function initModelo() {        
			// Aquí realizaríamos la conexión a la BBDD con el método que queramos
		}
		
		/**
		 * Llamadas a metodos dinamicamente
		 * @return response
		 */
		public function processApi(){
			$this->init_rest();
				
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
		
		
		
		public function crearPagina(){
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
		
		public function editarPagina(){
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
		private function eliminar($parametros = array()){
			$this->where = $parametros;
			$this->model_borrar(tbl_usuarios);
			return $this->resultado;
		}
		
		
		
	}
	
	// Initiiate Library
	
	$api = API::getInstance(); // new API;
	$api->processApi();
?>