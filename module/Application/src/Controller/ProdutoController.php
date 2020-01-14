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
use Application\Form\Produto as ProdutoForm;
use Application\Model\Produto;
use Zend\Session\SessionManager;

class ProdutoController extends AbstractActionController
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
            $produto = $this->table->getModel($id);
            //print_r($produto);
            $form = new ProdutoForm(
                'produto',
                ['table' => $this->parentTable]
            );
            $form->get('submit')->setValue(
                empty($id) ? 'Cadastrar' : 'Alterar'
            );
            $sessionStorage = new SessionArrayStorage();
            if (isset($sessionStorage->model)){
                $produto->exchangeArray($sessionStorage->model->toArray());
                unset($sessionStorage->model);
                $form->setInputFilter($produto->getInputFilter());
                $this->initValidatorTranslator();
                $form->bind($produto);
                $form->isValid();
            } else{
                $form->bind($produto);
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
                $form = new ProdutoForm(
                    'produto',
                    ['table' => $this->parentTable]
                );
                $produto = new Produto();
                $form->setInputFilter($produto->getInputFilter());
                $post = $request->getPost();
                $form->setData($post);
                if (!$form->isValid()){
                    $sessionStorage = new SessionArrayStorage();
                    $sessionStorage->model = $post;
                    return $this->redirect()->toRoute(
                        'application',
                        [
                            'action'=>'edit',
                            'controller'=>'produto'
                        ]
                    );
                }
                $produto->exchangeArray($form->getData());
                $this->table->saveModel($produto);
            }
            return $this->redirect()->toRoute(
                'application',
                ['controller'=>'produto']
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

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('key', null);
        $this->table->deleteModel($id);
        return $this->redirect()->toRoute(
            'application',
            ['controller'=>'produto']
        );
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
