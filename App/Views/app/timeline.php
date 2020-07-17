<h2>Timeline</h2>

<a href="/sair">Sair</a>

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
<?php } ?>