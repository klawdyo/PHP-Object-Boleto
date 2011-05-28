<?php
    define('OB_DIR', dirname(__FILE__));
   
    require OB_DIR . '/lib/utils/Debug.php';

    /*
        CORE
     */
    require OB_DIR . '/lib/core/OB.php';
    require OB_DIR . '/lib/core/Banco.php';
    require OB_DIR . '/lib/core/Vendedor.php';
    require OB_DIR . '/lib/core/Cliente.php';
    require OB_DIR . '/lib/core/Boleto.php';
    require OB_DIR . '/lib/core/Configuracao.php';
    require OB_DIR . '/lib/core/Template.php';
    
    /*
        UTILS
     */
    require OB_DIR . '/lib/utils/String.php';
    require OB_DIR . '/lib/utils/Barcode.php';
    require OB_DIR . '/lib/utils/Math.php';
    require OB_DIR . '/lib/utils/Validar.php';
