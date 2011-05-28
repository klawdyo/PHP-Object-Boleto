<?php
class BB extends Banco{
    public $Codigo = '001';
    public $Nome = 'Banco do Brasil';
    public $Css = 'bb.css';
    public $Image = 'bb.png';
    
    /*
        @var array $obrigatorios
        Armazena os campos obrigatórios para a geração do código de
        barras e a linha digitável neste banco, assim como a emissão
        do boleto bancário
     */
    public $obrigatorios = array(
        'Agencia', 'CodigoCedente',
        'Nome', 'Valor', 'Vencimento', 
        'Banco', 'Moeda', 'NossoNumero', 'Carteira'
    );
    
    
    
    
    
}