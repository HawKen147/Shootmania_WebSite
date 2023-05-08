<?php if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION["utilisateur"])) {
        header("Location:../view/index.php");
    }
};

include_once("../controleur/action.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//FR">
<html>

<head>
    <?php include_once("header.php"); ?>
</head>

<body>
    <header>
        <div class="container">
            <div class="tunnel-header">
                <a id="logo" href="index.php">
                    <!--<img src=https://www.aht.li/3634677/Banniere_IRAE-2048x1152.png" alt="logo">-->
                </a>
            </div>
        </div>
    </header>

    <main class="site-content">
        <?php
        include("nav.php");
        ?>
        <div id="page">
            <div class="main identification">
                <div class="identification-form sblock">
                    <div class="form-group mini"> Use your Discord ID to receive a message when your tournament will start !</div>
                    <form action="../controleur/add_discord.php" method="post" name="discord-id">
                        <h3>Enter your discord ID here</h3>
                        <span class="text-center field-validation-valid helper" id="erreur">
                            <?php
                            if (isset($_SESSION['discord-err'])) {
                                echo ($_SESSION['discord-err']);
                                unset($_SESSION['discord-err']);
                            };
                            ?>
                        </span>
                        <div class="form-group mini">
                            <input name="discord" placeholder="Your Discord Login" type="text" value="" id="discord" required>
                        </div>
                        <input type="submit" class="button" value="Enter">
                    </form>
                    <div class="identification-sep"></div>
                    <div class="new-costumer">
                        <a href="https://techswift.org/2020/04/22/how-to-find-your-user-id-on-discord/" target="_blank" class="button">Don't know how to find it ? </a>
                    </div>
                </div>
            </div>
        </div>
        <script src="JS/form.js"></script>
    </main>
    <footer class="site-footer">
        <div class="down-page">
            <div class="text-footer">
                Made By HawKen
            </div>
        </div>
</body>

</html>