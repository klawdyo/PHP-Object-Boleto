<?php
    header('Content-type: text/html; charset=utf-8');
    include '../OB_init.php';    

    $ob = new OB('756');
    
    //*
    $ob->Vendedor
            
            ->setAgencia('100')
            ->setConta('1193')
            ->setCodigoCedente('1')
            ->setCarteira('2')
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
            ->setValor(550)
            ->setNumParcela(1)
            ->setVencimento(4,7,2000)
            ->setNossoNumero('228563')
        ;
    
    $ob->render(); /**/