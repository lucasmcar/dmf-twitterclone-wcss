<form method="get" action="/seguir">
    <input type="text" name="pesquisa" placeholder="Quem você está procurando">
    <button type="submit">Pesquisar</button>
</form>

<div>
    <?php foreach($this->view->usuarios as $key) { ?>
        <div>
            <h2><?= $key['nome'] ?></h2>
        </div>
    <?php } ?>

</div>