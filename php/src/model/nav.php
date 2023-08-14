<nav>
  <ul>
    <li class="menu-deroulant">
      <a href="home.php">Home</a>
      <ul class="sous-menu">
        <li><a href="new_tournament.php">Create a new tournament</a></li>
        <li><a href="sb_cups.php">SpeedBall funcups</a></li>
      </ul>
    </li>
    <li><a href="links.php">Links</a></li>
    <li class="menu-deroulant">
      <a href="profile.php?name=<?php echo ($_SESSION["utilisateur"]); ?>">My Profile</a> <!-- affiche le variable name de l'utilisateur ($_SESSION["utilisateur"])-->
      <ul class="sous-menu">
        <li><a href="../view/my_teams.php">My teams</a></li>
      </ul>
    </li>
    <?php if (est_admin()) {
    ?>
      <li><a href="../view/admin.php">Administration</a></li>
    <?php }  ?>
    <li><a href="../controleur/disconect.php">Log out</a></li>
  </ul>
</nav>