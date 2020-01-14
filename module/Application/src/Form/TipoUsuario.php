<?php
    namespace Application\Form;

    use Zend\Form\Form;

    class TipoUsuario extends Form
    {
        public function __construct($name = null)
        {
            parent::__construct('tipoUsuario');
            $this->setAttribute('method', 'post');

            $this->add([
                'name' => 'id',
                'attributes' => [
                    'type' => 'number',
                    'autofocus' => 'autofocus'
                ],
                'options' => [
                    'label' => 'Código',
                ]
            ]);    
            $this->add([
                'name' => 'descricao',
                'attributes' => [
                    'type' => 'text',
                    'class' => 'form-control'
                ],
                'options' => [
                    'label' => 'Descricao',
                ],
            ]);
            $this->add([
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => 'Gravar',
                    'id' => 'submitbutton',
                ],
            ]);
        }
    }
?>