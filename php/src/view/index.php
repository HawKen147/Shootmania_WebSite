<?php
session_start();

include_once("../controleur/create_tables.php");
if (isset($_GET['invite']) & isset($_GET['id_teams']) & isset($_GET['limit'])){
    $id_teams = htmlspecialchars($_GET['id_teams']);
    $invite = htmlspecialchars($_GET['invite']);
    $limit = htmlspecialchars($_GET['limit']);
    $link = '?id_teams=' . $id_teams . '&invite=' . $invite . '&limit=' . $limit;
}
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
        <div id="page">
            <div class="main identification">
                <h2 class="title-1">Connect</h2>
                <div class="identification-form sblock">
                    <form action="/controleur/connect.php" method="post">
                        <h3>Connect here</h3>
                        <div class="text-center error">
                            <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log -->
                            <span class="text-center field-validation-valid helper">
                                <?php if (isset($_SESSION['log'])){ echo $_SESSION['log']; unset($_SESSION['log']);} ?>
                            </span>
                        </div>
                        <div class="form-group mini">
                            <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log (email) -->
                            <span class="text-center field-validation-valid helper">
                            </span>
                            <input data-default-value="" data-val="true" data-val-maxlength="Your login must be shorter than 50 characters." data-val-maxlength-max="50" data-val-required="You must use your login." maxlength="50" name="login" placeholder="Your Login" type="text" value="" required>
                        </div>
                        <div class="form-group mini">
                            <input data-val-regex-pattern="(?!&quot;)((?!&amp;#|<[a-zA-Z!\/?]).)*" data-val-required="You must use a valide password" id="password" name="password" placeholder="Your password" type="password" minlength="8" required>
                        </div>
                        <div class="captcha-placeholder">
                        </div>
                        <a class="forgot-password" href="password_recover.php" id="partialLostPasswordLink">You lost your password ?</a>
                        <?php if (isset($link)) { echo ('<input type="hidden" value="' . $link . '" name="link"> ');}?>
                        <input type="submit" class="button" value="log in">
                    </form>
                    <div class="identification-sep"></div>
                    <div class="new-costumer">
                        <h3 class="title-3"> New here ?</h3>
                        <a class="button" href="register.php">Register here</a>
                    </div>
                </div>
            </div>
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

