<?php
    namespace Application\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;

    class TipoProdutoTable
    {
        /**
         * 
         * @var TableGatewayInterface
         */
        private $tableGateway;

        /**
         * 
         * @var string
         */
        private $keyName = 'id';

        /**
         * 
         * @param TableGatewayInterface $tableGateway
         */
        public function __construct(TableGatewayInterface $tableGateway)
        {
            $this->tableGateway = $tableGateway;
        }

        /**
         * 
         * @return ResultInterface
         */
        public function fetchAll()
        {
            $resultSet = $this->tableGateway->select();
            return $resultSet;
        }

        /**
         * 
         * @param string $keyValue
         * @return TipoProduto
         */
        public function getModel($keyValue)
        {
            $rowset = $this->tableGateway->select(array($this->keyName => $keyValue));
            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new TipoProduto();
            }

            return $row;
        }

        /**
         * 
         * @param TipoProduto $tipoProduto
         */
        public function saveModel(TipoProduto $tipoProduto)
        {
            $data = array(
                'descricao' => $tipoProduto->descricao
            );
            $id = $tipoProduto->id;
            if (empty($this->getModel($id)->id)) {
                $data['id'] = 0;
                $this->tableGateway->insert($data);
            } else {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }

        public function deleteModel($keyValue)
        {
            try {
                $this->tableGateway->delete(array(
                    $this->keyName => $keyValue
                ));
            } finally {
                echo "<script>alert('Não é possíve remover o tipo de produto. O mesmo está em uso!');</script>";
                echo "<script> document.location.href = '/application/tipoProduto'; </script>";
            }
        }
    }
?>