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
    
    //Identificação
    public $Nome;
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
    public function __call($name, $arg=null){
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
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function setBanco($codigo){
        $this->Banco = $codigo;
        
        return $this;
    }
    
}