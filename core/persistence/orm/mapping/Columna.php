<?php

/**
 * Clase que representa las columnas de la base de datos
 */
class Columna {
    /*
     * representa el nombre de la columna en la base de datos
     */
    private $nombre;
    /*
     * representa la referencia a la variable que contiene el objeto
     */
    private $valor;
    /*
     * representa el tipo de clave en la base de datos
     * pk =primary key , 
     * fk =foren key ,
     * 0=normal
     */
    private $tipo; 
    
    private $entity;
    private $facade;
    
    function __construct($nombre,&$valor, $tipo,$entity="",$facade="") {
        $this->nombre = $nombre;
        $this->valor =&$valor;
        $this->tipo = $tipo;
        $this->entity=$entity;
        $this->facade=$facade;
    }
    
    function getNombre() {
        return $this->nombre;
    }

    function getValor() {
        return $this->valor;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getEntity() {
        return $this->entity;
    }

    function getFacade() {
        return $this->facade;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setFacade($facade) {
        $this->facade = $facade;
    }



}
