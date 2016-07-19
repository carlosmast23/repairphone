<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractFacade
 *
 * @author Carlos
 */
require_once CONEXION;   
require_once ESTRUCTURA;
require_once FACADE."EmpresaUsuarioFacade.php";  
require_once COLUMNSTABLE;

/**
 * Implementa metodos generales para las clases que hereden de facade
 * como son (insert,update,delete)
 * 
 */
abstract class AbstractFacade 
{
    //variable que me permite utilizar una pila global para hacer las comparaciones al momento de cargar
    protected static $pila=array();
    
    abstract protected function getNameRelationEntity(); //devuelve el nombre de la la clase entity mediante la cual vamos a trabajar
    
    //abstract protected function getColumnas();
    protected $conexion;
    
    function __construct() 
    {
        $this->conexion=  Conexion::getInstance();
    }

    static public function findPila($obj)
    {
        for($i=0;$i<count(static::$pila);$i++)
        {
            if($obj->equals(static::$pila[$i]))
            {
                return static::$pila[$i];
            }
        }
        
        return null;
    }
    
    public function consultaTabla()
    {
        $estructura=  $this->getEstructBlank();
        $query="SELECT * FROM ".$estructura->getNameTable();
        //echo "< ".$query." ></br>";
        $consulta=mysql_query($query,$this->conexion->getConexion()) or die(mysql_error());
        return $this->arrayToObject($consulta);

    }
    
    public function getFindId($clave,$valor)
    {
        $estructura=  $this->getEstructBlank();
        $query="SELECT * FROM ".$estructura->getNameTable()." WHERE $clave='$valor'";
        //echo $query."</br>";
        $consulta=mysql_query($query,$this->conexion->getConexion()) or die(mysql_error());
        return $this->arrayToObject($consulta);     
    }
    
    public function getFindPrimaryKey($valor,$ref)
    {
        $vector=$this->getEstructBlank();
        $columnas=$vector->getPK();
        //echo count($columnas);
        $query="SELECT * FROM ".$vector->getNameTable()." WHERE ".$columnas[0]->getNombre()."='$valor'";
        $consulta=mysql_query($query,$this->conexion->getConexion()) or die(mysql_error());
        return $this->castObject($consulta,$ref);     
    }
    
    //optimizar para borrar con todas las claves primarias
    public function delete($valor)
    {
       $vector=$this->getEstructBlank();
       $columas=$vector->getPK();
       $query="DELETE FROM ".$vector->getNameTable()." WHERE ".$columas[0]->getNombre()."='".$valor."';";
       $consulta=$this->conexion->ejecutar($query);
       //$consulta=mysql_query($query,$this->conexion->getConexion()) or die(mysql_error());
       return $consulta;
    }
    
    public function editar($obj)
    {
       $vector=$obj->getEstructura();
       $columnas=$vector->getColumnas();
       
       $consulta="UPDATE ".$vector->getNameTable()." SET ";
       //$vector=$entidad->getDatos();
       
       for ($i=0;$i<count($columnas);$i++)
       {
           $c=$columnas[$i];
            if($i==count($columnas)-1)
               $consulta=$consulta.$c->getNombre()."='".$c->getValor()."'";    
           else
               $consulta=$consulta.$c->getNombre()."='".$c->getValor()."'".",";    
           
       }
       //verifica que la estructura tenga una copia
       if(is_null($obj->getEstado()))
       {
           $obj->saveEstado();
       }
       
      $vector=$obj->getEstado()->getEstructura();
      $vector=$vector->getPK();
            
      $consulta=$consulta." WHERE ".$vector[0]->getNombre()."='".$vector[0]->getValor()."';";
       //echo $consulta;            
       $Result1 = $this->conexion->ejecutar($consulta);
       
       return $Result1;   
        
    }
    
    public function insert($obj)
    {
       
       $vector=$obj->getEstructura();
       $columnas=$vector->getColumnas();
       $consulta="INSERT INTO ".$vector->getNameTable()."(";
       
       for ($i=0;$i<count($columnas);$i++)
       {
           $c=$columnas[$i];
            if($i==count($columnas)-1)
               $consulta=$consulta.$c->getNombre();       
           else
               $consulta=$consulta.$c->getNombre().",";   
           
       }
       
       $consulta=$consulta.") VALUES (";
       
       for ($i=0;$i<count($columnas);$i++)
       {
            $c=$columnas[$i];
            if($i==count($columnas)-1)
               $consulta=$consulta."'".$c->getValor()."'";    
            else
               $consulta=$consulta."'".$c->getValor()."',";   
           
       }
       
       $consulta=$consulta.");";
       //echo $consulta;
       $Result1 = $this->conexion->ejecutar($consulta);
       //$Result1 = mysql_query($consulta,$this->conexion->getConexion()) or die(mysql_error());
       
       return $Result1;              
    }
    /**
     * Funcion que retorna la estructura de la tabla correpospondiente
     * 
     * 
     * @return ColumnsTable
     */
    
