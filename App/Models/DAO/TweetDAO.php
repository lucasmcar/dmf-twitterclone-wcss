<?php

namespace App\Models\DAO;

use App\Connection;
use App\Models\Tweet;
use DiamondFramework\Model\Model;

class TweetDAO
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

        $getTweet = "SELECT id, id_usuario, tweet, dat FROM tweets WHERE id_usuario = :id_usuario"; 
        $stmt = $conexao->prepare($getTweet);
        $stmt->bindValue(':id_usuario', $twt->getIdUsuario());
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    
}