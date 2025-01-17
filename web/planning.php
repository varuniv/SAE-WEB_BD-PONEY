<?php
$cssFile = "styles/planning.css";
include 'header.php';

session_start();
$idA = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

function getCoursNonInscrit($connexion, $idA) {
    $sqlNiveau = "SELECT niveauA FROM ADHERANT WHERE idA = :idA";
    $stmtNiveau = $connexion->prepare($sqlNiveau);
    $stmtNiveau->bindParam(':idA', $idA, PDO::PARAM_INT);
    $stmtNiveau->execute();
    $niveauA = $stmtNiveau->fetchColumn();

    $sql = "
        SELECT C.idC, C.nomC AS nomCours, C.dateC AS dateCours, C.heureC AS heureCours, C.dureeC AS dureeCours, C.niveauC AS niveauCours FROM COURS C
        WHERE C.niveauC = :niveauA
        AND C.idC NOT IN (SELECT R.idC FROM RESERVER R WHERE R.idA = :idA)
    ";
    
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':niveauA', $niveauA, PDO::PARAM_STR);
    $stmt->bindParam(':idA', $idA, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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