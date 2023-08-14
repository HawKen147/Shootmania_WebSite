<?php
if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION['utilisateur'])) {
    header("Location:../view/index.php" );
    exit;
  }
}
if ($_SESSION['id_team'] !== $_GET['id_teams']){
    header('Location:../view/team.php?id_teams=' . $_SESSION['id_team']);
}
include_once("../controleur/action.php");

if(isset($_SESSION['utilisateur']) && !isset($_GET['invite'])){
  if(!check_player_team(htmlspecialchars($_GET['id_teams']), [$_SESSION['utilisateur']])){
    header('Location:../view/home.php');
    exit;
  }
}

if (!isset($_SESSION['utilisateur']) && isset($_GET['invite']) && isset($_GET['id_teams']) && isset($_GET['limit'])) {
  $id_teams = htmlspecialchars($_GET['id_teams']);
  $invite = htmlspecialchars($_GET['invite']);
  $limit = htmlspecialchars($_GET['limit']);
  $link = '../index.php' . '?id_teams=' . $id_teams . '&invite=' . $invite . '&limit=' . $limit;
  header("Location:" . $link);
  exit;
} 

if(isset($_SESSION['utilisateur']) && isset($_GET['invite']) && isset($_GET['id_teams']) && isset($_GET['limit'])){
  add_player_team($_SESSION['utilisateur'], htmlspecialchars($_GET['invite']),htmlspecialchars($_GET['id_teams']), htmlspecialchars($_GET['limit']));
};

?>
<!DOCTYPE html>
<html>

<head>
  <?php include_once("../model/header.php");
  ?>
</head>

<body>
  <header>
    <div class="container">
      <div class="tunnel-header">
        <a id="logo" href="../view/home.php">
        </a>
      </div>
    </div>
  </header>
  <main class="site-content">
    <?php
    include("../model/nav.php");
    $resultat = affiche_team();
    $ligne = $resultat->fetch(PDO::FETCH_ASSOC);
    if (isset($_GET['invite']) && $_SESSION['err']) {
      echo ($_SESSION['err']);
      unset ($_SESSION['err']);
    }
    ?>

    <div id="page">
        <form action="../controleur/update_team.php?id_teams=<?php echo $_SESSION['id_team']; ?>" method="post">
            <div class="main identification">
            <h2 class="title-1">edit team</h2>
                <div class="identification-form sblock">
                    <input type="text" value="<?php echo $ligne['nom_team']; ?>" placeholder="Team name" name="team_name">
                    <input type="text" pattern="https://.*" value="<?php echo $ligne['images']; ?>" placeholder="Team image" name="team_image">
                    <br>
                    <input type="submit" class="button" value="Update team">
                </div>
            </div>
        </form>
        <h4><?php echo $ligne['nom_team'];?> created by <?php echo $ligne['createur']; ?></h4>    
        <div> 
            <img src="<?php echo $ligne['images'] ?>" alt="<?php echo $ligne['nom_team'] ?>_image">
        </div>
    </div>
  </main>
  <footer>
    <?php
        include_once ('../model/footer.php');
    ?>
  </footer>
</body>
<script src="/JS/button-copie.js"></script>
<script>
  var currentURL = window.location.href; // recupere l'url
  var cleanUrl = currentURL.split("?")[0]; // supprime les variables contenu dans l'url
  var url = "<?php echo ($url) ?>";
  document.getElementById("url_invite").textContent = cleanUrl + url;
</script>
</html>