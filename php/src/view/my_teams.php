<?php if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION["utilisateur"])) {
    header("Location:../index.php");
  }
};

include_once("../controleur/action.php");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include_once("../model/header.php"); ?>
</head>

<body>
  <header>
    <div class="container">
      <div class="tunnel-header">
        <a id="logo" href="/view/index.php">
          <!--    <img src="image/Banniere_IRAE.png" alt="logo">-->
        </a>
      </div>
    </div>
  </header>
  <main class="site-content">
    <?php
    include("../model/nav.php");
    ?>
    <div id="page">
      <div class="main identification">
        <form action="../controleur/new_team.php" method="post">
          <h3>Create Your team Here</h3>
          <div class="text-center error">
            <span class="text-center field-validation-valid helper">
            <?php
            if (isset($_SESSION['err'])){
              echo $_SESSION['err'];
              unset($_SESSION['err']);
            }
          ?>
            </span>
          </div>
          <div class="form-group mini">
            <input placeholder="Name of Your team" name="Team_name" id="Team_name" maxlength="50" required>
            <input type="url" pattern="https://.*" placeholder="Any Image of your team ?" name="Image_team" id="Image_team">
          </div>
          <input type="submit" class="button" value="Create your team">
        </form>
        <h3>Your teams</h3>
        <?php
        $result = affiche_team_joueur();
        if (isset($result)){
           while ($ligne = $result->fetch(PDO::FETCH_ASSOC)) {
            if ($ligne !='' && $ligne['login_player'] === $_SESSION["utilisateur"]){
              $id = $ligne['id_teams'];
              echo ( '<a href=team.php?id_teams=' . $id . '>' . $ligne['nom_team'] . '<br>' 
              . '<br>' . '<img src=' .  $ligne['images'] . '>' . '</a>' . '<br>' .  '<br>'. '<br>');
            }
          }
        };
        ?>
      </div>
    </div>
  </main>
  <footer class="site-footer">
    <?php include_once('../model/footer.php'); ?>
  </footer>
</body>
</html>