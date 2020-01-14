<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Mvc\I18n\Translator as MvcTranslator;
use Zend\Validator\AbstractValidator;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\Resources;
use Application\Form\Usuario as UsuarioForm;
use Application\Model\Usuario;
use Zend\Session\SessionManager;

class UsuarioController extends AbstractActionController
{
    private $table;
    private $parentTable;

    public function __construct($table, $parentTable, $sessionManager)
    {
        $this->table = $table;
        $this->parentTable = $parentTable;
        $sessionManager->start();
    }

    public function indexAction()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1){
            return new ViewModel(
                ['models' => $this->table->fetchAll()]
            );
        }
        else if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
            echo "<script>alert('Você não tem permissão de acessar está página!');</script>";
            echo "<script> document.location.href = '/application'; </script>";
        }
        else {
            return $this->redirect()->toRoute(
                'login'
            );
        }
    }

    /**
     * Action to add and change records
     */
    public function editAction()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1){
            $id = $this->params()->fromRoute('key', null);
            $usuario = $this->table->getModel($id);
            //print_r($usuario);
            $form = new UsuarioForm(
                'usuario',
                ['table' => $this->parentTable]
            );
            $form->get('submit')->setValue(
                empty($id) ? 'Cadastrar' : 'Alterar'
            );
            $sessionStorage = new SessionArrayStorage();
            if (isset($sessionStorage->model)){
                $usuario->exchangeArray($sessionStorage->model->toArray());
                unset($sessionStorage->model);
                $form->setInputFilter($usuario->getInputFilter());
                $this->initValidatorTranslator();
                $form->bind($usuario);
                $form->isValid();
            } else{
                $form->bind($usuario);
            }
            return [
                'form' => $form,
                'title' => empty($id) ? 'Incluir' : 'Alterar'
            ];
        }
        else if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
            echo "<script>alert('Você não tem permissão de acessar está página!');</script>";
            echo "<script> document.location.href = '/application'; </script>";
        }
        else {
            return $this->redirect()->toRoute(
                'login'
            );
        }
    }

    /**
     * Action to save a record
     */
    public function saveAction()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1){
            $request = $this->getRequest();
            if ($request->isPost()) {
                $form = new UsuarioForm(
                    'usuario',
                    ['table' => $this->parentTable]
                );
                $usuario = new Usuario();
                $form->setInputFilter($usuario->getInputFilter());
                $post = $request->getPost();
                $form->setData($post);
                if (!$form->isValid()){
                    $sessionStorage = new SessionArrayStorage();
                    $sessionStorage->model = $post;
                    return $this->redirect()->toRoute(
                        'application',
                        [
                            'action'=>'edit',
                            'controller'=>'usuario'
                        ]
                    );
                }
                $usuario->exchangeArray($form->getData());
                try {
                    $this->table->saveModel($usuario);
                } finally {
                    echo "<script>alert('Nome do usuário já existe!');</script>";
                    echo "<script> document.location.href = '/application/usuario/edit'; </script>";
                }
            }
            return $this->redirect()->toRoute(
                'application',
                ['controller'=>'usuario']
            );
        }
        else if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
            echo "<script>alert('Você não tem permissão de acessar está página!');</script>";
            echo "<script> document.location.href = '/application'; </script>";
        }
        else {
            return $this->redirect()->toRoute(
                'login'
            );
        }
    }

    public function ativarAction(){
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1){
            $id = $this->params()->fromRoute('key', null);
            $status = $this->params()->fromRoute('status', null);
            $usuario = $this->table->getModel($id);
            $usuario->status = (int) $status;
            $this->table->saveModel($usuario);
            return $this->redirect()->toRoute(
                'application',
                ['controller'=>'usuario']
            );
        }
        else if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
            echo "<script>alert('Você não tem permissão de acessar está página!');</script>";
            echo "<script> document.location.href = '/application'; </script>";
        }
        else {
            return $this->redirect()->toRoute(
                'login'
            );
        }
    }

    protected function initValidatorTranslator()
    {
        $translator = new Translator();
        $mvcTranslator = new MvcTranslator($translator);
        $mvcTranslator->addTranslationFilePattern(
            'phparray',
            Resources::getBasePath(),
            Resources::getPatternForValidator()
        );

        AbstractValidator::setDefaultTranslator($mvcTranslator);
    }
}
