<?php
    namespace Application\Form;

    use Zend\Form\Form;
    use Application\Model\TipoProdutoTable;

    class Produto extends Form
    {
        private $table;

        public function __construct($name = null, array $options = array())
        {
            if (isset($options['table'])){
                $this->table = $options['table'];
            } else {
                throw new \Exception('Form requires TipoProdutoTable instance');
            }
            parent::__construct('produto');
            $this->setAttribute('method', 'post');
            $this->add(array(
                'name' => 'id',
                'type' => 'hidden'
            ));
            $this->add(array(
                'name' => 'nome',
                'attributes' => array(
                    'type' => 'text',
                    'autofocus' => 'autofocus',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'Nome: ',
                ),
            ));
            $this->add(array(
                'name' => 'tb_tipo_produto_id',
                'type' => 'select',
                'options' => array(
                    'label' => 'Tipo Produto: ',
                    'value_options' => $this->getValueOptions()
                ),
                'attributes' => [
                    'class' => 'form-control',
               ],
            ));
            $this->add(array(
                'name' => 'preco_compra',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'currency-field',
                    'pattern' => '^R\$\d{1,3}(\.\d{3})*(\,\d+)?$',
                    'value' => '',
                    'data-type' => 'currency',
                    'placeholder' => 'R$ 1.000,00'
                ),
                'options' => array(
                    'label' => 'Preço Compra: ',
                ),
            ));
            $this->add(array(
                'name' => 'preco_venda',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'currency-field',
                    'pattern' => '^R\$\d{1,3}(\.\d{3})*(\,\d+)?$',
                    'value' => '',
                    'data-type' => 'currency',
                    'placeholder' => 'R$ 1.000,00'
                ),
                'options' => array(
                    'label' => 'Preço Venda: ',
                ),
            ));
            $this->add(array(
                'name' => 'preco_servico',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'currency-field',
                    'pattern' => '^R\$\d{1,3}(\.\d{3})*(\,\d+)?$',
                    'value' => '',
                    'data-type' => 'currency',
                    'placeholder' => 'R$ 1.000,00'
                ),
                'options' => array(
                    'label' => 'Preço Servico: ',
                ),
            ));
            $this->add(array(
                'name' => 'quantidade',
                'attributes' => array(
                    'type' => 'number',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'Quantidade: ',
                ),
            ));
            $this->add(array(
                'name' => 'observacao',
                'attributes' => array(
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'rows' => '4',
                    
                ),
                'options' => array(
                    'label' => 'Observação: ',
                ),
            ));
            
            $this->add(array(
                'name' => 'submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'Gravar',
                    'id' => 'submitbutton',
                    'class' => 'btn btn-primary'
                ),
            ));
        }

        /**
         * 
         * @return TipoProdutoTable
         */
        private function getTipoProdutoTable()
        {
            return $this->table;
        }

        /**
         * 
         * @return Generator
         */
        private function getValueOptions()
        {
            $valueOptions = array();
            $tiposprodutos = $this->getTipoProdutoTable()->fetchAll();
            $options = array();
            foreach ($tiposprodutos as $tipoproduto) {
                $options[$tipoproduto->id] = $tipoproduto->descricao;
            }
            return $options;
        }
    }
?>