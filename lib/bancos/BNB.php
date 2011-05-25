<?php

class BNB extends Banco{
    public $nome = 'Banco do Nordeste';
    //public $css = 'caixa.css';
    public $image = 'bnb.png';
    
    /*
        @var array $posicoes
        Armazena os dados de posições dos valores dentro do código de barras.
        
        @example
        O Fator de Vencimento (FatorVencimento) inicia na posição
        "5" (contando a partir do zero), e tem 4 caracteres: (5,4)
    */
    public $posicoes = array(
        #Campos comuns a todos os bancos
        'Banco'         => array(0,3),   //identificação do banco
        'Moeda'         => array(3,1),   //Código da moeda: real=9
        'DV'            => array(4,1),   //Dígito verificador geral da linha digitável
        'FatorVencimento'=>array(5,4),   //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'         => array(9,10),  //Valor nominal do título
        #Campos variávies
        'Agencia'       => array(19,4),  //Código da agencia, sem dígito
        'Conta'         => array(23,7),  //Código da Carteira
        'DVConta'       => array(30,1), //Dígito da conta do Cedente
        'NossoNumero'   => array(31,7),  //Nosso número
        'DVNossoNumero' => array(38, 1),
        'Carteira'      => array(39, 2),
    );

    /*
        @var $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:Agencia:Conta:DVConta:NossoNumero:DVNossoNumero:Carteira000';
    
    /*
        @var $layoutCodigoBarras
        Armazena o layout que será usado para gerar a linha digitável nesse banco
     */
    public $layoutLinhaDigitavel = ':Banco:Moeda:Agencia:Carteira:NossoNumero:Conta:FatorVencimento:Valor';

    
    //public $obrigatorios = array();
}