<?php
/*
    Class Templates.
    Essa class permitirá alterar os dados constantes na exibição do boleto,
    adicionar informações extras, etc.

*/

class Template{
    /*
       @var string $Title
       Título da página
    */
    public $Title = 'Object Boleto';

    /*
       @var string $Template
       Template utilizado na página
    */
    public $Template = 'default';
    
    /*
       @var array $Styles
       Sequência de estilos adicionados à página
    */
    private $Styles = array();
    
    /*
       @var array $Data
       Guarda o objeto pai enviado
    */
    protected $Data = array();
    
    /**
      * Construtor da classe
      * 
      * @version 0.1 19/05/2011 Initial
      */
    public function __construct(&$obj){
        $this->parent = $obj;
    }
    
    /**
      * Adiciona estilos css ao template
      * 
      * @version 0.1 18/05/2011 Initial
      *          0.2 19/05/2011 - Só um estilo igual é adicionado
      *                         - Styles podem ser adicionados a partir dos
      *                         templates, blocks e serão enviados diretamente
      *                         para o template padrão
      *          0.3 22/05/2011 - $filename pode receber um array de estilos
      *                         - Não é mais possível o envio de variáveis dos
      *                         blocks para o template.
      */
    public function addStyle($filename, $media = 'all' ){
        #$filename pode receber um array de arquivos
        if(is_array($filename)){
            foreach($filename as $file){
                $this->addStyle($file);
            }
            return $this;
        }
        #Tornando opcional informar a extensão do CSS
        if(!preg_match('/(.css)$/', $filename)){
            $filename .= '.css';
        }
        #Guardando o estilo
        $this->Styles[$filename] = $media;
        
        return $this;
    }
    /**
      * Retorna os styles css formatados como html
      * 
      * @version 0.1 19/05/2011 Initial
      */
    public function getStyles(){
        if(!empty($this->Styles)){
            $html = '';
            foreach($this->Styles as $file => $media){
                $html .= '<link rel="stylesheet" type="text/css" media="'
                      . $media . '" href="' .  OB::url('/public/css/' . $file)
                      . '" />' . PHP_EOL;
            }
        }
        return $html;
    }
    
    /**
      * Pega o html do bloco pré-carregado
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function getBlock($blockName, $data = array()){
        //$data = array_merge($data, array('OB' => (object)$this->Data));
        
        return $this->render('/blocks/'.$blockName, $data);
    }
    
    /**
      * Renderiza templates
      * 
      * @version 0.1 18/05/2011 Initial
      *          1.0 22/05/2011 Consertado o bug dos Output bufferin
      */
    public function render($template, $data = array()){
        $data = array_merge($data, array('OB' => $this->parent));
        $template = OB_DIR . '/templates/' . $template . '.htm.php';
        
        if(file_exists($template)){
            extract($data);
            ob_start();
            require $template;
        }
        else{
            throw new Exception('Template "' . $template . '" não existe.');
        }
    }
    
    /**
      * Manda variáveis para os templates/blocks
      * 
      * @version 0.1 20/05/2011 Initial
      */
    public function set($var, $value){
        $this->$var = $value;
        return $this;
    }
    
    
    # # # # # # # # # # # # # # # # # # # # # #
    # # 
    # #     SETTERS E TRATAMENTO DOS VALORES DE ENTRADA
    # #
    # # # # # # # # # # # # # # # # # # # # # #

    
    /**
      * Configura o título da página do template
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function setTitle($title){
        $this->Title = $title;
        return $this;
    }
    
    /**
      * Define qual o template que será usado
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function setTemplate($template){
        $this->Template = $template;
        return $this;
    }

}