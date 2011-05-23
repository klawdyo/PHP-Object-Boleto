<?php
    //$ob->plugin('Pdf')->save('/public/files/filename.pdf');
            
class Plugin{
    
    public $plugins = array();
    public static $object;
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function __construct(){

    }
    
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public static function instance(){
        if(empty(self::$object)){
            self::$object = new Plugin;
        }
        return self::$object;
    }
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public static function load($pluginName){
        $self = self::instance();
        $filename = self::path($pluginName);
        if(file_exists($filename)){
            $className = $pluginName . 'Plugin';
            require $filename;
            return $self->plugins[$pluginName] = new $className($self->parent);
        }
        else{
            throw new Exception('Plugin nao existe');
        }
    }
    /**
      *
      * @version 0.1 18/05/2011 Initial
      *
      */
    public static function path($pluginName){
        return OB_DIR . '/lib/plugins/' . $pluginName . '.plugin.php';
    }
    
}