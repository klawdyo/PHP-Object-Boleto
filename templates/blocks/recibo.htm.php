<div id="recibo">
    <!--  cabecalho  -->
    <div class="cabecalho">
        <div class="banco_logo "><img src="<?php echo OB::url('/public/images/' . $OB->Banco->Image);?>" /></div>
                    <div class="banco_codigo "><?php echo Math::Mod11($OB->Banco->Codigo, 0, 0, true)?></div>
        <div class="linha_digitavel"><?php echo $OB->linhaDigitavel();?></div>
    </div>
    <!--Linha1-->
    <div class="linha">
        <!-- Cedente -->
        <div class="cedente item">
            <label>Cedente</label>
            <?php echo $OB->Vendedor->RazaoSocial; ?>
        </div>
        <!-- Agência/Código do Cedente -->
        <div class="agencia item">
            <label>Ag./Código do Cedente</label>
            <?php echo $OB->Banco->agenciaCodigoCedente(); ?>
        </div>
        <!-- Espécie Moeda -->
        <div class="moeda item">
            <label>Moeda</label>
            R$
        </div>
        <!-- Quantidade -->
        <div class="qtd item">
            <label>Qtd.</label>
            <?php echo $OB->Boleto->Quantidade;?>
        </div>
        <!-- Nosso Número -->
        <div class="nosso_numero item">
            <label>Nosso Número</label>
            <?php echo $OB->Boleto->NossoNumero; ?>
        </div>
    </div>
    
    <!--Linha 2-->
    <div class="linha">
        <!-- Número do Documento -->
        <div class="num_doc item">
            <label>Número do Documento</label>
            <?php echo $OB->Boleto->NumDocumento;?>
        </div>
        <!-- CPF/CNPJ -->
        <div class="cpf_cnpj item">
            <label>CPF/CNPJ</label>
            <?php
                if(isset($OB->Vendedor->Cpf)){
                   echo $OB->Vendedor->Cpf; 
                }
                elseif(isset($OB->Vendedor->Cnpj)){
                    echo $OB->Vendedor->Cnpj;
                }
                
            ?>
        </div>
        <!-- Vencimento -->
        <div class="vencimento item">
            <label>Vencimento</label>
            <?php
               if($OB->Boleto->VencimentoContraApresentacao == false){
                  echo $OB->Boleto->Vencimento;
               }
               else{
                   echo 'Contra-Apresentacao';
               }
            ?>
        </div>
        <!-- Valor do Documento -->
        <div class="valor item">
            <label>Valor do Documento</label>
            <?php echo number_format($OB->Boleto->Valor/100, 2, ',', '.');?>
        </div>
    </div>
    
    <!--Linha 3-->
    <div class="linha">
        <!-- Descontos/Abatimentos -->
        <div class="descontos item">
            <label>(-) Desconto/Abatimento</label>
        </div>
        <!-- Outras Deduções -->
        <div class="outras_deducoes item">
            <label>(-) Outras Deduções</label>
        </div>
        <!-- Mora/Multa -->
        <div class="multa item">
            <label>(+) Mora/Multa</label>
        </div>
        <!-- Outros Acréscimos -->
        <div class="outros_acrescimos item">
            <label>(+) Outros Acréscimos</label>
        </div>
        <!-- Valor Cobrado -->
        <div class="valor item">
            <label>(=) Valor Cobrado</label>
        </div>
    </div>
    
    <!--Linha 4-->
    <div class="linha">
        <!-- Sacado -->
        <div class="sacado item">
            <label>Sacado</label>
            <?php echo $OB->Cliente->Nome;?>
        </div>
    </div>
    
    <!--Linha 5-->
    <div class="linha">
        <!-- Demonstrativo -->
        <div class="demonstrativo item">
            <label>Demonstrativo</label>
            Detalhes da compra<br>
            Detalhes da compra<br>
            Detalhes da compra<br>
        </div>
        <!-- Autenticação Mecânica -->
        <div class="autenticacao_mecanica">
            <label>Autenticação Mecânica</label>
        </div>
    </div>
    
    <!--Linha pontilhada para corte-->
    <div class="linha_corte"><label>Corte na linha pontilhada</label></div>
</div>