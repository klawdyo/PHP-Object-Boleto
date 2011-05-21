            <?php
                #Carregando o estilo referente ao banco, caso ele tenha
                if(!empty($OB->Layout->css))
                    $OB->Template->addStyle($OB->Layout->css);
            ?>
<div id="recibo">
    <!--Linha1-->
    <div class="linha">
        <!-- Cedente -->
        <div class="cedente item">
            <label>Cedente</label>
        </div>
        <!-- Agência/Código do Cedente -->
        <div class="agencia item">
            <label>Cedente</label>
        </div>
        <!-- Espécie Moeda -->
        <div class="moeda item">
            <label>Cedente</label>
        </div>
        <!-- Quantidade -->
        <div class="qtd item">
            <label>Cedente</label>
        </div>
        <!-- Nosso Número -->
        <div class="nosso_numero item">
            <label>Cedente</label>
        </div>
    </div>
    
    <!--Linha 2-->
    <div class="linha">
        <!-- Número do Documento -->
        <div class="num_doc item">
            <label>Cedente</label>
        </div>
        <!-- CPF/CNPJ -->
        <div class="cpf_cnpf item">
            <label>Cedente</label>
        </div>
        <!-- Vencimento -->
        <div class="vencimento item">
            <label>Cedente</label>
        </div>
        <!-- Valor do Documento -->
        <div class="valor item">
            <label>Cedente</label>
        </div>
    </div>
    
    <!--Linha 3-->
    <div class="linha">
        <!-- Descontos/Abatimentos -->
        <div class="descontos item">
            <label>(-) Descontos/ Abatimentos</label>
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
        <!-- Descontos/Abatimentos -->
        <div class="sacado item">
            <label>(-) Descontos/ Abatimentos</label>
        </div>
    </div>
    
</div>