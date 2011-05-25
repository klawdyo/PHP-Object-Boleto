<?php
//18/05/11
class Banco{
    /*
        @var array $nome
        Armazena o nome do banco
    */
    public $nome;
    
    /*
        @var array $image
        Armazena o nome da imagem da logomarca do banco
    */
    public $image;
    
    /*
        @var array $css
        Armazena o arquivo CSS utilizado por esse banco
    */
    public $css;
    
    /*
        @var array $relacoes
        Armazena a relação entre os mais diversos bancos e os nomes dos
        seus arquivos. Os nomes devem estar iguais, inclusive em relação
        ao caso.
        Fonte: http://www.febraban.org.br/Bancos.asp
     */
    public $relacoes = array(
        '001' => 'BB',
        '003' => 'BancoAmazonia',
        '004' => 'BNB',
        '033' => 'Santander',
        '070' => 'BRB', //Banco de Brasília
        '104' => 'Caixa',
        '237' => 'Bradesco',
        '318' => 'Bmg',
        '341' => 'Itau',
        '356' => 'Real',
        '409' => 'Unibanco',
        '623' => 'Panamericano',
    );
    
    
    /*
        @var array $posicoes
        Armazena os dados de posições dos valores dentro do código de barras.
        
        @example
        O Fator de Vencimento (FatorVencimento) inicia na posição
        "5" (contando a partir do zero), e tem 4 caracteres: (5,4)
    */
    public $posicoes = array(
                     //(Inicio, Tamanho). Inicia em 0
                     
        #Campos comuns a todos os bancos
        'Banco'         => array(0,3),   //identificação do banco
        'Moeda'         => array(3,1),   //Código da moeda: real=9
        'DV'            => array(4,1),   //Dígito verificador geral da linha digitável
        'FatorVencimento'=>array(5,4),   //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'         => array(9,10),  //Valor nominal do título
        
        #Campos variáveis de banco para banco
        'Agencia'       => array(19,4),  //Código da agencia, sem dígito
        'Carteira'      => array(23,2),  //Código da Carteira
        'NossoNumero'   => array(25,12), //Nosso número
        'Conta'         => array(36,7),  //Conta corrente do cedente, sem o dígito
    );
    
    /*
        @var $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:Agencia:Carteira:NossoNumero:Conta0';
    
    /*
        @var $layoutCodigoBarras
        Armazena o layout que será usado para gerar a linha digitável nesse banco
     */
    public $layoutLinhaDigitavel = ':Banco:Moeda:Agencia:Carteira:NossoNumero:Conta:FatorVencimento:Valor';

    /*
        @var $formataLinhaDigitavel
        Máscara para a linha digitável
     */
    public $mascaraLinhaDigitavel = '00000.00000 00000.000000 00000.000000 0 00000000000000';
    
    
    /**
      * Construtor da classe
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function __construct(){

    }
    
    /**
      * Carrega o arquivo e as configurações de layout do banco informado
      * 
      * @version 0.1 20/05/2011 Initial
      */
    public function load($codigo){
        if(array_key_exists($codigo, $this->relacoes)){
            $banco = $this->relacoes[$codigo];
            $filename = OB_DIR . '/lib/bancos/' . $banco . '.php';

            if(file_exists($filename)){
                require $filename;
                return new $banco;
            }
            else{
                throw new Exception('O arquivo /lib/bancos/' . $banco. '.php não existe.');
            }
        }
        else{
            throw new Exception('O banco ' . $banco. ' não existe em Banco::$relacoes');
        }
    }
    
    /**
      * Normaliza as variáveis de acordo com os seus tamanhos exatos
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function normalize($valor, $variavel){
        if(array_key_exists($variavel, $this->posicoes)){
            $length = $this->posicoes[$variavel][1];
            if(strlen($valor) < $length){
                return OB::zeros($valor, $length);
            }
            else{
                return String::left($valor, $length);
            }
        }
        else{
            throw new Exception(" A chave \"{$variavel}\" não existe no layout");
        }
    }

    
}