<?php
require 'Validation.php';
class Validar extends Validation{
    
    /**
     *	Valida um título eleitoral informado, verificando se o dígito
     *	verificador é válido, e, opcionalmente, se pertence a um estado determinado
     *	
     *	@version:	0.2 - 13/05/2009
     *	                0.3 - 27/05/2011 Transformado em static
     *	@param	string	sigla_uf	Estado da federação. Se não pertencer a esse
     *	estado, ou se o estado não existir, retorna erro.
     *	@param 	$msg Mensagem personalizada para esse campo. Caso seja null, error()
     *	roteará a mensagem para o padrão da função de validação
     *	@return	$this
     ***	
     *	FORMA DE CÁLCULO
     *	- Para o número 012345678914, as 8 primeiras posições representam o título,
     *	as posições 9 e 10 representam o código da UF, as posições 11 e 12
     *	representam o dígito verificador.
     *	- Para calcular o primeiro dígito, pegamos os 8 primeiros dígitos e os
     *	multiplicamos por 2, 3, 4... até 9, começando do primeiro dígito até o último.
     *	Depois somamos os resultados, e o total será dividido por 11. O RESTO
     *	dessa divisão será o primeiro DV.
     *	- Para o cálculo do segundo DV, pegamos os algarismos das posições 9 e 10,
     *	referentes ao UF e o caractere 11, que é o primeiro DV já calculado.
     *	Agora multiplicamos pelos algarismos 7, 8 e 9, respectivamente, e
     *	somamos seus resultados. O total será dividido por 11 e o segundo DV
     *	será o resto da divisão.
     *	TABELA DE UFs
                    $arr_uf = array(
        '01'=> 'SP','02'=> 'MG','03'=> 'RJ','04'=> 'RS','05'=> 'BA',
        '06'=> 'PR','07'=> 'CE','08'=> 'PE','09'=> 'SC','10'=> 'GO',
        '11'=> 'MA','12'=> 'PB','13'=> 'PA','14'=> 'ES','15'=> 'PI',
        '16'=> 'RN','17'=> 'AL','18'=> 'MT','19'=> 'MS','20'=> 'DF',
        '21'=> 'SE','22'=> 'AM','23'=> 'RO','24'=> 'AC','25'=> 'AP',
        '26'=> 'RR','27'=> 'TO','28'=> 'EX'
    );
     *	@param $msg Mensagem personalizada para esse campo. Caso  seja  null,  error()
     *				roteará a mensagem para o padrão da função de validação
     */
    public static function titulo($sigla_uf = null, $msg = null){
            //Só permite números
            if(eregi("([^0-9]+)", $this->nowdata())){
                    $this->error($msg, 'titulo', null, 'Só números são permitidos'); 
            }
            else{
                //	precisa ter 12 caracteres numéricos. retira tudo q nao for número e adiciona zeros à esquerda.
                $titulo = str_pad($this->nowdata(),12,"0",STR_PAD_LEFT);
        
                $tit = substr($titulo,0,8);
                $num_uf =  substr($titulo,8,2);
                $dv =  substr($titulo,10,2);
                $ignore_list = array('000000000000');
                
                if(in_array($titulo, $ignore_list))
                    return false;
                
                //1 dv
                for($i = 0; $i < 8; $i++){
                        $soma1 += $tit[$i] * ($i+2);
                }
                //2 dv
                $soma2 = $num_uf[0] * 7 + $num_uf[1] * 8 + ($soma1 % 11) * 9;
        
                if(($soma1 % 11) . ($soma2%11) != $dv){
                        $error = 5;
                }
                
                if($error > 0){
                        $this->error($msg, 'titulo'); 
                }
            }
            return $this;
    }

    /**
    *	Valida um PIS (Programa de Integração Social)
    *	
    *	@version:   0.3  18/05/2009
    *	            1.0  23/05/2011 - Importado do ValidationComponent.
    *	                            - Agora retorna true or false
    *	                            - Método static
     *	@param $pis Número do PIS
     *	@return	boolean True se for um número válido
    */
    public static function pis($pis){
            #permite pontos e traços, mas não deve permitir outras coisas
            $pis = str_pad(preg_replace("([^0-9]+)", '', $pis), 10, '0', STR_PAD_LEFT);
            #DV informado
            $dv = substr($pis,-1,1);
            #sequencia de números a serem calculados
            $seqcalc = "3298765432";
            
            $soma = 0;

            for($i = 0; $i < 10; $i++){
                $soma += $pis[$i] * $seqcalc[$i];
            }

            $dv1 = (($soma % 11) < 2) ? 0 : (11 - ($soma % 11));

            return ($dv1 != $dv);
    }
    
