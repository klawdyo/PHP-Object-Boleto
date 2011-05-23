<?php
 header('Content-type: text/html; charset=utf-8');
 include 'OB_init.php';    


    $ob = new OB();
    
    $ob->Vendedor
            ->setBanco('104')
            ->setAgencia('214')
            ->setConta('10571')
            ->setNome('Jose Claudio Medeiros de Lima')
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
            //->setNome('Maria Joelma Bezerra de Medeiros')
            //->setCpf('111.999.888-77')
            //->setEmail('mariajoelma85@hotmail.com')
            ->set(array(
                        'Nome' => 'Sheverllannyo',
                        'Cpf' => '123.456.789-09',
                        'Email'=> 'shev_moto@mail.com'
                        ))
        ;
        
            
    $ob->Boleto
            ->setValor(1329.45)
            ->setDiasVencimento(5)
            ->setNossoNumero('123456')
            ->setNumDocumento('873245')
            ->setQuantidade(1)
        ;
            
    $ob->render();
    