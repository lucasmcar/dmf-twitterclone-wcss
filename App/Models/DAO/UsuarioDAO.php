<?php

namespace App\Models\DAO;

use App\Connection;
use App\Models\Usuario;
use DiamondFramework\Model\Container;
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

       if($conexao != null)
       {
           try
           {
            $selectBy = "SELECT nome, email FROM usuarios WHERE email = :email ";
            $stmt = $conexao->prepare($selectBy);
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->execute();
    
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
           }
           catch(\PDOException $ex)
           {
                echo "Erro: ".$ex->getMessage();
           }
       }

       return "Erro ao logar";
    }

    public function autenticar(Usuario $usuario)
    {
        $conexao = Connection::getDb();

        if($conexao != null)
        {
            try
            {
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
            catch(\PDOException $ex)
            {
                return "Erro: ".$ex->getMessage();
            }
        }  
    }

    public function getUsuario(Usuario $usuario)
    {

        $conexao = Connection::getDb();
        if($conexao != null)
        {
            try 
            {
                $select ="SELECT u.id, u.nome, u.email, 
                (
                    SELECT 
                        count(*) 
                    from 
                        usuario_seguidores as us 
                    where 
                        us.id_usuario = :id_usuario
                    and us.id_usuario_seguindo = u.id
                ) as seguindo_sn 
                FROM USUARIOS as u 
                where u.nome 
                like :nome AND u.id != :id_usuario";
                $stmt = $conexao->prepare($select);
                $stmt->bindValue(':nome', '%'.$usuario->getNome().'%');
                $stmt->bindValue(':id_usuario', $usuario->getId());
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } 
            catch (\PDOException $ex) 
            {
                echo "Erro: ".$ex->getMessage();  
            }
        }

        return "Erro ao recuperar usuários";
    }

    public function seguirUsuario(Usuario $usuario, int $idUsuarioSeguindo)
    {
        $conexao = Connection::getDb();

        if($conexao != null)
        {
            try
            {
                $insert = "INSERT INTO usuario_seguidores (id_usuario, id_usuario_seguindo) VALUES (:id_usuario, :id_usuario_seguindo)";
                $stmt = $conexao->prepare($insert);
                $stmt->bindValue(':id_usuario', $usuario->getId());
                $stmt->bindValue(':id_usuario_seguindo', $idUsuarioSeguindo);
                $stmt->execute();
                
                return true;
            }
            catch(\PDOException $ex)
            {
                echo "Erro: ".$ex->getMessage();
            }
        }

        return false;
        
    }

    public function deixarSeguir(Usuario $usuario, $idUsuarioSeguindo)
    {
        $conexao = Connection::getDb();

        if($conexao != null)
        {
            try
            {
                $delete = "DELETE FROM usuario_seguidores WHERE id_usuario = :id_usuario AND id_usuario_seguindo = :id_usuario_seguindo";
                $stmt = $conexao->prepare($delete);
                $stmt->bindValue(':id_usuario', $usuario->getId());
                $stmt->bindValue(':id_usuario_seguindo', $idUsuarioSeguindo);
                $stmt->execute();
                
                return true;
            }
            catch(\PDOException $ex)
            {
                echo "Erro: ".$ex->getMessage();
            }
        }

        return false;
    }

    public function getInfo(Usuario $usuario)
    {

        $conexao = Connection::getDb();

        if($conexao != null)
        {
            try 
            {
                $info = "SELECT nome FROM usuarios where id = :id_usuario";
                $stmt = $conexao->prepare( $info );
                $stmt->bindValue(':id_usuario', $usuario->getId());
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } 
            catch (\PDOException $ex) 
            {
                echo "Erro: ".$ex->getMessage();
            }
        }
    }

    public function getTotalSeguindo(Usuario $usuario)
    {

        $conexao = Connection::getDb();

        if($conexao != null)
        {
            try 
            {
                $total = "SELECT count(*) as total_seguindo FROM usuario_seguidores where id_usuario  = :id_usuario";
                $stmt = $conexao->prepare( $total );
                $stmt->bindValue(':id_usuario', $usuario->getId());
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } 
            catch (\PDOException $ex) 
            {
                echo "Erro: ".$ex->getMessage();
            }
        }
    }

    public function getTotalSeguidores(Usuario $usuario)
    {

        $conexao = Connection::getDb();

        if($conexao != null)
        {
            try 
            {
                $seguidores = "SELECT count(*) as total_seguidores FROM usuario_seguidores where id_usuario_seguindo = :id_usuario";
                $stmt = $conexao->prepare( $seguidores );
                $stmt->bindValue(':id_usuario', $usuario->getId());
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