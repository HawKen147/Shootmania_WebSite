<?php
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
                <a id="logo" href="./index.php">
                    <!--    <img src="image/Banniere_IRAE.png" alt="logo">-->
                </a>
            </div>
        </div>
    </header>
    <main class="site-content">
        <div class="main identification">
            <h2 class="title-1">Register</h2>
            <div class="identification-form sblock">
                <form action="../controleur/reg.php" method="post">
                    <h3>Register here</h3>
                    <div class="text-center error">
                        <span class="text-center field-validation-valid helper">
                            <?php if(isset($_SESSION['err'])){echo $_SESSION['err']; unset($_SESSION['err']);};?>
                        </span>
                    </div>
                    <div class="form-group mini">
                        <input data-val-maxlength="Your login must be shorter than 50 characters." data-val-maxlength-max="50" data-val-required="You must use your login." maxlength="50" name="login" placeholder="Your Login" type="text" value="" required>
                    </div>
                    <div class="form-group mini">
                        <input data-val-regex-pattern="(?!&quot;)((?!&amp;#|<[a-zA-Z!\/?]).)*" data-val-required="You must use a valide password" id="pass" name="mot_de_passe" placeholder="Your password" type="password" minlength="8" required>
                    </div>
                    <div class="form-group mini">
                        <input data-val-regex-pattern="(?!&quot;)((?!&amp;#|<[a-zA-Z!\/?]).)*" data-val-required="You must use a valide password" id="password" name="confirmation" placeholder="confirm your password" type="password" minlength="8" required>
                    </div>
                    <div class="form-group mini">
                        <input data-val-maxlength="Your email adress must be shorter than 50 characters." data-val-regex="Enter a vallide email adress please." data-val-regex-pattern="^([\w.+-]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([\w-]+\.)+[a-zA-Z]{2,}))$" data-val-required="Vous devez indiquer votre adresse email." id="Email" name="email" placeholder="Email" type="email" value="" class="input-validation-error" aria-describedby="Email-error" aria-invalid="true" required>
                    </div>
                    <input type="submit" class="button" value="submit">
                </form>
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