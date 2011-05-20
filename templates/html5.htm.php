<?php
//pr($OB);
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
            
            <!--DIV PERSONALIZADA-->
            <?php if($OB->Template->blockExists('custom')): ?>
            <div id="personalizada">
                <?php echo $OB->Template->getBlock('custom'); ?>
            </div>
            <?php endif; ?>
            
            <!--DIV DADOS DO VENDEDOR-->
            <div id="dados_vendedor">
                
            </div>
            
            <!--DIV RECIBO DO SACADO-->
            <div id="recibo">
                
            </div>
            
            <!--DIV FICHA DE COMPENSACAO-->
            <?php
                echo $OB->Template->getTemplate('ficha_compensacao');
            ?>
        </div>
    </body>
</html>