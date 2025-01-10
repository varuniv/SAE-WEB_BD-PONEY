<?php
$cssFile = "styles/accueil.css";
include 'header.php';
?>
    <div class="titre">
        <h1>Accueil<h1>
    </div>
    <div class="accueil_div">
        <a class="btn border-1 border-dark btn-base p-3" href="planning.php">Consulter les plannings de cours</a>
        <a class="btn border-1 border-dark btn-base p-3" href="compte.php">Consulter mes informations</a>
    </div>
    <div class="titre-deux">
        <h2>Mes cours dans les 7 prochains jours :</h2>
    </div>
    <div class="planning_div">
        <div class="cours_div">
            <div>
                <h3>Nom du cours</h3>
            </div>
            <div>
                <p class="description">25/02/2024</p>
                <p>12:00:00</p>
            </div>
            <div class="f_ligne">
                <p style="margin-right: 4px;">Durée : </p>
                <p>1H</p>
            </div>
            <div class="f_ligne">
                <p style="margin-right: 4px;">Niveau : </p>
                <p>Junior</p>
            </div>
            <div class="f_ligne">
                <div style=" margin-right:10px;">
                    <img src="img/icon_cheval.png" alt="Icon de cheval" style="width: 50px;height: 50px;">
                </div>
                <div style="display: flex;align-items: center;">
                    <p style="margin-bottom: 0 !important;">Abyss<p>
                </div>
            </div>
            <div>
                <a class="btn border-1 border-dark btn-base">Annuler la réservation</a>
            </div>
        </div>
    </div>
</body>
</html>