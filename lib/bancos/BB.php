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

	public $tamanhos = array(
        #Campos comuns a todos os bancos
        'Banco'             => 3,   //identificação do banco
        'Moeda'             => 1,   //Código da moeda: real=9
        'DV'                => 1,   //Dígito verificador geral da linha digitável
        'FatorVencimento'   => 4,   //Fator de vencimento (Dias passados desde 7/out/1997)
        'Valor'             => 10,  //Valor nominal do título
        #Campos variávies
        'Agencia'           => 4,   //Código da agencia, sem dígito
        'Conta'             => 8,   //Número da conta
		'CodigoCedente'		=> 6,	//Número do convênio fornecido pelo banco
        'DigitoConta'       => 1,   //Dígito da conta do Cedente
        'NossoNumero'       => 5,   //Nosso número
        'DigitoNossoNumero' => 5,   //Dígito do nosso número
        'Carteira'          => 2,   //Código da carteira
    );

	/*
        @var string $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco.
        Cada variável é precedida por dois-pontos (:), que serão substituídas
        pelos seus respectivos valores
     */
//	public $layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:CodigoCedente:NossoNumero:Agencia:Conta:Carteira';

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
		switch ($object->Vendedor->Carteira) {
			case '18-6':
				$object->Boleto->NossoNumero = $object->Data['CodigoCedente'] . Math::Mod11($object->Data['NossoNumero'], 0, 0, true);
				break;
			case '18-6-17':
				$this->layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor:CodigoCedente:NossoNumero21';
				break;
			case '18-7':
				$this->layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor000000:CodigoCedente:NossoNumero:Carteira';
				$object->Boleto->NossoNumero = $object->Data['CodigoCedente'] . $object->Data['NossoNumero'];
				break;
			case '18-8':
				$this->layoutCodigoBarras = ':Banco:Moeda:FatorVencimento:Valor000000:CodigoCedente:NossoNumero:Carteira';
				$object->Boleto->NossoNumero = $object->Data['CodigoCedente'] . Math::Mod11($object->Data['NossoNumero'], 0, 0, true);
				break;
		}
		$object->Vendedor->Carteira = '18';
		//Gerando o número do dígito da conta
		$object->Data['DigitoConta'] = Math::Mod11($object->Cliente->Conta);
		$object->Data['DigitoNossoNumero'] = Math::Mod11($object->Boleto->NossoNumero);
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
        Abaixo, "CNR" é a carteira padrão, e "CNR Fácil" é a segunda opção
        de carteira. No "CNR Fácil", há apenas as mudanças no NossoNumero e no
        CodigoCedente. Os demais campos são iguais
     */
	public $carteiras = array(
		'18-6',
		'18-6-17' => array('NossoNumero' => 17, 'CodigoCedente' => 7),
		'18-7' => array('NossoNumero' => 10, 'CodigoCedente' => 7),
		'18-8' => array('NossoNumero' => 9, 'CodigoCedente' => 8)
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





}