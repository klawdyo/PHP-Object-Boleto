<?php
/*
    Class Math
    Essa classe tem o objetivo de concentrar funções matemáticas usadas
    no sistema.
    
    -----------------------------------------------
        COPYRIGHT
    -----------------------------------------------

    Licensed under The MIT License.
    Redistributions of files must retain the above copyright notice.

    @author  Cláudio Medeiros <contato@claudiomedeiros.net>
    @package ObjectBoleto http://github.com/klawdyo/PHP-Object-Boleto
    @subpackage ObjectBoleto.Lib.Utils
    @license http://www.opensource.org/licenses/mit-license.php The MIT License
    
    -----------------------------------------------
        HOW TO USE
    -----------------------------------------------
        //Inclua a class no arquivo
        require 'lib/utils/Math.php';
        
        //Chame as funções normalmente
        echo Math::Mod11('261533'); //Retorna 9
        echo Math::Mod10('261533'); //Retorna 4
        
    -----------------------------------------------
        CHANGELOG
    -----------------------------------------------
    
    17/05/2011
    [+] Mod11() calcula o módulo 11 do número informado
    [+] Mod10() calcula o módulo 10 do número informado
    [+] financing() calcula a prestacao de um financiamento considerando
        periodo, valor inicial e juros
    
    22/05/2011
    [m] Correção de bug em Mod11()
    
    24/05/2011
    [m] Mod10() e Mod11() agora podem retornar o valor original formatado
        juntamente com o dígito calculado pelo algoritmo
    
    28/05/2011
    [m] Adicionado $maxFactor em Mod11() como quinto parâmetro
    [m] $separator foi movido para o sexto parâmetro
    
    -----------------------------------------------
        TO DO
    -----------------------------------------------
    
    - Cálculo de parcelas em um parcelamento simples, com arredondamento,
    retirada dos centavos para outra prestação, etc.
    
    -----------------------------------------------
        KNOWN BUGS
    -----------------------------------------------
    Ao passar números como inteiros, e que comecem com 0, o PHP
    entendará tratar-se de um octal e o cálculo será errado. A solução
    é sempre evitar adicionar à esquerda do número, ou sempre passar
    o número entre aspas, mantendo como string e evitando a conversão
    automática para octal.
    
    
 */
class Math{
    
    /**
      * method Mod11()
      * Calcula o módulo 11 de um número, conforme esquema abaixo, retirado
      * de http://pt.wikipedia.org/wiki/D%C3%ADgito_verificador
      
            +---+---+---+---+---+---+   +---+
            | 2 | 6 | 1 | 5 | 3 | 3 | - | 9 |<---
            +---+---+---+---+---+---+   +---+
              |   |   |   |   |   |
              x7  x6  x5  x4  x3  x2
              |   |   |   |   |   |
              =14 =36 =5  =20 =9  =6
              +---+---+---+---+---+-> = (90 x 10) / 11 = 81, resto 9 => Dígito = 9
          
            +---+---+---+---+---+---+   +---+---+
            | 2 | 6 | 1 | 5 | 3 | 3 | - | 9 | 4 |<---
            +---+---+---+---+---+---+   +---+---+
              |   |   |   |   |   |       |
              x8  x7  x6  x5  x4  x3      x2
              |   |   |   |   |   |       |
              =16 =42 =6  =25 =12 =9      =18
              +---+---+---+---+---+-> = (128 x 10) / 11 = 116, resto 4 => Dígito = 4
      
      * @version 0.1 17/05/2011 Initial
      *          0.2 22/05/2011 Bug corrigido
      *          0.3 24/05/2011 Adicionados os parâmetros $returnFull e $separator
      *          0.4 28/05/2011 Adicionado o parâmetro $maxFactor
      *          0.5 19/10/2013 Corrigido erro no retorno
      *
      * @param $number O número informado
      * @param $ifTen Caso o resto da divisão seja 10, o que colocar
      *     em seu lugar? Existem exemplos de bancos que adicionam
      *     "0", outros "1", outros "X", outros "P", etc
      * @param $ifZero Se o resultado for zero, substituir por algum outro valor?
      * @param $returnFull Deve retornar o valor completo, incluindo o dígito,
      *     ou somente o cálculo da divisão?
      * @param $maxFactor Estipula o fator máximo de múltiplicação a ser aplicado
      *     nos algarismos do número informado
      * @param $separator Separador para o dígito calculado
      * @return mixed
      */
    public static function Mod11($number, $ifTen = '0', $ifZero = '0',
                                 $returnFull = false, $maxFactor = 9, $separator = '-'){
        $numLen = strlen($number) - 1;
        $sum = 0;
        $factor = 2; //Inicial
        
        #Loop pelos algarismos, de trás pra frente. O último número
        #é multiplicado pelo fator 2, o penúltimo por 3, e assim por diante.
        #Quando o fator ficar maior que $maxFactor, retorno seu valor para 2
        for($i = $numLen; $i >= 0; $i --){
            $sum += substr($number, $i, 1) * $factor;
            $factor = $factor >= $maxFactor ? 2 : $factor + 1;
        }
        
        #Resto da divisão
        $rest = ($sum * 10) % 11;
        
        #Verificando se o resto é 10 ou zero. //v0.5
        if($rest === 10){$rest = $ifTen;}
        elseif($rest === 0){$rest = $ifZero;}
        
        #Se $returnFull===false, retorna só o resto
        if($returnFull === false)
            return $rest;
        else
            return $number . $separator . $rest;
    }
    
    
    /**
      * Method Mod10()
      * Calcula o módulo 10 de um número, conforme o esquema a seguir
      *
      * @version 0.1 17/05/2011 Initial
      *          0.2 24/05/2011 Adicionados os parâmetros $returnFullNumber e $separator
      * 
      * @tutorial
        +---+---+---+---+---+---+   +---+
        | 2 | 6 | 1 | 5 | 3 | 3 | - | 4 |
        +---+---+---+---+---+---+   +---+
          |   |   |   |   |   |
         x1  x2  x1  x2  x1  x2
          |   |   |   |   |   |
         =2 =12  =1 =10  =3  =6
         +2 +1+2 +1 +1+0 +3  +6 = 16
        +---+---+---+---+---+-> = (16 / 10) = 1, resto 6 => DV = (10 - 6) = 4
      * Se o resto for diferente de 0, o resultado será 10 menos esse número
      *
      * @param $number Número a ser calculado o módulo 10
      * @param $returnFull Deve retornar o valor completo, incluindo o dígito,
      *    ou somente o cálculo da divisão?
      * @param $separator Separador para o dígito calculado
      * @return integer 
      */
    public static function Mod10($number, $returnFullNumber = false, $separator = '-'){
        $numLen = strlen($number) - 1;
        $sum = 0;
        $factor = 2;
        
        for($i = $numLen; $i >= 0; $i --){
            $result = substr($number, $i, 1) * $factor;
            
            if($result >= 10){
                $result = substr($result, 0, 1) + substr($result, 1, 1);
            }
            
            $sum += $result;
            $factor = $factor == 2 ? 1 : 2;
        }
        //Resto da divisão
        $rest = $sum % 10;
        
        $rest = $rest <> 0 ? 10 - $rest : $rest;
        
        if($returnFullNumber === false){
            return $rest;
        }
        else{
            return $number . $separator . $rest;
        }
    }
    
    /**
      * http://pt.wikipedia.org/wiki/Tabela_price#C.C3.A1lculo
      */
    public static function financing($investimento, $juros, $periodo) {
        return ($investimento * $juros) / (1 - (1 / pow((1 + $juros), $periodo)));
    }
}