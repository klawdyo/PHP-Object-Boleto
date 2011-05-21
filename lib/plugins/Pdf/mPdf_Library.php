<?php
/**
-----------------
Configuration
-----------------
1) Download mPdf (http://mpdf.bpm1.com/download) and copy mpdf folder to /lib/utils in your application.
2) Copy MPdf.php to /lib/utils/mPdf.php.
3) Require lib/utils/mPdf.php in your controllers and start using it. 
 
-----------------------
Usage
-----------------------
<?php
        
        require 'lib/utils/mPdf.php';
        
        $pdf = new mPdf(array(
            
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
        $pdf->download('downloaded-filename.pdf');
        
        //To save. Path relative to /SPAGHETTI_ROOT
        $pdf->save('/files/saved-filename.pdf');

-----------------------------------------

/**/


require_once 'lib/utils/Pdf/mpdf/mpdf.php';

class mPdf_Library {
    protected $view = null;
    protected $data = array();
    protected $layout = false;
    public    $mPDF = null;
    protected $url = null;//if a remote file.
    protected $paper = array();
    
    public function __construct($data = array()) {
        foreach($data as $key => $value):
            $this->{$key} = $value;
        endforeach;
        
        $this->paper();
        pr($this->paper);
        $this->mPDF = new mPDF('UTF-8', $this->paper);
        //pr($this->mPDF->CurOrientation);
    }
    public function render() {
        if(!$this->url):
            $view = new View();
            $content = $view->render($this->view, $this->data, $this->layout);
            $this->mPDF->WriteHTML($content);
        else:
            $this->mPDF->WriteHTML(file_get_contents($this->url));
        endif;
    }
    public function download($filename = null){
        $this->render();
        $this->mPDF->Output($filename, 'D');
    }
    public function save($filename) {
        $this->render();
        $filename = Filesystem::path($filename);
        $this->mPDF->Output($filename, 'F');
    }
    protected function paper(){
        $paper = array_merge(array('size' => 'A4', 'orientation' => 'portrait'), $this->paper);
        
        if($paper['orientation'] == 'portrait'):
            $this->paper = $paper['size'];
        else:
            $this->paper = $paper['size'] . '-L';
        endif;
    }
}