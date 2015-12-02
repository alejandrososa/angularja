<?php

namespace Api;

class Demo
{
    private $datos = array();
    
    // TODO - Insert your code here
    function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    /**
     * Duplicar contenido
     * @param array $columnas
     * @param array $valores
     * @param int $cantidad
     * @return array
     */
    private function duplicar($columnas, $valores, $cantidad){
        $cantidad = isset($cantidad) ? $cantidad : 2;
        $datos = $fila = array();
        $y = 0;
        
    
        for ($i = 0, $total = $cantidad; $i < $total; $i ++){
            
            if(isset($columnas[0])){
                $fila[$columnas[0]] = isset($valores[0][$y]) ? $valores[0][$y] : null;
            }
            if(isset($columnas[1])){
                $fila[$columnas[1]] = isset($valores[1][$y]) ? $valores[1][$y] : null;
            }
            if(isset($columnas[2])){
                $fila[$columnas[2]] = isset($valores[2][$y]) ? $valores[2][$y] : null;
            }
            if(isset($columnas[3])){
                $fila[$columnas[3]] = isset($valores[3][$y]) ? $valores[3][$y] : null;
            }
            if(isset($columnas[4])){
                $fila[$columnas[4]] = isset($valores[4][$y]) ? $valores[4][$y] : null;
            }
            if(isset($columnas[5])){
                $fila[$columnas[5]] = isset($valores[5][$y]) ? $valores[5][$y] : null;
            }
            if(isset($columnas[6])){
                $fila[$columnas[6]] = isset($valores[6][$y]) ? $valores[6][$y] : null;
            }
            if(isset($columnas[7])){
                $fila[$columnas[7]] = isset($valores[7][$y]) ? $valores[7][$y] : null;
            }
            
            
            $datos[$i] = $fila;
            
            
            /*$datos[$i] = array(
                $columnas[0] => isset($valores[0][$y]) ? $valores[0][$y] : null,
                $columnas[1] => isset($valores[1][$y]) ? $valores[1][$y] : null,
                $columnas[2] => isset($valores[2][$y]) ? $valores[2][$y] : null,
                $columnas[3] => isset($valores[3][$y]) ? $valores[3][$y] : null,
                $columnas[4] => isset($valores[4][$y]) ? $valores[4][$y] : null,
                $columnas[5] => isset($valores[5][$y]) ? $valores[5][$y] : null,
                $columnas[6] => isset($valores[6][$y]) ? $valores[6][$y] : null,
                $columnas[7] => isset($valores[7][$y]) ? $valores[7][$y] : null
            );*/
    
            $y++;
            if($y == 2){ $y = 0; }
        }
    
        return $datos;
    }
    
    /**
     * Selecciona ultimos articulos
     * @param int $cantidad
     * @return array 
     */
    public function getUltimosArticulos($cantidad){
        
        $claves = array(
            'titulo',
            'texto',
            'url'
        );
    
        $titulos = array(
            'Gulf spill claims chief responds to BP complaints',
            'Tech jobs: Minorities have degrees, but don’t get hired',
        );
    
        $textos = array(
            "Plaintiffs' lawyers Wednesday questioned whether BP was leveling outrageous and unfounded...",
            "SAN FRANCISCO – Top universities turn out black and Hispanic computer science and computer..."
        );
        

        $valores[0] = $titulos;
        $valores[1] = $textos;
        $valores[2] = '';
        
        $this->datos = $this->duplicar($claves, $valores, $cantidad);
        
        return $this->datos;
    }
    
    /**
     * Selecciona ultimos articulos
     * @param int $cantidad
     * @return array
     */
    public function getUltimasNoticias($cantidad){
    
        $claves = array(
            'titulo',
            'texto',
            'imagen'
        );
    
        $titulos = array(
            'Gulf spill claims chief responds to BP complaints',
            'Tech jobs: Minorities have degrees, but don’t get hired',
        );
    
        $textos = array(
            "Plaintiffs' lawyers Wednesday questioned whether BP was leveling outrageous and unfounded...",
            "SAN FRANCISCO – Top universities turn out black and Hispanic computer science and computer..."
        );
        
        $enlaces = array(
            "assets/plantillas/solido/images/photos/image-11.jpg",
            "assets/plantillas/solido/images/photos/image-12.jpg",
            "assets/plantillas/solido/images/photos/image-13.jpg"
        );
        
        
    
    
        $valores[0] = $titulos;
        $valores[1] = $textos;
        $valores[2] = $enlaces;
    
        $this->datos = $this->duplicar($claves, $valores, $cantidad);
    
        return $this->datos;
    }
    
