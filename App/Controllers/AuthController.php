<?php

namespace App\Controllers;

use App\Models\DAO\UsuarioDAO;
use DiamondFramework\Model\Container;
use DiamondFramework\Controller\Action;

class AuthController extends Action
{
    public function autenticar()
    {
        $emailLogin = filter_input(INPUT_POST, 'loginEmail');
        $senhaLogin = md5(filter_input(INPUT_POST, 'loginSenha'));

        $usuario = Container::getModel('Usuario');

        $usuario->setEmail( $emailLogin );
        $usuario->setSenha( $senhaLogin );

        $usuarioDao = new UsuarioDAO();

        $usuarioDao->autenticar( $usuario );

       if($usuario->getId() != '' && $usuario->getNome() != '')
       {
            session_start();

            $_SESSION['id'] = $usuario->getId();
            $_SESSION['nome'] = $usuario->getNome();

            header('location: /timeline');
       }
       else
       {
           header('location: /?login=erro' );
           echo "Erro na autenticação";
       }
    }

    public function sair()
    {
        session_start();

        session_destroy();

        header('location: /');

    }
}