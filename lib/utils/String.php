<?php

class String{
    
    
    protected static $self;
    
    /**
      * Construtor
      *
      */
    public function __construct(){
        mb_internal_encoding('utf-8');
    }
    
    /**
      * Instância singleton
      * 
      * @version
      *     0.1 18/05/2011 Initial
      * 
      * @param string $text Texto a ser verificado
      * @param int $length Tamanho máximo
      */
    public static function instance(){
        if(empty(self::$self)){
            self::$self = new String;
        }
        
        return self::$self;
    }
    
    /**
      * Corta um texto, exibindo somente os $num caracteres do início
      * 
      * @version
      *     0.1 18/05/2011 Initial
      * 
      * @param string $text Texto a ser verificado
      * @param int $length Tamanho máximo
      */
    public static function left($text, $length){
        self::instance();
        return mb_substr($text, 0, $length);
    }
    
    /**
      * Corta um texto, exibindo somente os $num caracteres ao final
      * 
      * @version
      *     0.1 18/05/2011 Initial
      * 
      * @param string $text Texto a ser verificado
      * @param int $length Tamanho máximo
      */
    public static function right($text, $length){
        self::instance();
        return mb_substr($text, -1 * $length);
    }
    
    
    /**
      * Corta um texto em um tamanho definido, adicionando reticências ou outro
      * indicador de continuação ao final.
      * 
      * @version
      *     0.1 Initial
      *     0.2 09/10/2010 Adicionado suporte às funções multi-byte.
      * 
      * @param string $text Texto a ser verificado
      * @param int $length Tamanho máximo
      * @param string $complement Complemento para o texto cortado. O padrão
      *     é reticências: "..."
      * @param bool $cut Define se as palavras podem ser cortadas, caso o
      *     tamanho máximo seja atingido no meio de uma delas.
      *     
      */
    public function slice($text, $length, $complement = '&hellip;', $cut = false){
        $newText = mb_substr($text, 0, $length);
        
        //Se na string original, o tamanho definido já representar um espaço,
        //ou seja, o tamanho requerido não decepará a palavra, ou então, se
        //é permitido cortar a palavra na metade com $cut = true
        if(mb_substr($text, $length, 1) == ' ' || $cut === true):
            return $newText . $complement;
        endif;
        
        if(mb_strlen($text) > $length):
            //O último espaço encontrado na string
            $lastSpacePos = mb_strrpos($newText, " ");

            //Tem que encontrar pelo menos 1 espaço. Se encontrar, defina o
            //tamanho a ser cortado como sendo a posição desse espaço
            if($lastSpacePos !== false):
                $length = $lastSpacePos;
            endif;
            
            return mb_substr($newText, 0, $length) . $complement;
        else:
            return $text;
        endif;        
    }
    
    /**
      * Checa se a string passada está em UTF-8
      *
      * @version
      *     0.1 09/10/2010 Initial
      * 
      * @param string $text
      * @return bool TRUE caso a string esteja em utf-8
      */
    public function isUtf8($text){
        return mb_check_encoding($text, 'utf-8');
    }
    
    
    /**
      * Checa se a string passada está em UTF-8
      *
      * @version
      *     0.1 09/10/2010 Initial
      *     
      * @param string $text
      * @param mixed $verifyFollowings A lista dos charsets que serão usados
      *     para verificar se a string informada está em um deles.
      * @return string O nome do charset utilizado na string. A busca é feita
      *     entre os charsets indicados em $verifyFollowings
      */
    public function getCharset($text,
                               $verifyFollowings = array('utf-8', 'iso-8859-1')){
        
        //O "x" corrige um bug da função "mb_detect_string", que falha caso
        //a última letra da string seja acentuada.
        return mb_detect_encoding($text . 'x', $verifyFollowings);
    }
    
    /**
      * Converte para utf8 se ainda não estiver
      *
      * @version
      *     0.1 09/10/2010 Initial
      *
      * @param string $text A string que será convertida
      * @return String O texto convertido
      */
    public function toUtf8($text){
        if(!$this->isUtf8($text)):
            return utf8_encode($text);
        endif;
        
        return $text;
    }
    
    public static function insert($string, $data) {
        foreach($data as $key => $value):
            $regex = '%(:' . $key . ')%';
            $string = preg_replace($regex, $value, $string);
        endforeach;
        return $string;
    }
    public static function extract($string) {
        preg_match_all('%:([a-zA-Z-_]+)%', $string, $extracted);
        return $extracted[1];
    }
    //18/05/2011
    public static function putAt($text, $put, $at){
        return self::left($text, $at) . $put . mb_substr($text, $at);
    }
    //18/05/2011
    public static function applyMask($text, $mask){
        $length = strlen($text);
        $buff = '';

        $special = array('/', '.', '-', '_', ' ');

        for($i = 0, $j = 0; $i < $length; $i++, $j++){
            if(!isset($text[$i]) || !isset($mask[$j])) break;
            
            if(in_array($mask[$j], $special)){
                $buff .= $mask[$j];
                $j++;
            }
                $buff .= $text[$i];
        }
        
        return $buff;
    }
    
}