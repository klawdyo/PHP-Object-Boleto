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
    25/05/2011
    [+] Inicial
    
    
    
  */
class BNB extends Banco{
    public $Codigo = '004';
    public $Nome = 'Banco do Nordeste';
    //public $Css = 'bnb.css';
    public $Image = 'bnb.png';
    
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
        'Agencia'           => 4,   //Código da agencia, sem dígito
        'Conta'             => 7,   //Número da conta
        'DigitoConta'       => 1,   //Dígito da conta do Cedente
        'NossoNumero'       => 7,   //Nosso número
        'DigitoNossoNumero' => 1,   //Dígito do nosso número
        'Carteira'          => 2,   //Código da carteira
     // 'Zeros'             => 3,   //Zeros
    );

    /*
        @var string $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco.
        Cada variável é precedida por dois-pontos (:), que serão substituídas
        pelos seus respectivos valores
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:Agencia:Conta:DigitoConta:NossoNumero:DigitoNossoNumero:Carteira000';

	/**
      * particularidade() Faz em tempo de execução mudanças que sejam imprescindíveis
      * para a geração correta do código de barras
      *
      *
      *
      * @version 0.1 28/05/2011 Initial
      */
    public function particularidade($object){
		$object->Boleto->NossoNumero = Math::Mod11($object->Boleto->NossoNumero, 0, 0, true);
		$object->Data['DigitoConta'] = Math::Mod10($object->Data['Conta']);
		$object->Data['DigitoNossoNumero'] = Math::Mod10($object->Data['NossoNumero']);
    }

}