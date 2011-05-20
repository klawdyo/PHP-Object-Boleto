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
       Sequência de templates adicionados à página
    */
    private $Styles = array(
        //'blueprint/screen.css' => 'screen',
        //'blueprint/print.css' => 'print',
        //'blueprint/ie.css' => 'screen',
        //'default.css' => 'screen',
        //'print.css' => 'print',
    );
    
    /*
       @var array $Styles
       Armazena o html dos blocks
    */
    public $Blocks = array();
    
    /**
      *
      * @version 0.1 19/05/2011 Initial
      *
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
      *
      */
    public function addStyle($filename, $media = 'all' ){
        if(!preg_match('/(.css)$/', $filename)){
            $filename .= '.css';
        }
        
        $this->Styles[$filename] = $media;
        
        return $this;
    }
    /**
      * Retorna os styles css formatados como html
      * 
      * @version 0.1 19/05/2011 Initial
      *
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
      * Envia para o template um bloco de código para um lugar previamente
      * definido.
      * Ao construir um template, é possível determinar locais que receberão
      * esses blocos. Ex.:
      * Em um determinado local do template default.htm.php, eu criei um
      * bloco chamado 'personalizado'. Nesse bloco, eu posso carregar o
      * html do template 'demonstrativo.htm.php'. Nesse caso, eu chamaria
      * o método Template::addBlock('personalizado', 'demonstrativo', $data);
      * Onde $data seria um array de dados que seriam usados dentro do
      * template 'demonstrativo.htm.php'
      * 
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function addBlock($blockName, $templateName, $data = array()){
        $this->Blocks[$blockName] = $this->render($templateName, $data);
    }
    
    /**
      * O bloco existe?
      * 
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function blockExists($blockName){
        return array_key_exists($blockName, $this->Blocks);
    }
    
    /**
      * Pega o html do bloco pré-carregado
      * 
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function getBlock($blockName, $data = array()){
        if($this->blockExists($blockName)){
            return $this->Blocks[$blockName];
        }
    }
    
    /**
      * Pega o html de um template qualquer informado em $templateFilename,
      * adiciona os dados e o carrega dentro de outro template
      * 
      * @version 0.1 19/05/2011 Initial
      *
      */
    public function getTemplate($templateFilename, $data = array()){
        $blockName = 'template_' . time();
        //$data = array_merge($data, array('OB' => $this->parent));
        $this->addBlock($blockName, $templateFilename, $data);
        //$this->addBlock($blockName, $templateFilename, array('OB' => $this->parent));
        
        return $this->getBlock($blockName);
    }
    
    
    /**
      * Renderiza templates
      * 
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function render($template, $data){
        $template = OB_DIR . '/templates/' . $template . '.htm.php';
        if(file_exists($template)){
            extract($data);
            ob_start();
            require $template;
            //ob_end_flush();
            return ob_get_clean();
        }
        else{
            throw new Exception('Template "' . $template . '" não existe.');
        }
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
      *
      */
    public function setTitle($title){
        $this->Title = $title;
        return $this;
    }
    
    /**
      * Define qual o template que será usado
      * 
      * @version 0.1 18/05/2011 Initial
      *
      */
    public function setTemplate($template){
        $this->Template = $template;
        return $this;
    }

}