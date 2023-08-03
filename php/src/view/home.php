<?php
if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION["utilisateur"])) {
    header("Location:../view/index.php");
  };
};
$user = $_SESSION['utilisateur'];
include_once("../controleur/action.php");
est_admin();
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
        <a id="logo" href="/view/index.php"></a>
      </div>
    </div>
  </header>
  <main class="site-content">
    <?php
    include("nav.php");
    ?>
    <div class="user">
      <?php
      echo ("Welcome " . $user);
      ?>
      <div id=clock></div>
    </div>
    <div class="titre-h3">
      <h3> Upcoming Tournaments </h3>
    </div>
    <?php 
    if(isset($_SESSION['tournois'])){
      echo ($_SESSION['tournois']);
      unset($_SESSION['tournois']);
    }
    ?>
    <table>
      <thead>
        <tr>
          <td>Tournament</td>
          <td>Mode</td>
          <td>Player per teams</td>
          <td>Start of the cup</td>
        </tr>
      </thead>
      <tbody id="affiche_tournois_dated">

      </tbody>
    </table>

    <div class="titre-h3">
      <h3> Previous Tournament </h3>
    </div>
    <table>
      <thead>
        <tr>
          <td>Tournament</td>
          <td>Mode</td>
          <td>1st Place</td>
          <td>2nd Place</td>
          <td>3rd Place</td>
        </tr>
      </thead>
      <tbody id="affiche_tournois_outdated">

      </tbody>
    </table>
  </main>
  
  <footer class="site-footer">
    <div class="down-page">
      <div class="text-footer">
        Made By HawKen
      </div>
    </div>
  </footer>
</body>

<script src="../JS/ajax_update_dated_tournament.js" async></script>
<script src="../JS/ajax_update_outdated_tournament.js" async></script>
<script src="../JS/clock.js" async></script>
</html>