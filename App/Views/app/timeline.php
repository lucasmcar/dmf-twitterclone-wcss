<h2>Timeline</h2>

<a href="/sair">Sair</a>

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

<form method="POST" action="/tweet">
<div class="">
    <textarea name="tweetbox">
    
    </textarea>
</div>
<div class="">
    <button type="submit">Tweetar</button>
</div>
</form>

<?php foreach($this->view->tweets as $id_tweet => $tweet) { ?>
 <div>
    <?= $tweet['nome'] ?> <span><?= $tweet['dat'] ?></span>
</div>
 <div>
    <p><?= $tweet['tweet'] ?></p>
 </div>
 <div>
     <?php if($tweet['id_usuario'] == $_SESSION['id']) { ?>
        <form>
            <button>Apagar tweet</button>
        </form>
     <?php } ?>
 </div>
<?php } ?>

<div>
    <a href="/seguir">Quem seguir</a>
</div>