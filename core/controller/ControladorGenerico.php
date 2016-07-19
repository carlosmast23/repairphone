<?php

/**
 * Clase generica que implementa todos los metodos
 * nesearios para controlar las sessiones
 */
abstract class ControladorGenerico {
    

     protected static $todos="todos";
     protected static $admin="admin";
    
     protected $configuracion;
     protected $permisos; //array que almacena los permisos de los usuarios para cada pagina
     //protected $redireccion; //pagina para redireccionar;
     
                 
     function __construct() 
     {
        $this->setPermisos();
        $this->configuracion=Config::getInstance();
     }

     
     /**
      * Variable que me permite verficar si se ha iniciado
      * alguna session
      * @return boolean
      */
     protected function verificarSession()
    {
        if(isset($_SESSION["session"]))
        {
            $correcto=false;
            foreach ($this->permisos as $valor)
            {
                echo $_SESSION["session"];
                if($_SESSION["session"]==$valor)
                {
                    $correcto=true;
                }
            }
            return $correcto;
        }
        else
        {
            foreach ($this->permisos as $valor)
            {
                if("todos"==$valor)
                {
                    return true;
                }
            }
            return false;
            
        }
        
        return false;
    }
    
    /**
     * Obtiene la configuracion del sistema
     * @return type
     */
    public function getConfiguracion()
    {
        return $this->configuracion;
    }
    
    /**'
     * Metodo para redireccionar a una url
     */
    public  function direccionar($url)
    {
        $direccion = 'Location:';
        $direccion = $direccion . $this->configuracion->getSitePath() . $url; //revisar
        //$direccion=  $this->configuracion->$sitename;
        header($direccion);
    }
    
    /**
     * Metodo que construye los mensajes del sitio web
     * @param type $titulo
     * @param type $mensaje
     * @param string $redireccion
     * @param type $tiempo
     * @param type $boton
     * @param type $imagen
     */
    public function mensaje($titulo, $mensaje,$redireccion,$tiempo,$boton,$imagen)
    {
        //controlar las imagenes
        $htmlImagen;
        switch ($imagen)
        {
            case 1:$htmlImagen="mensaje.png";
                    break;
            
            case 2:$htmlImagen="error.png";
                    break;
            
        }
        
        //controlar el boton
        $htmlBoton="";
        if($boton)
        {
            $htmlBoton="button";
        }
        else
        {
            $htmlBoton="hidden";            
        }
        
        if(gettype($redireccion)=="boolean")
        {
            $redireccion="";
        }
        
        $direccion = 'Location:';
        $direccion = $direccion . $this->configuracion->getSitePath()
                ."mensajes/mensaje.php?"
                . "titulo=$titulo"
                . "&mensaje=$mensaje"
                . "&tiempo=$tiempo"
                . "&boton=$htmlBoton"
                . "&img=$htmlImagen"
                . "&redireccion=$redireccion";
        header($direccion);
    }
    
    /**
     * Obtiene el path del sitio web
     * @param type $url
     * @return type
     */
    public function getPathAbsoluta($url)
    {
        return $this->configuracion->getSitePath() . $url;
    }
    
    /**
     * Metodo que me permite buscar un directorio
     * dentro del sitio web
     * @return boolean
     */
    static public function buscarDirectorio()
    {
        //$path=realpath(dirname(__FILE__));
        $path=str_replace('\\', '/',dirname(__FILE__));
        $archivo="/Main.php";

        $condicion=true;
        while($condicion)
        {
            $dirFinal=$path.$archivo;
            echo $dirFinal."</br>";
            if (file_exists($dirFinal))
            {
                return realpath($dirFinal);
            }
            else
            {
                $respaldo=$path;
                $path=rtrim(dirname($path). PHP_EOL);
                if($respaldo==$path)
                {
                    return false;
                }
            }
        }

    }
}
