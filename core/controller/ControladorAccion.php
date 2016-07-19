<?php
require_once RAIZ.'Config.php';
require_once RAIZ.'resources/controlador/ControladorGenerico.php';

/**
 * Clase abstracta que implementa los metodos necesarios para
 * gestionar las sesiones y renderisar las paginas
 * Nota: Esta clase se utiliza cuando no se tienen que remplazar variables en la vista
 */
abstract class ControladorAccion extends ControladorGenerico {
    
     abstract function setPermisos(); //ingresar los permisos de loa pagina
     abstract function ejecutar(); //funcion que ejecutar las acciones necesarias
     abstract function getRedireccion(); //funcion que obtiene la pagina para redireccion
     
     function __construct() {      
         parent::__construct();
     }
     

     /**
      * Verifica la session y redenriza o caso contrario
      * envia a la pagina principal definido como index
      */
    public function renderizar()
    {
              
        if($this->verificarSession())
        {
            $this->ejecutar();
        }
        else
        {
             $direccion='Location:';
             $direccion=$direccion.$this->configuracion->sitename."index.html";
             header($direccion);
        }                
        
    }    
    
    /**
     * Me perimite almacenar varialbes de session
     * @param type $clave
     * @param type $obj
     * @return boolean
     */
   public function setVarSession($clave,$obj)
   {
       if (session_status() == PHP_SESSION_NONE) 
       {
            session_start();
       }
       $_SESSION[$clave]=$obj;
       return true;
   }
   
   /**
    * Me permite recuperar varaibles de session
    * @param type $clave
    * @return type
    */
   public function getVarSession($clave)
   {
       if (session_status() == PHP_SESSION_NONE) 
       {
            session_start();
       }
       if(isset($_SESSION[$clave]))
       {
           return $_SESSION[$clave];
       }
       else
       {
           return null;
       }
       
   }

}
