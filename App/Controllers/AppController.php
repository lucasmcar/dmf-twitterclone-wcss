<?php

namespace App\Controllers;

use App\Models\DAO\TweetDAO;
use App\Models\DAO\UsuarioDAO;
use DiamondFramework\Controller\Action;
use DiamondFramework\Model\Container;

class AppController extends Action
{
    public function timeline()
    {
        $this->validaSessao();

        $getTweetsDao = new TweetDAO();

        $tweet  = Container::getModel('tweet');

        $tweet->setIdUsuario($_SESSION['id']);

        $tweets = $getTweetsDao->pegarTweets($tweet);

        $usuario = Container::getModel('Usuario');
        $usuario->SetId($_SESSION['id']);

        $usuarioDao = new UsuarioDAO();
        $tweetsDao = new TweetDAO();

        $this->view->total_tweets = $tweetsDao->getTotalTweets($tweet);
        $this->view->info_usuario = $usuarioDao->getInfo($usuario);
        $this->view->total_seguidores = $usuarioDao->getTotalSeguidores($usuario);
        $this->view->total_seguindo = $usuarioDao->getTotalSeguindo($usuario);

        $this->view->tweets = $tweets;

        $this->render('timeline');  
    }

    public function tweet()
    {
        
        $this->validaSessao();

        $tweetPost = filter_input(INPUT_POST, 'tweetbox');

        $tweet = Container::getModel('tweet');
        $tweet->setTweet( trim($tweetPost) );
        $tweet->setIdUsuario($_SESSION['id']);

        $tDao = new TweetDAO();

        $tDao->tweetar( $tweet );

        header('location: /timeline');
    }

    public function seguir()
    {
        $this->validaSessao();

        $pesquisa = filter_input(INPUT_GET, 'pesquisa');

        $pesquisaPor = isset($pesquisa) ? $pesquisa : '';

        $usuarios = array();

        if($pesquisaPor != '')
        {
            $usuario = Container::getModel('Usuario');
            $usuario->setNome( trim($pesquisaPor) );
            $usuario->setId( $_SESSION['id']);

            $dao = new UsuarioDAO();

            $usuarios = $dao->getUsuario( $usuario );
        }

        $usuario = Container::getModel('Usuario');
        $usuario->SetId($_SESSION['id']);

        $usuarioDao = new UsuarioDAO();
        $tweetsDao = new TweetDAO();
        $tweet  = Container::getModel('tweet');

        $tweet->setIdUsuario($_SESSION['id']);

        $this->view->total_tweets = $tweetsDao->getTotalTweets($tweet);
        $this->view->info_usuario = $usuarioDao->getInfo($usuario);
        $this->view->total_seguidores = $usuarioDao->getTotalSeguidores($usuario);
        $this->view->total_seguindo = $usuarioDao->getTotalSeguindo($usuario);

        $this->view->usuarios = $usuarios;

        $this->render('seguir');
    }

    public function acao()
    {
        $this->validaSessao();

        //acao
       $acoes = filter_input(INPUT_GET, 'acao');
       $idUser = filter_input(INPUT_GET, 'id_usuario');

       $acao = isset($acoes) ? $acoes : '';
       $id_usuario_seguindo = isset($idUser) ? $idUser : '';
        //idusuario

        $usuario = Container::getModel('Usuario');

        $usuario->setId($_SESSION['id']);
        
        print_r($_SESSION['id']);
        $daoUsuario = new UsuarioDAO();

        if($acao == 'seguir')
        {
            $daoUsuario->seguirUsuario($usuario, $id_usuario_seguindo);
        }
        else
        {
            $daoUsuario->deixarSeguir($usuario, $id_usuario_seguindo);
        }

        header('Location: /seguir');
    }

    private function validaSessao()
    {
        session_start();

        if(!isset($_SESSION['id']) ||
        $_SESSION['id'] == '' || 
        !isset($_SESSION['nome']) || 
        $_SESSION['nome'] == '')
        {
            header('location: /?login=erro');
        }
    }
}