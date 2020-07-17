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

            /*$this->render('timeline');*/
        
        
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
            $usuario->setNome( $pesquisaPor );

            $dao = new UsuarioDAO();

            $usuarios = $dao->getUsuario( $usuario );
        }

        $this->view->usuarios = $usuarios;

        $this->render('seguir');
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