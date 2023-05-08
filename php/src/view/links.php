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
        </a>
      </div>
    </div>
  </header>
  <main class="site-content">
    <?php
    include("nav.php");
    ?>
    <div class="link">
      <div class="link33">
        <li>
          <h3> Web Sites</h3>
          <ul>
            <li><a href="https://www.maniaplanet.com/">ManiaPlanet</a></li>
            <li><a href="https://sm.mania-exchange.com/">ManiaExchange</a></li>
            <li><a href="https://item.mania.exchange/">ItemExchange</a></li>
            <li><a href="https://league.paragon-esports.com/">Paragon League</a></li>
            <li><a href="https://speedball.the-dmark.com/stats/">SpeedBall Statistics</a></li>
          </ul>
          <h3>Ressources</h3>
          <ul>
            <li><a href="https://urlz.fr/hmYk">CrossHairs</a> & <a href="https://urlz.fr/hmYo">Zyix CrossHairs</a></li>
            <li><a href="http://aurel.obstacle.ovh/wordpress/">Aurel's Blog</a></li>
            <li><a href="https://doc.maniaplanet.com/">ManiaScript Documentation</a></li>
            <li><a href="https://urlz.fr/hcw7">Custom Youtube Intro</a></li>
          </ul>
      </div>
      <div class="link-ytub">
        <h3>Youtube Channels</h3>
        <ul>
          <li><a href="https://www.youtube.com/channel/UCFuotbDEH95CdUzj5G8VBJw">Rstyle Channel</a></li>
          <li><a href="https://www.youtube.com/c/sbville">Sbville Channel</a></li>
          <li><a href="https://www.youtube.com/c/HAScrashedOfficial">Crash Channel</a></li>
          <li><a href="https://www.youtube.com/channel/UCRoFW12O4pokjUw0oj_8m3g">Pixou Channel</a></li>
          <li><a href="https://www.youtube.com/user/MissUkkepuk">Ukkepuk Channel</a></li>
          <li><a href="https://www.youtube.com/user/aurelamckVIDS">Aurel Channel</a></li>
          <li><a href="https://www.youtube.com/user/ilevelin">Ilevelin Channel</a></li>
          <li><a href="https://www.youtube.com/channel/UCK47hRTy4H0wKPaaYtsif0g">Hype Channel</a></li>
          <li><a href="https://www.youtube.com/channel/UCis6zqXsmS_LmrT8us0ILQA">Irae Channel</a></li>
          <li><a href="https://www.youtube.com/channel/UCymN_1LLkQa16dICCI2T99g">Atria Channel</a></li>
        </ul>
      </div>
      <div class="link2">
        <h3> Discords</h3>
        <ul>
          <li><a href="https://discord.gg/mhDPGXezA9">Obstacle Discord</a></li>
          <li><a href="https://discord.gg/mWbmegdPjS">SpeedBall Discord</a></li>
          <li><a href="https://discord.gg/XqTRSEEQ8R">ShootMania Esport Discord</a></li>
          <li><a href="https://discord.gg/jkGkXFe358">Open Planet Discord</a></li>
          <li><a href="https://discord.gg/VcT6TWkCG4">Aurel Discord</a></li>
        </ul>
        <h3>Medias</h3>
        <ul>
          <li><a href="https://www.instagram.com/shootmaniastorm/">Instagram</a></li>
          <li><a href="https://www.facebook.com/ShootMania/">Facebook</a></li>
          <li><a href="https://twitter.com/Shootmania">Official Twitter</a> & <a href="https://twitter.com/ShootmaniaS"> Shootmania Community Twitter</a></li>
        </ul>
      </div>

      </li>
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