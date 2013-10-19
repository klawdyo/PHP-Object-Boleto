<?php
//18/05/11
class Banco{
    /*
        @var array $Codigo
        Armazena o código do banco
    */
    public $Codigo;

    /*
        @var array $nome
        Armazena o nome do banco
    */
    public $Nome;
    
    /*
        @var array $image
        Armazena o nome da imagem da logomarca do banco
    */
    public $Image;
    
    /*
        @var array $css
        Armazena o arquivo CSS utilizado por esse banco
    */
    public $Css;
    
    /*
        @var array $object
        Armazena o objeto OB
    */
    public $parent;
    
    /*
        @var array $relacoes
        Armazena a relação entre os mais diversos bancos e os nomes dos
        seus arquivos. Os nomes devem estar iguais, inclusive em relação
        ao caso.
        Fonte: http://www.febraban.org.br/Bancos.asp
     */
    public $relacoes = array(
        '001' => 'BB',
        '003' => 'BancoAmazonia',
        '004' => 'BNB',
        '033' => 'Santander',
        '041' => 'Banrisul',
        '070' => 'BRB', //Banco de Brasília
        '104' => 'Caixa',
        '237' => 'Bradesco',
        '318' => 'Bmg',
        '341' => 'Itau',
        '356' => 'Real',
        '399' => 'Hsbc',
        '409' => 'Unibanco',
        '623' => 'Panamericano',
        '756' => 'Bancoob',
    );
    
    
    /*
        @var array $tamanhos
        Armazena os dados de posições dos valores dentro do código de barras.
        
    */
    public $tamanhos = array();

    /*
        @var array $carteiras
        Armazena todas as carteiras disponíveis e as diferenças de tamanhos
        dos campos entre elas.
    */
    public $carteiras = array();
    
    /*
        @var $layoutCodigoBarras
        armazena o layout que será usado para gerar o código de barras desse banco
     */
    public $layoutCodigoBarras;
    
    /*
        @var $formataLinhaDigitavel
        Máscara para a linha digitável
     */
    public $mascaraLinhaDigitavel = '00000.00000 00000.000000 00000.000000 0 00000000000000';
    
    
    /**
      * Construtor da classe
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function __construct($object = null){
        if(!empty($object)){
            $this->parent = $object;
        }
    }
    
    /**
      * Carrega o arquivo e as configurações de layout do banco informado
      * 
      * @version 0.1 20/05/2011 Initial
      */
    public function load($codigo, $object){
        

        if(array_key_exists($codigo, $this->relacoes)){
            $banco = $this->relacoes[$codigo];
            $filename = OB_DIR . '/lib/bancos/' . $banco . '.php';

            if(file_exists($filename)){
                require $filename;
                return new $banco($object);
            }
            else{
                throw new Exception('O arquivo /lib/bancos/' . $banco. '.php não existe.');
            }
        }
        else{
            throw new Exception('O banco ' . $codigo. ' não existe em Banco::$relacoes');
        }
    }
    
    /**
      * Normaliza as variáveis de acordo com os seus tamanhos exatos
      * 
      * @version 0.1 18/05/2011 Initial
      */
    public function normalize($valor, $variavel){
        if(array_key_exists($variavel, $this->tamanhos)){
            $length = $this->tamanhos[$variavel];
            if(strlen($valor) < $length){
                return OB::zeros($valor, $length);
            }
            else{
                return String::left($valor, $length);
            }
        }
        else{
            throw new Exception(" A chave \"{$variavel}\" não existe no layout");
        }
    }
        
    /**
      * engenhariaReversa() pega um número de código de barras e o transforma em um array
      * com os valores, baseando os detalhes de cada banco.
      */
    public function engenhariaReversa($banco, $codigoBarras){
        
    }

    
    /**
      * particularidade() Faz em tempo de execução mudanças que sejam imprescindíveis
      * para a geração correta do código de barras
      * Esse método será estendido por todas as classes filhas, portanto só é
      * necessário declará-la caso haja algo para mudar
      *
      * @version 0.1 28/05/2011 Initial
      */
    public function particularidade($data){}
    
    /**
      * agenciaCondigoCedente()
      * Retorna a agência e a conta/código do cedente formatada de acordo
      * com o padrão visual do banco.
      * Caso esse método não seja declarado na classe individual dos bancos,
      * ele irá herdar esta definição
      */
    public function agenciaCodigoCedente(){
        $object = $this->parent;
        
        return Math::Mod10($object->Data['Agencia'], true) . ' / ' . Math::Mod10($object->Data['Conta'], true);
    }
    
    
    /**
      * Avalia se todos os campos necessários para a geração do código de barras
      * estão preenchidos
      *
      * @version 0.1 28/05/2011
      *          0.2 18/10/2013 Reabilitado. Agora não verifica a o DV, pois este é calculado
      *             só ao final da geração do código de barras
      */
    public function verificaObrigatorios($data){
        $obrigatorios = array_keys($this->tamanhos);
        
        foreach($this->tamanhos as $chave => $valor){
            //Se a chave for diferente de 'DV' e 
            if($chave != 'DV' && (!array_key_exists($chave, $data) || is_null($data[$chave]))){
                throw new Exception('O campo "' . $chave . '" é obrigatório para
                    a geração do código de barras do banco "' . $this->Nome . '"');
            }
        }
    }
    
    /**
      * Retorna as carteiras aceitas por esse boleto
      *
      * @version 0.1 31/05/2011
      */
    public function getCarteiras(){
        $buff = array();
        
        foreach($this->carteiras as $key => $carteira){
            if(is_array($carteira)){
                $buff[] = $key;
            }
            else{
                $buff[] = $carteira;
            }
        }
        return $buff;
    }

    /**
      * Retorna as posições desse banco, para essa carteira,
      * já considerando as diferenças. Se informar o parâmetro
      * $campo, retorna o tamanho específico desse campo
      *
      * @version 0.1 31/05/2011
      *          0.2 31/05/2011 Se passar um nome de campo, ele retorna só aquele campo específico
      */
    public function getTamanhos($campo = null){
        if(is_null($campo)){
            $carteira = $this->parent->Vendedor->Carteira;
            if(array_key_exists($carteira, $this->carteiras)){
                return array_merge($this->tamanhos, $this->carteiras[$carteira]);
            }
            else{
                return $this->tamanhos;
            }
        }
        else{
            $tamanhos = $this->getTamanhos();
            if(array_key_exists($campo, $tamanhos)){
                return $tamanhos[$campo];
            }
        }
    }
}