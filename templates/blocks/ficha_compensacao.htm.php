<?php

?>

            <div id="ficha_compensacao">
                <!--  cabecalho  -->
                <div class="cabecalho">
                    <div class="banco_logo "><img src="<?php echo OB::url('/public/images/' . $OB->Banco->Image);?>" /></div>
                    <div class="banco_codigo "><?php echo Math::Mod11($OB->Banco->Codigo, 0, 0, true)?></div>
                    <div class="linha_digitavel  last"><?php echo $OB->linhaDigitavel();?></div>
                </div>
                
                <div id="colunaprincipal" class="">
                    <!--  linha1  -->
                        <!--local de pagamento-->
                        <div class="local_pagamento item">
                             <label>Local de Pagamento</label>
                             <?php echo $OB->Configuracao->LocalPagamento; ?>
                        </div>
                    
                    <!--  linha2  -->
                        <!--Cedente-->
                        <div class="cedente item">
                             <label>Cedente </label>
                             <?php echo $OB->Vendedor->RazaoSocial; ?>
                        </div>
                    
                    <!--  linha3  -->
                    <div class="linha">
                        <!--data emissao-->
                        <div class="data_doc item">
                            <label>Data do documento</label>
                             <?php echo $OB->Boleto->DataEmissao; ?>
                        </div>
                        <!--numdocumento-->
                        <div class="num_doc item">
                            <label>Número do documento</label>
                             <?php echo $OB->Boleto->NumDocumento; ?>
                        </div>
                        <!--especiedocumento-->
                        <div class="espec_doc item">
                            <label>Espécie Doc.</label>
            
                        </div>
                        <!--aceite-->
                        <div class="aceite item">
                            <label>Aceite</label>
            
                        </div>
                        <!--data processamento-->
                        <div class="dt_proc item">
                            <label>Data proc</label>
                             <?php echo $OB->Boleto->DataEmissao; ?>
                        </div>
                    </div>
                    
                    <!--  linha4  -->
                    <div class="linha">
                        <!--uso do banco-->
                        <div class="uso_banco item">
                            <label>Uso do Banco</label>
                            
                        </div>
                        <!--carteira-->
                        <div class="carteira item">
                            <label>Carteira</label>
                             <?php echo $OB->Vendedor->Carteira; ?>
                        </div>
                        <!--especie moeda-->
                        <div class="moeda item">
                            <label>Moeda</label>
                            R$
                        </div>
                        <!--quantidade-->
                        <div class="qtd item">
                            <label>Quantidade</label>
                            <?php echo $OB->Boleto->Quantidade; ?>
                        </div>
                        <!--valor-->
                        <div class="valor item">
                            <label>(x) Valor</label>
                            <?php echo number_format($OB->Boleto->ValorUnitario/100,2,',','.'); ?>
                        </div>
                    </div>
                    
                    <!--  instrucoes/mensagens  -->
                    <div class="mensagens ">
                             <label>Instruções (Texto de responsabilidade do cedente)</label>
                             <?php
                                $instrucoes = $OB->Configuracao->getInstrucoes();
                                echo implode('<br />', $instrucoes);
                             ?>
                    </div>
                
                </div>
                <!--Coluna direita-->
                <div id="colunadireita" class="">
                    <div class="">
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
                    <div class="">
                         <label>Agência / Código cedente </label>
                         <?php echo $OB->Banco->agenciaCodigoCedente(); ?>
                    </div>
                    <div class="">
                         <label>Nosso número</label>
                         <?php echo $OB->Boleto->NossoNumero; ?>
                    </div>
                    <div class="">
                         <label>(=) Valor do documento</label>
                         <?php echo !empty($OB->Boleto->Valor) ? number_format($OB->Boleto->Valor/100, 2, ',', '.') : ''; ?>
                    </div>
                    <div class="">
                         <label>(-) Desconto/Abatimento</label>
                         <?php echo $OB->Boleto->Desconto ? number_format($OB->Boleto->Desconto, 2, ',', '.') : ''; ?>
                    </div>
                    <div class="">
                         <label>(-) Outras deduções</label>
                         <?php echo $OB->Boleto->OutrosAbatimentos ? number_format($OB->Boleto->OutrosAbatimentos, 2, ',', '.') : ''; ?>
                    </div>
                    <div class="">
                         <label>(+) Mora/Multa</label>
                         <?php echo $OB->Boleto->Multa ? number_format($OB->Boleto->Multa, 2, ',', '.') : ''; ?>
                    </div>
                    <div class="">
                         <label>(+) Outros Acréscimos</label>
                         <?php echo $OB->Boleto->OutrosAcrescimos ? number_format($OB->Boleto->OutrosAcrescimos, 2, ',', '.') : ''; ?>
                    </div>
                    <div class="">
                         <label>(=) Valor cobrado</label>
                    </div>
                </div>
                
                <!--  sacado  -->
                <div id="sacado" class="">
                    <div class="">
                         <label>Sacado</label>
                         <?php
                            echo $OB->Cliente->Nome
                               . '<br>'
                               . 'CPF: ' . $OB->Cliente->Cpf
                               . '<br>'
                               . $OB->Cliente->Endereco
                               ;
                         ?>
                    </div>
                </div>
                
                <!--  codigo_barras  -->
                <div id="codigo_barras" class="">
                    <div>
                        <label>Sacador/Avalista</label>
                        <?php
                           echo Barcode::getHtml($OB->geraCodigo());
                        ?>
                    </div>
                    <div class="">
                        <span>Ficha de Compensação</span>
                        <label>Autenticação Mecânica</label>
                    </div>
                </div>
                
                <!--Linha pontilhada para corte-->
                <div class="linha_corte"><label>Corte na linha pontilhada</label></div>
                
            <!--Encerra ficha de compensação-->    
            </div>