    /**
     *	function cpf()
     * Valida um CPF verificando seus algarismos e seus dígitos verificadores. 
     *	Para fins de validação, cpf() não leva em consideração as presenças de pontos e 
     *	traços ao número informado.
     *	
     *	@version:	0.3 18/05/2009 Initial
     *	                1.0 23/05/2011 - Método agora é static
     *	                               - Retorna true se for válido
     *	                               - Importado do ValidationComponent.
     *	                               
     *	@param $value CPF a ser verificado
     *	@return	$this
     */
    public static function cpf($value) {
        #permite pontos e traços, mas não deve permitir outras coisas
        $value = str_pad(preg_replace("([^0-9]+)", '', $value), 11, '0', STR_PAD_LEFT);

        $cpf = substr($value, 0, 9);
        $dv = substr($value,9,2);
        
        $soma = $soma2 = 0;
        for($i = 0; $i <= 9; $i++){
            $ignore_list[] = str_repeat($i, 11); //gerando ignore list
            @$soma += $cpf[$i] * (10 - $i);
            @$soma2 += $cpf[$i] * (11 - $i);
        }
        
        if(in_array($value, $ignore_list)){
                return false;
        }
        
        $dv1   = (($soma % 11) <= 1) ? 0 : (11 - ($soma % 11));
        $soma2 = ($soma2 + $dv[0] * 2) % 11;
        $dv2   = (($soma2 % 11) <= 1) ? 0 : (11 - ($soma2 % 11));
        //pr($dv1.$dv2);
        if($dv1 . $dv2 != $dv[0] . $dv[1]){
                return false;
        }
        return true;
    }
    
    /**
      * Valida uma CNH (Carteira nacional de habilitação)
      *
      * @version 0.1 Initial. Retirado da internet
      *          0.2 23/05/2011 - Transformado em static
      *                         - Algumas adaptações
      *                         - Importado do ValidationComponent.
      * 
      */
    public static function cnh($cnh) {
        $ret = false;
    
        if((strlen($cnh = preg_replace('/[^\d]/' , '' , $cnh)) == 11 )){
            $dsc = 0;

            for ( $i = 0 , $j = 9 , $v = 0 ; $i < 9 ; ++$i , --$j ){
                $v += (int) $cnh{ $i } * $j;
            }

            if ( ( $vl1 = $v % 11 ) >= 10 ) {
                $vl1 = 0;
                $dsc = 2;
            }

            for ( $i = 0 , $j = 1 , $v = 0 ; $i < 9 ; ++$i , ++$j ){
                $v += (int) $cnh{ $i } * $j;
            }

            $vl2 = ( $x = ( $v % 11 ) ) >= 10 ? 0 : $x - $dsc;
            $ret = sprintf( '%d%d' , $vl1 , $vl2 ) == substr( $cnh , -2 );
        }
        
        return $ret;
    }

    /**
     *	function cnpj()
     *	Valida um CNPJ.
     *	cnpj() não considera pontos, traços e barras.
     *	
     *	@version:	0.2 18/05/2009 
     *	                0.3 23/05/2011 - Agora retorna True se for um cnpj válido
     *                                 - Importado do ValidationComponent.
     *	                0.4 27/05/2011 Método transformado em  static
     *	                0.5 27/05/2011 Mudança do algoritmo
     *
     *	@param $cnpj CNPJ a ser verificado
     *	@return	boolean
     */
    public static function cnpj($cnpj = null){
        /*elimina tudo que não for números e acrescenta zeros à esquerda
        $cnpj = String::left(preg_replace("([^0-9])", "", $cnpj), 14);
        $dv   = String::right($cnpj, 2);
        $seqcalc1 =  "543298765432";
        $seqcalc2 = "6543298765432";
        
        $soma1 = $soma2 = 0;
        //faz as multiplicações
        for($i = 0; $i < 12; $i++){
            $soma1 += $cnpj[$i] * $seqcalc1[$i];
            $soma2 += $cnpj[$i] * $seqcalc2[$i];
        }
        
        $dv1 = (($soma1 % 11) < 2) ? 0 : (11 - ($soma1 % 11));

        $soma2 += $dv1 * 2;
        $dv2 = (($soma2 % 11) < 2) ? 0 : (11 - ($soma2 % 11));

        return $dv1 . $dv2 != $dv;/**/
        // Canonicalize input
        $cnpj = sprintf('%014s', preg_replace('{\D}', '', $cnpj));

        // Validate length and CNPJ order
        if ((strlen($cnpj) != 14)
                || (intval(substr($cnpj, -4)) == 0)) {
            return false;
        }

        // Validate check digits using a modulus 11 algorithm
        for ($t = 11; $t < 13;) {
            for ($d = 0, $p = 2, $c = $t; $c >= 0; $c--, ($p < 9) ? $p++
                                                                  : $p = 2) {
                $d += $cnpj[$c] * $p;
            }

            if ($cnpj[++$t] != ($d = ((10 * $d) % 11) % 10)) {
                return false;
            }
        }

        return true;
        
    }		
    
    
}