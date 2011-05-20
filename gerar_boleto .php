<?php
    include 'ObjBoleto_init.php';    
    
    new Templates(array(
                        'css' => 'default',
                        'title' => 'Máris Modas',
                        ));
    
    //Dados do Vendedor (Cedente)
    $Vendedor = new Vendedor(array(
        'Banco' => '237',
        'Agencia' => '1172',
        'Conta' => '00075896452',
        'Carteira' => '06',
        
        'Nome' => 'José Cláudio Medeiros de Lima',
        'Endereco' => 'Rua 24 de Junho, 1323, Centro - Assu/RN - CEP 59650-000',
        'Logo' => 'logo_empresa.png',
    ));
    
    //Dados do Cliente (Sacado)
    $Cliente = new Cliente(array(
        'Nome' => 'Marta Joelma Bezerra',
        'Endereco' => 'R Gen. Antônio Ferreira Dantas, 111',
        'CPF' => '024.499.854-06',
        'Email' => 'martajoelma77@gmail.com',
    ));
    
    
    $Boleto = new Boleto();
    
    $Boleto
           ->setVendedor($Vendedor)
           ->setCliente($Cliente)
           #Dados do Boleto
           //->setVencimento($dia, $mes, $ano) //Defina uma data exata para o vencimento
           ->setDiasVencimento('5') //Defina a quantidade de dias até o vencimento
           ->setValor(3455.4)
           ->setNossoNumero('2345324653')
           
           
           
           #Opções do boleto
           ->render()
           //->save('nomearquivo.pdf')
           //->download()
           ;
           

