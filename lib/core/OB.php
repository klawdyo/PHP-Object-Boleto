<?php

class OB{
    
    /*
        @var object $Vendedor
        Dados do cedente (banco ou quem vai receber)
     */
    public $Vendedor;    
    
    /*
        @var object $Cliente
        Dados do Sacado (cliente. quem pagará a conta)
     */
    public $Cliente;
    
    /*
        @var object $Boleto
        Dados de configurações do banco, layout, etc.
     */
    public $Boleto;
    
    /*
        @var object $Template
        Dados de configurações dos templates
     */
    public $Template;
    
    /*
        @var object $Banco
        Dados de configuração do Layout para o banco escolhido
     */
    public $Banco;
    
    /*
        @var array $Data
        Dados utilizados na geração do código de barras e da linha digitável
     */
    public $Data = array();
    
    
    /**
      * Construtor
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function __construct($codigoBanco){
        $this->loadBanco($codigoBanco);
        
        $classes = array('Vendedor', 'Cliente', 'Boleto', 'Configuracao', 'Template');
        foreach($classes as $class){
            $this->$class = new $class($this);
        }
    }
    
    /**
      * Carrega o plugin informado
      * 
      * @version 0.1 18/05/2011 Initial
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
      *          0.2 20/05/2011 Verificando se algo já foi carregado
      *          0.3 27/05/2011 Parâmetro $codigoBanco adicionado.
      *             loadBanco() agora é chamado no construtor da
      *             classe.
      */
    public function loadBanco($codigoBanco){
        if(!empty($this->Banco)){
            return $this->Banco;
        }
        
        #Instância do Layouts pai
        $banco = new Banco;
        
        #Todos os layouts dos bancos estendem o layout pai. Carrego o layout
        #específico para o banco em questão
        $this->Banco = $banco->load($codigoBanco, $this);
        
        return $this->Banco;
    }
    
    /**
      * Calcula o fator de vencimento, que é a quantidade de dias desde
      * a data-base 07/10/1997
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public static function fatorVencimento($dia, $mes, $ano){
        $timestampVencimento = (int) (mktime(0, 0, 0, $mes, $dia, $ano) / (24 * 60 * 60));
        $timestampDatabase = (int) (mktime(0, 0, 0 , 10, 7, 1997) / (24 * 60 * 60));
        
        return abs($timestampVencimento - $timestampDatabase);
    }
    
    /**
      * Transforma um fator de vencimento em uma data
      *
      * @version 0.1 28/05/2011 Initial
      */
    public static function fatorVencimentoParaData($fator, $formato = 'd/m/Y'){
        return date($formato, ((strtotime('1997-10-7 00:00:00')/86400) + $fator) * 86400);
    }
    
