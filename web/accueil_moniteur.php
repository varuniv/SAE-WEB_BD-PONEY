<?php
$cssFile = "styles/accueil.css";

include 'header_moniteur.php';

session_start();
$idM = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

require_once("../bd/selects.php");



$coursProchains = getCours7ProchainJours($idM, $connexion)
?>
<div class="titre">
    <h1>Accueil</h1>
</div>
<div class="accueil_div">
    <a class="btn border-1 border-dark btn-base p-3" href="ajouterCours_moniteur.php">Ajouter un cours</a>
    <a class="btn border-1 border-dark btn-base p-3" href="compte_moniteur.php">Consulter mes informations</a>
</div>
<div class="titre-deux">
    <h2>Mes cours dans les 7 prochains jours :</h2>
</div>
<div class="planning_div">
    <?php if (empty($coursProchains)) : ?>
        <p>Aucun cours réservé dans les 7 prochains jours.</p>
    <?php else : ?>
        <?php foreach ($coursProchains as $cours) : ?>
            <div class="cours_div">
                <div class="cours_nom">
                    <h3><?php echo htmlspecialchars($cours['nomCours']); ?></h3>
                </div>
                <div>
                    <p class="description"><?php echo htmlspecialchars($cours['dateCours']); ?></p>
                    <p><?php echo htmlspecialchars($cours['heureCours']); ?></p>
                </div>
                <div class="f_ligne">
                    <p style="margin-right: 4px;">Durée : </p>
                    <p><?php echo htmlspecialchars($cours['dureeCours']); ?></p>
                </div>
                <div class="f_ligne">
                    <p style="margin-right: 4px;">Niveau : </p>
                    <p><?php echo htmlspecialchars($cours['niveauCours']); ?></p>
                </div>
                <div>
                    <a class="btn border-1 border-dark btn-base" href="modifierCours_moniteur.php?idC=<?php echo urlencode($cours['idC']); ?>">Modifier</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>