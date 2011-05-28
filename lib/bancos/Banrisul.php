<?php

class Banrisul extends Banco{
    public $Codigo = '041';
    public $Nome = 'Banrisul';
    //public $Css;
    public $Image = 'banrisul.png';
    
    /*
        @var array $tamanhos
        Armazena os tamanhos dos campos na geração do código de barras
        e da linha digitável
        
        Especificações sobre as posições 20 a 44 do código de barras
        Posições 20 a 20 Produto: 
                        "1" Cobrança Normal, Fichário emitido pelo BANRISUL
                        "2" Cobrança Direta, Fichário emitido pelo CLIENTE.
        Posição 21 a 21 Constante "1"
        Posição 22 a 24 Agência Cedente sem Número de Controle.
        Posição 25 a 31	Código do Cedente sem Número de Controle.
        Posição 32 a 39	Nosso Número sem Número de Controle.
        Posição 40 a 42	Constante "041".
        Posição 43 a 44	Duplo Dígito referente às posições 20 a 42 (módulos 10 e 11).
    */
    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco'             => 3,  //identificação do banco
        'Moeda'             => 1,  //Código da moeda: real=9
        'DV'                => 1,  //Dígito verificador geral da linha digitável
        'FatorVencimento'   => 4,  //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => 10, //Valor nominal do título
        #Campos variávies
        'Agencia'           => 3,  //Código do cedente
        'CodigoCedente'     => 7,  //Código do cedente
        'NossoNumero'       => 8,  //Nosso número
    );

    /*
        @var string $layoutCodigoBarras
        Armazena o layout que será usado para gerar o código de barras desse banco.
        Cada variável é precedida por dois-pontos (:), que serão substituídas
        pelos seus respectivos valores
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor21:Agencia:CodigoCedente:NossoNumero041:DuploDigito';
    
    /**
      * particularidade() Faz em tempo de execução mudanças que sejam imprescindíveis
      * para a geração correta do código de barras
      * Particularmente para o Banrisul, ele acrescenta ao array OB::$Data, que
      * guarda as variáveis que geram o código de barras, uma nova variável
      * $DuploDigito, específica desse banco
      *
      * @version 0.1 28/05/2011 Initial
      */
    public function particularidade(&$data){
        $codigo = String::insert('21:Agencia:CodigoCedente:NossoNumero041', $data);
        return $data['DuploDigito'] = Math::Mod10($codigo) . Math::Mod11($codigo);
    }
}