<?php
    header('Content-type: text/html; charset=utf-8');
    include '../OB_init.php';    

    $ob = new OB('070');
    
    //*
    $ob->Vendedor
            
            ->setAgencia('172')
            ->setConta('1000345')
            ->setCarteira('1')
            ->setRazaoSocial('José Claudio Medeiros de Lima')
            ->setCpf('012.345.678-39')
            ->setEndereco('Rua dos Mororós 111 Centro, São Paulo/SP CEP 12345-678')
            ->setEmail('joseclaudiomedeirosdelima@uol.com.br')
        ;
    
    //Define as configurações do boleto
    $ob->Configuracao
            ->setLocalPagamento('Pagável em qualquer banco até o vencimento')
            ->addInstrucao('Sr. Caixa. Não receber após 20 dias de atraso.')
            ->addInstrucao('Multa de 2% por atraso e 1% ao dia.')
        ;
    
    //Envia variáveis para ser usada nos templates
    $ob->Template
            //Define o título da página
            ->setTitle('PHP->OB ObjectBoleto')
            //Define o template que será usado
            ->setTemplate('html5')
        ;
    
    //Define as configurações do cliente
    $ob->Cliente
            ->setNome('Maria Joelma Bezerra de Medeiros')
            ->setCpf('111.999.888-39')
            ->setEmail('mariajoelma85@hotmail.com')
            ->setEndereco('')
            ->setCidade('')
            ->setUf('')
            ->setCep('')
        ;
    
    //Define as configurações do boleto
    $ob->Boleto
            ->setValor(23)
            ->setNumParcela(1)
            ->setVencimento(24,1,2013)
            ->setNossoNumero(758964)
        ;
    
    //Renderiza o boleto
    $ob->render(); /**/