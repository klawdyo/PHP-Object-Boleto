<?php
    header('Content-type: text/html; charset=utf-8');
    include '../OB_init.php';    

    $ob = new OB('399');
    
    //*
    $ob->Vendedor
            
            ->setAgencia('100')
            ->setConta('1122334')
            ->setCodigoCedente('1122334')
            ->setCarteira('CNR')
            ->setRazaoSocial('José Claudio Medeiros de Lima')
            ->setCpf('012.345.678-39')
            ->setEndereco('Rua dos Mororós 111 Centro, São Paulo/SP CEP 12345-678')
            ->setEmail('joseclaudiomedeirosdelima@uol.com.br')
        ;
            
    $ob->Configuracao
            ->setLocalPagamento('Pagável em qualquer banco até o vencimento')
        ;
        
    $ob->Template
            ->setTitle('PHP->OB ObjectBoleto')
            ->setTemplate('html5')
        ;
        
    $ob->Cliente
            ->setNome('Maria Joelma Bezerra de Medeiros')
            ->setCpf('111.999.888-39')
            ->setEmail('mariajoelma85@hotmail.com')
            ->setEndereco('')
            ->setCidade('')
            ->setUf('')
            ->setCep('')
        ;
    
    $ob->Boleto
            ->setValor(2952.95)
            ->setVencimento(5,6,2011)
            ->setNossoNumero('0000012345678943')
        ;
    
    $ob->render();
