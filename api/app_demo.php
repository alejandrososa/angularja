<?php

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
        $datos = array();
        $y = 0;
        
    
        for ($i = 0, $total = $cantidad; $i < $total; $i ++){
            $datos[$i] = array(
                $columnas[0] => isset($valores[0][$y]) ? $valores[0][$y] : null,
                $columnas[1] => isset($valores[1][$y]) ? $valores[1][$y] : null,
                $columnas[2] => isset($valores[2][$y]) ? $valores[2][$y] : null
            );
    
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
    
}

//demo
/**
$d = new Demo();

echo '<pre>';
echo json_encode($d->getUltimosArticulos(), JSON_PRETTY_PRINT);
echo '</pre>';
*/
?>
