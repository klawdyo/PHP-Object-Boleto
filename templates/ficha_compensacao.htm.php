<div id="ficha_compensacao">
    <!--  cabecalho  -->
    <div id="cabecalho">
        <div class="cabecalho banco_logo span-4"><img src="<?php echo OB::url('/public/images/logobradesco.jpg')?>"></div>
        <div class="cabecalho banco_codigo span-2">237-2</div>
        <div class="cabecalho linha_digitavel span-12 last"><?php echo $OB->linhaDigitavel();?></div>
    </div>
    
    <div id="colunaprincipal" class="span-12">
        <!--  linha1  -->
            <!--local de pagamento-->
            <div class="local_pagamento item span-12">
                 <label>Local de Pagamento</label>
                 Pagável em qualquer banco até o vencimento
            </div>
        
        <!--  linha2  -->
            <!--Cedente-->
            <div class="cedente item span-12">
                 <label>Cedente </label>
                 Banco do Brasil S/A
            </div>
        
        <!--  linha3  -->
        <div class="linha">
            <!--data emissao-->
            <div class="data_doc item">
                <label>Data do documento</label>
                19/05/2011
            </div>
            <!--numdocumento-->
            <div class="num_doc item">
                <label>Número do documento</label>
                00000000
            </div>
            <!--especiedocumento-->
            <div class="espec_doc item">
                <label>Espécie Doc.</label>
                000
            </div>
            <!--aceite-->
            <div class="item aceite">
                <label>Aceite</label>
                N
            </div>
            <!--data processamento-->
            <div class="item dt_proc">
                <label>Data proc</label>
                19/05/2011
            </div>
        </div>
        
        <!--  linha4  -->
        <div class="linha">
            <!--uso do banco-->
            <div class="item uso_banco span-3">
                <label>Uso do Banco</label>
                
            </div>
            <!--carteira-->
            <div class="item carteira span-2">
                <label>Carteira</label>
                06
            </div>
            <!--especie moeda-->
            <div class="item moeda span-3">
                <label>Espécie Moeda</label>
                R$
            </div>
            <!--quantidade-->
            <div class="item qtd span-2">
                <label>Quantidade</label>
                <?php echo $OB->Boleto->Quantidade; ?>
            </div>
            <!--valor-->
            <div class="item valor span-2 last">
                <label>(x) Valor</label>
                <?php echo number_format($OB->Boleto->Valor/100,2,',','.'); ?>
            </div>
        </div>
        
        <!--  instrucoes/mensagens  -->
        <div class="mensagens span-11">
                 <label>Instruções (Texto de responsabilidade do cedente)</label>
        </div>
    
    </div>
    <!--Coluna direita-->
    <div id="colunadireita" class="span-7">
        <div class="span-7">
             <label>Vencimento</label>
             <?php echo $OB->Boleto->Vencimento; ?>
        </div>
        <div class="span-7">
             <label>Agência / Código cedente </label>
             <?php
                echo $OB->Vendedor->Agencia . '-' . Math::Mod11($OB->Vendedor->Agencia)
                     . ' / ' .
                     $OB->Vendedor->Conta . '-' . Math::Mod11($OB->Vendedor->Conta)
                ;
                ?>
        </div>
        <div class="span-7">
             <label>Nosso número</label>
             <?php
                echo $OB->Boleto->NossoNumero . '-' . Math::Mod11($OB->Boleto->NossoNumero)
                ;
                ?>
        </div>
        <div class="span-7">
             <label>(=) Valor do documento</label>
             <?php echo !empty($OB->Boleto->Valor) ? number_format($OB->Boleto->Valor/100, 2, ',', '.') : ''; ?>
        </div>
        <div class="span-7">
             <label>(-) Desconto/Abatimento</label>
             <?php echo $OB->Boleto->Desconto ? number_format($OB->Boleto->Desconto, 2, ',', '.') : ''; ?>
        </div>
        <div class="span-7">
             <label>(-) Outras deduções</label>
             <?php echo $OB->Boleto->OutrosAbatimentos ? number_format($OB->Boleto->OutrosAbatimentos, 2, ',', '.') : ''; ?>
        </div>
        <div class="span-7">
             <label>(-) Mora/Multa</label>
             <?php echo $OB->Boleto->Multa ? number_format($OB->Boleto->Multa, 2, ',', '.') : ''; ?>
        </div>
        <div class="span-7">
             <label>(-) Outros Acréscimos</label>
             <?php echo $OB->Boleto->OutrosAcrescimos ? number_format($OB->Boleto->OutrosAcrescimos, 2, ',', '.') : ''; ?>
        </div>
        <div class="span-7">
             <label>(=) Valor cobrado</label>
        </div>
    </div>
    
    <!--  sacado  -->
    <div id="sacado" class="">
        <div class="span-7">
             <label>Sacado</label>
             José Cláudio Medeiros de Lima<br>
             CPF: 012.905.824-67<br>
             Rua 24 de Junho, 1323, Centro - Assu-RN
        </div>
    </div>
    
    <!--  codigo_barras  -->
    <div id="codigo_barras" class="">
        <label>Sacador/Avalista</label>
        <?php
           echo Barcode::getHtml($OB->geraCodigo());
        ?>
    </div>
    

<!--Encerra ficha de compensação-->    
</div>
