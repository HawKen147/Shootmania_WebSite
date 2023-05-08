<?php
session_start();

include_once("../controleur/action.php");

if (isset($_GET['section'])) {
    $section = htmlspecialchars($_GET['section']);
}

if (isset($_GET['verif']) && isset($_GET['everif'])) {
    $verif = htmlspecialchars($_GET['verif']);
    $everif = htmlspecialchars(($_GET['everif']));
}

if (isset($_SESSION['recup_logins'])) {
    $login = $_SESSION['recup_logins'];
};
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
                </a>
            </div>
        </div>
    </header>

    <main class="site-content">
        <div id="page">
            <div class="main identification">
                <h2 class="title-1">Password Lost</h2>
                <div class="identification-form sblock">
                    <form action="/controleur/password_recovery.php" method="post">
                        <?php if (isset($section) && $section == 'code') { ?>
                            <h3>Enter The Code For <h4> <?php echo $_SESSION['recup_logins']; ?> </h4>
                            </h3>
                            <div class="text-center error">
                                <?php //rentrer les erreurs 
                                ?>
                                <span class="text-center field-validation-valid helper">
                                </span>
                            </div>
                            <div class="form-group mini">
                                <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log (email) -->
                                <span class="text-center field-validation-valid helper">
                                </span>
                                <input id="login" name="logins" type="hidden" value="<?php echo ($login); ?>">
                                <input data-val-regex="Enter your code" data-val-required="use your code here." id="code" name="verif_code" placeholder="Your code here" type="text" value="" class="input-validation-error" aria-describedby="code-error" aria-invalid="true" required>
                            </div>
                            <input type="submit" class="button" value="submit" name="recup_code">

                        <?php }
                        if (isset($verif) && $verif == 'code' && isset($everif) && $everif == 'logins') {
                            $login = htmlspecialchars($_GET['logins']);
                            $code = htmlspecialchars($_GET['code']);
                        ?>
                            <h3>New Password Here <h4> <?php echo $_SESSION['recup_logins']; ?> </h4>
                            </h3>
                            <div class="text-center error">
                                <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log -->
                                <span class="text-center field-validation-valid helper">
                                </span>
                            </div>
                            <div class="form-group mini">
                                <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log (email) -->
                                <span class="text-center field-validation-valid helper">
                                </span>
                                <input type="hidden" name="logins" value="<?php echo ($login); ?>">
                                <input type="hidden" name="code" value="<?php echo ($code); ?>">
                                <input data-val-regex="Enter your new passord" data-val-required="use your code here." id="code" name="new_pass" placeholder="Your new passord here" type="password" value="" class="input-validation-error" aria-describedby="code-error" aria-invalid="true" required>
                            </div>
                            <input type="submit" class="button" value="submit" name="new_password">
                        <?php }
                        if (!isset($section) && !isset($everif)) { ?>
                            <h3>Use Your Login To Change Your Password</h3>
                            <div class="text-center error">
                                <?php // rentrer les erreurs de connexion 
                                ?>
                                <span class="text-center field-validation-valid helper">
                                </span>
                            </div>
                            <div class="form-group mini">
                                <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log (email) -->
                                <span class="text-center field-validation-valid helper">
                                </span>
                                <input data-val-regex="Enter a valid login adress please." data-val-regex-pattern="^([\w.+-]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([\w-]+\.)+[a-zA-Z]{2,}))$" data-val-required="You have to use your login here." id="login" name="login" placeholder="Your login here" type="text" value="" class="input-validation-error" aria-describedby="text-error" aria-invalid="true" required>
                            </div>
                            <input type="submit" class="button" value="submit" name="recup_logins">
                        <?php } ?>
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
</body>

</html>