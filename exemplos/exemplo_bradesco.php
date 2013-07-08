<?php
    header('Content-type: text/html; charset=utf-8');
    include '../OB_init.php';

    $ob = new OB('237');

    //*
    $ob->Vendedor

            ->setAgencia('1172')
            ->setConta('0403005')
            ->setCarteira('06')
            ->setRazaoSocial('José Claudio Medeiros de Lima')
            ->setCpf('012.345.678-39')
            ->setEndereco('Rua dos Mororós 111 Centro, São Paulo/SP CEP 12345-678')
            ->setEmail('joseclaudiomedeirosdelima@uol.com.br')
			->setCodigoCedente('0403005')
			->setInsertDVAtPosFour(false)
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
            //->setDiasVencimento(5)
            ->setVencimento(6,9,2011)
            ->setNossoNumero('75896452')
            ->setNumDocumento('27.030195.10')
            ->setQuantidade(1)
        ;

    $ob->render(); /**/
