<h3>Sign up here</h3>
<button class="button" id="myBtn">Sign Up</button>
</div>
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="center">
      <h3>Chose your team</h3>
      <div>
        <form method="post" action="../controleur/team_sign_up.php">
          <select name="Team" id="Team" onchange="getSelectValue(this);">
            <option value="">--Please your team--</option>
            <?php
            $id = $_SESSION['id_tournament'];
            $user = $_SESSION['utilisateur'];
            //print the teams in the Select form for the teams cup singning up
            $teams = print_teams($user, $id);
            foreach ($teams as $team) {
              echo '<option value="' . $team['id'] .'">' . $team['name'] . '</option>';
            }
            ?>
            <input id="id_tournois" name="id_tournois" type="hidden" value="<?php echo ($id); ?>">
          </select>
          <div>
            <h3>chose your team mates</h3>
          </div>
          <fieldset>
            <legend id="nb_player">
              Please select
              <?php
              $nb_player = nb_player_tounament($_GET['id']);
              if ($nb_player > 1) {
                echo ($nb_player . ' players for this tournament');
              } else {
                echo ($nb_player . ' player for this tournament');
              }
              ?>
            </legend>
            <div id=team_player class="left" onclick="get_player_from_team();"></div>
          </fieldset>
          <input type="submit" class="button" value="Sign up" id="button_team_select">
        </form>
      </div>
    </div>
  </div>
</div>
<script src="/JS/Boutton_sign_up.js"></script>
<script src="../JS/modal.js"></script>