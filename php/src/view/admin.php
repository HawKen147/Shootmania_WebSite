<?php
include_once("../controleur/action.php");
if (!isset($_SESSION)) {
    header("Location:../index.php");
};

if (est_admin() == false) {
    header("Location:../view/home.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include_once("../model/header.php"); ?>
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
        include("../model/nav.php");
        ?>
        <span class="erreur">
        <?php
        if (isset($_SESSION['add_admin'])) {
            echo $_SESSION['add_admin'];
            unset($_SESSION['add_admin']);
        }
        echo "<br>";
        if (isset($_SESSION['del_admin'])) {
            echo $_SESSION['del_admin'];
            unset($_SESSION['del_admin']);
        }
        ?>
        </span>
        <h3>Add an Administrator</h3>
        <form name="add-admin" action="/controleur/add_admin.php" method="post">
            <div class="form-group">
                <div class="add-admin">
                    <select name="login" id="logins0">
                        <?php
                        affiche_user_no_admin();
                        ?>
                    </select>
                    <div class="input">
                        <input class="button" id="boutton_admin" type="submit" name="add_admin" value="send">
                    </div>
                </div>
            </div>
        </form>
            <form name="delx-admin" action="/controleur/add_admin.php" method="post">
                <h3>Delete an admin</h3>
                <div class="form-group">
                    <div class="add-admin">
                        <select name="login" id="logins1">
                            <?php

                            affiche_user_admin();
                            ?>
                        </select>
                        <div class="input">
                            <input class="button" id="boutton_del" type="submit" name="del_admin" value="send">
                        </div>
                    </div>
                </div>
            </form>
        <br>
        <h4>Add a link</h4>
        <span class="erreur">
            <?php if (isset($_SESSION['link'])){ echo $_SESSION['link']; unset($_SESSION['link']);} ?>
        </span>
        <form action="../controleur/add_link.php" method="post">
            <select name="media_type" id="" required>
                <option value="">chose the type of the media</option>
                <option value="discord">Discord</option>
                <option value="media">Media</option>
                <option value="youtube_channel">Youtube channel</option>
                <option value="web_site">Web site</option>
                <option value="ressources">Ressources</option>
            </select>
            <input type="text" maxlength="50" name="media_name" placeholder="Name of the media" require>
            <input type="text" maxlength="50" name="link" placeholder="The link to access to this media (https://)" pattern="https://.*" required>
            <input type="submit" value="send" class="button">
        </form>
    </main>
    <footer class="site-footer">
        <?php include_once('../model/footer.php'); ?>
    </footer>
</body>

</html>