    /**
      * Gera o código numérico que será a base para o código de barras
      * 
      * @version 0.1 18/05/2011 Initial
      *          0.2 20/05/2011 - Modificações gerais;
      *                         - Uso das variáveis de layout externas;
      *                         - Separação dos tratamentos de dados em outro
      *                         método;
      *                         - Criação da propriedade Boleto->CodigoBarras
      *                         - Verificação se a propriedade já existe
      *                         para evitar mais processamento
      *          0.3 28/05/2011 - Chama Banco::particularidade() para
      *                         os bancos que as tiverem
      */
    public function geraCodigo(){
        #Se nenhum código foi gerado.
        if(empty($this->Boleto->CodigoBarras)){
            #Padroniza os dados necessários de acordo com Layout do banco
            $this->normalizeData();
            
            #Verifica alguma particularidade do banco na geração do código
            $this->Banco->particularidade($this);
            
            #Verifica os campos obrigatórios
            $this->Banco->verificaObrigatorios($this->Data);

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
      *          0.2 20/05/2011 Agora verifica se a propriedade já está
      *                 preenchida, salva os dados em uma propriedade de
      *                 classe
      *          0.3 25/05/2011 Acrescentados DigitoNossoNumero e DigitoConta
      *             para atender a necessidade de alguns bancos
      *          0.4 27/05/2011 normalize() verifica se a chave existe no
      *                 array antes de tentar normalizar seu valor.
      *          0.5 27/05/2011 Acrescentado DigitoAgencia
      */
    public function normalizeData(){
        if(empty($this->Data)){
            $this->Data = array(
                'Banco'=> $this->Banco->Codigo,
                'Moeda' => $this->Vendedor->Moeda,
                'Valor' => $this->Boleto->Valor,
                'Agencia' => $this->Vendedor->Agencia,
                'Carteira' => $this->Vendedor->Carteira,
                'Conta' => $this->Vendedor->Conta,
                'NossoNumero' => $this->Boleto->NossoNumero,
                'FatorVencimento' => $this->Boleto->FatorVencimento,
                'CodigoCedente' => $this->Vendedor->CodigoCedente,
               );

            foreach($this->Data as $var => $value){
                if(array_key_exists($var, $this->Banco->tamanhos)){
                    $this->Data[$var] = self::normalize($this->Data[$var], $this->Banco->tamanhos[$var]);
                }
            }
            
            $this->Data['Vencimento'] = $this->Boleto->Vencimento;
            $this->Data['DigitoAgencia'] = Math::Mod11($this->Data['Agencia']);
            $this->Data['DigitoConta'] = Math::Mod11($this->Data['Conta']);
            $this->Data['DigitoNossoNumero'] = Math::Mod11($this->Data['NossoNumero']);

            return $this->Data;
        }
        else{
            return $this->Data;
        }
    }
    
    /**
      * Gera a linha digitável já formatada. O layout só é necessário
      * para gerar o código de barras. Para gerar a linha digitável,
      * todos os bancos usam os mesmos posicionamentos em relação ao
      * código previamente gerado:
      * Campo1 - Posições de 1-4 e 20-24, Campo2 - Posições 25-34,
      * Campo3 - Posições 35-44, Campo4 - Posição 5 e
      * Campo5 - Posições 6-19.
      * 
      * @version 0.1 18/05/2011 Initial
      *          1.0 27/05/2011 Mudança total em linha digitavel.
      */
    public function linhaDigitavel(){
        $codigo = $this->geraCodigo();
        //  1       10        20        30        40  44
        //  |        |         |         |         |   |
        //  10497498600001000001870000900000000001234567 //cod-bar
        //  10491870000900000000001234567749860000100000 //lin-digi virgem
        //  10491.8700X 00900.00000X 00012.34567X 7 49860000100000 //lin-digi formatada
        //  10491.87006 00900.000001 00012.345674 7 49860000100000
        //  10491.87006 00900.000001 00012.345674 7 49860000100000
        // 104918700    0090000000   00012345677
        
        //Campo1 - Posições de 1-4 e 20-24
        $linhaDigitavel = substr($codigo, 0, 4) . substr($codigo, 19, 5)
        //Campo2 - Posições 25-34
                         .substr($codigo, 24, 10)
        //Campo3 - Posições 35-44
                         .substr($codigo, 34, 10)
        //Campo4 - Posição 5
                         .substr($codigo, 4, 1)
        //Campo5 - Posições 6-19
                         .substr($codigo, 5, 14);
        
        $dv1 = Math::Mod10(substr($linhaDigitavel, 0, 9));
        $dv2 = Math::Mod10(substr($linhaDigitavel, 9, 10));
        $dv3 = Math::Mod10(substr($linhaDigitavel, 19, 10));

        #Inserindo os DVs em seus lugares
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv3, 29);
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv2, 19);
        $linhaDigitavel = String::putAt($linhaDigitavel, $dv1, 9);
       
        #Aplicando A linha digitável gerada à sua máscara
        $linhaDigitavel = String::applyMask($linhaDigitavel, $this->Banco->mascaraLinhaDigitavel);

        return $linhaDigitavel;
    }
    
    /*public function linhaDigitave(){
        $codigo = $this->geraCodigo();
        
        #Inicio $data vazia
        $data = array();
        
        #A partir das posições indicadas pelo layout, separo os dados dentro
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
    }/**/
    
    /**
      * Renderiza o template
      * 
      * @version 0.1 18/05/2011 Initial
      *          0.2 20/05/2011 Retirado o echo
      *          1.0 20/05/2011 Movido da classe Boleto para a classe OB
      */
    public function render(){
        $this->Template->render($this->Template->Template);
        flush();
    }
    
    # # # # # # # # # # # # # # # # # # # # # #
    # # 
    # #     FUNÇÕES AUXILIARES
    # #
    # # # # # # # # # # # # # # # # # # # # # #

    
    /**
      * Pega uma url relativa
      * 
      * @version 0.1 19/05/2011 Initial
      */
    public static function url($url = null){
        return preg_replace('([\\\/]+)','/',dirname(dirname(dirname(substr(__FILE__, strlen($_SERVER['DOCUMENT_ROOT']))))) . '//' . $url);
    }
    
    /**
      * Completa com zeros adicionais à esquerda até o valor informado
      * 
      * @version 0.1 18/05/2011 Initial
      */
   public static function zeros($text, $length, $cut = false){
        return str_pad($text, $length, '0', STR_PAD_LEFT);
    }
    
    /**
      * Completa com zeros adicionais à esquerda até o valor informado,
      * alterando a variável original, e cortando caso o valor tenha
      * mais caracteres que o permitido
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public static function normalize(&$var, $length){
        return String::left(self::zeros($var, $length), $length);
    }
}