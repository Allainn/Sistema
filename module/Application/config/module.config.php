<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Session\SessionManager;
use Application\Model\UsuarioTable;
use Application\Model\Usuario;
use Application\Model\TipoUsuarioTable;
use Application\Model\TipoUsuario;
use Application\Model\TipoProdutoTable;
use Application\Model\TipoProduto;
use Application\Model\ProdutoTable;
use Application\Model\Produto;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:controller[/:action[/:key[/:status]]]]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/login[/:controller]',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'aliases' => [
            'autenticacao' => Controller\AutenticacaoController::class,
            'usuario' => Controller\UsuarioController::class,
            'tipoProduto' => Controller\TipoProdutoController::class,
            'produto' => Controller\ProdutoController::class,
            'application' => Controller\IndexController::class,
        ],
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\LoginController::class => InvokableFactory::class,
            Controller\AutenticacaoController::class => function($sm){
                $table = $sm->get(UsuarioTable::class);
                $sessionManager = new SessionManager();
                return new Controller\AutenticacaoController($table, $sessionManager);
            },
            Controller\TipoUsuarioController::class => function($sm){
                $table = $sm->get(TipoUsuarioTable::class);
                $sessionManager = new SessionManager();
                return new Controller\TipoUsuarioController($table, $sessionManager);
            },
            Controller\UsuarioController::class => function($sm){
                $table = $sm->get(UsuarioTable::class);
                $parentTable = $sm->get(TipoUsuarioTable::class);
                $sessionManager = new SessionManager();
                return new Controller\UsuarioController($table, $parentTable, $sessionManager);
            },
            Controller\TipoProdutoController::class => function($sm){
                $table = $sm->get(TipoProdutoTable::class);
                $sessionManager = new SessionManager();
                return new Controller\TipoProdutoController($table, $sessionManager);
            },
            Controller\ProdutoController::class => function($sm){
                $table = $sm->get(ProdutoTable::class);
                $parentTable = $sm->get(TipoProdutoTable::class);
                $sessionManager = new SessionManager();
                return new Controller\ProdutoController($table, $parentTable, $sessionManager);
            },
        ],
    ],
    'route_layouts' => [
        'application'   => 'layout/user', 
        'home'        => 'layout/user', 
        'login'       => 'layout/login',
        'error/404'   => 'error/404',
        'error/index' => 'error/index',
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/user'             => __DIR__ . '/../view/layout/layout.phtml',
            'layout/login'            => __DIR__ . '/../view/layout/layout_login.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'constraints' => [
        'action' => '[a-zA-Z0-9_-]+',
        'id' => '[0-9]+',
    ],
    'service_manager' => [
        'factories' => [
            UsuarioTable::class => function($sm) {
                $tableGateway = $sm->get('UsuarioTableGateway');
                $table = new UsuarioTable($tableGateway);
                return $table;
            },
            'UsuarioTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Usuario());
                return new TableGateway('tb_usuarios', $dbAdapter, null, $resultSetPrototype);
            },
            TipoUsuarioTable::class => function($sm) {
                $tableGateway = $sm->get('TipoUsuarioTableGateway');
                $table = new TipoUsuarioTable($tableGateway);
                return $table;
            },
            'TipoUsuarioTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new TipoUsuario());
                return new TableGateway('tb_tipo_usuarios', $dbAdapter, null, $resultSetPrototype);
            },
            TipoProdutoTable::class => function($sm) {
                $tableGateway = $sm->get('TipoProdutoTableGateway');
                $table = new TipoProdutoTable($tableGateway);
                return $table;
            },
            'TipoProdutoTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new TipoProduto());
                return new TableGateway('tb_tipo_produto', $dbAdapter, null, $resultSetPrototype);
            },
            ProdutoTable::class => function($sm) {
                $tableGateway = $sm->get('ProdutoTableGateway');
                $table = new ProdutoTable($tableGateway);
                return $table;
            },
            'ProdutoTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Produto());
                return new TableGateway('tb_produtos', $dbAdapter, null, $resultSetPrototype);
            },
        ]
    ]
];
