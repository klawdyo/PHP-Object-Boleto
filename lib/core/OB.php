<?php

class OB{
    
    //Dados do cedente (banco ou quem vai receber)
    public $Vendedor;    
    
    //Dados do Sacado (cliente. quem pagará a conta)
    public $Cliente;
    
    //Dados de configurações do banco, layout, etc.
    public $Boleto;
    
    //Dados de configurações dos templates
    public $Template;
    
    //Dados de configuração do Layout para o banco escolhido
    public $Layout;
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function __construct(){
        $classes = array('Vendedor', 'Cliente', 'Boleto', 'Configuracao', 'Template');
        foreach($classes as $class){
            $this->$class = new $class($this);
        }
        //Carrego 
        require OB_DIR . '/lib/layouts/Layouts.php';
        //$this->Layout = new Layouts($this);
    }
    
    //public function __get()
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function plugin($pluginName){
        if(!class_exists('Plugin')){
            require OB_DIR . '/lib/core/Plugin.php';
        }
        return Plugin::load($pluginName);

    }
    
    /**
      * Carrego os dados do banco desejado
      * 
      * @version 0.1 20/05/2011 Initial
      */
    public function loadBanco(){
        //Instância do Layouts pai
        $layout = new Layouts;
        //Todos os layouts dos bancos extendem o layout pai. Carrego o layout
        //específico para o banco em questão
        $this->Layout = $layout->Banco($this->Vendedor->Banco);
        //
        return $this->Layout;
    }
    
    /**
      * Calcula o fator de vencimento
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public static function fatorVencimento($dia, $mes, $ano){
        $timestampVencimento = (int) (mktime(0,0,0,$mes, $dia, $ano) / (24*60*60));
        $timestampDatabase = (int) (mktime(0,0,0,10, 7, 1997) / (24*60*60));
        
        return abs($timestampVencimento - $timestampDatabase);
    }
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function geraCodigo(){
        if(empty($this->Boleto->CodigoBarras)){
            //Carrega o banco usado
            $this->loadBanco();
            $data = array(
                        'banco'=> $this->Vendedor->Banco,
                        'moeda' => $this->Vendedor->Moeda,
                        'valor' => $this->Boleto->Valor,
                        'agencia' => $this->Vendedor->Agencia,
                        'carteira' => $this->Vendedor->Carteira,
                        'conta' => $this->Vendedor->Conta,
                        'nosso_numero' => $this->Boleto->NossoNumero,
                        'vencimento' => $this->Boleto->Vencimento,
                        'fator_vencimento' => $this->Boleto->FatorVencimento,
                        'zero_fixo' => 0
                       );
            $layoutCodigoBarras = ':banco:moeda:fator_vencimento:valor:agencia:carteira:nosso_numero:conta:zero_fixo';
            $cod = String::insert($layoutCodigoBarras, $data);
            
            //Calculo o dígito verificador geral
            $dv = Math::Mod11($cod, 1, 1);
    
            //Insiro o dígito verificador exatamente na posição 4, iniciando em 0.
            return $this->Boleto->CodigoBarras = String::putAt($cod, $dv, 4);
        }
        else{
            return $this->Boleto->CodigoBarras;
        }
    }
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
   public static function zeros($text, $length){
        return str_pad($text, $length, '0', STR_PAD_LEFT);
    }
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function normalizeData(){
        
    }
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function extractData(){
        $this->Banco->posicoes;
    }
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function linhaDigitavel(){
        $codigo = $this->geraCodigo();
        
        #Inicio $data vazia
        $data = array();
        
        #A partir das posições indicadaas pelo layout, separo os dados dentro
        #do código em variáveis normais
        foreach($this->Layout->posicoes as $var => $substr){
            $data[$var] = substr($codigo, $substr[0], $substr[1]);
        }
        
        //Layout para montar a linha digitável, que virá de $this->Layout->layoutLinhaDigitavel
        $layout = ':banco:moeda:agencia:carteira:nosso_numero:conta_corrente'.
                  ':vencimento:valor';
                  
        $mask   = '00000.00000 00000.000000 00000.000000 0 00000000000000';
        
        //Aplico no layout da linha digitável os dados da variável $data
        $linhaDigitavel = String::insert($this->Layout->layoutLinhaDigitavel, $data);

        #Calculando o dv vindo do código de barras, que 
        #fica exatamente na posição 4, iniciando em 0
        $dv = $codigo[4];
        
        #Calculando os dígitos verificadores dos subgrupos
        $dv1 = Math::Mod10(substr($linhaDigitavel, 0, 9));
        $dv2 = Math::Mod10(substr($linhaDigitavel, 9, 10));
        $dv3 = Math::Mod10(substr($linhaDigitavel, 20, 10));
        
        #Inserindo os DVs em seus lugares
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv1, 9);//
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv2, 20);//
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv3, 31);//
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv, 32);
       
        #Aplicando A linha digitável gerada à sua máscara
        $linhaDigitavel = String::applyMask($linhaDigitavel, $this->Layout->mascaraLinhaDigitavel);
        
        return $linhaDigitavel;
    }
    
    /**
      * Pega uma url relativa
      * 
      * @version 0.1 19/05/2011 Initial
      *
      */
    public static function url($url = null){
        return dirname($_SERVER['REQUEST_URI']) . $url;
    }
    
    # # # # # # # # # # # # # # # # # # # # # #
    # # 
    # #     SETTERS E TRATAMENTO DOS VALORES DE ENTRADA
    # #
    # # # # # # # # # # # # # # # # # # # # # #

    
    
    
    
}