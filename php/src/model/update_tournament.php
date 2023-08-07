<?php
// Démarrer la session
if (!isset($_SESSION)) {
  session_start();
}

include_once('../controleur/action.php');

if (!is_creator_tournament($_SESSION['utilisateur'], $_SESSION['id_tournament'])){
    $_SESSION['err'] = "you're not the creator of the tournament, you can't modify it ";
    header('Location:../view/home.php');
} else {
    $tournament = get_tournament_info($_SESSION['id_tournament']);
}
?>
<div id="page">
    <div class="main identification">
        <div class="identification-form sblock">
            <form action="../controleur/update_tournament_db.php" method="post">
            <h3>Modify Your Tournament</h3>
            <div class="text-center error">
                <span class="text-center field-validation-valid helper"><?php if(isset($_SESSION['err'])){ echo $_SESSION['err']; unset($_SESSION['err']);} ?></span>
        </div>
        <div class="form-group mini">
            <span class="text-center field-validation-valid helper"></span>
            <input placeholder="Name of the Tournament" value="<?php echo $tournament['nom_tournois'];?>" name="Tournament_Name" id="Tournament_Name" maxlength="50" required>
        </div>
        <div class="form-group mini">
            <input placeholder="Mode of the tournament" value="<?php echo $tournament['mode'];?>" name="Tournament_mode" id="Tournament_mode" disabled>
        </div>
        <div class="form-group mini">
            <input pattern="[1-5]{1}" min="1" max="5" placeholder="Number of player per team" value="<?php echo $tournament['nombre_player'];?>" name="Tournament_nb_player" id="Tournament_nb_player" disabled>
        </div>
        <div class="form-group mini">
            <input type="url" pattern="https://.*" placeholder="Image of the tournament" value="<?php echo $tournament['image'];?>" name="Image_Tournament" id="Image_Tournament">
        </div>
        <div class="form-group mini">
            <input placeholder="Link of the Shootmania Serveur" value="<?php echo $tournament['link_serv'];?>" name="Serv_Link" id="Serv_Link">
        </div>
        <div class="form-group mini">
        <input placeholder="dd/mm/yyyy HH:MM" pattern="^(0[1-9]|[1-2][0-9]|3[0-1])/(0[1-9]|1[0-2])/[0-9]{4} (0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])$" value="<?php echo $tournament['time_tournament']; ?>" name="time" required>
        </div>
        <div class="form-group mini">
            <textarea placeholder="Description of the tournament" name="Tournament_Desc" id="Tournament_Desc" required><?php echo $tournament['description'];?></textarea>
        </div>
        <div class="captcha-placeholder">
        </div>
        <input type="submit" class="button" value="update your tournament">
        <div class="form-group text-center stay-connected">
        </div>
    </form>
</div>