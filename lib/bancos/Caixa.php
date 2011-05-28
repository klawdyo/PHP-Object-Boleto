<?php

class Caixa extends Banco{
    public $Codigo = '104';
    public $Nome = 'Caixa';
    public $Css = 'caixa.css';
    public $Image = 'caixa.png';
    
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
        //'Carteira'          => array(19, 1) //1 fixo
        'CodigoCedente'     => array(20,6),  //Código da agencia, sem dígito
        //'NoveFixo'          => array(25,1),
        'NossoNumero'       => array(26,17),  //Código da Carteira
    );/**/
    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco'             => 3,   //identificação do banco
        'Moeda'             => 1,   //Código da moeda: real=9
        'DV'                => 1,   //Dígito verificador geral da linha digitável
        'FatorVencimento'   => 4,   //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => 10,  //Valor nominal do título
        #Campos variávies
        'CodigoCedente'     => 6,  //Código do cedente
        'NossoNumero'       => 17,  //Nosso número
    );

    /*
        @var $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor1:CodigoCedente9:NossoNumero';
    
    /*
        @var $layoutLinhaDigitavel
        Armazena o layout que será usado para gerar a linha digitável nesse banco
                                1       10        20        30        40  44
                                |        |         |         |         |   |
                                10497498600001000001870000900000000001234567
                                ban,moe,dv,venc,vr,ag,  conta, dvc,nosnum
                                00490.01605 00119.320000 00531.550006 4 10690000100000
     */
    //public $layoutLinhaDigitavel = ':Banco:Moeda:CodigoCedente:NossoNumero:FatorVencimento:Valor';

    
    //public $obrigatorios = array();    
}