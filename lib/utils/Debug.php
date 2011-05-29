<?php

class Debug {
    public static function handleErrors($handler = null) {
        if(is_null($handler)) {
            $handler = array('Debug', 'handleError');
        }

        set_error_handler($handler, -1);
        ini_set('error_log', OB_DIR . '/log/error.log');
    }

    public static function handleError($code, $message, $file, $line) {
        throw new ErrorException($message, 0, $code, $file, $line);
    }

    public static function log($message) {
        error_log($message);
    }

    public static function pr($data, $legend=null) {
        if(is_null($legend)):
            echo PHP_EOL . '<pre>' .PHP_EOL . print_r($data, true) . PHP_EOL . '</pre>' . PHP_EOL;
        else:
            echo '<fieldset><legend>'   . $legend
                                        . '</legend><pre>'
                                        . print_r($data, true)
                                        . '</pre></fieldset>';
        endif;
    }

    public static function dump($data) {
        self::pr(var_export($data, true));
    }

    public static function trace() {
        return debug_backtrace();
    }
}

function pr($data, $legend = null) {
    Debug::pr($data, $legend);
}

function dump($data) {
    Debug::dump($data);
}