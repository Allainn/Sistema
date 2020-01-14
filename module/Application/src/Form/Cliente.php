<?php
    namespace Application\Form;

    use Zend\Form\Form;

    class Cliente extends Form
    {
        public function __construct($name = null)
        {
            parent::__construct('cliente');
            $this->setAttribute('method', 'post');

            $this->add([
                'name' => 'id',
                'type' => 'hidden'
            ]);    
            $this->add(array(
                'name' => 'nome',
                'attributes' => array(
                    'type' => 'text',
                    'autofocus' => 'autofocus',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'Nome Completo: ',
                ),
            ));
            $this->add(array(
                'name' => 'endereco',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'Endereço: ',
                ),
            ));
            $this->add(array(
                'name' => 'telefone',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'Telefone: ',
                ),
            ));
            $this->add(array(
                'name' => 'celular',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'Celular: ',
                ),
            ));
            $this->add(array(
                'name' => 'cpf',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'CPF: ',
                ),
            ));
            $this->add(array(
                'name' => 'email',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'E-mail: ',
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