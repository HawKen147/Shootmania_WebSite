<?php
include_once("../controleur/action.php");
if (!isset($_SESSION)) {
    header("Location://test-site/Site/php/view/index.php");
};

if (est_admin() == false) {
    header("Location://test-site/Site/php/view/home.php");
}
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
        <?php
        if (est_HawKen()) {
        ?>
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
        <?php
        }
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
        <br>

        <?php
        affiche_tournois();
        ?>
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