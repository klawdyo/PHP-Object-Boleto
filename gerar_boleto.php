<?php
 header('Content-type: text/html; charset=utf-8');
 include 'OB_init.php';    


    $ob = new OB();
    
    $ob->Vendedor
            ->setBanco('001')
            ->setAgencia('214')
            ->setConta('10571')
            ->setNome('Jose Claudio Medeiros de Lima')
            ->setCpf('012.345.678-90')
            ->setEndereco('Rua dos Mororós 111 Centro, São Paulo/SP CEP 12345-678')
            ->setEmail('joseclaudiomedeirosdelima@uol.com.br')
        ;
            
    $ob->Configuracao
            ->addInstrucao('Sr. Caixa, cobrar multa de 2% após o vencimento')
            ->addInstrucao('Receber até 10 dias após o vencimento')
            ->addInstrucao('Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br')
            ->addInstrucao('Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br')
        ;
        
    $ob->Template
            ->setTitle('ObjBoleto')
            ->setTemplate('html5')
        ;
        
    $ob->Cliente
            ->setNome('Maria Joelma Bezerra de Medeiros')
            ->setCpf('111.999.888-77')
            ->setEmail('mariajoelma85@hotmail.com')
        ;
        
            
    $ob->Boleto
            ->setValor(129.45)
            ->setDiasVencimento(5)
            ->setNossoNumero('123456')
            ->setNumDocumento('873245')
            ->setDesconto(25.99)
        ;
    
    //$ob->plugin('Pdf')->save('/public/files/filename.pdf');
            
    
            
    $ob->render();
    $ob->Cliente
            ->setNome('Maria Joelma Bezerra de Medeiros')
            ->setCpf('111.999.888-77')
            ->setEmail('mariajoelma85@hotmail.com')
        ;
        
            
    $ob->Boleto
            ->setValor(1294.5)
            ->setDiasVencimento(30)
            ->setNossoNumero('123457')
            ->setNumDocumento('873246')
            ->setDesconto(25.99)
        ;
    $ob->render();
    
    