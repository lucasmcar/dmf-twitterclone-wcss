<?php


namespace App;

class Connection 
{
    public static function getDb()
    {
        try
        {
            $con= new \PDO(
                    "mysql:host=localhost;dbname=twitter;charset=utf8", 
                    "root", 
                    "");
            $con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            return $con; 
            
        } 
        catch (\PDOException $ex) 
        {
            echo "Erro: ". $ex->getMessage();
        }
    }
}
