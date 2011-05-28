<?php
/**
-----------------------
    COPYRIGHT
-----------------------
    Licensed under The MIT License.
    Redistributions of files must retain the above copyright notice.

    @author  Cláudio Medeiros <contato@claudiomedeiros.net>
    @package ObjectBoleto http://github.com/klawdyo/PHP-Object-Boleto
    @subpackage ObjectBoleto.Lib.Bancos
    @license http://www.opensource.org/licenses/mit-license.php The MIT License
    
-----------------------
    CHANGELOG
-----------------------
    17/05/2011
    [+] Inicial
    
    
    
  */
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