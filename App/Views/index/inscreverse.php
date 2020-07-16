<form method="POST" action="/registrar">

    <input type="text" value="<?= $this->view->usuario['nome']; ?>" name="txNome" placeholder="Nome">
    <input type="email" value="<?= $this->view->usuario['email']; ?>" name="txEmail" placeholder="Email">
    <input type="password" value="<?= $this->view->usuario['senha']; ?>" name="txSenha" placeholder="*****">
    
    <input type="submit" value="Enviar">

    <?php if($this->view->erroCadastro) { ?>
        <p>Erro ao tentar cadastrar: Conta já existente ou campos inválidos</p>
    <?php } ?>
    
</form>