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
class Hsbc extends Banco{
    public $Codigo = '399';
    public $Nome = 'Hsbc';
    //public $Css;
    public $Image = 'hsbc.png';
    
    /*
        @var array $tamanhos
        Armazena os tamanhos dos campos na geração do código de barras
        e da linha digitável
        
          1   5   10   15   20   25   30   35   40  44
          |   |    |    |    |    |    |    |    |   |
          39991100100000550002110000000012283256304168
          \./||\../\......../\...../\.........../\../|  
           . ..  .      .       .         .        . ... Código do aplicativo (2 fixo)
           . ..  .      .       .         .        ..... Data no formato juliano
           . ..  .      .       .         .............. Nosso número
           . ..  .      .       ........................ Código do cedente
           . ..  .      ................................ Valor
           . ..  ....................................... Fator de vencimento
           . ........................................... Dígito verificador do código
           . ........................................... Código da Moeda
           ............................................. Código do banco
                                                        
                                                        
                                                        
                                                        

        
    */
    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco'             => 3,  //identificação do banco
        'Moeda'             => 1,  //Código da moeda: real=9
        'DV'                => 1,  //Dígito verificador geral da linha digitável
        'FatorVencimento'   => 4,  //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => 10, //Valor nominal do título
        #Campos variávies
        'CodigoCedente'     => 7,
        'NossoNumero'       => 13,
        'DataVencimentoCalendarioJuliano' => 4,
        //'CodigoAplicativo'  => 1,
    );
    
    public $carteiras = array(4, 5);
    
    /*
        @var string $layoutCodigoBarras
        Armazena o layout que será usado para gerar o código de barras desse banco.
        Cada variável é precedida por dois-pontos (:), que serão substituídas
        pelos seus respectivos valores
     */
    public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:CodigoCedente:NossoNumero:DataVencimentoCalendarioJuliano2';
    
    /**
      * particularidade() Faz em tempo de execução mudanças que sejam imprescindíveis
      * para a geração correta do código de barras
      * Especificamente para o Hsbc, temos duas particularidas: Data no formato juliano, e
      * um dígito verificador triplo para o nosso número.
      *
      * @version 0.1 28/05/2011 Initial
      */
    public function particularidade($object){
        $object->Data['DataVencimentoCalendarioJuliano'] = '0000';
        $object->Data['NossoNumero'] = $this->geraCodigoDocumento($object->Data);
    }
    
    public function geraCodigoDocumento($dados){
        $dv1 = Math::Mod11($dados['NossoNumero']);
        $dv2 = $dados['Carteira'];
        $codigo = $dados['NossoNumero'] . $dv1 . $dv2;
        
        $data = OB::fatorVencimentoParaData($dados['FatorVencimento'], 'dmy');

        $dv3 = Math::Mod11($codigo + $data + $dados['CodigoCedente']);
        
        return OB::zeros($codigo . $dv3, $this->tamanhos['NossoNumero']);
    }
}