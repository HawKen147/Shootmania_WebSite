<?php 
if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION['utilisateur'])) {
    header("Location:../view/index.php" );
  }
  if (!isset($_SESSION['utilisateur']) & isset($_GET['invite']) & isset($_GET['id_teams']) & isset($_GET['limit'])) {
      $id_teams = htmlspecialchars($_GET['id_teams']);
      $invite = htmlspecialchars($_GET['invite']);
      $limit = htmlspecialchars($_GET['limit']);
      $link = '../view/index.php' . '?id_teams=' . $id_teams . '&invite=' . $invite . '&limit=' . $limit;
      header("Location:" . $link);
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
        <a id="logo" href="../view/index.php">
          <!--    <img src="image/Banniere_IRAE.png" alt="logo">-->
        </a>
      </div>
    </div>
  </header>
  <main class="site-content">
    <?php
    include("nav.php");
    if (isset($_GET['invite'])) {
      echo ( 'bienvenue' );
    }
    ?>

    <div id="page">
      <div>
        
        <?php
        $resultat = affiche_team();
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
          echo ( $ligne['nom_team'] . '<br>' . $ligne['createur'] . '<br>' .
          '<br>' . '<img src=' .  $ligne['images'] . '>'. '<br>' .  '<br>');
        }
        ?>
        <br>
        <span>List players :</span>
        <br>
        <?php
        $res = affiche_joueur_team();
        if ($res) {
          while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            echo ( $ligne['login_player'] . '<br>');
          } 
        }
        ?>
        <br>
        
        <?php
        $url = create_url_team();
        ?>
      </div>
    </div>
    <span id="url_invite"></span>
    <br>
    <button id="btn_copy">copy</button>
  </main>
  <?php
    include_once ('../model/footer.php');
  ?>
</body>
<script src="/JS/button-copie.js"></script>
<script>
  var currentURL = window.location.href; // recupere l'url
  var cleanUrl = currentURL.split("?")[0]; // supprime les variables contenu dans l'url
  var url = "<?php echo ($url) ?>";
  document.getElementById("url_invite").textContent = cleanUrl + url;
</script>
</html>