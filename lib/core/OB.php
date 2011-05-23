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
    public $Banco;
    
    
    //
    public $data = array();
    
    
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
        #Carrego o layout
        require OB_DIR . '/lib/core/Banco.php';
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
      * Carrego os dados do banco desejado
      * 
      * @version 0.1 20/05/2011 Initial
      *          0.2 20/05/2011 Verifico se algo já foi carregado
      */
    public function loadBanco(){
        if(!empty($this->Banco)){
            return $this->Banco;
        }
        
        #Instância do Layouts pai
        $banco = new Banco;
        
        #Todos os layouts dos bancos extendem o layout pai. Carrego o layout
        #específico para o banco em questão
        $this->Banco = $banco->load($this->Vendedor->Banco);
        
        return $this->Banco;
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
      *              20/05/2011 Modificações gerais, uso das variáveis de layout
      *                 externas, separação dos tratamentos de dados em outro
      *                 método, verificação se a propriedade já existe para
      *                 evitar mais processamento, e criação da propriedade
      *
      */
    public function geraCodigo(){
        #Se nenhum código foi gerado.
        if(empty($this->Boleto->CodigoBarras)){
            #Carrega o banco usado
            $this->loadBanco();
            
            #Padroniza os dados necessários de acordo com Layout do banco
            $this->normalizeData();
            
            #Insere os valores de $this->data no layout do codigo de barras
            $cod = String::insert($this->Banco->layoutCodigoBarras, $this->Data);

            #Cálculo do dígito verificador geral do código de barras
            $dv = Math::Mod11($cod, 1, 1);

            #Inserindo o dígito verificador exatamente na posição 4, iniciando em 0.
            $this->Boleto->CodigoBarras = String::putAt($cod, $dv, 4);
        }

        return $this->Boleto->CodigoBarras;
    }
    
    /**
      * Normaliza os dados da propriedade, unificando a esse trabalho
      * 
      * @version 0.1 18/05/2011 Initial
      *              20/05/2011 Agora verifica se a propriedade já está
      *                 preenchida, salva os dados em uma propriedade de
      *                 classe
      *
      * @todo Esse método é responsabilidade do layout
      */
    public function normalizeData(){
        if(empty($this->Data)){
            $data = array(
                'Banco'=> $this->Vendedor->Banco,
                'Moeda' => $this->Vendedor->Moeda,
                'Valor' => $this->Boleto->Valor,
                'Agencia' => $this->Vendedor->Agencia,
                'Carteira' => $this->Vendedor->Carteira,
                'Conta' => $this->Vendedor->Conta,
                'NossoNumero' => $this->Boleto->NossoNumero,
                'FatorVencimento' => $this->Boleto->FatorVencimento,
               );

            foreach($data as $var => $value){
                $this->Data[$var] = self::zeros($value, $this->Banco->posicoes[$var][1]);
            }
            
            $this->Data['Vencimento'] = $this->Boleto->Vencimento;

            return $this->Data;
        }
        else{
            return $this->Data;
        }
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
      * Gera a linha digitável já formatada
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function linhaDigitavel(){
        $codigo = $this->geraCodigo();
        
        #Inicio $data vazia
        $data = array();
        
        #A partir das posições indicadaas pelo layout, separo os dados dentro
        #do código em variáveis normais
        foreach($this->Banco->posicoes as $var => $substr){
            $data[$var] = substr($codigo, $substr[0], $substr[1]);
        }
        
        #Aplico no layout da linha digitável os dados da variável $data
        $linhaDigitavel = String::insert($this->Banco->layoutLinhaDigitavel, $data);

        #Calculando o dv vindo do código de barras, que 
        #fica exatamente na posição 4, iniciando em 0
        $dv = $codigo[4];
        
        #Calculando os dígitos verificadores dos subgrupos
        $dv1 = Math::Mod10(substr($linhaDigitavel, 0, 9));
        $dv2 = Math::Mod10(substr($linhaDigitavel, 9, 10));
        $dv3 = Math::Mod10(substr($linhaDigitavel, 20, 10));
        
        #Inserindo os DVs em seus lugares
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv1, 9);
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv2, 20);
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv3, 31);
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv, 32);
       
        #Aplicando A linha digitável gerada à sua máscara
        $linhaDigitavel = String::applyMask($linhaDigitavel, $this->Banco->mascaraLinhaDigitavel);
        
        return $linhaDigitavel;
    }
    /**
      * Renderiza o template
      * @version 0.1 18/05/2011 Initial
      *          0.2 20/05/2011 Retirado o echo
      *          1.0 20/05/2011 Movido da classe Boleto para a classe OB
      * @todo Trabalho pra OB
      */
    public function render(){
        $this->loadBanco();

        /*$data = array(
            'OB' => (object) array(
                'Template' => $this->Template,
                'Vendedor' => $this->Vendedor,
                'Cliente' => $this->Cliente,
                'Boleto' => $this->Boleto,
                'Configuracao' => $this->Configuracao,
        ));/**/
        
        //$this->Template->render($this->Template->Template, $data);
        $this->Template->render($this->Template->Template);
        flush();
    }
    
    
    # # # # # # # # # # # # # # # # # # # # # #
    # # 
    # #     SETTERS E TRATAMENTO DOS VALORES DE ENTRADA
    # #
    # # # # # # # # # # # # # # # # # # # # # #







    # # # # # # # # # # # # # # # # # # # # # #
    # # 
    # #     FUNÇÕES AUXILIARES
    # #
    # # # # # # # # # # # # # # # # # # # # # #

    
    /**
      * Pega uma url relativa
      * 
      * @version 0.1 19/05/2011 Initial
      *
      */
    public static function url($url = null){
        return dirname($_SERVER['REQUEST_URI']) . $url;
    }
    
    /**
      * Completa com zeros adicionais à esquerda até o valor informado
      * 
      * @version 0.1 18/05/2011 Initial
      */
   public static function zeros($text, $length){
        return str_pad($text, $length, '0', STR_PAD_LEFT);
    }
}