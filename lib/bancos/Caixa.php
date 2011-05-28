<?php

class Caixa extends Banco{
    public $Codigo = '104';
    public $Nome = 'Caixa';
    public $Css = 'caixa.css';
    public $Image = 'caixa.png';
    
    /*
        @var array $tamanhos
        Armazena os tamanhos dos campos na geração do código de barras
        e da linha digitável
    */
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
        @var string $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco.
        Cada variável é precedida por dois-pontos (:), que serão substituídas
        pelos seus respectivos valores
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor1:CodigoCedente9:NossoNumero';
}