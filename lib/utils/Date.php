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
    public static function add($date, $num, $unit = 'days', $format = null) {
        $new_date = self::addInTime($date, $num, $unit);
        return self::format($new_date, $format);
    }
    public static function nextWorkday($date = null) {
        if(is_null($date)):
            $date = date('Y-m-d');
        endif;
        $date = self::add($date, 1, 'days', 'Y-m-d');
        
        while(!self::isWorkday($date)):
            $date = self::add($date, 1, 'days', 'Y-m-d');
        endwhile;
        
        return self::format($date);
    }
    public static function isWorkday($date = null) {
        if(is_null($date)):
            $date = date('Y-m-d');
        endif;
        return !self::isWeekend($date) && !self::isHoliday($date);
    }
    public static function isWeekend($date = null) {
        if(is_null($date)):
            $time = time();
        else:
            $time = strtotime($date);
        endif;
        
        return date('N', $time) >= 6;
    }
    public static function isHoliday($date = null) {
        $date = self::format($date, 'd/m');
        return in_array($date, self::$holidays);
    }
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
   public static function addHoliday($date) {
        self::$holidays []= $date;
    }
    public static function setDefaultFormat($format) {
        self::$format = $format;
    }
    protected static function addInTime($date, $num, $unit = 'days') {
        if(is_null($date)):
            $date = time();
        else:
            $date = strtotime($date);
        endif;
        return $date + $num * self::$convert[$unit];
    }
    
    public static function convertFrom($fromFormat, $date, $toFormat = null){
        
        
    }
}