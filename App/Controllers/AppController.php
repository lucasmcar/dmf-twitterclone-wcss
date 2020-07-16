<?php

namespace App\Controllers;

use App\Connection;
use App\Models\DAO\TweetDAO;
use DiamondFramework\Controller\Action;
use DiamondFramework\Model\Container;

class AppController extends Action
{
    public function timeline()
    {
        session_start();

        if($_SESSION['id'] != '' && $_SESSION['nome'])
        {
            $getTweetsDao = new TweetDAO();

            $tweet  = Container::getModel('tweet');

            $tweet->setIdUsuario($_SESSION['id']);

            $tweets = $getTweetsDao->pegarTweets($tweet);

            echo "<pre>";
            print_r($tweets);
            echo "</pre">
            $this->render('timeline');
        }
        else
        {
            header('location: /?login=erro');
        }
    }

    public function tweet()
    {
        session_start();

        if($_SESSION['id'] != '' && $_SESSION['nome'])
        {
            $tweetPost = filter_input(INPUT_POST, 'tweetbox');

            $tweet = Container::getModel('tweet');
            $tweet->setTweet( $tweetPost );
            $tweet->setIdUsuario($_SESSION['id']);

            $tDao = new TweetDAO();

            $tDao->tweetar( $tweet );

            header('location: /timeline');

            /*$this->render('timeline');*/
        }
        else
        {
            header('location: /?login=erro');
        }
    }
}