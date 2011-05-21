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
    
    /**
      * Configura o nome do cliente
      *
      * @version 0.1 20/05/2011 Initial
      */
    public function setNome($value){
        $this->Nome = $value;
        return $this;
    }
    
    /**
      * Configura o email do cliente
      *
      * @version 0.1 20/05/2011 Initial
      */
    public function setEmail($value){
        $this->Email = $value;
        return $this;
    }
    
    /**
      * Configura o cpf do cliente
      *
      * @version 0.1 20/05/2011 Initial
      */
    public function setCpf($value){
        $this->Cpf = $value;
        return $this;
    }
    
    /**
      * Configura o cnpj do cliente
      *
      * @version 0.1 20/05/2011 Initial
      */
    public function setCnpj($value){
        $this->Cnpj = $value;
        return $this;
    }
    
    /**
      * Configura o endereço do cliente
      *
      * @version 0.1 20/05/2011 Initial
      */
    public function setEndereco($value){
        $this->Endereco = $value;
        return $this;
    }
    
}