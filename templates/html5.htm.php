<?php
#Esse template usará os seguintes blocks: ficha_compensaca.htm.php
$OB->Template->addBlock('ficha_compensacao');
//pr($OB->Template,'html5');
?>
<html>
    <head>
        <title><?php echo $OB->Template->Title;?></title>
        <?php
            $OB->Template->addStyle('default');
            echo $OB->Template->getStyles();
            ?>
    </head>
    
    <body>
        <!--    DIV CENTRAL    -->
        <div id="container" class="container">
            
            <!--DIV DADOS DO VENDEDOR-->
            <div id="dados_vendedor">
                
            </div>
            
            <!--DIV RECIBO DO SACADO-->
            <div id="recibo">
                
            </div>
            
            <!--DIV FICHA DE COMPENSACAO-->
            <?php
                if($OB->Template->blockLoaded('ficha_compensacao')){
                    echo $OB->Template->getBlock('ficha_compensacao', array('OB'=>$OB));
                }
                else{
                    echo 'ficha de compensacao nao foi carregada';
                }
            ?>
        </div>
    </body>
</html>