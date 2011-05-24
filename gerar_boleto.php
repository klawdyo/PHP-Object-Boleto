<?php
    header('Content-type: text/html; charset=utf-8');
    include 'OB_init.php';    

    $ob = new OB();
    
    $ob->Vendedor
            ->setBanco('104')
            ->setAgencia('9999')
            ->setConta('99999')
            ->setCarteira('18')
            ->setNome('José Claudio Medeiros de Lima')
            ->setCpf('012.345.678-90')
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
            ->setCpf('111.999.888-77')
            ->setEmail('mariajoelma85@hotmail.com')
            ->setEndereco('')
            ->setCidade('')
            ->setUf('')
            ->setCep('')
        ;
    
    $ob->Boleto
            ->setValor(2950)
            ->setDiasVencimento(5)
            ->setNossoNumero('77777770000087654')
            ->setNumDocumento('27.030195.10')
            ->setQuantidade(1)
        ;
            
    $ob->render();
    
    
    //00199.99903 07777.777009 00008.765402 2 49810000295295
    //00190.00009 07777.777009 00087.654182 8 49810000295295