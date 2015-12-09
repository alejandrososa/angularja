<?php
namespace Api;

use Api\Entorno;
use \PDO;
use App\Config;


abstract class Modelo{
	
	private $_dbusuario;
	private $_dbclave;
	private $_dbHost;
	private $_dbbd;
	private $config;
	protected $query;
	protected $tabla;	
	protected $where;	
	protected $resultado;
	protected $filas = array();
	private $_cnx;
	private $pdo;
	private static $_instancias = array();
	/*abstract protected function agregar();
	abstract protected function seleccionar();
	abstract protected function seleccionar_by();
	abstract protected function editar();
	abstract protected function eliminar();*/
		

 	//SINGLETON
    final private function  __construct() {       
        // Por si acaso, controlamos que no exista ya
        if(array_key_exists(get_called_class(), self::$_instancias)) {
            throw new Exception('Ya existe una instancia de '.get_called_class());
        }
        static::initModelo();
		$this->_conexion();		
    }
	public function  __destruct() {
	    $this->_cerrar_conexion();
    }
    // Método abstracto para initModelo cada singleton
    abstract protected static function initModelo();
 
    final public static function getInstance() {
       $class = get_called_class();
       if(!array_key_exists($class, self::$_instancias)) {
           self::$_instancias[$class] = new $class();
       }
       return self::$_instancias[$class];
    }

    final public function __clone() {
        throw new Exception('Class tipo ' . get_called_class() . ' no puede ser clonada');
    }
	//FIN SINGLETON
	
	
	private function config_load($nombre) {		
		$configuration = array();
		if (!file_exists(''.$nombre . '.php')){
			die('El archivo ' . $nombre . '.php no existe.');
		}
	
		require('' . $nombre . '.php');
			
		if (!isset($config) OR !is_array($config)) //' . dirname(__FILE__) . '
			die('The file ' . $nombre . '.php file does not appear to be formatted correctly.');
				
		if (isset($config) AND is_array($config))
			$configuration = array_merge($configuration, $config);
					
		return $configuration;
	}
	
	
	private function _conexion(){
		//$entorno = new Entorno();
		//self::$config = $this->config_load($entorno->getEntorno().'app_config');

		$configApp = new Config();
		$this->config = $configApp->getBaseDatos();

		if (empty($this->config['driver']))
			die('Por favor, establece un controlador de base de datos valido '.$this->config['driver']);
				
		$driver = strtoupper($this->config['driver']);
		
		switch ($driver) {

			case 'MYSQL':
				$this->_dbHost      = $this->config['host'];
				$this->_dbbd        = $this->config['nombre'];
				$this->_dbusuario   = $this->config['usuario'];
				$this->_dbclave     = $this->config['clave'];
				
				$this->pdo = new PDO('mysql:host='.$this->_dbHost.'; dbname='.$this->_dbbd, $this->_dbusuario, $this->_dbclave);  
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->exec("SET CHARACTER SET utf8"); 
				$this->_cnx = $this->pdo;		
			break;

			default:
				die('Base de datos no soporta: ' . $this->config['driver']);
				
		}
	}

	/**
	* @desc - cierra la conexión con la base de datos
	*/
	private function _cerrar_conexion(){
		$this->_cnx = null;
	}
	


	/**
	* @desc - consulta dinámica con pdo, de ámbito protegido, de esta forma sus clases hijas podrán utilizarlo
	* @access protected 
	* @param $valores - array con los datos
	* @param $insert - bool si es false devuelve resultados, en otro caso elimina, actualiza o inserta
	*/
	protected function dynamic_query($valores, $insert = false){
		$this->_conexion();
		$resultado = $this->_cnx->prepare($this->query);

		foreach($valores as $key => $valor){
            if(is_int($valor)){ 
            	$param = PDO::PARAM_INT; 
            }
            elseif(is_bool($valor)){ 
            	$param = PDO::PARAM_BOOL; 
            }
            elseif(is_null($valor)){ 
            	$param = PDO::PARAM_NULL; 
            }
            elseif(is_string($valor)){ 
            	$param = PDO::PARAM_STR; 
            }
            else{ 
            	$param = FALSE;
            }

            if($param){
            	$resultado->bindValue(":$key",$valor,$param);
            }
        }

        $resultado->execute();

        if($insert == false){
	        if($resultado->rowCount() > 1){
	        	$this->filas = $resultado->fetchAll();
	        }else if($resultado->rowCount() == 1){
	        	$this->filas = $resultado->fetch();
	        }
	    }

        $resultado = null;
        $this->_cerrar_conexion();
	}

