<?php
/**
-----------------
Configuration
-----------------
1) Download DomPdf (http://code.google.com/p/dompdf/) and copy dompdf folder to /lib/utils in your application.
2) Copy Pdf.php to /lib/utils/Pdf.php.
3) Require lib/utils/Pdf.php in your models and start using it. 
 
-----------------------
Usage
-----------------------
<?php
        //Required if a key "url" is defined
        //define("DOMPDF_ENABLE_REMOTE", true);
        
        require 'lib/utils/Pdf.php';
        
        $pdf = new DomPdf(array(
            
            //View to render
            'view' => 'certificados/participantes',
            
            //Layout to be used
            'layout' => 'certificados',
            
            //Url. Only if a remote file. Required constant DOMPDF_ENABLE_REMOTE as TRUE
            //'url' => 'http://www.google.com.br',
            
            //Paper settings. 
            'paper' => array(
                             'size'=>'A4',
                             'orientation'=>'landscape' //portrait or landscape
                             ),
            
            //Sending data to view
            'data' => array(
                'name' => 'Cláudio Medeiros',
                'email' => 'contato@claudiomedeiros.net'
            ),
        ));
        
        //To download
        $pdf->download('download'.time().'.pdf');
        
        //To save
        $pdf->save('/files/'.time().'.pdf');

-----------------------------------------

/**/


require_once 'lib/utils/Pdf/dompdf/dompdf_config.inc.php';

class DomPdf_Library {
    protected $view = null;
    protected $data = array();
    protected $layout = false;
    public $DomPdf = null;
    protected $url = null;//if a remote file.
    protected $paper = array();
    
    public function __construct($data = array()) {
        foreach($data as $key => $value):
            $this->{$key} = $value;
        endforeach;

        $this->DomPdf = new DOMPDF();
        $this->paper();
    }
    public function render() {
        if(!$this->url):
            $view = new View();
            $content = $view->render($this->view, $this->data, $this->layout);
            $this->DomPdf->load_html($content);
        else:
            $this->DomPdf->load_html_file($this->url);
        endif;

        $this->DomPdf->render();
    }
    public function download($filename = null){
        $this->render();
        $this->DomPdf->stream($filename);
    }
    public function save($filename) {
        $this->render();
        file_put_contents($filename, $this->DomPdf->output());
    }
    public function paper(){
        $this->paper =
            array_merge(array('size'=>'A4', 'orientation'=>'portrait'), $this->paper);
        
        $this->DomPdf->set_paper($this->paper['size'], $this->paper['orientation']);
    }

}