<?php

namespace App\Models;

use DiamondFramework\Model\Model;

class Tweet extends Model
{

    private $id;
    private $tweet;
    private $data;
    private $idUsuario;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTweet()
    {
        return $this->tweet;
    }

    public function setTweet($tweet)
    {
        $this->tweet = $tweet;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario; 
    }

}