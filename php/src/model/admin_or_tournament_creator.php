<div class="center">
    <h3>only for tournament owner and admin</h3>
    <form action="../controleur/del_tournament.php" method="get">
      <div class="input">
        <input id="id_tournois" name="id_tournois" type="hidden" value="<?php echo ($_GET['id']); ?>">
        <input class="button" id="boutton_add_team_tournament" type="submit" name="del_tournament" value="delete">
      </div>
    </form>
</div>