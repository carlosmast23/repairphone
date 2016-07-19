<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ColumnsTable
 *
 * @author Carlos
 */
class ColumnsTable {
    private $field;
    private $type;
    private $null;
    private $key;
    private $default;
    private $extra;
    
    function __construct($field, $type, $null, $key, $default, $extra) 
    {
        $this->field = $field;
        $this->type = $type;
        $this->null = $null;
        $this->key = $key;
        $this->default = $default;
        $this->extra = $extra;
    }

    function getField() {
        return $this->field;
    }

    function getType() {
        return $this->type;
    }

    function getNull() {
        return $this->null;
    }

    function getKey() {
        return $this->key;
    }

    function getDefault() {
        return $this->default;
    }

    function getExtra() {
        return $this->extra;
    }

    function setField($field) {
        $this->field = $field;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setNull($null) {
        $this->null = $null;
    }

    function setKey($key) {
        $this->key = $key;
    }

    function setDefault($default) {
        $this->default = $default;
    }

    function setExtra($extra) {
        $this->extra = $extra;
    }


}
