<?php //18/05/2010

class Configuracao{
    private $instrucoes = array();
    public $localPagamento;
    
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
    public function addInstrucao($frase){
        if(!empty($frase)){
            $this->instrucoes[] = $frase;
        }        
        return $this;
    }
    
    /**
      *
      * @version 0.1 19/05/2011 Initial
      *
      */
    public function setLocalPagamento($frase){
        if(!empty($frase)){
            $this->localPagamento[] = $frase;
        }        
        return $this;
    }
    
}