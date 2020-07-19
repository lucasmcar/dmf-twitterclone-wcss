<div>
    <div>
        <?= $this->view->info_usuario['nome'] ?>
    </div>
        
    <ul>
        <li>Tweets <?=$this->view->total_tweets['total_tweets'] ?> </li>
        <li>Seguidores <?= $this->view->total_seguidores['total_seguidores'] ?></li>
        <li>Seguindo <?= $this->view->total_seguindo['total_seguindo'] ?></li>
    </ul>
</div>



<form method="get" action="/seguir">
    <input type="text" name="pesquisa" placeholder="Quem você está procurando">
    <button type="submit">Pesquisar</button>
</form>

<div>
    <?php foreach($this->view->usuarios as $key => $usuario) { ?>
        <div>
            <h2><?= $usuario['nome'] ?></h2>
           
        </div>
        <div>
            <?php if($usuario['seguindo_sn'] == 0) { ?>
                <a href="/acao?acao=seguir&id_usuario=<?= $usuario['id'] ?>">Seguir</a>
            <?php } else { ?>
                <a href="/acao?acao=deixar&id_usuario=<?= $usuario['id'] ?>">Deixar de seguir</a>
            <?php } ?>
        </div>
    <?php } ?>

</div>