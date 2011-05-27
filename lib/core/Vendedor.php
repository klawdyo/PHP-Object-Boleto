<?php
/*
    Essa class vai trazer as configurações do Cedente
*/
class Vendedor{
    //Dados bancários
    public $Banco;
    public $Agencia;
    public $Conta;
    public $Carteira;
    public $Moeda = 9;
    
    //Identificação
    public $RazaoSocial;
    public $Cnpj;
    public $Endereco;
    public $Email;
    
    
    public $parent;
    
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
    public function __call($name, $arg = null){
        //pr();
        preg_match('/^(set|get)([a-zA-Z]+)$/', $name, $output);
        if($output[1] == 'set'){
            $this->$output[2] = $arg[0];
            return $this;
        }
        elseif($output[1] == 'get'){
            if(isset($this->$output[2])){
                return $this->$output[2];
            }
            else{
                throw new Exception("A propriedade \"{$output[2]}\" não existe na class Vendedor");
            }
        }
    }
    
    /**
      * Configura os dados do vendedor a partir de um array
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
      * Configura o banco
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function setBanco($codigo){
        $this->Banco = OB::zeros($codigo, 3);
        
        return $this;
    }

    /**
      * Configura 
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setRazaoSocial($codigo){
        $this->Banco = OB::zeros($codigo, 3);
        
        return $this;
    }

    /**
      * Configura 
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setAgencia($codigo){
        $this->Agencia = OB::zeros($codigo, 4);
        
        return $this;
    }

    /**
      * Configura 
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setConta($value){
        $this->Conta = $value
        
        return $this;
    }

    /**
      * Configura 
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setNumContrato($value){
        $this->Conta = $value
        
        return $this;
    }

    /**
      * Configura 
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setCarteira($value){
        $this->Carteira = $value
        
        return $this;
    }

    /**
      * Configura 
      * 
      * @version 0.1 27/05/2011 Initial
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
      * Configura 
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setEndereco($value){
        $this->Endereco = $value
        
        return $this;
    }

    /**
      * Configura 
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setEmail($value){
        if(Validar::email($value)){
            $this->Email = $value;
        }
        else{
            throw new Exception('E-mail "' . $value . '" inválido');
        }
        return $this;
    }
}