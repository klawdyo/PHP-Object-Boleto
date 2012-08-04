<?php
    header('Content-type: text/html; charset=utf-8');
    include 'OB_init.php';    

    $ob = new OB('004');
    
    //*
    $ob->Vendedor
            
            ->setAgencia('0016')
            ->setConta('1193')
            ->setCarteira('55')
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
            ->set('instrucao', array('linha1', 'linha2', 'linha3'))
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
            ->setValor(1000)
            //->setDiasVencimento(5)
            ->setVencimento(10,9,2000)
            ->setNossoNumero('1234567')
            ->setNumDocumento('27.030195.10')
            ->setQuantidade(1)
        ;
    
    $ob->render(); /**/
/*
    $ob->Vendedor
            ->setAgencia('1565')
            ->setConta('87000000414')
            ->setCodigoCedente('87000000414')
            ->setCarteira('55')
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
            ->setValor(1000)
            ->setDiasVencimento(5)
            //->setVencimento(10,9,2000)
            ->setNossoNumero('1234567')
            ->setNumDocumento('27.030195.10')
            ->setQuantidade(1)
        ;
    
    $ob->render();/**/