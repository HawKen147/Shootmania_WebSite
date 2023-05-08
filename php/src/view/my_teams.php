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
  <?php include_once("header.php"); ?>
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
      <div class="main identification">
        <form action="/controleur/new_team.php" method="post">
          <h3>Create Your team Here</h3>
          <div class="text-center error">
            <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log -->
            <span class="text-center field-validation-valid helper">
            </span>
          </div>
          <div class="form-group mini">
            <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log (email) -->
            <span class="text-center field-validation-valid helper">
            </span>
            <input placeholder="Name of Your team" name="Team_name" id="Team_name" maxlength="50" required>
            <input type="url" pattern="https://.*" placeholder="Any Image of your team ?" name="Image_team" id="Image_team">
          </div>
          <input type="submit" class="button" value="Create your team">
        </form>
      </div>
    </div>
    <!-- affiche les teams ici -->
    <?php
    affiche_team_joueur();
    ?>

    </form>
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