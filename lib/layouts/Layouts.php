<?php
//18/05/11
class Layouts{
    protected $nomeBanco;
    protected $logoBanco;
    
    protected $css = 'default';//css utilizado no boleto desse banco
    protected $template = 'default';
    
    public $relacoes = array(
        '001' => 'BB',
        '104' => 'Caixa',
        '237' => 'Bradesco',
    );
    
    
    /*
    Pegando os dados do boleto constantes no código de barras
    */
    protected $posicoes = array(
                     //(Inicio, Tamanho). Inicia em 0
        'Banco'         => array(0,3),    //identificação do banco
        'Moeda'         => array(3,1),    //Código da moeda: real=9
        'DV'            => array(4,1),    //Dígito verificador geral da linha digitável
        'Vencimento'    => array(5,4),    //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'         => array(9,10),  //Valor nominal do título
        'Agencia'       => array(19,4),  //Código da agencia, sem dígito
        'Carteira'      => array(23,2),  //Código da Carteira
        'NossoNumero'   => array(25,11),  //Nosso número
        'Conta'         => array(36,7),  //Conta corrente do cedente, sem o dígito
    );
    
    /* @var $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco
     */
    protected $layoutCodigoBarras = ':Banco:Moeda:Vencimento:Valor:Agencia:Carteira:NossoNumero:Conta0';
    
    /* @var $layoutCodigoBarras
        Armazena o layout que será usado para gerar a linha digitável nesse banco
     */
    protected $layoutLinhaDigitavel = ':Banco:Moeda:Agencia:Carteira:NossoNumero:Conta:Vencimento:Valor';

    /* @var $formataLinhaDigitavel
       Máscara para a linha digitável
     */
    protected $mascaraLinhaDigitavel = '00000.00000 00000.000000 00000.000000 0 00000000000000';
    
    
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