	protected function simple_query() 
	{ 
		$resultado = $this->_cnx->prepare($this->query);
        $resultado->execute();
        //$this->filas = $resultado->fetchAll(PDO::FETCH_ASSOC);
		$this->resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $resultado = null;
	}
	
	protected function model_get($tabla) {
		$sql = "Select * from " . $tabla . " ";			
		$counter = 0;

		if(!empty($this->where)){
			foreach ($this->where as $key => $value) {
				if ($counter == 0) {
					$sql .= "WHERE {$key} = '".$value."' ";
				} else {
					$sql .= "AND {$key} = '".$value."' ";
				}
				$counter++;
			}
		}

		//echo $sql;
		$resultado = $this->_cnx->query($sql);
      	$resultado->execute();
        $this->resultado = $resultado->fetch(PDO::FETCH_ASSOC);
		return $this->resultado;
	}
	
	
	
	protected function model_get_pagina($tabla){
		//SELECT * FROM `wsp_paginas` as pagina inner join wsp_paginasmeta as meta on pagina.id = meta.post_id
		//$sql = "SELECT * FROM ".$tabla." as pagina inner join wsp_paginasmeta as meta on pagina.id = meta.post_id ";			
		$sql = "SELECT * FROM ".$tabla." ";			
		$counter = 0;
		
		foreach ($this->where as $key => $value) {
			if ($counter == 0) {				
				$sql .= "WHERE {$key} = '".$value."' ";				
			} else {				
				$sql .= "AND {$key} = '".$value."' ";					
			}									
			$counter++;			
		}
		//echo $sql;
		$stmfilas = $this->_cnx->query($sql);
      	$stmfilas->execute();
		$filas = $stmfilas->fetchAll(PDO::FETCH_ASSOC);
		foreach ($filas as $row) {
			
			//razones
			$idpagina = isset($row['ID']) ? intval($row['ID']) : 0;			
			$stmrazones = $this->_cnx->prepare("SELECT meta_value FROM wsp_paginasmeta 
											where post_id = ".$idpagina."  and meta_key ='razones'");
			$stmrazones->execute();
			$razones = $stmrazones->fetch();
			
			//subtitulo		
			$stmsubtitulo = $this->_cnx->prepare("SELECT meta_value FROM wsp_paginasmeta 
											where post_id = ".$idpagina."  and meta_key ='subtitulo'");
			$stmsubtitulo->execute();
			$subtitulo = $stmsubtitulo->fetch();
			
			
			
			/*$pagina = new stdClass();			
			$pagina->id = isset($row['id']) ? $row['id'] : '';
			$pagina->titulo =isset($row['pagina_titulo']) ? $row['pagina_titulo'] : '';
			$pagina->subtitulo = $subtitulo['meta_value'];
			$pagina->descripcion = isset($row['pagina_contenido']) ? $row['pagina_contenido'] : '';
			$pagina->razones = $razones['meta_value'];
			*/
					
					
						
			$pagina = array(
				'id' => isset($idpagina) ? $idpagina : '',
				'titulo' => isset($row['pagina_titulo']) ? $row['pagina_titulo'] : '',
				'subtitulo' => $subtitulo['meta_value'],
				'descripcion' => isset($row['pagina_contenido']) ? $row['pagina_contenido'] : '',
				'razones' => json_decode($razones['meta_value']),
				//'razones' => $razones['meta_value'],
				
				/*'servicios' => array(
					'titulo' => $row['Nombre del servicio'],
					'descripcion' => $row['Descripción del servicio'],
					'imagen' => $row[''],
				),
				'clientes' => array(
					'nombre' => $row['Nombre del Cliente'],
					'imagen' => $row[''],
				),
				'frase' => $row[''],
				'llamadaacion' => $row['Estudio Gratis'],
				'llamadaaccionfrase' => $row['Te damos cita y resultados inmediatos'],
				'llamadaaccionboton' => $row['Reservar Gratis'],
				'llamadaaccionurl' => $row['#'],
				'customerNumber'	=> isset($row['uid']) ? $row['uid'] : '', 
				'customerName'		=> isset($row['name']) ? $row['name'] : '',
				'email'				=> isset($row['email']) ? $row['email'] : '',
				'address'			=> isset($row['address']) ? $row['address'] : '',
				'city'				=> isset($row['city']) ? $row['city'] : '',
				//'state'				=> $row['state'],
				//'postalCode'		=> $row['postalCode'],
				//'country'			=> $row['country']
				*/
				
			);
		}
		
		if (isset($pagina)){
			$this->resultado = $pagina;//array('data' => $pagina);
			return json_encode($this->resultado);
		}
				
			//$this->resultado = $pagina;//$resultadopagina; //pagina;
			//return json_encode($this->resultado, JSON_NUMERIC_CHECK);//$this->resultado;
	}
	
	protected function model_actualizar_pagina($tabla, $valores){	
		$sql = "SELECT * FROM ".$tabla." ";			
		$counter = 0;
		
		foreach ($this->where as $key => $value) {
			if ($counter == 0) {				
				$sql .= "WHERE {$key} = '".$value."' ";				
			} else {				
				$sql .= "AND {$key} = '".$value."' ";					
			}									
			$counter++;			
		}
		//echo $sql;
		$stmfilas = $this->_cnx->query($sql);
      	$stmfilas->execute();
		$filas = $stmfilas->fetchAll(PDO::FETCH_ASSOC);
		foreach ($filas as $row) {
			
			//razones
			$idpagina = isset($row['ID']) ? intval($row['ID']) : 0;			
			$stmrazones = $this->_cnx->prepare("SELECT meta_value FROM wsp_paginasmeta 
											where post_id = ".$idpagina."  and meta_key ='razones'");
			$stmrazones->execute();
			$razones = $stmrazones->fetch();
			
			//subtitulo		
			$stmsubtitulo = $this->_cnx->prepare("SELECT meta_value FROM wsp_paginasmeta 
											where post_id = ".$idpagina."  and meta_key ='subtitulo'");
			$stmsubtitulo->execute();
			$subtitulo = $stmsubtitulo->fetch();
					
						
			$pagina = array(
				'id' => isset($idpagina) ? $idpagina : '',
				'titulo' => isset($row['pagina_titulo']) ? $row['pagina_titulo'] : '',
				'subtitulo' => $subtitulo['meta_value'],
				'descripcion' => isset($row['pagina_contenido']) ? $row['pagina_contenido'] : '',
				'razones' => json_decode($razones['meta_value']),
				//'razones' => $razones['meta_value'],
				
				/*'servicios' => array(
					'titulo' => $row['Nombre del servicio'],
					'descripcion' => $row['Descripción del servicio'],
					'imagen' => $row[''],
				),
				'clientes' => array(
					'nombre' => $row['Nombre del Cliente'],
					'imagen' => $row[''],
				),
				'frase' => $row[''],
				'llamadaacion' => $row['Estudio Gratis'],
				'llamadaaccionfrase' => $row['Te damos cita y resultados inmediatos'],
				'llamadaaccionboton' => $row['Reservar Gratis'],
				'llamadaaccionurl' => $row['#'],
				'customerNumber'	=> isset($row['uid']) ? $row['uid'] : '', 
				'customerName'		=> isset($row['name']) ? $row['name'] : '',
				'email'				=> isset($row['email']) ? $row['email'] : '',
				'address'			=> isset($row['address']) ? $row['address'] : '',
				'city'				=> isset($row['city']) ? $row['city'] : '',
				//'state'				=> $row['state'],
				//'postalCode'		=> $row['postalCode'],
				//'country'			=> $row['country']
				*/
				
			);
		}
		
		if (isset($pagina)){
			$this->resultado = $pagina;//array('data' => $pagina);
			return json_encode($this->resultado);
		}
	}
	
	protected function model_get_all_users($tabla){
		$resultado = $this->_cnx->query("SELECT * FROM " . $tabla . "");
		$usuarios = array();
		foreach ($resultado as $row) {
						
			$usuarios[] =  array(
				/*'uid'	=> $row['uid'], 
				'name'	=> $row['name'],
				'email'	=> $row['email'],
				'phone'	=> $row['phone']*/
				'customerNumber'	=> isset($row['uid']) ? $row['uid'] : '', 
				'customerName'		=> isset($row['name']) ? $row['name'] : '',
				'email'				=> isset($row['email']) ? $row['email'] : '',
				'address'			=> isset($row['address']) ? $row['address'] : '',
				'city'				=> isset($row['city']) ? $row['city'] : '',
				//'state'				=> $row['state'],
				//'postalCode'		=> $row['postalCode'],
				//'country'			=> $row['country']
				
				
			);
							
        }
		
		if (isset($usuarios)){
			$this->resultado = $usuarios;
			return json_encode($this->resultado, JSON_NUMERIC_CHECK);
		}
	}
	
	protected function model_contador_filas() {
		$resultado = $this->_cnx->query($this->query)->rowCount();
		$this->resultado = $resultado;			
    }
	

	

	
	public function model_insertar_meta($id, $tabla, $valores) {
		try {				
			//añado el id de la pagina al array meta
			$postid = array('post_id' => $id);
			$metas =  array_merge($valores, $postid);
			
			foreach ($metas as $key => $meta){
				$campometa[] = $key . " = :" . $key;
			}

			$sqlmetas = "INSERT INTO " . $tabla . " SET " . implode(", ", $campometa);
			$stmtmeta = $this->_cnx->prepare($sqlmetas);
						
			foreach ($metas as $key => $meta){
				if(is_int($meta)){	$parammeta = PDO::PARAM_INT; }
				elseif(is_bool($meta)){ $parammeta = PDO::PARAM_BOOL; }
				elseif(is_null($meta)){ $parammeta = PDO::PARAM_NULL; }
				elseif(is_string($meta)){ $parammeta = PDO::PARAM_STR; }
				else{ $parammeta = FALSE; }
	
				if($parammeta){ $stmtmeta->bindValue(":" . $key,$meta,$parammeta); }
				//$stmt->bindValue(':' . $key, $valor);
			}
			
			$stmtmeta->execute();	
			
		} catch (PDOException $exception) {
			//die($exception->getMessage());
			$this->resultado = $exception->getMessage();
			//$this->resultado = $sqlmetas;
			//$this->resultado = false;						
		}
		
		return $this->resultado;					
	}
	
	public function model_actualizar_meta($id, $tabla, $valores) {
		try {				
			//añado el id de la pagina al array meta
			$postid = array('post_id' => $id);
			$metas =  array_merge($valores, $postid);
			
			foreach ($metas as $key => $meta){
				$campometa[] = $key . " = :" . $key;
			}

			$sqlmetas = "UPDATE " . $tabla . " SET " . implode(", ", $campometa);
			$stmtmeta = $this->_cnx->prepare($sqlmetas);
						
			foreach ($metas as $key => $meta){
				if(is_int($meta)){	$parammeta = PDO::PARAM_INT; }
				elseif(is_bool($meta)){ $parammeta = PDO::PARAM_BOOL; }
				elseif(is_null($meta)){ $parammeta = PDO::PARAM_NULL; }
				elseif(is_string($meta)){ $parammeta = PDO::PARAM_STR; }
				else{ $parammeta = FALSE; }
	
				if($parammeta){ $stmtmeta->bindValue(":" . $key,$meta,$parammeta); }
				//$stmt->bindValue(':' . $key, $valor);
			}
			
			$stmtmeta->execute();	
			
		} catch (PDOException $exception) {
			$this->resultado = $exception->getMessage();
			//$this->resultado = false;						
		}
		
		return $this->resultado;					
	}
	
	protected function model_actualizar($tabla, $valores) {
		foreach ($valores as $key => $valor){
			$campo[] = $key . ' = :' . $key;
		}

		$sql  = "UPDATE " . $tabla . " SET " . implode(', ', $campo) . " ";
		
		$counter = 0;
		foreach ($this->where as $key => $value) {
			if ($counter == 0) {				
				$sql .= "WHERE {$key} = :{$key} ";				
			} else {				
				$sql .= "AND {$key} = :{$key} ";	
			}									
			$counter++;			
		}
		
		$stmt = $this->_cnx->prepare($sql);
		
		foreach ($valores as $key => $valor){
			if(is_int($valor)){ 
				$param = PDO::PARAM_INT; 
			}
			elseif(is_bool($valor)){ 
				$param = PDO::PARAM_BOOL; 
			}
			elseif(is_null($valor)){ 
				$param = PDO::PARAM_NULL; 
			}
			elseif(is_string($valor)){ 
				$param = PDO::PARAM_STR; 
			}
			else{ 
				$param = FALSE;
			}
	
			if($param){
				$stmt->bindValue(':' . $key,$valor,$param);
			}
			//$stmt->bindValue(':' . $key, $valor);
		}
		
		foreach ($this->where as $key => $value){
			$stmt->bindValue(':' . $key, $value);
		}
		
		$this->resultado = $stmt->execute();
		return $this->resultado;			
	}


	
	
	
	
	
	private function array_sort($array, $on, $order=SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();
	
		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}
	
			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
				break;
				case SORT_DESC:
					arsort($sortable_array);
				break;
			}
	
			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}
	
		return $new_array;
	}









	protected function seleccion()
	{
		$resultado = $this->_cnx->prepare($this->query);
		$resultado->execute();
		return $resultado->fetchAll(PDO::FETCH_ASSOC);
	}
	protected function buscar($tabla){
		try {
			$sql = "SELECT * FROM " . $tabla . " ";
			$counter = 0;
			$columnas = array();

			if(!empty($this->where)){
				foreach ($this->where as $key => $value) {
					if ($counter == 0) {
						$sql .= "WHERE {$key} LIKE CONCAT('%', :{$key}, '%') "; //like :{$key} ";
					} else {
						$sql .= "OR {$key} LIKE CONCAT('%', :{$key}, '%') ";
					}
					$counter++;
				}
			}

			$stmt = $this->pdo->prepare($sql);

			if(!empty($this->where)) {
				foreach ($this->where as $key => $value) {
					$stmt->bindValue(':' . $key, $value);
				}
			}

			$stmt->execute();


			while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$columnas[] = $row;
			}

			//print_r($stmt);
			//die();

			if (isset($columnas)){
				$this->resultado = $columnas;
				return $this->resultado;
			}

			//return json_encode($stmt->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK);

		} catch (PDOException $exception) {

			die($exception->getMessage());

		}
	}
	protected function unico($tabla, $multiple = null){



        try {
            $sql = "SELECT * FROM " . $tabla . " ";
            $counter = 0;

            foreach ($this->where as $key => $value) {
                if ($counter == 0) {
                    $sql .= "WHERE {$key} = :{$key} ";
                    //$sql .= "WHERE {$key} = ". (is_int($value) ? $value : "'".$value."'")." ";
                } else {
                    $sql .= "AND {$key} = :{$key} ";
                }
                $counter++;
            }

            $stmt = $this->pdo->prepare($sql);

            foreach ($this->where as $key => $value)
                $stmt->bindValue(':' . $key, $value);

            $stmt->execute();

			if(!empty($multiple) && $multiple == true){
				while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
					$columnas[] = $row;
				}
				return $columnas;
			}else{
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}

            //return json_encode($stmt->fetch(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK);

        } catch (PDOException $exception) {

            die($exception->getMessage());

        }
	}
	protected function todos($tabla){
		$columnas = array();
		$resultado = $this->_cnx->query("SELECT * FROM " . $tabla);

		while ( $row = $resultado->fetchObject() ) {
			$columnas[] = $row;
		}

		if (isset($columnas)){
			$this->resultado = $columnas;
			return $this->resultado;
		}
	}
	protected function insertar($tabla, $valores) {
		try {
			foreach ($valores as $key => $valor){
				$campo[] = $key . ' = :' . $key;
			}

			$sql = "INSERT INTO " . $tabla . " SET " . implode(', ', $campo);
			$stmt = $this->_cnx->prepare($sql);

			foreach ($valores as $key => $valor){
				if(is_int($valor)){	$param = PDO::PARAM_INT; }
				elseif(is_bool($valor)){ $param = PDO::PARAM_BOOL; }
				elseif(is_null($valor)){ $param = PDO::PARAM_NULL; }
				elseif(is_string($valor)){ $param = PDO::PARAM_STR; }
				else{ $param = FALSE; }

				if($param){ $stmt->bindValue(':' . $key,$valor,$param); }
			}
			$stmt->execute();
			return $this->_cnx->lastInsertId();
			//$this->resultado = $this->_cnx->lastInsertId();

		} catch (PDOException $exception) {
			$this->resultado = false;
		}
		return $this->resultado;
	}
	protected function actualizar($tabla, $valores) {
		try {
			$campo = array();
			foreach ($valores as $key => $valor){
				$campo[] = $key . ' = :' . $key;
			}

			$sql  = "UPDATE " . $tabla . " SET " . implode(', ', $campo) . " ";

			$counter = 0;
			foreach ($this->where as $key => $value) {
				if ($counter == 0) {
					$sql .= "WHERE {$key} = :{$key} ";
				} else {
					$sql .= "AND {$key} = :{$key} ";
				}
				$counter++;
			}

			$stmt = $this->pdo->prepare($sql);

			foreach ($valores as $key => $valor){
				if(is_int($valor)){
					$param = \PDO::PARAM_INT;
				}
				elseif(is_bool($valor)){
					$param = \PDO::PARAM_BOOL;
				}
				elseif(is_null($valor)){
					$param = \PDO::PARAM_NULL;
				}
				elseif(is_string($valor)){
					$param = \PDO::PARAM_STR;
				}
				else{
					$param = FALSE;
				}

				if($param){
					$stmt->bindValue(':' . $key,$valor,$param);
				}
				//$stmt->bindValue(':' . $key, $valor);
			}

			foreach ($this->where as $key => $value){
				$stmt->bindValue(':' . $key, $value);
			}

			return $stmt->execute();
			//return $sql;

		}catch (\PDOException $exception) {
			die($exception->getMessage());
		}
	}
	protected function eliminar($table) {
		$sql = "DELETE FROM " . $table . " ";
		$counter = 0;
		foreach ($this->where as $key => $value) {
			if ($counter == 0) {
				$sql .= "WHERE {$key} = :{$key} ";
			} else {
				$sql .= "AND {$key} = :{$key} ";
			}
			$counter++;
		}
		$stmt = $this->pdo->prepare($sql);
		foreach ($this->where as $key => $value){
			$stmt->bindValue(':' . $key, $value);
		}
		$this->resultado = $stmt->execute();
		return $this->resultado;
	}

    /*public function query($statement) {
        try {
            return self::$PDO->query($statement);
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }*/

    public function row_count($statement) {
        try {
            return self::$PDO->query($statement)->rowCount();
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    public function fetch_all($statement, $fetch_style = PDO::FETCH_ASSOC) {
        try {
            return self::$PDO->query($statement)->fetchAll($fetch_style);
        }	 catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    public function fetch_row_assoc($statement) {
        try {
            return self::$PDO->query($statement)->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    public function last_insert_id() {
        return $this->_cnx->lastInsertId();
    }

    public function where($value) {
        $this->where = $value;
        return $this;
    }

    public function insert($table, $values) {

        try {
            foreach ($values as $key => $value)
                $field_names[] = $key . ' = :' . $key;

            $sql = "INSERT INTO " . $table . " SET " . implode(', ', $field_names);
            $stmt = self::$PDO->prepare($sql);

            foreach ($values as $key => $value)
                $stmt->bindValue(':' . $key, $value);

            $stmt->execute();

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    public function delete($table) {
        $sql = "DELETE FROM " . $table . " ";
        $counter = 0;

        foreach ($this->where as $key => $value) {
            if ($counter == 0) {
                $sql .= "WHERE {$key} = :{$key} ";
            } else {
                $sql .= "AND {$key} = :{$key} ";
            }
            $counter++;
        }
        $stmt = self::$PDO->prepare($sql);
        foreach ($this->where as $key => $value)
            $stmt->bindValue(':' . $key, $value);

        $stmt->execute();
    }
	
	
}?>