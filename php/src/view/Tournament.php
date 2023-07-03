<?php if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION["utilisateur"])) {
    header("Location:../view/index.php");
  }
};

include_once("../controleur/action.php");

//check if the tournament exist before loading the page
$id = htmlspecialchars($_GET['id']);
$last_id = get_last_id_tournament();
if ($id > $last_id || $id <= 0) {
  header("Location:../view/home.php");
}

?>
<!DOCTYPE html>
<html>

<head>
  <?php
  include_once("header.php");
  ?>
  <script src="/JS/modal.js" async></script>
  <script src="/JS/ajax_team_reg.js" async></script>
  <script src="/JS/Boutton_sign_up.js"></script>
</head>

<body>
  <header>
    <div class="container">
      <div class="tunnel-header">
        <a id="logo" href="/view/index.php">
        </a>
      </div>
    </div>
  </header>
  <main class="site-content">
    <?php
    include("nav.php");
    ?>

    <div id="page">
      <?php
      affiche_tournois_url();
      ?>

      <div class=center>
        <span class=erreur>
          <?php
          if (isset($_SESSION['erreur'])) {
            echo ($_SESSION['erreur']);
            unset($_SESSION['erreur']);
          }
          ?>
        </span>
        <h3>Sign up here</h3>
        <button class="button" id="myBtn">Sign Up</button>
      </div>
      <div id="myModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <div class="center">
            <H3>Chose your team</H3>
            <div>
              <form method="get" action="/controleur/team_sign_up.php">
                <select name="Team" id="Team" onchange="getSelectValue(this);">
                  <option value="">--Please your team--</option>
                  <?php
                  //print the teams in the Select form for the teams cup singning up
                  print_teams($id);
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
                      if( $nb_player > 1 ){
                        echo($nb_player . ' players for this tournament');
                      } else {
                        echo($nb_player . ' player for this tournament');
                      }
                    ?>
                  </legend>
                  <div id=team_player class="left" onclick="get_player_from_team();">

                  </div>
                </fieldset>
                <div id="button_team_select">
                  <input type="submit" class="button" value="Sign up"></input>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="center">
      <?php if (est_admin() || est_createur_tournois()) { ?>
        <h3>only for tournament owner and admin</h3>
        <form action="../controleur/del_tournament.php" method="get">
          <div class="input">
            <input id="id_tournois" name="id_tournois" type="hidden" value="<?php echo ($_GET['id']); ?>">
            <input class="button" id="boutton_add_team_tournament" type="submit" name="del_tournament" value="delete">
          </div>
        </form>
    </div>
  <?php } ?>

  
  <?php
  $teams = print_team_signed_up($id);
  if ($teams) {
    ?>
    <span> Team already signed up </span>
    <?php
    foreach ($teams as $team) {
      $id_team = recupere_id_team($team);
  ?>
      <div>
        <?php echo '<a href="../view/team.php?id_teams=' . $id_team . '&name=' . $_SESSION['utilisateur'] . '">' . $team . '</a>'  ?>
      </div>
  <?php
    }
  } else {
    ?> 
    <span>no team registered yet </span>
  <?php  
  }
  ?>
  </div>
  </main>
  <footer class="site-footer">
    <div class="down-page">
      <div class="text-footer">
        Made By HawKen
      </div>
    </div>
  </footer>
</body>
<script src="/JS/modal.js"> </script>
<script src="/JS/Boutton_sign_up.js"></script>

</html>