    public function getEstructuraTabla()
    {
        $estructura=  $this->getEstructBlank();
        $query="SHOW COLUMNS FROM ".$estructura->getNameTable();
        $consulta=mysql_query($query,$this->conexion->getConexion()) or die(mysql_error());
        $array=array();
        $fila=mysql_fetch_array($consulta);
        $i=0;
        do
        {
            $array[$i]=new ColumnsTable($fila[0],$fila[1],$fila[2],$fila[3],$fila[4],$fila[5]);;
            //echo $fila[1] ."<br>";
            $i++;
        }while($fila=mysql_fetch_array($consulta));
        return $array;
        
        //return $this->arrayToObject($consulta);
    }
    
    
    protected function getEstructBlank()
    {
        $nameClass=$this->getNameRelationEntity();
        $obj=new $nameClass();
        return $obj->getEstructura();
    }
    
    
    //funciones para conversiones 
    //public abstract function getObj($fila);
    
    public function getObj($fila,$ref) 
    {
               
        //echo "< ".var_dump($fila)." ></br>";
        //estructura de la tabla
        $estructura= $this->getEstructuraTabla();
        //estructura del objeto
        $nameClass=$this->getNameRelationEntity();
        
        if(!isset($ref))
        {
            if(is_null($ref))
            {
                $obj=new $nameClass();
            }
            else
            {
                $obj=$ref;
            }
        }
        else
        {
            $obj=$ref;
        }
        
        
        $estructuraTabla=$obj->getEstructura();
        //recorrere relacion foraneas y campos isn relaciones
        for($i=0;$i<count($estructura);$i++)
        {                   
          $campo=$estructura[$i]->getField();
          $columna=$estructuraTabla->findColumna($campo);
          
          if($columna->getTipo()=="pk"  || $columna->getTipo()=="0")
          {
              $columna->setValor($fila[$i]);             
          }
          
        }
        
        ///crear objetos en blanco de las clavees foraneas
        //la creacion de referencias me permite tener enlazado todos los objetos
        //aquneue estos todavia no tenga ningun valor asignado
        for ($i = 0; $i < count($estructura); $i++) 
        {

            $campo = $estructura[$i]->getField();
            $columna = $estructuraTabla->findColumna($campo);

            if ($columna->getTipo() == "fk") {
                $nameFacade = $columna->getFacade();
                $facade = new $nameFacade();
                $nameClassFK=$facade->getNameRelationEntity();
                $objNew = new $nameClassFK();
                $columna->setValor($objNew);
            }
        }


        /////  Obtener el objeto de la pila si existe  ////////
        $objPila=static::findPila($obj);
        
        if(!is_null($objPila))
        {
            //echo "< ".var_dump(static::$pila)." ></br>";
            $obj=$objPila;            
        }
        else
        {    
            //grabar el objeto creado en la lista statica de todos los valores        
            static::$pila[]=$obj;
            

            //rrecorre las relaciones quue tienen una dependedncia de objetos (fk)
            for($i=0;$i<count($estructura);$i++)
            {         

              $campo=$estructura[$i]->getField();
              $columna=$estructuraTabla->findColumna($campo);

              if($columna->getTipo()=="fk")
              {
                  $nameFacade=$columna->getFacade();
                  $facade=new $nameFacade();
                  $objNew=$facade->getFindPrimaryKey($fila[$i],$columna->getValor());
                  $columna->setValor($objNew);              
              }

            }


            //proceso para encontrar los valores de los arreglos
            //busca todas las dependencias de arreglos que hayamos declarado en las clases entity
            
            $arreglos= $estructuraTabla->getArrays();
            for($i=0;$i<count($arreglos);$i++)
            {
                $arrayDb=$arreglos[$i];
                $nameFacade=$arrayDb->getFacadeFilter();
                $facade=new $nameFacade();
                //echo $arrayDb->getRefField();
                $datos=$facade->getFindId($arrayDb->getRelationField(),$arrayDb->getRefField());
                $nameRelation=$arrayDb->getRelationTable();

                $arrayResult=array();

                for($j=0;$j<count($datos);$j++)
                {
                    $object=$datos[$j];
                    $columna2=$object->getEstructura()->findColumna($nameRelation);
                    $arrayResult[]=$columna2->getValor();                
                }

                //igualar el resultado al arreglo del objeto corrspondiente
                $arrayDb->setArray($arrayResult); 
                
               // echo var_dump($obj);    

            }
        }
       // echo var_dump($obj);
        //echo var_dump(static::$pila);
        return $obj;
        
    }
    
 
    
    public function arrayToObject($consulta)
    {
        $array=array();
        //$fila=mysql_fetch_array($consulta);
        $i=0;
        while($fila=mysql_fetch_array($consulta))
        {
            $array[$i++]=  $this->getObj($fila,null);
        }        
        return $array;
    }
    
    public function castObject($consulta,$ref)
    {
        $array=array();
        $fila=mysql_fetch_array($consulta);
        return $this->getObj($fila,$ref);        
    }
    

}
