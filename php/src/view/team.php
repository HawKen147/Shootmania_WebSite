<?php 
if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION['utilisateur'])) {
    header("Location:../index.php" );
    exit;
  }
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
  $_SESSION['id_team'] = htmlspecialchars($_GET['id_teams']);
  $creator = is_team_creator($_SESSION['id_team'], $_SESSION['utilisateur']);
  $admin = est_admin();
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
    if (isset($_GET['invite']) && $_SESSION['err']) {
      echo ($_SESSION['err']);
      unset ($_SESSION['err']);
    }
    ?>

    <div id="page">
      <div>
        <?php
        $resultat = affiche_team();
        $ligne = $resultat->fetch(PDO::FETCH_ASSOC);
        ?>
        <h4><?php echo $ligne['nom_team'];?> created by <?php echo $ligne['createur']; ?></h4>    
        <div> <img src="<?php echo $ligne['images'] ?>" alt="<?php echo $ligne['nom_team'] ?>_image"></div>
        <br>
        <h4>List players :</h4>
        <br>
        <?php
        $players = affiche_joueur_team();
        foreach ($players as $player){
          echo $player;
          echo '<br>';
        }
        ?>
        <br>
        <?php
            if ($creator || $admin){
            ?>
        <div>
          <a href="<?php echo '../view/edit_team.php?id_teams=' . $_GET["id_teams"]; ?>">
            <button class="button">Edit your team here</button>
          </a>
        </div>
        <div>
          <h4>delete a user here</h4>
          <form action="../controleur/del_player.php" method="post">
              <select name="Delet a user from your team" id="">Delet a user from your team
                <option value="">--Delet a player from your team--</option>
                <?php
                  foreach ($players as $player){
                    if ($player !== $_SESSION['utilisateur']){
                      echo '<option value="' . $player . '">' . $player . '</option>';
                    }
                  }
                ?>
              </select>
          <input type="submit" class="button">
          </form>
        </div>
        <?php
            }
          ?>
        <br>
        <h4>Invite a player with the link below !</h4>
        <?php
        $url = create_url_team();
        ?>
      </div>
    </div>
    <span id="url_invite" hidden></span>
    <br>
    <button id="btn_copy" class="button">Copy the link</button>
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