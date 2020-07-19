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

        $tweet  = Container::getModel('tweet');
        $usuario = Container::getModel('Usuario');

        $getTweetsDao = new TweetDAO();
        $usuarioDao = new UsuarioDAO();
        $tweetsDao = new TweetDAO();

        $tweet->setIdUsuario($_SESSION['id']);
        $usuario->SetId($_SESSION['id']);

        $this->view->total_tweets = $tweetsDao->getTotalTweets($tweet);
        $this->view->info_usuario = $usuarioDao->getInfo($usuario);
        $this->view->total_seguidores = $usuarioDao->getTotalSeguidores($usuario);
        $this->view->total_seguindo = $usuarioDao->getTotalSeguindo($usuario);

        //Variaveis de paginacao
        $total_registros = 10;

        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

        $deslocamento = ($pagina-1) * $total_registros;

        //$tweets = $getTweetsDao->pegarTweets($tweet);
        $tweets = $getTweetsDao->pegarTweetsPorPagina($tweet, $total_registros, $deslocamento);
        $total_tweets = $tweetsDao->pegarTotalRegistros($tweet);
        $this->view->totalPaginas = ceil($total_tweets['total']/$total_registros);
        $this->view->pagina_ativa = $pagina;
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