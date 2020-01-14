<?php
    namespace Application\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;
    use Zend\Db\Sql\Select;

    class ProdutoTable
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
            $select = new Select();
            $select->from('tb_produtos')
                ->columns(array('id', 'tb_tipo_produto_id', 'nome', 'preco_compra', 'preco_venda', 'preco_servico', 'quantidade', 'observacao'))
                ->join(array('tprod'=>'tb_tipo_produto'),'tb_produtos.tb_tipo_produto_id = tprod.id', 'descricao');
            $resultSet = $this->tableGateway->selectWith($select);
            return $resultSet;
        }


        /**
         * 
         * @param string $keyValue
         * @return Produto
         */
        public function getModel($keyValue)
        {
            $select = new Select();
            $select->from('tb_produtos')
                ->columns(array('id', 'tb_tipo_produto_id', 'nome', 'preco_compra', 'preco_venda', 'preco_servico', 'quantidade', 'observacao'))
                ->join(array('tprod'=>'tb_tipo_produto'),'tb_produtos.tb_tipo_produto_id = tprod.id', 'descricao')
                ->where(array('tb_produtos.id' => $keyValue));
            $rowset = $this->tableGateway->selectWith($select);

            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new Produto();
            }

            return $row;
        }

        /**
         * 
         * @param Produto $produto
         */
        public function saveModel(Produto $produto)
        {
            $precoCompra = str_replace(',','.',str_replace('.','',substr($produto->precoCompra,3)));
            $precoVenda = str_replace(',','.',str_replace('.','',substr($produto->precoVenda,3)));
            $precoServico = str_replace(',','.',str_replace('.','',substr($produto->precoServico,3)));
            $data = array(
                'nome' => $produto->nome,
                'tb_tipo_produto_id' => $produto->tipoProduto->id,
                'preco_compra'=>$precoCompra,
                'preco_venda'=>$precoVenda,
                'preco_servico'=>$precoServico,
                'quantidade'=>$produto->quantidade,
                'observacao'=>$produto->observacao
            );
            $id = $produto->id;
            if (empty($this->getModel($id)->id)) {
                $data['id'] = 0;
                echo($produto->status);
                $this->tableGateway->insert($data);
            } else {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }

        public function deleteModel($keyValue)
        {
            $this->tableGateway->delete(array(
                $this->keyName => $keyValue
            ));
        }
        
    }
?>
