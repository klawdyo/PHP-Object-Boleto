<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>

<html>
    <head>
        <title><?php echo $Template->title; ?></TITLE>
        <meta http-equiv=Content-Type content=text/html; charset=windows-1252>
        <meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licença GPL" />
        <style type=text/css>
            /**   */
            .cp {  font: bold 10px Arial; color: black}
            /**   */
            .ti {  font: 9px Arial, Helvetica, sans-serif}
            /** Linha digitável */
            .ld { font: bold 15px Arial; color: #000000}
            /** Linha digitável pequena, das instruções  */
            .ld2 { font: bold 12px Arial; color: #000000 }
            /**   */
            .ct { FONT: 9px "Arial Narrow"; COLOR: #000033}
            /**   */
            .cn { FONT: 9px Arial; COLOR: black }
            /**   */
            .bc { font: bold 20px Arial; color: #000000 }
        </style> 
    </head>

    <body>
        <!--
            INSTRUÇÕES GERAIS SOBRE O BOLETO
        -->
        <table width=666 cellspacing=0 cellpadding=0 border=0>
            <tr>
                <td class="cp">
                    Instruções de Impressão
                </td>
            </tr>
            <tr>
                <td class="cp">
                    <p />
                    <li>Imprima em impressora jato de tinta (ink jet) ou laser em
                        qualidade normal ou alta (Não use modo econômico).</li>
                    <li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm)
                        e margens mínimas à esquerda e à direita do formulário.</li>
                    <li>Corte na linha indicada. Não rasure, risque, fure ou
                        dobre a região onde se encontra o código de barras.</li>
                    <li>Caso não apareça o código de barras no final, clique em
                        F5 para atualizar esta tela.</li>
                    <li>Caso tenha problemas ao imprimir, copie a seqüencia numérica
                        abaixo e pague no caixa eletrônico ou no internet banking:</li>
                    <span class="ld2 linha_digitavel">
                        Linha Digitável:
                        <?php echo $Boleto->linhaDigitavel; ?>
                        Valor:
                        <?php echo $Boleto->Valor; ?>
                    </span>
                </td>
            </tr>
        </table>
        
        <table width=666>
            <tbody>
                <tr>
                    <td class=ct width=666>
                        <img height=1 src=imagens/6.png width=665 border=0>
                    </td>
                </tr>
                <tr>
                    <TD class=ct width=666>
                        <div align=right>
                            <b class=cp>Recibo do Sacado</b>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table width=666 cellspacing=5 cellpadding=0 border=0>
            <tr>
                <td width=41>
                    
                </td>
            </tr>
        </table>
        
        <table width=666 class="vendedor">
          <tr>
            <td width=41>
                <!--<img src="imagens/logo_empresa.png">-->
                <?php echo $Vendedor->logo; ?>
            </td>
            <td class=ti width=455 class="dados_empresa">
                BoletoPhp - Código Aberto de Sistema de Boletos
                Rua Central, 123
                Curitiba - PR
            </td>
            <td width=150 class="ti">
                
            </td>
          </tr>
        </table>
        <table width=666>
            <tr>
                <td class=cp width=150> 
                  <span class="campo">
                    <IMG src="imagens/logobradesco.jpg" width="150" height="40" border=0>
                  </span>
                </td>
                <td width=3 valign=bottom>
                    <img height=22 src=imagens/3.png width=2 border=0>
                </td>
                <td class=cpt width=58 valign=bottom>
                    <div align=center>
                        <font class=bc>237-2</font>
                    </div>
                </td>
                <td width=3 valign=bottom>
                    <img height=22 src=imagens/3.png width=2 border=0>
                </td>
                <td class=ld align=right width=453 valign=bottom>
                    <span class=ld>
                        <span class="campotitulo">
                            23791.17209 60007.589645 52040.300502 1 49760000295295
                        </span>
                    </span>
                </td>
            </tr>
            <tbody>
                <tr>
                    <td colspan=5>
                        <img height=2 src=imagens/2.png width=666 border=0>
                    </td>
                </tr>
            </tbody>
        </table>
        <table cellspacing=0 cellpadding=0 border=0>
            <tbody>
                <tr>
                    <td class=ct valign=top width=7 height=13>
                        <img height=13 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=ct valign=top width=298 height=13>
                        Cedente
                    </td>
                    <td class=ct valign=top width=7 height=13>
                        <img height=13 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=ct valign=top width=126 height=13>
                        Agência/Código do Cedente
                    </td>
                    <td class=ct valign=top width=7 height=13>
                        <img height=13 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=ct valign=top width=34 height=13>
                        Espécie
                    </td>
                    <td class=ct valign=top width=7 height=13>
                        <img height=13 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=ct valign=top width=53 height=13>
                        Quantidade
                    </td>
                    <td class=ct valign=top width=7 height=13>
                        <img height=13 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=ct valign=top width=120 height=13>
                        Nosso número
                    </td>
                </tr>
                <tr>
                    <td class=cp valign=top width=7 height=12>
                        <img height=12 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=cp valign=top width=298 height=12>
                        <span class="campo">
                            Alcantara & Schmidt Ltda.
                        </span>
                    </td>
                    <td class=cp valign=top width=7 height=12>
                        <img height=12 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=cp valign=top width=126 height=12>
                        <span class="campo">
                            1172-0 / 0403005-2
                        </span>
                    </td>
                    <td class=cp valign=top width=7 height=12>
                        <img height=12 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=cp valign=top  width=34 height=12>
                        <span class="campo">
                            R$
                        </span>
                    </td>
                    <td class=cp valign=top width=7 height=12>
                        <img height=12 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=cp valign=top  width=53 height=12>
                        <span class="campo">
                            001
                        </span>
                    </td>
                    <td class=cp valign=top width=7 height=12>
                        <img height=12 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=cp valign=top align=right width=120 height=12>
                        <span class="campo">
                            06/00075896452-5
                        </span>
                    </td>
                </tr>
                <tr>
                    <td valign=top width=7 height=1>
                        <img height=1 src=imagens/2.png width=7 border=0>
                    </td>
                    <td valign=top width=298 height=1>
                        <img height=1 src=imagens/2.png width=298 border=0>
                    </td>
                    <td valign=top width=7 height=1>
                        <img height=1 src=imagens/2.png width=7 border=0>
                    </td>
                    <td valign=top width=126 height=1>
                        <img height=1 src=imagens/2.png width=126 border=0>
                    </td>
                    <td valign=top width=7 height=1>
                        <img height=1 src=imagens/2.png width=7 border=0>
                    </td>
                    <td valign=top width=34 height=1>
                        <img height=1 src=imagens/2.png width=34 border=0>
                    </td>
                    <td valign=top width=7 height=1>
                        <img height=1 src=imagens/2.png width=7 border=0>
                    </td>
                    <td valign=top width=53 height=1>
                        <img height=1 src=imagens/2.png width=53 border=0>
                    </td>
                    <td valign=top width=7 height=1>
                        <img height=1 src=imagens/2.png width=7 border=0>
                    </td>
                    <td valign=top width=120 height=1>
                        <img height=1 src=imagens/2.png width=120 border=0>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table>
            <tbody>
                <tr>
                    <td class=ct valign=top width=7 height=13>
                        <img height=13 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=ct valign=top colspan=3 height=13>Número do documento
                    </td>
                    <td class=ct valign=top width=7 height=13>
                        <img height=13 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=ct valign=top width=132 height=13>
                        CPF/CNPJ
                    </td>
                    <td class=ct valign=top width=7 height=13>
                        <img height=13 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=ct valign=top width=134 height=13>
                        Vencimento
                    </td>
                    <td class=ct valign=top width=7 height=13>
                        <img height=13 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=ct valign=top width=180 height=13>
                        Valor documento
                    </td>
                </tr>
                <tr>
                    <td class=cp valign=top width=7 height=12>
                        <img height=12 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=cp valign=top colspan=3 height=12>
                        <span class="campo">
                            75896452
                        </span>
                    </td>
                    <td class=cp valign=top width=7 height=12>
                        <img height=12 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=cp valign=top width=132 height=12>
                        <span class="campo">
                            
                        </span>
                    </td>
                    <td class=cp valign=top width=7 height=12>
                        <img height=12 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=cp valign=top width=134 height=12>
                        <span class="campo">
                            23/05/2011
                        </span>
                    </td>
                    <td class=cp valign=top width=7 height=12>
                        <img height=12 src=imagens/1.png width=1 border=0>
                    </td>
                    <td class=cp valign=top align=right width=180 height=12>
                        <span class="campo">
                            2952,95
                        </span>
                    </td>
                </tr>
                <tr>
                    <td valign=top width=7 height=1>
                        <img height=1 src=imagens/2.png width=7 border=0>
                    </td>
                    <td valign=top width=113 height=1>
                        <img height=1 src=imagens/2.png width=113 border=0>
                    </td>
                    <td valign=top width=7 height=1>
                        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=72 height=1><img height=1 src=imagens/2.png width=72 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=132 height=1><img height=1 src=imagens/2.png width=132 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=134 height=1><img height=1 src=imagens/2.png width=134 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=113 height=13>(-) 
        
        Desconto / Abatimentos</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=112 height=13>(-) 
        
        Outras deduções</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=113 height=13>(+) 
        
        Mora / Multa</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=113 height=13>(+) 
        
        Outros acréscimos</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(=) 
        
        Valor cobrado</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=113 height=12></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=112 height=12></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=113 height=12></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=113 height=12></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12></td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=113 height=1><img height=1 src=imagens/2.png width=113 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=112 height=1><img height=1 src=imagens/2.png width=112 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=113 height=1><img height=1 src=imagens/2.png width=113 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=113 height=1><img height=1 src=imagens/2.png width=113 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=659 height=13>Sacado</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=659 height=12> 
        
          <span class="campo">
        
          José da Silva  </span></td>
        
        </tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=659 height=1><img height=1 src=imagens/2.png width=659 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct  width=7 height=12></td><td class=ct  width=564 >Demonstrativo</td><td class=ct  width=7 height=12></td><td class=ct  width=88 >Autenticação 
        
        mecânica</td></tr><tr><td  width=7 ></td><td class=cp width=564 >
        
        <span class="campo">
        
          Pagamento de Compra na Loja Nonononono<br>
        
          Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ 2.95<br>
        
          BoletoPhp - http://www.boletophp.com.br<br>
        
          </span>
        
          </td><td  width=7 ></td><td  width=88 ></td></tr></tbody></table><table cellspacing=0 cellpadding=0 width=666 border=0><tbody><tr><td width=7></td><td  width=500 class=cp> 
        
        <br><br><br> 
        
        </td><td width=159></td></tr></tbody></table><table cellspacing=0 cellpadding=0 width=666 border=0><tr><td class=ct width=666></td></tr><tbody><tr><td class=ct width=666> 
        
        <div align=right>Corte na linha pontilhada</div></td></tr><tr><td class=ct width=666><img height=1 src=imagens/6.png width=665 border=0></td></tr></tbody></table><br><table cellspacing=0 cellpadding=0 width=666 border=0><tr><td class=cp width=150> 
        
          <span class="campo"><IMG 
        
              src="imagens/logobradesco.jpg" width="150" height="40" 
        
              border=0></span></td>
        
        <td width=3 valign=bottom><img height=22 src=imagens/3.png width=2 border=0></td><td class=cpt width=58 valign=bottom><div align=center><font class=bc>237-2</font></div></td><td width=3 valign=bottom><img height=22 src=imagens/3.png width=2 border=0></td><td class=ld align=right width=453 valign=bottom><span class=ld> 
        
        <span class="campotitulo">
        
        23791.17209 60007.589645 52040.300502 1 49760000295295</span></span></td>
        
        </tr><tbody><tr><td colspan=5><img height=2 src=imagens/2.png width=666 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=472 height=13>Local 
        
        de pagamento</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>Vencimento</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=472 height=12>Pagável 
        
        em qualquer Banco até o vencimento</td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12> 
        
          <span class="campo">
        
          23/05/2011  </span></td>
        
        </tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=472 height=1><img height=1 src=imagens/2.png width=472 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=472 height=13>Cedente</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>Agência/Código 
        
        cedente</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=472 height=12> 
        
          <span class="campo">
        
          Alcantara & Schmidt Ltda.  </span></td>
        
        <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12> 
        
          <span class="campo">
        
          1172-0 / 0403005-2  </span></td>
        
        </tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=472 height=1><img height=1 src=imagens/2.png width=472 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13> 
        
        <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=113 height=13>Data 
        
        do documento</td><td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=153 height=13>N<u>o</u> 
        
        documento</td><td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=62 height=13>Espécie 
        
        doc.</td><td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=34 height=13>Aceite</td><td class=ct valign=top width=7 height=13> 
        
        <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=82 height=13>Data 
        
        processamento</td><td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>Nosso 
        
        número</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=113 height=12><div align=left> 
        
          <span class="campo">
        
          18/05/2011  </span></div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=153 height=12> 
        
            <span class="campo">
        
            75896452    </span></td>
        
          <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=62 height=12><div align=left><span class="campo">
        
            DS  </span> 
        
         </div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=34 height=12><div align=left><span class="campo">
        
          </span> 
        
         </div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=82 height=12><div align=left> 
        
           <span class="campo">
        
           18/05/2011   </span></div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12> 
        
             <span class="campo">
        
             06/00075896452-5     </span></td>
        
        </tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=113 height=1><img height=1 src=imagens/2.png width=113 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=153 height=1><img height=1 src=imagens/2.png width=153 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=62 height=1><img height=1 src=imagens/2.png width=62 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=34 height=1><img height=1 src=imagens/2.png width=34 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=82 height=1><img height=1 src=imagens/2.png width=82 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1> 
        
        <img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr> 
        
        <td class=ct valign=top width=7 height=13> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top COLSPAN="3" height=13>Uso 
        
        do banco</td><td class=ct valign=top height=13 width=7> <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=83 height=13>Carteira</td><td class=ct valign=top height=13 width=7> 
        
        <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=53 height=13>Espécie</td><td class=ct valign=top height=13 width=7> 
        
        <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=123 height=13>Quantidade</td><td class=ct valign=top height=13 width=7> 
        
        <img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=72 height=13> 
        
        Valor Documento</td><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(=) 
        
        Valor documento</td></tr><tr> <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td valign=top class=cp height=12 COLSPAN="3"><div align=left> 
        
         </div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=83> 
        
        <div align=left> <span class="campo">
        
          06</span></div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=53><div align=left><span class="campo">
        
        R$</span> 
        
         </div></td><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=123><span class="campo">
        
         001 </span> 
        
         </td>
        
         <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top  width=72> 
        
           <span class="campo">
        
           2952,95   </span></td>
        
         <td class=cp valign=top width=7 height=12> <img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12> 
        
           <span class="campo">
        
           2952,95   </span></td>
        
        </tr><tr><td valign=top width=7 height=1> <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=75 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=31 height=1><img height=1 src=imagens/2.png width=31 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=83 height=1><img height=1 src=imagens/2.png width=83 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=53 height=1><img height=1 src=imagens/2.png width=53 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=123 height=1><img height=1 src=imagens/2.png width=123 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=72 height=1><img height=1 src=imagens/2.png width=72 border=0></td><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody> 
        
        </table><table cellspacing=0 cellpadding=0 width=666 border=0><tbody><tr><td align=right width=10><table cellspacing=0 cellpadding=0 border=0 align=left><tbody> 
        
        <tr> <td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td></tr><tr> 
        
        <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td></tr><tr> 
        
        <td valign=top width=7 height=1><img height=1 src=imagens/2.png width=1 border=0></td></tr></tbody></table></td><td valign=top width=468 rowspan=5><font class=ct>Instruções 
        
        (Texto de responsabilidade do cedente)</font><br><br><span class=cp> <FONT class=campo>
        
        - Sr. Caixa, cobrar multa de 2% após o vencimento<br>
        
        - Receber até 10 dias após o vencimento<br>
        
        - Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br<br>
        
        &nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br</FONT><br><br> 
        
        </span></td>
        
        <td align=right width=188><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(-) 
        
        Desconto / Abatimentos</td></tr><tr> <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12></td></tr><tr> 
        
        <td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table></td></tr><tr><td align=right width=10> 
        
        <table cellspacing=0 cellpadding=0 border=0 align=left><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td></tr><tr><td valign=top width=7 height=1> 
        
        <img height=1 src=imagens/2.png width=1 border=0></td></tr></tbody></table></td><td align=right width=188><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(-) 
        
        Outras deduções</td></tr><tr><td class=cp valign=top width=7 height=12> <img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12></td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table></td></tr><tr><td align=right width=10> 
        
        <table cellspacing=0 cellpadding=0 border=0 align=left><tbody><tr><td class=ct valign=top width=7 height=13> 
        
        <img height=13 src=imagens/1.png width=1 border=0></td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=1 border=0></td></tr></tbody></table></td><td align=right width=188> 
        
        <table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(+) 
        
        Mora / Multa</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12></td></tr><tr> 
        
        <td valign=top width=7 height=1> <img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1> 
        
        <img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table></td></tr><tr><td align=right width=10><table cellspacing=0 cellpadding=0 border=0 align=left><tbody><tr> 
        
        <td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=1 border=0></td></tr></tbody></table></td><td align=right width=188> 
        
        <table cellspacing=0 cellpadding=0 border=0><tbody><tr> <td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(+) 
        
        Outros acréscimos</td></tr><tr> <td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12></td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table></td></tr><tr><td align=right width=10><table cellspacing=0 cellpadding=0 border=0 align=left><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td></tr></tbody></table></td><td align=right width=188><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>(=) 
        
        Valor cobrado</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top align=right width=180 height=12></td></tr></tbody> 
        
        </table></td></tr></tbody></table><table cellspacing=0 cellpadding=0 width=666 border=0><tbody><tr><td valign=top width=666 height=1><img height=1 src=imagens/2.png width=666 border=0></td></tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=659 height=13>Sacado</td></tr><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=659 height=12><span class="campo">
        
        José da Silva</span> 
        
        </td>
        
        </tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=cp valign=top width=7 height=12><img height=12 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=659 height=12><span class="campo">
        
        Rua ABC</span> 
        
        </td>
        
        </tr></tbody></table><table cellspacing=0 cellpadding=0 border=0><tbody><tr><td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=cp valign=top width=472 height=13> 
        
          <span class="campo">
        
          São Paulo - SP - CEP: 010200-000  </span></td>
        
        <td class=ct valign=top width=7 height=13><img height=13 src=imagens/1.png width=1 border=0></td><td class=ct valign=top width=180 height=13>Cód. 
        
        baixa</td></tr><tr><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=472 height=1><img height=1 src=imagens/2.png width=472 border=0></td><td valign=top width=7 height=1><img height=1 src=imagens/2.png width=7 border=0></td><td valign=top width=180 height=1><img height=1 src=imagens/2.png width=180 border=0></td></tr></tbody></table><TABLE cellSpacing=0 cellPadding=0 border=0 width=666><TBODY><tr><TD class=ct  width=7 height=12></td><TD class=ct  width=409 >Sacador/Avalista</td><TD class=ct  width=250 ><div align=right>Autenticação 
        
        mecânica - <b class=cp>Ficha de Compensação</b></div></td></tr><tr><TD class=ct  colspan=3 ></td></tr></tbody></table><TABLE cellSpacing=0 cellPadding=0 width=666 border=0><TBODY><tr><TD vAlign=bottom align=left height=50>
        <!--    CÓDIGO DE BARRAS    -->
        
        
        <!--    CÓDIGO DE BARRAS    -->
        
           
        
         </td>
        
        </tr></tbody></table><table cellSpacing=0 cellPadding=0 width=666 border=0><tr><TD class=ct width=666></td></tr><TBODY><tr><TD class=ct width=666><div align=right>Corte 
        
        na linha pontilhada</div></td></tr><tr><TD class=ct width=666><img height=1 src=imagens/6.png width=665 border=0></td></tr></tbody></table>
    
    </body>
</html>

