<?php
//18/05/11
class Boleto{
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function __construct(&$obj){
        $this->parent = $obj;
        
        //Pré-configurando o boleto
        $this->setDataEmissao();
    }
    
    
    
    # # # # # # # # # # # # # # # # # # # # # #
    # # 
    # #     SETTERS E TRATAMENTO DOS VALORES DE ENTRADA
    # #
    # # # # # # # # # # # # # # # # # # # # # #


    //Setters Valores
    public $Valor;
    public $FatorVencimento;
    public $Vencimento;
    public $NossoNumero;
    public $NumDocumento;
    public $DataEmissao;
    //Opcionais
    public $Quantidade;
    public $Desconto;
    public $OutrosAbatimentos;
    public $Multa;
    public $OutrosAcrescimos;
    //
    public $CodigoBarras;
    public $LinhaDigitavel;
    
    /**
      * Define a data da emissão do boleto. Qualquer um dos parâmetros
      * deixados em branco seraá preenchido com o valor referente ao dia
      * atual
      * 
      * @version 0.1 19/05/2011 Initial
      *
      */
    public function setDataEmissao($dia = null, $mes = null, $ano = null){
        $dia = empty($dia) ? date('d') : $dia;
        $mes = empty($mes) ? date('m') : $mes;
        $ano = empty($ano) ? date('Y') : $ano;
        
        $this->DataEmissao = $dia . '/' . $mes . '/' . $ano;
        return $this;
    }
    
    /**
      *
      * @version 0.1 19/05/2011 Initial
      *
      */
    public function setNumDocumento($numero){
        $this->NumDocumento = $numero;
        return $this;
    }
    
    /**
      * Define o valor, retirando a vírgula
      * 
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function setValor($valor){
        $this->Valor = (int) ($valor * 100);
        return $this;
    }
    
    /**
      * Define o nosso número do boleto
      * 
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function setNossoNumero($valor){
        if(!preg_match('/[^0-9]/', $valor)){
            $this->NossoNumero = $valor;
            return $this;
        }
        else{
            throw new Exception('Boleto::setNossoNumero só permite números');
        }
        
    }
    
    /**
      * Define uma data específica de vencimento
      * 
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function setVencimento($dia, $mes, $ano){
        $this->FatorVencimento = OB::fatorVencimento($dia, $mes, $ano);
        $this->Vencimento = $dia . '/' . $mes . '/' . $ano;
        return $this;
    }
    
    /**
      * Adiciona dias à data de hoje para definir o vencimento
      * 
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function setDiasVencimento($num){
        $time = strtotime('+' . $num . ' days');
        $this->setVencimento(date('d', $time), date('m', $time), date('Y', $time));
        return $this;
    }
    
    /**
      * 
      * 
      * @version 0.1 20/05/2011 Initial
      */
    public function setMulta($valor){
        $this->Multa = $valor;
        return $this;
    }
    
    /**
      * 
      * 
      * @version 0.1 20/05/2011 Initial
      */
    public function setDesconto($valor){
        $this->Desconto = $valor;
        return $this;
    }
    
    /**
      * 
      * 
      * @version 0.1 20/05/2011 Initial
      */
    public function setOutrosAcrescimos($valor){
        $this->OutrosAcrescimos = $valor;
        return $this;
    }
    
    /**
      * 
      * 
      * @version 0.1 20/05/2011 Initial
      */
    public function setOutrosAbatimentos($valor){
        $this->OutrosAbatimentos = $valor;
        return $this;
    }
    
    /**
      * 
      * 
      * @version 0.1 20/05/2011 Initial
      */
    public function setQuantidade($num){
        $this->Quantidade = $num;
        return $this;
    }
    
    
}