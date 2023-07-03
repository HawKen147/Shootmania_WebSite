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
        <div id="page">

            <div class="main identification">

                <h2 class="title-1">Create Now</h2>
                <div class="identification-form sblock">
                    <div class="form-group">How to create a tournament ?</div>
                    <div class="form-group">Your tournament needs a name (50 characters max) </div>
                    <div class="form-group">You have to write the description of your tournament (how your tournament will works)</div>
                    <div class="form-group">You have to say which mode will be your tournament (elite, SpeedBall, infection ....)</div>
                    <div class="form-group">You can use an image with the link (you can use dropbox or google drive or others) </div>
                    <div class="form-group">You can also give the link of the shootmania server where the tournament will take place. </div>

                    <form action="../controleur/New_Tournament.php" method="post">
                        <h3>Create Your Tournament</h3>
                        <div class="text-center error">
                            <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log -->
                            <span class="text-center field-validation-valid helper">
                            </span>
                        </div>
                        <div class="form-group mini">
                            <!-- ici mettre les codes codes erreurs de l'utilisateur qui se log (email) -->
                            <span class="text-center field-validation-valid helper">
                            </span>
                            <input placeholder="Name of the Tournament" name="Tournament_Name" id="Tournament_Name" maxlength="50" required>
                        </div>
                        <div class="form-group mini">
                            <input placeholder="Mode of the tournament" name="Tournament_mode" id="Tournament_mode" required>
                        </div>
                        <div class="form-group mini">
                            <input pattern="[1-5]{1}" min="1" max="5" placeholder="Number of player per team" name="Tournament_nb_player" id="Tournament_nb_player" required>
                        </div>
                        <div class="form-group mini">
                            <input type="url" pattern="https://.*" placeholder="Image of the tournament" name="Image_Tournament" id="Image_Tournament">
                        </div>
                        <div class="form-group mini">
                            <input placeholder="Link of the Shootmania Serveur" name="Serv_Link" id="Serv_Link">
                        </div>
                        <div class="form-group mini">
                            <input id="time" type="datetime-local" name="time" required>
                        </div>
                        <div class="form-group mini">
                            <textarea placeholder="Description of the tournament" name="Tournament_Desc" id="Tournament_Desc" required></textarea>
                        </div>
                        <div class="captcha-placeholder">
                        </div>
                        <input type="submit" class="button" value="Create">
                        <div class="form-group text-center stay-connected">
                        </div>
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