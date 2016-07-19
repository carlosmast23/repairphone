<?php

/*
 * Clase abstracta que establace las funciones a implementar
 * para realizar un mapero objeto - relacional para comunicarme
 * con la base de datos
 */

/**
 * Clase que me permite vincular las clases con una sola estructura
 *
 * @author Carlos
 */
abstract class AbstractDb 
{
    protected $estructura;
    
    function __construct() 
    {
        $this->estructura=new Estructura();
        $this->setEstructura();
    }

    public function getEstructura() 
    {
        return $this->estructura;        
    }
    
    abstract public function setEstructura();
    protected $copia; //variable que va a tener una copia del objeto en un determinado tiempo
    //abstract public function saveEstado();
    //abstract public function getEstado();
    //abstract public function getPk(); //obtener la clave principa;
    
    //funcion que me permite llenar automaticamente con el nombre de los arrays desde el formulario
    public function llenarConArray($array)
    {
       
        foreach ($array as $key => $valor)
        {
              //echo $key ." => ".$valor;
            //echo "$key </ br>";
            if (property_exists(get_class($this),$key)) 
            {
                //self::$key=$valor;
                $setter = 'set' . ucfirst($key);
                $this->$setter($valor);  
                //echo $valor;
            }
            
        } 
      //  return new self();
    }
    
    public function getEstado() 
    {
        return $this->copia;
    }

    public function saveEstado() 
    {
        $this->copia=clone($this);        
    }
    
    public function equals($obj)
    {
        $estruc1=  $this->getEstructura();
        $estruc2=  $obj->getEstructura();
        
        $c1=$estruc1->getPK()[0];
        $c2=$estruc2->getPK()[0];
        
        if(($c1->getValor()==$c2->getValor()) &&($c1->getNombre()==$c2->getNombre()))
        {
            //echo "c1: [".var_dump($c1)."].</br>";
            //echo "c2: [".var_dump($c2)."].</br>";
                   return true;
        }
        return  false;
        
    }
}
