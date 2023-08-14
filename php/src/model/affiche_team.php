<?php
include_once('../controleur/action.php');

$teams = print_team_signed_up($id);
if ($teams) {
  ?>
  <br>
  <span>Signed up Teams</span>
<?php
  foreach ($teams as $team) {
    echo '<div><a href="../view/team.php?id_teams=' . $team['id'] . '&name=' . $_SESSION['utilisateur'] . '">' . $team['name'] . '</a></div>';
  }
} else {
  echo '<div class="center">No team registered yet</div>';
}