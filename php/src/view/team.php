<?php if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION["utilisateur"])) {
    header("Location://test-site/Site/view/index.php");
  }
};

include_once("../controleur/action.php");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include_once("header.php");
  ?>
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
    include("nav.php");
    ?>

    <div id="page">
      <div>
        <?php
        affiche_team();
        affiche_joueur_team();
        if (!isset($_GET['invite'])) {
          echo ('<a href=' . create_url_team() . '>' . 'invite your team mate </a>');
        }
        // bouton en javascript copier coller
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

</html>