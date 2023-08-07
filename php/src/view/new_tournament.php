<?php if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION["utilisateur"])) {
        header("Location://test-site/Site/php/view/index.php");
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
                    <!--    <img src="image/Banniere_IRAE.png" alt="logo">-->
                </a>
            </div>
        </div>
    </header>
    <main class="site-content">
        <?php
        include("nav.php");
        ?>
        <?php
        if (isset($_GET['edit'])){
            include_once('../model/update_tournament.php');
        } else {
            include_once('../model/create_tournament.php');
        }
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