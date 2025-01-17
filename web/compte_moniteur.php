<?php
$cssFile = "styles/compte.css";

include 'header.php';

session_start();
$idM = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

function getCours($idM, $connexion) {
    $sql = "SELECT C.idC, C.nomC AS nomCours, C.dateC AS dateCours, C.heureC AS heureCours, C.dureeC AS dureeCours, C.niveauC AS niveauCours
            FROM COURS C
            JOIN MONITEUR M ON C.idM = M.idM
            WHERE M.idM = :idM;";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':idM', $idM, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$stmt = $connexion->prepare('SELECT * FROM PERSONNE WHERE id = :idM');
$stmt->bindParam(':idM', $idM, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch();

$coursProchains = getCours($idM, $connexion)
?>

    <div class="titre">
        <h1>Informations du compte :<h1>
    </div>
    <div class="compte_div">
        <h3><?php echo htmlspecialchars($result['prenom']); echo " ";  echo htmlspecialchars($result['nom']);?></h3>
        <p>Adresse : <?php echo " ";  echo htmlspecialchars($result['adresse']);?></p>
        <p>Mail : <?php echo " ";  echo htmlspecialchars($result['mail']);?></p>
    </div>
    <div class="titre-deux">
        <h2>Mes cours :<h2>
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