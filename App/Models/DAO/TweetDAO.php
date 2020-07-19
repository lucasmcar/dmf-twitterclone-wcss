<?php

namespace App\Models\DAO;

use App\Connection;
use App\Models\Tweet;
use DiamondFramework\Model\Model;

class TweetDAO extends Model
{

    public function tweetar(Tweet $tweet)
    {
        $conexao = Connection::getDb();

        if($conexao != null)
        {
            try 
            {
                $insert = "INSERT INTO tweets (id_usuario, tweet) VALUES (:id_usuario, :tweet)";
                $stmt = $conexao->prepare($insert);
                $stmt->bindValue(':id_usuario', $tweet->getIdUsuario());
                $stmt->bindValue(':tweet', $tweet->getTweet());
                $stmt->execute();
            } 
            catch (\PDOException $ex) 
            {
                echo "Erro: ".$ex->getMessage();
            }
        } 
    }

    public function pegarTweets(Tweet $twt)
    {
        $conexao = Connection::getDb();

        $getTweet = "SELECT 
            t.id, 
            t.id_usuario, 
            u.nome, 
            t.tweet, 
            DATE_FORMAT(t.dat, '%d/%m/%Y %H:%i') as dat
            FROM tweets as t 
            LEFT JOIN  usuarios as u 
            on (t.id_usuario = u.id) 
            WHERE t.id_usuario = :id_usuario
            or
            t.id_usuario in (SELECT id_usuario_seguindo FROM usuario_seguidores WHERE id_usuario = :id_usuario)
            ORDER BY t.dat DESC"; 
        $stmt = $conexao->prepare($getTweet);
        $stmt->bindValue(':id_usuario', $twt->getIdUsuario());
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalTweets(Tweet $tweets)
    {
        $conexao = Connection::getDb();

        if($conexao != null)
        {
            try 
            {
                $tweet = "SELECT count(*) as total_tweets FROM tweets where id_usuario = :id_usuario";
                $stmt = $conexao->prepare( $tweet );
                $stmt->bindValue(':id_usuario', $tweets->getIdUsuario());
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } 
            catch (\PDOException $ex) 
            {
                echo "Erro: ".$ex->getMessage();
            }
        }
    }

    
}