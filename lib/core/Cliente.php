<?php

class Cliente{
    
    //Identificação
    public $Nome;
    public $Cnpj;
    public $Cpf;
    public $Endereco;
    public $Email;
    
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function __construct(&$obj){
        $this->parent = $obj;
    }
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function __call($name, $arg){
        preg_match('/^set([a-zA-Z]+)$/', $name, $output);
        $this->$output[1] = $arg[0];
        return $this;
    }
    
    /**
      * Configura os dados dos clientes a partir de um array
      *
      * @version 0.1 20/05/2011 Initial
      */
    public function set($array){
        foreach($array as $var => $value){
            $method = 'set' . $var;
            $this->$method($value);
        }
        return $this;
    }
    
}