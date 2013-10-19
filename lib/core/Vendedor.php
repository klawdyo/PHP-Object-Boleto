<?php
/*
    Essa class vai trazer as configurações do Cedente
*/
class Vendedor{
    //Dados bancários
    public $Agencia;
    public $Conta;
    public $CodigoCedente;
    public $Carteira;
    public $Moeda = 9;
    
    //Identificação
    public $RazaoSocial;
    public $Cnpj;
    public $Endereco;
    public $Email;
    
    
    public $parent;
    
    /**
      * Construtor
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function __construct(&$obj){
        $this->parent = $obj;
    }
    
    /**
      * Chama os métodos inexistentes
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function __call($name, $arg = null){
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
      * Configura a Razão Social
      * 
      * @version 0.1 27/05/2011 Initial
      *          0.2 27/05/2011 Renomeado de setNome() para setRazaoSocial()
      */
    public function setRazaoSocial($value){
        $this->RazaoSocial = $value;
        
        return $this;
    }

    /**
      * Configura a agência
      * 
      * @version 0.1 27/05/2011 Initial
      *          0.2 28/05/2011 Removido bug que forçava 4 caracteres
      *             no campo Agencia, sendo que alguns bancos usam 3
      */
    public function setAgencia($codigo){
        $this->Agencia = $codigo;
        
        return $this;
    }

    /**
      * Configura o número da conta do cliente.
      * Em alguns bancos, esse campo é desnecessário, sendo substituído pelo
      * número do contrato. Os código de barras serão gerados corretamente de
      * acordo com o padrão de cada banco, e os templates exibirão correta-
      * mente cada dado em seu lugar.
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setConta($value){
        $this->Conta = $value;
        
        return $this;
    }

    /**
      * Configura o número do contrato do Vendedor com o banco
      * Em alguns bancos, esse campo é desnecessário, sendo substituído pelo
      * número do contrato. Os código de barras serão gerados corretamente de
      * acordo com o padrão de cada banco, e os templates exibirão corre-
      * tamente cada dado em seu lugar.
      * 
      * @version 0.1 27/05/2011 Initial
      *          0.2 27/05/2011 Renomeado de setNumCodigoCedente() para
      *             setCodigoCedente()
      */
    public function setCodigoCedente($value){
        $this->CodigoCedente = $value;
        
        return $this;
    }

    /**
      * Configura a carteira 
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setCarteira($value){
        $this->Carteira = $value;
        
        return $this;
    }

    /**
      * Configura o cnpj do vendedor
      * 
      * @version 0.1 27/05/2011 Initial
      *          0.2 27/05/2011 Adicionada validação do CNPJ informado
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
      * Configura o endereço do vendedor
      * 
      * @version 0.1 27/05/2011 Initial
      */
    public function setEndereco($value){
        $this->Endereco = $value;
        
        return $this;
    }

    /**
      * Configura o e-mail do vendedor
      * 
      * @version 0.1 27/05/2011 Initial
      *          0.2 27/05/2011 Adicionada validação do e-mail
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