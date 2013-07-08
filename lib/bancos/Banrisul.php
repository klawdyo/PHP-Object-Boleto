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
        
        
          1   5   10   15   20   25   30   35   40  44
          |   |    |    |    |    |    |    |    |   |
          0419 100100000550002110000000012283256304168    //manual
          04191100100000550002110000000012283256304168    //gerado 
              |                |                    \/
              dv                                   dig.duplo
        
    */
    public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco'             => 3,  //identificação do banco
        'Moeda'             => 1,  //Código da moeda: real=9
        'DV'                => 1,  //Dígito verificador geral da linha digitável
        'FatorVencimento'   => 4,  //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => 10, //Valor nominal do título
        #Campos variávies
        'Agencia'           => 3,  //Código da agência
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
    public function particularidade($object){
        $codigo = String::insert('21:Agencia:CodigoCedente:NossoNumero041', $object->Data);
        $dv1 = Math::Mod10($codigo);
        $dv2 = Math::Mod11($codigo . $dv1);
        $object->Boleto->NossoNumero = Math::Mod11($object->Boleto->NossoNumero, 0, 0, true);
        
        return $object->Data['DuploDigito'] = self::DuploDigito($codigo);
    }
    
    /*
    
3.4.1.1 PRIMEIRO DÍGITO – MÓDULO 10
P1 – Multiplicar Os Dígitos Do Argumento Pelos Pesos 2,1,2,....Da Direita Para Esquerda;
P2 – Subtrair 9 Do Valor Obtido Em Cada Multiplicação Do P1 Se Superior A 9;
P3 – Efetuar Somatório Dos Resultados Das Multiplicações P1 Após P2;
P4 – Obter O Resto Da Divisão Inteira Do Somatório De P3 Por 10;
P5 – O Primeiro Dígito Será 10 Menos O Resto Da Divisão Inteira De P4;
P6 – Se O Resto Da Divisão Inteira De P4 For Zero, Então O Primeiro Dígito Será Zero.

3.4.1.2 SEGUNDO DÍGITO – MÓDULO 11
P7 – Multiplicar Os Dígitos Do Novo Argumento (Original Acrescido Do Primeiro Dígito) Pelos Pesos 2 A 7 Da Direita Para Esquerda;
P8 – Efetuar Somatório Dos Resultados Das Multiplicações De P7;
P9 – Obter O Resto Da Divisão Inteira Do Somatório De P8 Por 11;
P10 – O Segundo Dígito Será 11 Menos O Resto Da Divisão Inteira De P9;
P11 – Se O Resto Da Divisão Inteira De P9 For Zero, Então O Segundo Dígito Será Zero;
P12 – Se O Resto Da Divisão Inteira De P9 For 1 (Um), Então Somar 1 (Um)
    Ao Primeiro Dígito Calculado (Módulo 10) E Reiniciar A Partir De P7;
P13 – Se A Soma De 1 (Um) Ao Primeiro Dígito, Descrito No P12, For Maior Que 9, Então
    O Primeiro Dígito (Módulo 10) Será Zero;
P14 – Nos Casos De P12 E P13 O Primeiro Conserva Seu Valor Para O Seu Duplo-Dígito Final.

EXEMPLO DE CÁLCULO DO DUPLO-DÍGITO (NC):
Toma-se o argumento 00009194:
P1 - 9x1, 1x2, 9x1, 4x2
P2 - = 9, =2, =9, =8
P3 - 9 + 2 + 9 + 8 = 28
P4 - 28/10 resto 8
P5 - 10 - 8 = 2 (Primeiro Dígito)
P6 - (Não Se Aplica Neste Caso)
P7 - 9x6, 1x5, 9x4, 4x3, 2x2
P8 - 54 + 5 + 36 + 12 + 4 = 111
P9 - 111/11 resto 1
P10 – 11 – 1 = 10 (Inválido)
P11 - (Não Se Aplica Neste Caso)
P12 – 91943 (Novo Argumento)
P13 – (Não Se Aplica Neste Caso)
P14 – Primeiro Dígito Passa A Ser 3
P7 - 9x6, 1x5, 9x4, 4x3, 3x2
P8 - 54 + 5 + 36 + 12 + 6 = 113
P9 - 113/11 resto 3
P10 – 11 – 3 = 8 (Segundo Dígito)
P11 – (Não Se Aplica Neste Caso)
P12 – (Não Se Aplica Neste Caso)
P13 – (Não Se Aplica Neste Caso)
P14 – Primeiro Dígito Permanece Com 3 Resultado:
Argumento 00009194 Duplo Dígito = 38
Nota: Mesmo Não Constando No Exemplo, O Número Do Título Para O Banco Sempre Deve Ser Composto Por 8 (Oito) Dígitos, Neste Caso Deve Ser Completado Com Zeros A Esquerda.
    */
    public static function DuploDigito($num){
        #DV1 
        $dv1 = Math::Mod10($num);
        
        #DV2 - $num concatenado com $dv1, calculado com Mod11 com
        #multiplicador máximo 7
        $dv2 = Math::Mod11($num . $dv1, 10, 0, false, 7);
        
        #Se $dv2 = 10, adiciona 1 a $dv1 e recalcula $dv2
        #concatenando agora o novo $dv1
        if($dv2 == 10){
            $dv1++;
            $dv2 = Math::Mod11($num . $dv1, 10, 0, false, 7);
            
            #Se o novo valor de $dv1 for maior que 9, então
            #$dv1 passará a ser 0
            if($dv1 > 9){
                $dv1 = 0;
            }
        }
        
        return $dv1 . $dv2;
    }
}