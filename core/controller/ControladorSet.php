<?php

require_once RAIZ.'Config.php';
require_once RAIZ.'resources/controlador/ControladorGenerico.php';

/**
 * Clase que me permite remplazar , renderizar y contralar los
 * permisos de la pagina
 * Nota: Esta clase se utiliza cuando tenga que remplazar algun
 * contenido.
 */
abstract class  ControladorSet extends ControladorGenerico
{
    protected $diccionario;
    
    /**
     * Busca los valores para remplazar en la vista
     */
    abstract function buscarValores();
    /**
     * Establece un diccionario de datos para
     * remplazar en la vista
     */
    abstract function setDiccionario();
    /**
     * Establece la pagina la cual se va a remplazar
     * las variables y renderizar.
     */
    abstract function getPagina();
  //  abstract function setPermisos();
    
    function __construct() 
    {
    
        parent::__construct();
        $this->setDiccionario();
        $this->buscarValores();
        
    
    }
    

    /**
     * Remplaza y reconstruye la pagina con los
     * nuevo valores.
     */
    public function renderizar()
    {
        
        $pagina=  file_get_contents($this->getPagina());        
        $inicio=strpos($pagina,"<?php");
        $fin=strpos($pagina,"?>");
        
        
        
        if($this->verificarSession())
        {
            //cambio de las variables directas
            foreach ($this->diccionario as $key => $value)
            {
                if(gettype($value)=="array")
                {
                    $pagina=$this->remplazarEstructura($pagina, $key, $value);
                           
                }
                else
                {
                    $pagina=  str_replace("[$key]", $value, $pagina);     
                }
            }   
            print $pagina;
        }
        else
        {
             //echo 
             $direccion='Location:';
             $direccion=$direccion.$this->configuracion->sitename."index.html";
             //$direccion=  $this->configuracion->$sitename;
             header($direccion);
             //echo "redireccionando ...";
        }                
        
    }    
    
    /**
     * Me permite crear un sistema de etiquetado por nodos para remplazar
     * de forma secuencial estructural.
     * 
     * @param type $html
     * @param type $nombre
     * @param type $diccionario
     * @return type
     */
    private function remplazarEstructura($html,$nombre,$diccionario)
    {
       // echo $nombre;
        //$nombre="columna";
        $apertura="<!--estructura=".$nombre."-->";

        $cierre="<!--/estructura=".$nombre."-->";

        //echo $apertura;
        $posApertura=strpos($html,$apertura);
        $posCierre=strpos($html,$cierre);
        $tamanio=  strlen($html);

        $nuevaCadena=substr($html,$posApertura,($posCierre-$posApertura)+  strlen($cierre));
        //echo $nuevaCadena;

        $tramo=  str_replace($apertura,"",$nuevaCadena);
        $tramo=  str_replace($cierre,"",$tramo);

       // echo $tramo;
        //echo "-> $posApertura <- $posCierre";

              //echo $diccionario["columna"]["fila2"][2];
        //REMPLAZAR LOS VALORES Y GENERAR EL NUEVO COGIDO

        $clave;
        foreach ($diccionario as $key => $arreglo)
        {
              $clave=$key;
              break;
        } 

        $nuevaCorte="";

        for ($i=0;$i<count($diccionario[$clave]);$i++)
        {
            $remplazado=$tramo;
            foreach ($diccionario as $key => $arreglo)
            {
               //echo $diccionario['columna'][$key][$i]." ->";
                if(gettype($diccionario[$key][$i])=="array")
                {
                    $remplazado=$this->remplazarEstructura($remplazado,$key,$diccionario[$key][$i]);
                }
                else
                {                   
                    $remplazado=str_replace("[$key]",$diccionario[$key][$i], $remplazado);
                }
            }
            $nuevaCorte=$nuevaCorte.$remplazado;
            //echo "</br>";
        }

        $paginaFinal=str_replace($nuevaCadena,$nuevaCorte,$html);
        return $paginaFinal;

        
    }    
    
}

?>
