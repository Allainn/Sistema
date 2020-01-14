<?php
namespace Application\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class Produto
{
    /**
    * 
    * @var integer
    */
    public $id;

    /**
    * 
    * @var TipoProduto
    */
    public $tipoProduto;

    /**
    * 
    * @var string
    */
    public $nome;

    /**
    * 
    * @var string
    */
    public $precoCompra;

    /**
    * 
    * @var string
    */
    public $precoVenda;

    /**
    * 
    * @var string
    */
    public $precoServico;

    /**
    * 
    * @var string
    */
    public $quantidade;


    /**
    * 
    * @var bool
    */
    public $observacao;


    /**
     * 
     * @var InputFilterInterface
     */
    private $inputFilter;

    public function __construct()
    {
        $this->tipoProduto = new TipoProduto();
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->precoCompra = (isset($data['preco_compra'])) ? $data['preco_compra'] : null;
        $this->precoVenda = (isset($data['preco_venda'])) ? $data['preco_venda'] : null;
        $this->precoServico = (isset($data['preco_servico'])) ? $data['preco_servico'] : null;
        $this->quantidade = (isset($data['quantidade'])) ? $data['quantidade'] : null;
        $this->observacao = (isset($data['observacao'])) ? $data['observacao'] : null;
        $this->tipoProduto = new TipoProduto();
        $this->tipoProduto->id = (isset($data['tb_tipo_produto_id'])) ? $data['tb_tipo_produto_id'] : null;
        $this->tipoProduto->descricao = (isset($data['descricao'])) ? $data['descricao'] : null;
    }


    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            

            $inputFilter->add($factory->createInput([
                'name' => 'nome',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 45
                        ]
                    ]
                ]
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'tb_tipo_produto_id',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'Int'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Digits'
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'preco_compra',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 20
                        ]
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'preco_venda',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 20
                        ]
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'preco_servico',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 20
                        ]
                    ]
                ]
            ]));
            
            $inputFilter->add($factory->createInput([
                'name' => 'quantidade',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'Int'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Digits'
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'observacao',
                'required' => false,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 30
                        ]
                    ]
                ]
            ]));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

    /**
     * 
     * @return array
     */
    public function getArrayCopy() {
        return [
            'id'=>$this->id,
            'tb_tipo_produto_id'=>$this->tipoProduto->id,
            'nome'=>$this->nome,
            'preco_compra'=>$this->precoCompra,
            'preco_venda'=>$this->precoVenda,
            'preco_servico'=>$this->precoServico,
            'quantidade'=>$this->quantidade,
            'observacao'=>$this->observacao
        ];
    }
}
?>
