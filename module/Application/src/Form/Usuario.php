<?php
    namespace Application\Form;

    use Zend\Form\Form;
    use Application\Model\TipoUsuarioTable;

    class Usuario extends Form
    {
        private $table;

        public function __construct($name = null, array $options = array())
        {
            if (isset($options['table'])){
                $this->table = $options['table'];
            } else {
                throw new \Exception('Form requires TipoUsuarioTable instance');
            }
            parent::__construct('usuario');
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
                'name' => 'sobrenome',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'Sobrenome: ',
                ),
            ));
            $this->add(array(
                'name' => 'login',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'Login: ',
                ),
            ));
            $this->add(array(
                'name' => 'senha',
                'attributes' => array(
                    'type' => 'password',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => 'Senha: ',
                ),
            ));

            $this->add(array(
                'name' => 'tb_tipo_usuarios_id',
                'type' => 'select',
                'options' => array(
                    'label' => 'Tipo Usuario: ',
                    'value_options' => $this->getValueOptions()
                ),
                'attributes' => [
                    'class' => 'form-control',
               ],
            ));
            $this->add(array(
                'name' => 'status',
                'type' => 'checkbox',
                'options' => array(
                    'label' => 'Status',
                    'checked_value' => 1,
                    'unchecked_value' => 0,
                ),
                'attributes' => [
                    'value' => 'Ativo',
                    'class' => 'form-check-input',
               ],
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
         * @return TipoUsuarioTable
         */
        private function getTipoUsuarioTable()
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
            $tiposusuarios = $this->getTipoUsuarioTable()->fetchAll();
            $options = array();
            foreach ($tiposusuarios as $tipousuario) {
                $options[$tipousuario->id] = $tipousuario->descricao;
            }
            return $options;
        }
    }
?>