<?php
/*
    Class Barcode
    Essa classe tem o objetivo de fazer a geração de códigos de barra
    em imagem única
    
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
        require 'lib/utils/Barcode.php';
        
        //Chame as funções normalmente
        Barcode::getImage('123455689') pega o resource da imagem gerada
        echo Barcode::getHtml('123455689') retorna o html para gerar a imagem
        
    -----------------------------------------------
        CHANGELOG
    -----------------------------------------------
    
    17/05/2011
    [+] Initial 
    
    -----------------------------------------------
        TO DO
    -----------------------------------------------
    

    
    -----------------------------------------------
        KNOWN BUGS
    -----------------------------------------------

    
 */
class Barcode{
    //Imagem
    public $image;
    //dimensões do código de barras
    public $width = 480;
    public $height= 50;
    //Cores
    public $white;
    public $black;
    public $poolblue;
    //Configurações
    public $n = 1 ; //narrow: fino
    public $w = 3 ; //wide:largo
    public $start_code = '0000';
    public $end_code = '100';
    public $codes = array(  //0111000010
        //0       //1      //2      //3     //4
        '00110', '10001', '01001', '11000', '00101',
        //5       //6      //7      //8     //9
        '10100', '01100', '00011', '10010', '01010'
    );
    
    private $current_x = 0;
    private $color = 0;
    
    
    /**
      *
      *
      * @version 0.1 17/05/2011 Initial
      */
    public function __construct(){
        header("Content-type:image/png");
        $this->image = imagecreate( $this->width, $this->height);
        
        //Alocando cores
        $this->white = imagecolorallocate($this->image, 255, 255, 255);
        $this->black = imagecolorallocate($this->image, 0, 0, 0);
        
    }
    
    /**
      *
      *
      * @version 0.1 17/05/2011 Initial
      */
    public function addBar($x, $width, $color){
        $color = $color == 0 ? $this->black : $this->white;
        imagefilledrectangle($this->image, $x, 0, $x + $width, $this->height, $color);
    }
    
    /**
      *
      *
      * @version 0.1 17/05/2011 Initial
      */
    public function getBarcode($code){
        //Chamando quem vai processar a imagem
        $this->process($code);
        //Exibindo a image
        imagepng($this->image); 
        imagedestroy($this->image);
    }
    
    /**
      *
      *
      * @version 0.1 17/05/2011 Initial
      */
    public function __destruct(){
        $this->current_x = 0;
        $this->color = 0;
        $this->image = null;
    }
    
    /**
      *
      *
      * @version 0.1 17/05/2011 Initial
      */
    public static function getImage($code){
        $barcode = new Barcode();
        $barcode->getBarcode($code);
    }
    
    /**
      *
      *
      * @version 0.1 17/05/2011 Initial
      */
    public static function getHtml($code){
        //return '<img src="' . OB::url('barcode/' . $code) . '" />';
        return '<img src="' . OB::url('lib/utils/Barcode.php') . '?n=' . $code . '" />';
    }
    
    /**
      *
      *
      * @version 0.1 17/05/2011 Initial
      */
    public function interleave($code){
        $n1 = substr($code, 0, 1);
        $n2 = substr($code, 1, 1);
        $buff = '';

        for($i = 0; $i < 5; $i++){
            $buff .= substr($this->codes[$n1], $i, 1) . substr($this->codes[$n2], $i, 1);
        }

        return $buff;
    }
    
    /**
      *
      *
      * @version 0.1 17/05/2011 Initial
      */
    public function process($code){
        $n = strlen($code);
        //se o número de caracteres for ímpar, adicione um 0 no início
        $code = (strlen($code) % 2) <> 0 ? '0' . $code : $code;

        //Pegando cada número do código
        for($i = 0; $i < $n; $i+=2){
            $current = $this->interleave(substr($code, $i, 1) . substr($code, $i+1, 1));

            //Está no início? Adiciona o início
            if($i == 0) $current = $this->start_code . $current;
            //Está no final? Adiciono o final
            if($i == ($n - 2)) $current .= $this->end_code;
            
            //Transformando cada número os binários utilizados
            for($j = 0; $j < strlen($current); $j++){
                //Se for 1, a largura é 3. Se for 0, a largura é 1
                $width = substr($current, $j, 1) == 1 ? 3 : 1;
                //pr($width);
                
                $this->addBar($this->current_x, $width, $this->color);
                //Se a última cor for preta, mudo pra branca
                $this->color = $this->color == 0 ? 1 : 0;
                //Adiciona o x atual
                $this->current_x += $width;
            }
        }
        //Adiciona espaço em branco ao final
        $this->addBar($this->current_x, 1, $this->color);
    }
}
if(isset($_GET['n'])) Barcode::getImage($_GET['n']);