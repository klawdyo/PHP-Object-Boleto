<?php
/**
-----------------------
    COPYRIGHT
-----------------------
    Licensed under The MIT License.
    Redistributions of files must retain the above copyright notice.

    @author  Cláudio Medeiros <contato@claudiomedeiros.net>
    @package ObjectBoleto http://github.com/klawdyo/PHP-Object-Boleto
    @subpackage ObjectBoleto.Lib.Bancos
    @license http://www.opensource.org/licenses/mit-license.php The MIT License
    
-----------------------
    CHANGELOG
-----------------------
    17/05/2011
    [+] Inicial
    
    
    
  */
class Itau extends Banco{
    public $Codigo = '341';
    public $Nome = 'Itau';
    public $Css;
    public $Image = 'itau.png';
    
    /*
        @var array $tamanhos
        Armazena os tamanhos dos campos na geração do código de barras
        e da linha digitável
        
          1   5   10   15   20   25   30   35   40  44
          |   |    |    |    |    |    |    |    |   |
          34196307200000666061750000005160148348516000
          34198307100000666061750000005190148348519000
          └-┘↓↓└--┘└--------┘└-┘└------┘↓└--┘└---┘↓└-┘
           | ||  |      |     |     |   |  |   |  | |--- Zeros fixos
           | ||  |      |     |     |   |  |   |  └----- Módulo10 da agência e conta
           | ||  |      |     |     |   |  |   └-------- Código do aplicativo (2 fixo)
           | ||  |      |     |     |   |  └------------ Data no formato juliano
           | ||  |      |     |     |   └--------------- Módulo10 da ag, conta, carteira e NoNum
           | ||  |      |     |     └------------------- Nosso número
           | ||  |      |     └------------------------- Código do cedente
           | ||  |      └------------------------------- Valor
           | ||  └-------------------------------------- Fator de vencimento
           | |└----------------------------------------- Dígito verificador do código
           | └------------------------------------------ Código da Moeda
           └-------------------------------------------- Código do banco
        
        
    */
    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco'             => 3,   //identificação do banco
        'Moeda'             => 1,   //Código da moeda: real=9
        'DV'                => 1,   //Dígito verificador geral da linha digitável
        'FatorVencimento'   => 4,   //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => 10,  //Valor nominal do título
        #Campos variávies
        'Carteira'          => 3,
        'NossoNumero'       => 8,  //Nosso número
        'Agencia'           => 4,
        'Conta'             => 5
    );

    /*
        @var string $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco.
        Cada variável é precedida por dois-pontos (:), que serão substituídas
        pelos seus respectivos valores
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:Carteira:NossoNumero:DigitoAgContaCarteiraNNum:Agencia:Conta:DigitoAgConta000';
    
    
    public function particularidade($object){
        //pr($object->Data);
        $digAgConta = $object->Data['Agencia'] . $object->Data['Conta'];
        $digAgContaCartNNum = $object->Data['Agencia'] . $object->Data['Conta']
                            . $object->Data['Carteira'] . $object->Data['NossoNumero'];
        
        $object->Data['DigitoAgContaCarteiraNNum'] = Math::Mod10($digAgContaCartNNum);
        $object->Data['DigitoAgConta'] = Math::Mod10($digAgConta);
        $object->Boleto->NossoNumero = Math::Mod11($object->Boleto->NossoNumero, 0, 0, true);
    }
    
}