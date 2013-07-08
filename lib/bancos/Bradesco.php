<?php
/**
-----------------------
    COPYRIGHT
-----------------------
    Licensed under The MIT License.
    Redistributions of files must retain the above copyright notice.

    @author  Marco Pergola <marco.pergola@riotera.com>
    @package ObjectBoleto http://github.com/klawdyo/PHP-Object-Boleto
    @subpackage ObjectBoleto.Lib.Bancos
    @license http://www.opensource.org/licenses/mit-license.php The MIT License

-----------------------
    CHANGELOG
-----------------------
    01/09/2011
    [+] Inicial



  */
class Bradesco extends Banco{
    public $Codigo = '237';
    public $Nome = 'Bradesco';
    //public $Css = 'bb.css';
    public $Image = 'bradesco.png';

	public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco'             => 3,   //identificação do banco
        'Moeda'             => 1,   //Código da moeda: real=9
        'DV'                => 1,   //Dígito verificador geral da linha digitável
        'FatorVencimento'   => 4,   //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => 10,  //Valor nominal do título
        #Campos variávies
        'Agencia'           => 4,   //Código da agencia, sem dígito
        'Conta'             => 6,   //Número da conta
		'CodigoCedente'		=> 7,	//Número do convênio fornecido pelo banco
        'DigitoConta'       => 1,   //Dígito da conta do Cedente
        'NossoNumero'       => 11,   //Nosso número
        'DigitoNossoNumero' => 5,   //Dígito do nosso número
        'Carteira'          => 2,   //Código da carteira
    );

	/*
        @var string $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco.
        Cada variável é precedida por dois-pontos (:), que serão substituídas
        pelos seus respectivos valores
     */
	public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:Agencia:CartNum:CodigoCedente0';

	/**
      * particularidade() Faz em tempo de execução mudanças que sejam imprescindíveis
      * para a geração correta do código de barras
      * Especificamente para o Hsbc, temos duas particularidas: Data no formato juliano, e
      * um dígito verificador triplo para o nosso número.
      *
      *
      * @version 0.1 28/05/2011 Initial
      */
    public function particularidade($object){
		$object->Data['CartNum'] = $object->Data['Carteira'] . $object->Data['NossoNumero'];
		$object->Boleto->NossoNumero = $object->Vendedor->Carteira . ' / ' .  $this->dvNossoNumero($object->Data);;
    }

	/*
        @var $carteiras
        Identifica as carteiras disponíveis para esse banco.

        - A primeira carteira sempre é a carteira padrão.
        - Se a carteira for um array, esse array deverá conter as diferenças
        nos tamanhos entre essa carteira e a carteira padrão. Se for uma
        string, será considerado que os tamanahos são os mesmos da carteira
        padrão, e o valor será o nome da carteira.
        - Só é necessário informar os campos cujos tamanhos sejam diferentes
        dos da carteira padrão.
     */
	public $carteiras = array(
		'06',
		'03'
	);

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

	function dvNossoNumero($data) {
		$dv =  Math::Mod11($data['Carteira'] . $data['NossoNumero'], 0, 0, false, 7);
		return $data['NossoNumero'] . '-' . $dv;
	}

}