<?php
$cssFile = "styles/accueil.css";
include 'header.php';
?>
    <div class="titre">
        <h1>Accueil<h1>
    </div>
    <div class="accueil_div">
        <button class="btn" onclick="window.location.href='plannings.php'">Consulter les plannings de cours</button>
        <button onclick="window.location.href='informations.php'">Consulter mes informations</button>
    </div>
    <div class="titre-deux">
        <h2>Mes cours dans les 7 prochains jours :</h2>
    </div>
</body>
</html>