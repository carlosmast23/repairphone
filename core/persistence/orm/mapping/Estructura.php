<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase que representa una tabla de la base agrupando las
 * columnas y sus relaciones.
 *
 * @author Carlos
 */
require_once RAIZ."resources/modelo/conexion/Columna.php";
class Estructura {
    private $columnas;
    private $nameTable;
    private $arrays;
    
    function __construct() 
    {
        $array = array();
        $this->arrays=array();
    }    
    
    //agrega una colomuna a la estructura
    public function addColumna($obj)
    {
        $this->array[]=$obj;
    }
    
    public function addArray(&$array)
    {
        $this->arrays[]=&$array;        
    }
    
    public function getPK()
    {
         $listaPk=array();
         //foreach ( $this->array as $key => $value )
         foreach ( $this->array as $key =>$columna )
         {
           // echo $columna;
            if($columna->getTipo()=="pk")
            {
                $listaPk[]=$columna;                
            }
         }
         return $listaPk;
    }
    /*funcion que busca una columna por el nombre
     * 
     * return Columna
     */
    
    public function findColumna($nombre)
    {
        for ($i=0;$i<  count($this->array);$i++)
        {
            if($this->array[$i]->getNombre()==$nombre)
            {
                return $this->array[$i];
            }
        }
        return null;
    }


    public function getColumnas()
    {
        return $this->array;        
    }    
    
    public function getNameTable()
    {
        return $this->nameTable;
    }
    
    function setNameTable($nameTable) {
        $this->nameTable = $nameTable;
    }

    function getArrays() {
        return $this->arrays;
    }



}
