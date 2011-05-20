<?php
/**
-----------------
Configuration
-----------------
1) Copy Pdf.php to /lib/utils/Pdf.php.
2) Require lib/utils/Pdf.php in your models and start using it. 
 
-----------------------
Usage
-----------------------
<?php
        //Required if a key "url" is defined
        //define("DOMPDF_ENABLE_REMOTE", true);
        
        require 'lib/utils/Pdf.php';
        
        $pdf = new Pdf(array(
            
            //Library name. Required.
            'library' => 'mPdf', //DomPdf is available
            
            //View to render
            'view' => 'certificados/participantes',
            
            //Layout to be used
            'layout' => 'certificados',
            
            //Url. Only if a remote file.
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


*/



class Pdf {
    protected $object = array();
    
    public function __construct($data = array()) {
        if(array_key_exists('library', $data)):
            $library = array_unset($data, 'library');
            $library .= '_Library';
            require_once 'lib/utils/Pdf/' . $library . '.php';
           //pr($library); 
            $this->object = new $library($data);
        else:
            throw new PdfException('Library name not specified');
        endif;
    }
    public function render() {
        $this->object->render();
    }
    public function download($filename = null){
        $this->object->download($filename);
    }
    public function save($filename) {
        $this->object->save($filename);
    }
}

class PdfException extends Exception{}