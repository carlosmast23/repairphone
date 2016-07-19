<?php
    function findFirstPath(){$path=str_replace('\\', '/',dirname(__FILE__));$archivo="/Config.php";$condicion=true;while($condicion){$dirFinal=$path.$archivo;if (file_exists($dirFinal))return realpath($dirFinal);else{$respaldo=$path;$path=rtrim(dirname($path). PHP_EOL);if($respaldo==$path){return false;}}}}
    require_once findFirstPath();    
?>

<?php
require_once CONTROLADOR_SET;

/**
 * Clase que genera una pagina generica para mostrar mensajes
 * del sitio web.
 */
class Controlador extends ControladorSet
{
    function __construct() 
    {
        parent::__construct();
    }

    
    public function buscarValores() {
        
        $this->diccionario["titulo"]=$_GET['titulo'];
        $this->diccionario["mensaje"]=$_GET['mensaje'];
        $this->diccionario["tiempo"]=$_GET['tiempo'];
        $this->diccionario["pagina"]=$_GET['redireccion'];
        $this->diccionario["tipo"]=$_GET['boton'];
        $this->diccionario["img"]=$_GET['img'];
       //$this->diccionario["activar"]=$_GET['activar'];
        
    }

    public function getPagina() {
        return 'mensajeVista.php';
    }

    public function setDiccionario() 
    {
         $this->diccionario= array(
           "titulo"=>"",         
           "mensaje"=>"",     
           "tiempo"=>"", 
           "tipo"=>"",
        );
    }

    public function setPermisos() {
        $this->permisos=array(
        Controlador::$todos,
        );
    }

};
(new Controlador())->renderizar();
?>