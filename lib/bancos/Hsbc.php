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
        39999498900002952951122334000001234567815512
        39991498900002952951122334001234567894315512    -
        └-┘↓↓└--┘└--------┘└-----┘└-----------┘└--┘↓  
         | ||  |      |       |         |        | └-- Código do aplicativo (2 fixo)
         | ||  |      |       |         |        └---- Data no formato juliano
         | ||  |      |       |         └------------- Nosso número
         | ||  |      |       └----------------------- Código do cedente
         | ||  |      └------------------------------- Valor
         | ||  └-------------------------------------- Fator de vencimento
         | |└----------------------------------------- Dígito verificador do código
         | └------------------------------------------ Código da Moeda
         └-------------------------------------------- Código do banco
                                                      
                                                      
          Array
          (
              [Banco] => 399
              [Moeda] => 9
              [Valor] => 0000055000
              [NossoNumero] => 0039104766340
              [FatorVencimento] => 1001
              [CodigoCedente] => 0351202
              [DataVencimentoCalendarioJuliano] => 0000
          )                                                        
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
    
    
    /*
        @var $carteiras
        Identifica as carteiras disponíveis para esse banco.
        
        - A primeira carteira sempre é a carteira padrão.
        - Se a carteira for um array, esse array deverá conter as diferenças
        nos tamanhos entre essa carteira e a carteira padrão. Se for uma
        string, será considerado que os tamanahos são os mesmos da carteira
        padrão, e o valor será o nome da carteira.
        - Só é necessário informar os campos cujos tamanhos sejam diferentes
        dos da carteira padrão.
        Abaixo, "CNR" é a carteira padrão, e "CNR Fácil" é a segunda opção
        de carteira. No "CNR Fácil", há apenas as mudanças no NossoNumero e no
        CodigoCedente. Os demais campos são iguais
     */
    public $carteiras = array(
        'CNR',
        'CNR Fácil' => array('NossoNumero' => 7, 'CodigoCedente' => 13),
    );
    
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
      *
      * @version 0.1 28/05/2011 Initial
      */
    public function particularidade($object){
        if($object->Vendedor->Carteira == 'CNR Fácil'){
            $object->Data['DataVencimentoCalendarioJuliano'] = '0000';
        }
        else{
            $object->Data['DataVencimentoCalendarioJuliano'] = $this->julianDays($object->Boleto->Vencimento);
        }
        $object->Data['NossoNumero'] = $this->geraCodigoDocumento($object->Data);
        $object->Boleto->NossoNumero = Math::Mod11($object->Boleto->NossoNumero, 0, 0, true);        
    }
    
    /**
      * HSBC usa um dígito verificador triplo no NossoNumero.
      * 
      * @version 0.1 28/05/2011 Inicial
      */
    public function geraCodigoDocumento($dados){
        #dv1 é o Mod11 do NossoNumero
        $dv1 = Math::Mod11($dados['NossoNumero']);
        
        #Concatena o NossoNumero a dv1
        $codigo = (int) $dados['NossoNumero'] . $dv1;

        #Calcula a data de vencimento no formato dmy, em barras e com o ano com 2 digitos
        $data = OB::fatorVencimentoParaData($dados['FatorVencimento'], 'dmy');
        
        #Se o identificador for "4", dv3 é o Mod11 da soma do NossoNumero
        #concatenado a dv1 e dv2, a data sem barras e o código do cedente.
        #Se o identificador for "5", dv3 é o modulo 11 da soma donosso
        #numero concatenado e do codigo do cedente
        if($dados['Carteira'] == 'CNR'){
            $codigo .= 4;
            $dv3 = Math::Mod11($codigo + $data + $dados['CodigoCedente']);
        }
        else{
            $codigo .= 5;
            $dv3 = Math::Mod11($codigo + $dados['CodigoCedente']);
        }
        
        #Retorno com 13 caracteres
        return OB::zeros($codigo . $dv3, $this->tamanhos['NossoNumero']);
    }
    
    /**
      * Calcula a data juliana para uma data informada no formato d/m/a
      *
      * @version 0.1 28/05/2011 Initial
      *          0.2 31/05/2011 Formatação geral   
      */
    public function julianDays($date) {
        $date = preg_split('%[/-]+%', $date);
    
        $dataFinal = mktime(0,0,0,$date[1],$date[0],$date[2]);
        $dataInicial = mktime(0,0,0,12,31,$date[2]-1);
    
        return OB::zeros((int)(($dataFinal - $dataInicial)/(60*60*24)), 3) . String::right($date[2],1);
    }


}