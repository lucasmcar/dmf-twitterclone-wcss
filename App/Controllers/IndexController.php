<?php

namespace App\Controllers;
use DiamondFramework\Model\Container;
use DiamondFramework\Controller\Action;

//Models
use App\Models\Usuario;
use App\Models\DAO\UsuarioDAO;



class IndexController extends Action
{
    
    /**/
    public function index()
    {

        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';

        //Renderizar tela
        $this->render('index');
    }
    
    public function inscreverse()
    {

        $this->view->usuario = array
        (
            'nome' => '',
            'email' => '',
            'senha' => ''
        ); 
        $this->view->erroCadastro = false;

        $this->render('inscreverse');
    }
    
    public function registrar()
    {
           $nome = filter_input(INPUT_POST, 'txNome', FILTER_SANITIZE_STRING);
           $email = filter_input(INPUT_POST, 'txEmail', FILTER_SANITIZE_STRING);
           $senha = md5(filter_input(INPUT_POST, 'txSenha'));
           
           $usuario = Container::getModel('Usuario');
           
           $usuario->setNome( $nome );
           $usuario->setEmail( $email );
           $usuario->setSenha( $senha );
           
           $dao = new UsuarioDAO();
           
           if($dao->validarCadastro($usuario))
           {
                if(count($dao->getUserByEmail($usuario)) == 0)
                {
                    $dao->salvar($usuario);

                    $this->render('cadastro');
                }
                else
                {
                    $this->view->usuario = array
                    (
                        'nome' => $nome,
                        'email' => $email,
                        'senha' => $senha
                    ); 

                    $this->view->erroCadastro = true;

                    $this->render('inscreverse');
                }

                
           }
           else
           {
                $this->view->usuario = array
                (
                    'nome' => $nome,
                    'email' => $email,
                    'senha' => $senha
                ); 

                $this->view->erroCadastro = true;

               $this->render('inscreverse');
           }
    }

    
}
