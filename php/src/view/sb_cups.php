<?php if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION["utilisateur"])) {
    header("Location:../view/index.php");
  }
};

include_once ("../controleur/action.php");
include_once ("../controleur/challonge-api.php");

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
    <class id="page">
      <div class="iframe">
        <?php $url = test_url(); $num_cup = filter_var($url, FILTER_SANITIZE_NUMBER_INT); ?>
        <h3>SpeedBall Funcups n° <?php echo ($num_cup); ?> </h3> <br>
        <iframe src="<?php echo ($url) ?>" width="80%" height="510" frameborder="0" scrolling="auto" allowtransparency="false" loading="lazy"></iframe>
      </div>
    </class>
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