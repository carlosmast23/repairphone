<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorGrabar
 *
 * @author home
 */
abstract class Controlador
{
        var $conexion;
        
        function __construct() 
        {
            $this->conectar();
        }

        public function conectar()
        {
       

        $this->conexion=new Conexion("localhost","dbnotafacil","root","1234");
       //  $this->conexion=new Conexion("mysql.hostinger.es","u783050962_notaf","u783050962_root","N49XEOlPPV");

        $this->conexion->conexion();
               
        }
        
       public function verificarSeccion($url)
        {
            session_start();
             echo $_SESSION['nick'];
             if( empty($_SESSION['nick']))
             {
                 header('Location: '.$url);
             }
             
             
        }
        
        abstract public function ejecutar();
               
                    
        
}

?>
