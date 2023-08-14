<?php if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION["utilisateur"])) {
    header("Location:../view/index.php");
  }
};

include_once("../controleur/action.php");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include_once("../model/header.php"); 
  $link_media =  get_media_link();
  $link_discord = get_discord_link();
  $link_ressource = get_ressource_link();
  $link_youtube = get_youtube_link();
  $link_web_site = get_web_site_link();
  ?>
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
    include("../model/nav.php");
    ?>
    <div class="link-container">
      <div class="link link33">
          <h3> Web Sites</h3>
          <ul>
            <?php
            while ($ligne = $link_web_site -> fetch(PDO::FETCH_ASSOC)){
              echo "<li><a href=" . $ligne['link'] . "> " .  $ligne['media_name'] . "</a></li>";
            }
            ?>
          </ul>
      </div>
      <div class="link link33">
          <h3>Ressources</h3>
          <ul>
          <?php
            while ($ligne = $link_ressource -> fetch(PDO::FETCH_ASSOC)){
              echo "<li><a href=" . $ligne['link'] . "> " .  $ligne['media_name'] . "</a></li>";
            }
            ?>
          </ul>
      </div>
        <div class="link link-ytub">
        <h3>Youtube Channels</h3>
        <ul>
        <?php
            while ($ligne = $link_youtube -> fetch(PDO::FETCH_ASSOC)){
              echo "<li><a href=" . $ligne['link'] . "> " .  $ligne['media_name'] . "</a></li>";
            }
            ?>
        </ul>
      </div>
      <div class="link link2">
        <h3> Discords</h3>
        <ul>
        <?php
            while ($ligne = $link_discord -> fetch(PDO::FETCH_ASSOC)){
              echo "<li><a href=" . $ligne['link'] . "> " .  $ligne['media_name'] . "</a></li>";
            }
            ?>
        </ul>
      </div>
      <div class="link link2">
      <h3>Medias</h3>
        <ul>
        <?php
            while ($ligne = $link_media -> fetch(PDO::FETCH_ASSOC)){
              echo "<li><a href=" . $ligne['link'] . "> " .  $ligne['media_name'] . "</a></li>";
            }
            ?>
        </ul>
      </div>
      </li>
    </div>
  </main>
  <footer class="site-footer">
    <?php  include_once('../model/footer.php'); ?>
  </footer>
</body>

</html>