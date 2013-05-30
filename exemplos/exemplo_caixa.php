<?php
    header('Content-type: text/html; charset=utf-8');
    include '../OB_init.php';    

    $ob = new OB('104');
    
    //*
    $ob->Vendedor
            
            //->setAgencia('756')
            //->setCodigoCedente('10812')
            //->setCarteira('SR') //1 = SR - Sem Registro
            //->setRazaoSocial('Educandário Nossa Senhora das Vitórias')
            //->setCnpj('08.009.235/0001-56')
            //->setEndereco('Rua Augusto Severo, 200 Centro - Assu/RN 59.650-000')
            //->setEmail('financeiro@ensvassu.com.br')

            ->setAgencia('756')
            ->setCodigoCedente('00002')
            ->setCarteira('1') //1 = SR - Sem Registro
            ->setRazaoSocial('Educandário Nossa Senhora das Vitórias')
            ->setCnpj('08.009.235/0001-56')
            ->setEndereco('Rua Augusto Severo, 200 Centro - Assu/RN 59.650-000')
            ->setEmail('financeiro@ensvassu.com.br')
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
            //->setValor(195)
            //->setDiasVencimento(5)
            //->setVencimento(31,1,2013)
            //->setNossoNumero('000000368101138')
            //->setNumDocumento('00002')
            //->setQuantidade(1)
            ->setValor(123.5)
            ->setVencimento(17,6,2002)
            ->setNossoNumero('0000000000000017')
            ->setNumDocumento('00002')
            ->setQuantidade(1)
        ;
    
    $ob->render(); /**/
