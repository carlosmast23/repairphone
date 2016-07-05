<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexion
 *
 * @author home
 */
class Conexion {

    private $hostName;
    private $dataBase;
    private $userName;
    private $password;
    private $conexion;

    public function __construct($hostName, $dataBase, $userName, $password) {
        $this->hostName = $hostName;
        $this->dataBase = $dataBase;
        $this->userName = $userName;
        $this->password = $password;
    }

    public function conexion() {
        $this->conexion = mysql_pconnect($this->hostName, $this->userName, $this->password) or trigger_error(mysql_error(), E_USER_ERROR);
        $this->seleccionarDB();
    }

    public function desconectar() {
        mysql_close();
    }

    private function seleccionarDB() {
        mysql_select_db($this->dataBase, $this->conexion);
    }

    public function grabar($entidad) {
        //INSERT INTO NOTICIAS (`codigo`, `fecha`, `noticia`) VALUES ('11', '2013-12-02', 'SADASDASDASD');
        $consulta = "INSERT INTO " . $entidad->getTabla() . "(";
        $vector = $entidad->getDatos();


        for ($index = 0; $index < count($vector); $index++) {
            if ($index == count($vector) - 1)
                $consulta = $consulta . $vector[$index][0];
            else
                $consulta = $consulta . $vector[$index][0] . ",";
        }
        $consulta = $consulta . ") VALUES (";


        for ($index = 0; $index < count($vector); $index++) {
            if ($index == count($vector) - 1)
                $consulta = $consulta . "'" . $vector[$index][1] . "'";
            else
                $consulta = $consulta . "'" . $vector[$index][1] . "',";
        }

        $consulta = $consulta . ");";
        echo $consulta;
        $Result1 = mysql_query($consulta, $this->conexion) or die(mysql_error());

        return $Result1;
    }

    public function editar($entidad) {
        //UPDATE noticias SET codigo='14', noticia='df',fecha='2013-12-01' WHERE `codigo`='10';
        $consulta = "UPDATE " . $entidad->getTabla() . " SET ";
        $vector = $entidad->getDatos();


        for ($index = 0; $index < count($vector); $index++) {
            if ($index == count($vector) - 1)
                $consulta = $consulta . $vector[$index][0] . "='" . $vector[$index][1] . "'";
            else
                $consulta = $consulta . $vector[$index][0] . "='" . $vector[$index][1] . "'" . ",";
        }
        $consulta = $consulta . " WHERE " . $vector[0][0] . "='" . $vector[0][1] . "';";
        // echo $consulta;            
        $Result1 = mysql_query($consulta, $this->conexion) or die(mysql_error());

        return $Result1;
    }

    public function eliminar($entidad) {
        //DELETE FROM noticias WHERE `codigo`='12';
        $vector = $entidad->getDatos();
        $consulta = "DELETE FROM " . $entidad->getTabla();
        $consulta = $consulta . " WHERE " . $vector[0][0] . "='" . $vector[0][1] . "';";
        //echo $consulta;
        $Result1 = mysql_query($consulta, $this->conexion) or die(mysql_error());

        return $Result1;
    }

    public function consulta($entidad) {
        //echo "consulta : ";
        $vector = $entidad->getDatos();
        $query = "SELECT * FROM " . $entidad->getTabla() . " WHERE " . $vector[0][0] . "='" . $vector[0][1] . "';";
        $consulta = mysql_query($query, $this->conexion) or die(mysql_error());
        $fila = mysql_fetch_array($consulta);
        return $fila;
    }

    //un reporte de toda la tabla
    public function consultaTabla($entidad) {
        //echo "consulta : ";
        $vector = $entidad->getDatos();
        if (empty($vector[0][1])) {
            $query = "SELECT * FROM " . $entidad->getTabla();
        } else {
            $query = "SELECT * FROM " . $entidad->getTabla() . " WHERE " . $vector[0][0] . "='" . $vector[0][1] . "';";
        }

        $consulta = mysql_query($query, $this->conexion) or die(mysql_error());
        //echo "Query" . $query;
        return $consulta;
    }

    public function consultaLibre($query) {
        $consulta = mysql_query($query, $this->conexion) or die(mysql_error());
        //echo $query;
        return $consulta;
    }

    public function setDataBase($dataBase) {
        $this->dataBase = $dataBase;
    }

}

?>
