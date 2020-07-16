<?php

namespace App\Models\DAO;

use App\Connection;
use App\Models\Usuario;
use DiamondFramework\Model\Model;

class UsuarioDAO extends Model
{
   
    //Salvar usuario
    public function salvar(Usuario $usuario)
    {
        
        $conexao = Connection::getDb();
        
        //Verifica se a conexao nao é nula
        if($conexao != null)
        {
            try
            {
                $insert = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
                $stmt = $conexao->prepare($insert);
                $stmt->bindValue(':nome', $usuario->getNome());
                $stmt->bindValue(':email', $usuario->getEmail());
                $stmt->bindValue(':senha', $usuario->getSenha());
                $stmt->execute();
                
                return "Inserido com sucesso";
            } 
            catch (\PDOException $ex) 
            {
                echo "Erro: " .$ex->getMessage();
            }
        }
        
        return "Erro ao inserir";
    }
        
       
    /**
     * 
     * Method that validates user registration
     * receiving as a parameter, an object of type Usuario
     * @param Usuario $usuario
     */
    public function validarCadastro(Usuario $usuario)
    {
        
        $valido = true;
        if(strlen($usuario->getNome()) < 3)
        {
            $valido = false;
            var_dump($valido);
        }
        
        if(strlen($usuario->getEmail()) < 3)
        {
            $valido = false;
            var_dump($valido);
        }
        
        if(strlen($usuario->getSenha()) < 3)
        {
            $valido = false;
            var_dump($valido);
        }
        
        return $valido;
    }
    
    //Recuperar usuario por email
    public function getUserByEmail(Usuario $usuario)
    {
        $conexao = Connection::getDb();

        $selectBy = "SELECT nome, email FROM usuarios WHERE email = :email ";
        $stmt = $conexao->prepare($selectBy);
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function autenticar(Usuario $usuario)
    {
        $conexao = Connection::getDb();
        $autenticar = "SELECT id, nome, email, senha FROM USUARIOS WHERE email = :email AND senha = :senha";
        $stmt = $conexao->prepare($autenticar);
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':senha', $usuario->getSenha());
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($user['id'] != '' && $user['nome'] != '')
        {
            $usuario->setId($user['id']);
            $usuario->setNome($user['nome']);
        }

        return $user;
    }
    
}