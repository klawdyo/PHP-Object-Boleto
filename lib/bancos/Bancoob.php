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
    28/05/2011
    [+] Inicial
    
    
    
  */
class Bancoob extends Banco{
    public $Codigo = '756';
    public $Nome = 'Bancoob';
    //public $Css;
    public $Image = 'bancoob.png';
    
    /*
        @var array $tamanhos
        Armazena os tamanhos dos campos na geração do código de barras
        e da linha digitável

          1   5   10   15   20   25   30   35   40  44
          |   |    |    |    |    |    |    |    |   |
          75692100100000550002010001000000111228563001     
          └-┘↓↓└--┘└--------┘↓└--┘└┘└-----┘└┘└----┘└-┘
           | ||  |     |     | |  |    |   |   |    └--- Número da Parcela do boleto
           | ||  |     |     | |  |    |   |   └-------- Nosso número       
           | ||  |     |     | |  |    |   └------------ Ano da emisão
           | ||  |     |     | |  |    └---------------- Código do Cedente                
           | ||  |     |     | |  └--------------------- Modalidade de cobrança (01)
           | ||  |     |     | └------------------------ Agência
           | ||  |     |     └-------------------------- Carteira
           | ||  |     └-------------------------------- Valor
           | ||  └-------------------------------------- Fator de Vencimento
           | |└----------------------------------------- Dígito do código de barras
           | └------------------------------------------ Código da moeda
           └-------------------------------------------- Código do banco
            
            
    */
    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco'             => 3,  //identificação do banco
        'Moeda'             => 1,  //Código da moeda: real=9
        'DV'                => 1,  //Dígito verificador geral da linha digitável
        'FatorVencimento'   => 4,  //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => 10, //Valor nominal do título
        #Campos variávies
        'Carteira'          => 1,  //Código da agência
        'Agencia'           => 4,  //Código do cedente
        //'ModalidadeCobranca'=> 2,  //Nosso número
        'CodigoCedente'     => 7,  //Nosso número
        'AnoEmissao'        => 2,  //Nosso número //São 8 números, mas os 2 primeiros são sempre referente ao ano de emissão do boleto. Exemplo: 2011, todos os nossos números devem iniciar com 11
        'NossoNumero'       => 6,  //Nosso número //São 8 números, mas os 2 primeiros são sempre referente ao ano de emissão do boleto. Exemplo: 2011, todos os nossos números devem iniciar com 11
        'NumParcela'        => 3,  //Nosso número
    );

    /*
        @var string $layoutCodigoBarras
        Armazena o layout que será usado para gerar o código de barras desse banco.
        Cada variável é precedida por dois-pontos (:), que serão substituídas
        pelos seus respectivos valores
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:Carteira:Agencia01:CodigoCedente:AnoEmissao:NossoNumero:NumParcela';
    
    /**
      * particularidade() Faz em tempo de execução mudanças que sejam imprescindíveis
      * para a geração correta do código de barras
      * Particularmente para o Banrisul, ele acrescenta ao array OB::$Data, que
      * guarda as variáveis que geram o código de barras, uma nova variável
      * $DuploDigito, específica desse banco
      *
      * @version 0.1 28/05/2011 Initial
      */
    public function particularidade($object){
        $object->Data['NumParcela'] = OB::zeros($object->Boleto->NumParcela, 3);
        $object->Data['AnoEmissao'] = date('y');
        $object->Boleto->NossoNumero = Math::Mod11($object->Boleto->NossoNumero, 0, 0, true);
    }
}