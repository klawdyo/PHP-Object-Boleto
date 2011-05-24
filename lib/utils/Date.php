<?php 

class Date{
    public static $convert = array(
        'years' => 217728000,
        'months' => 18144000,
        'weeks' => 604800,
        'days' => 86400,
        'hours' => 3600,
        'minutes' => 60,
        'seconds' => 1
    );
    public static $holidays = array(
        '01/01', '21/04', '01/05', '07/09', '12/10',
        '02/11', '20/11', '15/11', '25/12'
    );
    public static $format = 'Y-m-d';
    

    /**
      * Calcula a diferença entre duas datas
      *
      * @version 0.1 Initial
      *
      * @param date $date Data informada
      * @param date optional $otherDate Data a ser comparada com a
      *     informada em $date. Caso seja nula, será considerada o
      *     dia de hoje
      * @param $unit optional Informa o tipo de retorno, podendo ser em
      *     days, months, years, hours, etc.
      */
    public static function diff($date, $otherDate = null, $unit = 'days') {
        if(is_null($otherDate)):
            $otherDate = time();
        else:
            $otherDate = strtotime($otherDate);
        endif;
        $date = strtotime($date);
        $time = abs($date - $otherDate);
        
        return ceil($time / self::$convert[$unit]);
    }

    /**
      * Adiciona um período de tempo a uma data
      *
      * @version 0.1 Initial
      *
      * @param $date Data inicial
      * @param $num Número de períodos a serem adicionados
      * @param $unit Tipo do período que está sendo adicionado
      * @param $format Formato de saída
      */
    public static function add($date, $num, $unit = 'days', $format = null) {
        $new_date = self::addInTime($date, $num, $unit);
        return self::format($new_date, $format);
    }

    /**
      * Devolve o próximo dia útil
      *
      * @version 0.1 Initial
      *          0.2 24/05/2011 Adicionado o parâmetro $format
      *
      * @param $date Data a ser comparada
      * @param $format Formato opcional de saída
      */
    public static function nextWorkday($date = null, $format = null) {
        if(is_null($date)):
            $date = date('Y-m-d');
        endif;
        $date = self::add($date, 1, 'days', 'Y-m-d');
        
        while(!self::isWorkday($date)):
            $date = self::add($date, 1, 'days', 'Y-m-d');
        endwhile;
        
        return self::format($date, $format);
    }

    /**
      * Retorna true se a data informada é um dia útil
      *
      * @version 0.1 Initial
      *
      * @param $date optional Data a ser verificada. HOJE se nada for
      *     informado
      */
    public static function isWorkday($date = null) {
        if(is_null($date)):
            $date = date('Y-m-d');
        endif;
        return !self::isWeekend($date) && !self::isHoliday($date);
    }

    /**
      * Verifica se a data informada é no final de semana
      *
      * @version 0.1 Initial
      *
      * @param $date optional Data a ser verificada. HOJE se nada for
      *     informado
      */
    public static function isWeekend($date = null) {
        if(is_null($date)):
            $time = time();
        else:
            $time = strtotime($date);
        endif;
        
        return date('N', $time) >= 6;
    }

    /**
      * Verifica se a data informada é um feriado
      *
      * @version 0.1 Initial
      *
      * @param $date optional Data a ser verificada. HOJE se nada for
      *     informado
      */
    public static function isHoliday($date = null) {
        $date = self::format($date, 'd/m');
        return in_array($date, self::$holidays);
    }

    /**
      * Formata uma data informada
      *
      * @version 0.1 Initial
      *
      * @param $date A data a ser formatada
      * @param $format O formato de saída. Se não for informado, será
      *     utilizado o formato definido em Date::$format
      */
    public static function format($date, $format = null) {
        if(is_null($format)):
            $format = self::$format;
        endif;
        if(is_null($date)):
            $date = time();
        elseif(!is_numeric($date)):
            $date = strtotime($date);
        endif;
        
        return date($format, $date);
    }

    /**
      * Retorna o tempo decorrido entre a data informada em $date e agora.
      *
      * @version 0.1 Initial
      *
      * @param $date a data a ser comparada
      */
    public static function timeAgo($date = null) {
        if(is_null($date)):
            $date = time();
        else:
            $date = strtotime($date);
        endif;
        $now = time();
        $since = $now - $date;

        $times = array_values(self::$convert);
        $names = array_keys(self::$convert);
        foreach($times as $i => $seconds):
            if(($count = floor($since / $seconds))):
                break;
            endif;
        endforeach;
        $name = preg_replace('/s$/', '', $names[$i]);
        $ago = ($count == 1) ? '1 ' . $name : $count . ' ' . $name . 's';

        if($i + 1 < count(self::$convert)):
            $name = preg_replace('/s$/', '', $names[$i + 1]);
            $seconds2 = $times[$i + 1];
            if(($count = floor(($since - ($seconds * $count)) / $seconds2))):
                $ago .= ', ' . (($count == 1) ? '1 ' . $name : $count . ' ' . $name . 's');
            endif;
        endif;
        
        return $ago;
    }

    /**
      * Adiciona um feriado à tabela de feriados em tempo de execução
      *
      * @version 0.1 Initial
      *
      * @param $date
      */
   public static function addHoliday($date) {
        self::$holidays []= $date;
    }

    /**
      * Define a formatação padrão a ser utilizada pela classe
      *
      * @version 0.1 Initial
      *
      * @param $format O formato padrão
      */
    public static function setDefaultFormat($format) {
        self::$format = $format;
    }

    /**
      * Adiciona unidades de tempo a uma data informada, mas retorna o
      * valor em UnixTimeStamp
      *
      * @version 0.1 Initial
      *
      * @param $date A data informada
      * @param $num O número de períodos
      * @param $unit A unidade dos períodos adicionados
      */
    protected static function addInTime($date, $num, $unit = 'days') {
        if(is_null($date)):
            $date = time();
        else:
            $date = strtotime($date);
        endif;
        return $date + $num * self::$convert[$unit];
    }
    
    /**
      * @todo
      * Converte entre formatos de data
      *
      * @version 0.1 Initial
      *
      * @param
      * @param
      * @param
      */
    public static function convertFrom($fromFormat, $date, $toFormat = null){
        
        
    }
}