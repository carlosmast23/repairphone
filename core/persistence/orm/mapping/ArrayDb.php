<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase que me permite representar un conjunto de datos necesarios para los arreglos
 *
 * @author Carlos
 */
class ArrayDb {

    /*
     * Objeto de tipo columna la cual se va a realizar el filtro
     */
    private $relationField;
    /*
     * Referencia al campo de la otra tabla que voy a relacionar
     */
    private $refField;
    /*
     * Nombre de el objero facade del filtro en la cual esta la relacion para hacer el filtro
     */
    
    private $facadeFilter;
    
        /*
     * Nombre de la tabla en la cual esta la relacion para hacer el filtro
     */
    
    private $relationTable;

    /*
     * Referencia donde se va a almacenar el resultado
     */
    private $array;
    
    function __construct($relationField, &$refField, $facadeFilter, $relationTable, &$array) {
        $this->relationField = $relationField;
        $this->refField = &$refField;
        $this->facadeFilter = $facadeFilter;
        $this->relationTable = $relationTable;
        $this->array = &$array;
    }
    
    function getRelationField() {
        return $this->relationField;
    }

    function getRefField() {
        return $this->refField;
    }

    function getFacadeFilter() {
        return $this->facadeFilter;
    }

    function getRelationTable() {
        return $this->relationTable;
    }

    function getArray() {
        return $this->array;
    }

    function setRelationField($relationField) {
        $this->relationField = $relationField;
    }

    function setRefField($refField) {
        $this->refField = $refField;
    }

    function setFacadeFilter($facadeFilter) {
        $this->facadeFilter = $facadeFilter;
    }

    function setRelationTable($relationTable) {
        $this->relationTable = $relationTable;
    }

    function setArray($array) {
        $this->array = $array;
    }




}
