<?php
    require '../../Spaghetti/Spa03.1-dev/lib/core/debug/Debug.php';
    require 'lib/utils/Math.php';
    require 'lib/utils/String.php';
    require 'lib/utils/Barcode.php';
    require 'lib/core/ObjBoleto.php';
    
    
    //Código gerado
    $ob = new OB;
    //pr($ob->geraCodigo()); //23791497600002952951172060007589645204030050
    pr($ob->linhaDigitavel());

    
