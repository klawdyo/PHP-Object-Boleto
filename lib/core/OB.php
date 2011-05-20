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
        //$this->Vendedor = new Vendedor($this);
        //$this->Cliente = new Cliente($this);
        //$this->Boleto = new Boleto($this);
        //$this->Configuracao = new Configuracao($this);
        //$this->Template = new Template($this);
        //$this->Layout = new Layouts;
        
    }
    
    
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
      *
      * @version 0.1 18/05/2011 Initial
      *
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
        //repassados
        $banco = self::zeros('237', 3);
        $moeda = self::zeros('9', 1);
        $valor = self::zeros((2952.95 * 100), 10); //10 algarismos
        $agencia = self::zeros('1172', 4); //tam.4
        $carteira = self::zeros('6', 2);//tam.2
        $conta = self::zeros('0403005', 7); //0403005-2 - tam.7
        $nosso_numero = self::zeros('00075896452', 11); ///00075896452-5 - tam.
        
        //calculado
        $vencimento = self::fatorVencimento('23', '5', '2011');


        $data = array(
                    'banco'=> $banco,
                    'moeda' => $moeda,
                    'valor' => $valor,
                    'agencia' => $agencia,
                    'carteira' => $carteira,
                    'conta' => $conta,
                    'nosso_numero' => $nosso_numero,
                    'vencimento' => $vencimento,
                    'zero_fixo' => 0
                   );
        $layoutCodigoBarras = ':banco:moeda:vencimento:valor:agencia:carteira:nosso_numero:conta:zero_fixo';
        $cod = String::insert($layoutCodigoBarras, $data);
        
        //Calculo o dígito verificador geral
        $dv = Math::Mod11($cod, 1, 1);
        
        //Insiro o dígito verificador exatamente na posição 4, iniciando em 0.
        return $this->codigo = String::putAt($cod, $dv, 4);
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
        $posicoes = array(
                              //(Inicio, Tamanho). Inicia em 0
            'banco'             => array(0,3),    //identificação do banco
            'moeda'             => array(3,1),    //Código da moeda: real=9
            'dv'                => array(4,1),    //Dígito verificador geral da linha digitável
            'vencimento'        => array(5,4),    //Fator de vencimento (Dias passados desde 7/out/1997)
            'valor'             => array(9,10),  //Valor nominal do título
            'agencia'           => array(19,4),  //Código da agencia, sem dígito
            'carteira'          => array(23,2),  //Código da Carteira
            'nosso_numero'      => array(25,11),  //Nosso número
            'conta_corrente'    => array(36,7),  //Conta corrente do cedente, sem o dígito
        );
        $data = array();
        foreach($posicoes as $var => $substr){
            $data[$var] = substr($codigo, $substr[0], $substr[1]);
        }
        pr($data, 'data');
        
        $layout = ':banco:moeda:agencia:carteira:nosso_numero:conta_corrente'.
                  ':vencimento:valor';
                  
        $mask   = '00000.00000 00000.000000 00000.000000 0 00000000000000';
        
        $cod = String::insert($layout, $data);

        pr($this->codigo, 'codigo de barras');
        
        #Calculando os dígitos verificadores dos subgrupos
        $dv1 = Math::Mod10(substr($cod, 0, 9));
        $dv2 = Math::Mod10(substr($cod, 9, 10));
        $dv3 = Math::Mod10(substr($cod, 20, 10));
        
        pr($dv1);        pr($dv2);        pr($dv3);
        
        #Inserindo os DVs em seus lugares
        $cod = String::putAt($cod, $dv1, 9);//
        $cod = String::putAt($cod, $dv2, 20);//
        $cod = String::putAt($cod, $dv3, 31);//
        $cod = String::putAt($cod, $data['dv'], 32);
       
        pr($cod);
        
        $cod = String::applyMask($cod, $mask);
        
        //23791.17209 60007.589645 52040.300547 1 9760000295295 //gerado por mim
        //23791.17209 60007.589645 52040.300502 1 49760000295295


        
        pr($cod);
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