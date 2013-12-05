<?php
    header('Content-type: text/html; charset=utf-8');
    include '../OB_init.php';    

    $ob = new OB('004');
    
    //*
    $ob->Vendedor
            
            ->setAgencia('0035')
            ->setConta('0036098')
            ->setCarteira('55') //Cobrança Simples - fichamento emitido pelo cliente
            ->setRazaoSocial('José Claudio Medeiros de Lima')
            ->setCpf('012.345.678-39')
            ->setEndereco('Rua dos Mororós 111 Centro, São Paulo/SP CEP 12345-678')
            ->setEmail('joseclaudiomedeirosdelima@uol.com.br')
        ;
            
    $ob->Configuracao
            ->setLocalPagamento('Pagável em qualquer banco até o vencimento')
            ->addInstrucao('- Sr. Caixa, cobrar multa de 2% após o vencimento')
            ->addInstrucao('- Receber até 10 dias após o vencimento')
            ->addInstrucao('- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br')
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
            ->setValor(949.50)
            ->setDiasVencimento(1)
            //->setVencimento(18,2,2013)
            ->setNossoNumero('0009946')
            ->setNumDocumento('666688')
            ->setQuantidade(1)
        ;
    
    $ob->render(); /**/
