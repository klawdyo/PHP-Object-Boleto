<?php
#Adicionando um style para ser carregado
$OB->Template->addStyle('default');

#Carregando o estilo referente ao banco, caso ele tenha
if(!empty($OB->Banco->Css))
    $OB->Template->addStyle($OB->Banco->Css);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title><?php echo $OB->Template->Title;?></title>
        <?php echo $OB->Template->getStyles();?>
    </head>
    
    <body>
        <!--    DIV CENTRAL    -->
        <div id="container">
            
            <!--DIV DADOS DO VENDEDOR-->
            <div id="dados_vendedor">
                
            </div>
            
            <!--DIV RECIBO DO SACADO-->
            <?php
                echo $OB->Template->getBlock('recibo');
            ?>
            
            <!--DIV FICHA DE COMPENSACAO-->
            <?php
                echo $OB->Template->getBlock('ficha_compensacao', array('viaparam'=>'viaparam'));
            ?>
        </div>
    </body>
</html>