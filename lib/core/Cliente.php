<?php

class Cliente{
    
    //Identificação
    public $Nome;
    public $Cnpj;
    public $Cpf;
    public $Email;
    public $Endereco;
    public $Cidade;
    public $Uf;
    public $Cep;
    
    
    /**
      * Construtor da classe
      * 
      * @version 0.1 18/05/2011 Initial
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
      *          0.2 27/05/2011 Adicionada Validação do cpf
      */
    public function setCpf($value){
        if(Validar::cpf($value)){
            $this->Cpf = $value;
        }
        else{
            throw new Exception('CPF "' . $value . '" inválido');
        }
        return $this;
    }
    
    /**
      * Configura o cnpj do cliente
      *
      * @version 0.1 20/05/2011 Initial
      *          0.2 27/05/2011 Adicionada Validação do cnpj
      */
    public function setCnpj($value){
        if(Validar::cnpj($value)){
            $this->Cnpj = $value;
        }
        else{
            throw new Exception('CNPJ "' . $value . '" inválido');
        }
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
    /**
      * Configura a cidade do cliente
      *
      * @version 0.1 20/05/2011 Initial
      */
    public function setCidade($value){
        $this->Cidade = $value;
        return $this;
    }
    /**
      * Configura a uf do cliente
      *
      * @version 0.1 20/05/2011 Initial
      */
    public function setUf($value){
        $this->Uf = $value;
        return $this;
    }
    /**
      * Configura o cep do cliente
      *
      * @version 0.1 20/05/2011 Initial
      */
    public function setCep($value){
        $this->Cep = $value;
        return $this;
    }
}