    /**
     * Selecciona articulos categoria
     * @param int $cantidad
     * @return array
     */
    public function getArticulosCategoria($cantidad){
    
        $claves = array(
            'categoria',
            'titulo',
            'texto',
            'imagen',
            'fecha',
            'enlace',
            'autor',
            'comentarios',
        );
    
        $categoria = array(
            'categoria 1','categoria 2'
        );
        
        $titulos = array(
            'Duis mollis magna porta ipsum eget feugiat',
            'Sed vehicula justo ut sem auctor sagittis',
        );
    
        $textos = array(
            "Vivamus auctor quam nec mauris commodo laoreet. Nam ut metus elementum, pharetra diam sed, rhoncus tortor. Sed vehicula justo ut sem auctor sagittis. Etiam quis",
            "Vivamus auctor quam nec mauris commodo laoreet. Nam ut metus elementum, pharetra diam sed, rhoncus tortor. Sed vehicula justo ut sem auctor sagittis. Etiam quis",
        );
        
        $imagen = array(
            "assets/plantillas/solido/images/photos/image-29.jpg",
            "assets/plantillas/solido/images/photos/image-29.jpg"
        );
        
        $fechas = array(
            "16, Oct, 2015",
            "21, Oct, 2015",
        );
        
        $enlaces = array(
            "#", "#"
        );
        
        $autor = array(
            "Joe Doe",
            "Joe Doe"
        );
        
        $comentarios = array(
            "7", "5"
        );
    
    
    
        $valores[0] = $categoria;
        $valores[1] = $titulos;
        $valores[2] = $textos;
        $valores[3] = $imagen;
        $valores[4] = $fechas;
        $valores[5] = $enlaces;
        $valores[6] = $autor;
        $valores[7] = $comentarios;
        
        $this->datos = $this->duplicar($claves, $valores, $cantidad);
    
        return $this->datos;
    }
    
    /**
     * Selecciona articulos categoria
     * @param int $cantidad
     * @return array
     */
    public function getArticulosCategoria2($cantidad){
    
        $claves = array(
            'categoria',
            'titulo',
            'texto',
            'imagen',
            'fecha',
            'enlace',
            'autor',
            'comentarios',
        );
    
        $categoria = array(
            'categoria 1','categoria 2'
        );
    
        $titulos = array(
            'Duis mollis magna porta ipsum eget feugiat',
            'Sed vehicula justo ut sem auctor sagittis',
        );
    
        $textos = array(
            "Vivamus auctor quam nec mauris commodo laoreet. Nam ut metus elementum, pharetra diam sed, rhoncus tortor. Sed vehicula justo ut sem auctor sagittis. Etiam quis",
            "Vivamus auctor quam nec mauris commodo laoreet. Nam ut metus elementum, pharetra diam sed, rhoncus tortor. Sed vehicula justo ut sem auctor sagittis. Etiam quis",
        );
    
        $imagen = array(
            "assets/plantillas/solido/images/photos/image-29.jpg",
            "assets/plantillas/solido/images/photos/image-29.jpg"
        );
    
        $fechas = array(
            "16, Oct, 2015",
            "21, Oct, 2015",
        );
    
        $enlaces = array(
            "#", "#"
        );
    
        $autor = array(
            "Joe Doe",
            "Joe Doe"
        );
    
        $comentarios = array(
            "7", "5"
        );
    
    
    
        $valores[0] = $categoria;
        $valores[1] = $titulos;
        $valores[2] = $textos;
        $valores[3] = $imagen;
        $valores[4] = $fechas;
        $valores[5] = $enlaces;
        $valores[6] = $autor;
        $valores[7] = $comentarios;
    
        $this->datos = $this->duplicar($claves, $valores, $cantidad);
    
        return $this->datos;
    }
    
}

//demo
/**
$d = new Demo();

echo '<pre>';
echo json_encode($d->getUltimosArticulos(), JSON_PRETTY_PRINT);
echo '</pre>';
*/
?>
