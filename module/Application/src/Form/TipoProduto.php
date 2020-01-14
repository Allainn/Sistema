<?php
    namespace Application\Form;

    use Zend\Form\Form;

    class TipoProduto extends Form
    {
        public function __construct($name = null)
        {
            parent::__construct('tipoProduto');
            $this->setAttribute('method', 'post');

            $this->add([
                'name' => 'id',
                'type' => 'hidden'
            ]);    
            $this->add(array(
                'name' => 'descricao',
                'attributes' => array(
                    'type' => 'text',
                    'autofocus' => 'autofocus',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'label' => 'Descrição: ',
                ),
            ));
            $this->add([
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => 'Gravar',
                    'id' => 'submitbutton',
                    'class' => 'btn btn-primary'
                ],
            ]);
        }
    }
?>