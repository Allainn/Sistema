<?php 

namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Mvc\I18n\Translator as MvcTranslator;
use Zend\Validator\AbstractValidator;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\Resources;
use Application\Model\Usuario;
use Application\Model\TipoUsuario;

class AutenticacaoController extends AbstractActionController
{

    private $table;

    public function __construct($table, $sessionManager)
    {
        $this->table = $table;
        $sessionManager->start();

        $login = $_POST['login'];
        $senha = $_POST['senha'];
        
        $usuario = $this->table->getAutentication($login, $senha);
        $sessionStorage = new SessionArrayStorage();
        if (isset($sessionStorage->model)){
            $usuario->exchangeArray($sessionStorage->model->toArray());
            unset($sessionStorage->model);
        }
        if (isset($usuario->id) ){
            if ($usuario->status == 1) { 
                $_SESSION['logado']= 'SIM'; 
                $_SESSION['login']= $login;
                $_SESSION['usuario']= $usuario->nome;
                //id 1 = Administrador
                //id 2 = TipoProduto
                $_SESSION['tipo_usuario']= $usuario->tipoUsuario->id;
                echo "<script>alert('Logado com Sucesso');</script>";
                echo "<script> document.location.href = '/application'; </script>";
            }
            else {
                echo "<script>alert('Usuário desativado!');</script>";
                echo "<script> document.location.href = '/login'; </script>";    
            }
        }
        else
        {     
            echo "<script>alert('Prezado usuário,\\n Seus dados estão incorrentos');</script>";
            echo "<script> document.location.href = '/login'; </script>";    
        }

    }

}
?>