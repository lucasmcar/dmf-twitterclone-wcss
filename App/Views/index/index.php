<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <form method="POST" action="/autenticar">
            <input type="email" name="loginEmail" placeholder="Seu email">
            <input type="password" name="loginSenha" placeholder="Sua senha">
            <button type="submit">Entrar</button>
        </form>    

        <?php if($this->view->login == 'erro') { ?>
            <span>Email e ou senha inválido</span>
        <?php } ?>
    </body>
</html>
