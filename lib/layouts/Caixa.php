<?php

class Caixa extends Layouts{
    
    protected $logoBanco = 'logocaixa.png';
    protected $nomeBanco = 'Caixa';
    
    /*
        Pegando os dados do boleto constantes no código de barras
    */
    protected $posicoes = array(
                                //Inicio, Tamanho. Inicia em 0
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
    
    /*
        @var $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco
     */
    protected $layoutCodigoBarras = ':banco:moeda:dv:vencimento:valor:agencia:carteira:nosso_numero:conta:zero_fixo';
    /*
        @var $layoutCodigoBarras
        Armazena o layout que será usado para gerar a linha digitável nesse banco
     */
    protected $layoutLinhaDigitavel = ':banco:moeda:agencia:carteira:nosso_numero:conta_corrente:vencimento:valor';
    
}