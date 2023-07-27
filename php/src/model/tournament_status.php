<form action="../controleur/start_tournament.php" method="post">
    <div class="center input">
        <input id="id_tournois" name="id_tournois" type="hidden" value="<?php echo ($_GET['id']); ?>">
        <input class="button" id="boutton_start_tournament" type="submit" name="start_tournament" value="start tournament">
    </div>
</form>