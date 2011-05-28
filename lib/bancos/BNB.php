<?php

class BNB extends Banco{
    public $nome = 'Banco do Nordeste';
    //public $css = 'bnb.css';
    public $image = 'bnb.png';
    
    /*
        @var array $posicoes
        Armazena os dados de posições dos valores dentro do código de barras.
        
        @example
        O Fator de Vencimento (FatorVencimento) inicia na posição
        "5" (contando a partir do zero), e tem 4 caracteres: (5,4)
    */
    /*public $posicoes = array(
        #Campos comuns a todos os bancos
        'Banco'             => array(0,3),   //identificação do banco
        'Moeda'             => array(3,1),   //Código da moeda: real=9
        'DV'                => array(4,1),   //Dígito verificador geral da linha digitável
        'FatorVencimento'   =>array(5,4),   //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => array(9,10),  //Valor nominal do título
        #Campos variávies
        'Agencia'           => array(19,4),  //Código da agencia, sem dígito
        'Conta'             => array(23,7),  //Código da Carteira
        'DigitoConta'       => array(30,1), //Dígito da conta do Cedente
        'NossoNumero'       => array(31,7),  //Nosso número
        'DigitoNossoNumero' => array(38, 1),
        'Carteira'          => array(39, 2),
    );/**/
    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco'             => 3,   //identificação do banco
        'Moeda'             => 1,   //Código da moeda: real=9
        'DV'                => 1,   //Dígito verificador geral da linha digitável
        'FatorVencimento'   => 4,   //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => 10,  //Valor nominal do título
        #Campos variávies
        'Agencia'           => 4,   //Código da agencia, sem dígito
        'Conta'             => 7,   //Número da conta
        'DigitoConta'       => 1,   //Dígito da conta do Cedente
        'NossoNumero'       => 7,   //Nosso número
        'DigitoNossoNumero' => 1,   //Dígito do nosso número
        'Carteira'          => 2,   //Código da carteira
    );

    /*
        @var $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:Agencia:Conta:DigitoConta:NossoNumero:DigitoNossoNumero:Carteira000';
    
    /*
        @var $layoutLinhaDigitavel
        Armazena o layout que será usado para gerar a linha digitável nesse banco
                                1       10        20        30        40  44
                                |        |         |         |         |   |
                                00494106900001000000016000119320000053155000
                                ban,moe,dv,venc,vr,ag,  conta, dvc,nosnum,dvn,cart,000
                                00490.01605 00119.320000 00531.550006 4 10690000100000
     */
    //public $layoutLinhaDigitavel = ':Banco:Moeda:Agencia:Conta:DigitoConta:NossoNumero:DigitoNossoNumero:Carteira000:FatorVencimento:Valor';

    
    //public $obrigatorios = array();
}