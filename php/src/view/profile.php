<?php if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION["utilisateur"])) {
    header("Location://test-site/Site/php/view/index.php");
  }
};

include_once("../controleur/action.php");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include_once("header.php"); ?>
</head>

<body>
  <header>
    <div class="container">
      <div class="tunnel-header">
        <a id="logo" href="//test-site/Site/view/index.php">
        </a>
      </div>
    </div>
  </header>
  <main class="site-content">
    <?php
    include("nav.php");
    ?>
    <div class="colonne-droite">
      <div class="affiche-profile">
        <div class="user">
          <span> User ID : <?php User(); ?></span>
        </div>
        <div class="user">
          <span> User Email : <?php email(); ?></span>
        </div>
        <div class="user">
          <span> User Discord : <?php if (id_discord() != False) {
                                  echo (id_discord());
                                }; ?></span>
        </div>
        <?php
        if (id_discord() == FALSE) {
        ?>
          <div class="reg-discord">
            <a href="discord_reg.php">Enter Your Discord ID here !</a>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="affiche-tournois">
      <div class="affiche-url">
        <div class="tournois-url">
          <div class="title-url">
            <!-- nom du tournois > by < createur >
          <img class="image-lim-url" src= < image > 
          -->
            <br>
          </div>
          <?php
          affiche_tournois_profile();
          //get_user_url();

          ?>
          <!-- mode du jeu -->
          <br>
          <br>
          <!-- decription du monde -->
          <br>
          <br>
          <!--lien du serveur-->
        </div>
      </div>
    </div>

    <div id="page">
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