<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorSet
 *
 * @author home
 */
abstract class ControladorSet {

    protected $conexion;
    protected $diccionario;
    protected $pagina;
    protected $valorSesion; //variable para almacenar los nombres de la seccion

    public function getValorSesion() {
        return $this->valorSesion;
    }

    public function validarSesion() {
        $valorSesion = $this->getValorSesion();
        session_start();
        if (count($this->getValorSesion()) > 0) {
            if (empty($_SESSION['nick'])) {
                header('Location: /NotaFacil/trunk/NotaFacilCodesoft/index1.php');
            }
        }


//        $valorSesion=$this->getValorSesion();
//        for ($index = 0; $index < count($valorSesion); $index++) 
//        {
//            if($valorSesion[$index]==$)
//            {
//                
//            }
//            echo "--> ".$valorSesion[$index];
//        }
    }

    function __construct($pagina) {

        $this->conectar();
        $this->pagina = $pagina;
        $this->setDiccionario();
        $this->setValorSesion();
        $this->buscarValores();
        $this->validarSesion();
    }

    //funcion para remplazar los valor que estan en el diccionario
    abstract function buscarValores();

    abstract function setValorSesion(); //me permite implementar lo valores para la sesion

    public function conectar() {


        $this->conexion = new Conexion("localhost", "DBNotaFacil2", "root", "TAISS190826");

        $this->conexion->conexion();
    }

    //cuando se desea hacer algun remplazo en la pagina
    public function rederizarPagina() {
        $pagina = file_get_contents($this->pagina);

        //me permite eliminar el codigo php de redireccion
        $indiceInicial = strpos($pagina, '<?php');
        $indiceFin = strpos($pagina, '?>') + 2;
        //echo $indiceInicial." - ".$indiceFin ;
        if (($indiceFin - $indiceInicial) == 3) {
            $paginaCorteA = substr($pagina, 0, $indiceInicial);
            $paginaCorteB = substr($pagina, $indiceFin, strlen($pagina));
            $pagina = $paginaCorteA . $paginaCorteB;
        }

        foreach ($this->diccionario as $key => $value) {
            $pagina = str_replace("[" . $key . "]", $value, $pagina);
        }

        //header('Location: listaVista.php');

        print $pagina;
    }

    abstract public function setDiccionario();

    public function getConexion() {
        return $this->conexion;
    }

    public function getDiccionario() {
        return $this->diccionario;
    }

    public function verificarSeccion($url) {
        session_start();
        //echo $_SESSION['nick'];
        if (empty($_SESSION['nick'])) {
            header('Location: ' . $url);
        }
    }

}

?>
