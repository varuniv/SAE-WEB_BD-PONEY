<?php
$cssFile = "styles/planning.css";
include 'header.php';

session_start();
$idA = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

require_once("../bd/selects.php");



$lesCours = getCoursNonInscrit($connexion, $idA);
?>

    <div class="titre">
        <h1>Prochains Cours :<h1>
    </div>
    <div class="planning_div">
        <?php if (empty($lesCours)) : ?>
            <p>Aucun cours réservé</p>
        <?php else : ?>
            <?php foreach ($lesCours as $cours) : ?>
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
                        <a class="btn border-1 border-dark btn-base" href="reserver.php?idC=<?php echo urlencode($cours['idC']); ?>">Réserver</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>