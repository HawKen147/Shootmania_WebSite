<?php
session_start();
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
                </a>
            </div>
        </div>
    </header>

    <main class="site-content">
        <div id="page">
            <div class="main identification">
                <div>
                    <p>The e-mail has been sent. Check your e-mail box. </p>
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