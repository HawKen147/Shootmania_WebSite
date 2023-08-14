<?php
// Démarrer la session
if (!isset($_SESSION)) {
  session_start();
}

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers index.php
if (!isset($_SESSION["utilisateur"])) {
  header("Location:../index.php");
  exit(); // Ajout d'un exit() pour arrêter l'exécution du script après la redirection
}

// Inclure le fichier contenant les fonctions d'action (par exemple, action.php)
include_once("../controleur/action.php");

// Vérifier si le tournoi existe avant de charger la page
$id = htmlspecialchars($_GET['id']);
$_SESSION['id_tournament'] = $id;
print_team_signed_up($id);
$last_id = get_last_id_tournament();
if ($id > $last_id || $id <= 0) {
  header("Location:../view/home.php");
  exit(); // Ajout d'un exit() pour arrêter l'exécution du script après la redirection
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php
  include_once("../model/header.php");
  ?>
</head>
<body>
  <header>
    <div class="container">
      <div class="tunnel-header">
        <a id="logo" href="../view/index.php"></a>
      </div>
    </div>
  </header>
  <main class="site-content">
    <?php
    include("../model/nav.php");
    ?>

    <div id="page">
      <?php
      affiche_tournois_url();
      ?>
      <div class="center">
        <span class="erreur">
          <?php
          if (isset($_SESSION['err'])) {
            echo ($_SESSION['err']);
            unset($_SESSION['err']);
          }
          if (isset($_SESSION['tournois'])) {
            echo ($_SESSION['tournois']);
            echo "<br>";
            unset($_SESSION['tournois']);
          }
          ?>
        </span>
        <?php
        // Récupérer le statut du tournoi
        $status = get_tournament_status($_GET['id']);
        // Afficher le contenu en fonction du statut du tournoi
        if (isset($status) && $status['status'] == 'incoming') {
          include_once('../model/sign_up.php');
          if(est_admin() || is_creator_tournament($_SESSION['utilisateur'], $id)){
            echo '<div class="center"><a href="../view/new_tournament.php?id=' . $id . '&edit"><button class="button">update your tournament here</button></a></div>';
            echo '<div class="center"> <a href="../controleur/del_tournament.php"><button class="button">delete your tournament</button></a></div>';
          }
        } elseif (isset($status) && $status['status'] == 'underway') {
          echo '<span>Registration are closed</span>';
        } elseif (isset($status) && $status['status'] == 'over') {
          echo 'The tournament is over';
        }
        // Inclure le contenu en fonction des privilèges de l'utilisateur
        if (est_admin() || est_createur_tournois()) {
          include_once('../model/admin_or_tournament_creator.php');
        }
        //affiche le bouton pour commencer le tournois
        if (isset($status) && $status['status'] == 'incoming') {
          if (get_number_registrered_teams($id) >= 3){
            include_once('../model/tournament_status.php');
          }
          // Récupérer et afficher les équipes inscrites au tournois
         include_once('../model/affiche_team.php');
        } elseif (isset($status) && $status['status'] == 'underway') {
          include_once('../model/tournament_finish_it.php');
          include_once('../model/affiche_team.php');
        // Récupérer et afficher les vainqueurs du tournois
        } elseif (isset($status) && $status['status'] == 'over') {
          include_once('../model/tournament_result.php');
        }
        ?>
      </div>
    </div>
  </main>
</body>
<footer>
    <?php
      include_once ('../model/footer.php');
    ?>
</footer>
<script src="/JS/ajax_team_reg.js"></script>
</html>
