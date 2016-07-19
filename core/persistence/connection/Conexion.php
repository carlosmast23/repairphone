<?php

require_once RAIZ.'Config.php';

/**
 * Clase que gestiona la conexion a la base de datos y provee de los
 * metodos basico para ejecutar procesos y consultas.
 */
class Conexion {
    /**
     *Variable estatica que almacena una sola instancia de la conexion
     * @var type 
     */
   private static $instancia;
   
   /**
    *Host de la base de datos
    * @var type 
    */
   private $hostName;
   /**
    *Nombre de la base de datos
    * @var type 
    */
   private $dataBase;
   /**
    *Usuarioa de la base de datos
    * @var type 
    */
   private $userName;
   /**
    *Clave de la base de datos
    * @var type 
    */
   private $password;
   /**
    *Variable que contiene la conexion de esta clase con la
    * base de dato
    * Nota: esta variable no es una instancia de esta clase,
    * si no de otra clase la cual se conecta directo con la base.
    * @var type 
    */
   private $conexion; //variable para mantener una conexion
   
   /**
    * Metodo singleton para tener una sola
    * conexion con la base de datos
    * @return type
    */
   public static function getInstance()
   {
      if (  !self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }
   
   /**
    * COnstruye y establece los valores con la base
    */
   function __construct() 
   {
       $configuracion=  Config::getInstance();
       $this->hostName = $configuracion->host;
       $this->dataBase = $configuracion->db;
       $this->userName = $configuracion->user;
       $this->password = $configuracion->password;
       $this->conectar();
       
   }
   
   /**
    * Realiza la coneion con la db
    */
   public function conectar()
   {
       $this->conexion=mysql_pconnect($this->hostName,  $this->userName,  $this->password) or trigger_error(mysql_error(),E_USER_ERROR); 
       mysql_select_db($this->dataBase,  $this->conexion);        
      
   }
   
   /**
    * Ejecuta un query de accion(insert,update,delete)
    * @param type $query
    * @return type
    */
   public function ejecutar($query)
   {
       $Result1 = mysql_query($query,$this->conexion) or die(mysql_error()); 
      // echo "-->ejecutar";
       return $Result1;
       
   }
   
   /**
    * Realiza y obtiene consultas de la base de datos
    * @param type $query
    * @return type
    */
   public function consulta($query)
   {
       $consulta=mysql_query($query,$this->conexion) or die(mysql_error());
       $fila=mysql_fetch_array($consulta);
      // echo "-->consultar";
       return $fila;
   }
   
   /**
    * Variable que tiene la conexion directa con la bases
    * @return types
    */
   public function getConexion()
   {
       return $this->conexion;      
   }
   
}
