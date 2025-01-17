<?php
$cssFile = "styles/accueil.css";
include 'header.php';

session_start();
$idM = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

if (isset($_GET['idC'])) {
    $idC = $_GET['idC'];
}

function getLeCours($connexion, $idC) {

    $sql = "SELECT idC, nomC AS nomCours, dateC AS dateCours, heureC AS heureCours, dureeC AS dureeCours, niveauC AS niveauCours FROM COURS WHERE idC= :idC";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':idC', $idC, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$leCours= getLeCours($connexion, $idC);

function getNiveaux($connexion) {
    $sql = "SELECT DISTINCT niveauA FROM ADHERANT";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $lesNiveaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $lesNiveaux;
}

function addCreneau($connexion, $dateCreneau, $heureCreneau){
    $insertSql = "INSERT INTO CRENEAU (dateC, heureC) VALUES (:dateC, :heureC)";
    $insertStmt = $connexion->prepare($insertSql);
    $insertStmt->bindParam(':dateC', $dateCreneau);
    $insertStmt->bindParam(':heureC', $heureCreneau);
    $insertStmt->execute();
}

function updateCours($connexion, $idC, $nomCours, $dureeCours, $dateCreneau, $heureCreneau, $niveauCours) {
    $sql = "UPDATE COURS SET nomC = :nomCours, dureeC = :dureeCours, dateC = :dateCreneau, heureC = :heureCreneau, niveauC = :niveauCours WHERE idC = :idC";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':nomCours', $nomCours);
    $stmt->bindParam(':dureeCours', $dureeCours, PDO::PARAM_INT);
    $stmt->bindParam(':dateCreneau', $dateCreneau);
    $stmt->bindParam(':heureCreneau', $heureCreneau);
    $stmt->bindParam(':niveauCours', $niveauCours);
    $stmt->bindParam(':idC', $idC, PDO::PARAM_INT);
    $stmt->execute();
}

if (isset($_GET['idC'])) {
    $idC = $_GET['idC'];
}

$lesNiveaux = getNiveaux($connexion);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modifier'])) {
    $nomCours = $_POST['nomCours'];
    $dureeCours = $_POST['dureeCours'];

    $dateCreneau = $_POST['dateCreneau'];
    $heureCreneau = $_POST['heureCreneau'];
    $niveauCours= $_POST['niveauCours'];

    $sql = "SELECT COUNT(*) FROM CRENEAU WHERE dateC = :dateC AND heureC = :heureC";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':dateC', $dateCreneau);
    $stmt->bindParam(':heureC', $heureCreneau);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        addCreneau($connexion, $dateCreneau, $heureCreneau);
    }

    updateCours($connexion, $idC, $nomCours, $dureeCours, $dateCreneau, $heureCreneau, $niveauCours);

    header("Location: accueil_moniteur.php");
    
}
?>


<div class="titre">
    <h1>Modifier le cours :</h1>
</div>
<div>
    <form action="modifierCours_moniteur.php?idC=<?php echo urlencode($idC); ?>" method="POST">
        <div>
            <label for="dateCreneau">Date :</label>
            <input type="date" id="dateCreneau" name="dateCreneau" required 
                value="<?php echo isset($leCours[0]['dateCours']) ? htmlspecialchars($leCours[0]['dateCours']) : ''; ?>"><br>

            <label for="heureCreneau">Heure :</label>
            <input type="time" id="heureCreneau" name="heureCreneau" required 
                value="<?php echo isset($leCours[0]['heureCours']) ? htmlspecialchars($leCours[0]['heureCours']) : ''; ?>"><br>
        </div>
        <div>
            <label for="nomCours">Nom du Cours :</label>
            <input type="text" id="nomCours" name="nomCours" required 
                value="<?php echo isset($leCours[0]['nomCours']) ? htmlspecialchars($leCours[0]['nomCours']) : ''; ?>"><br>

            <label for="dureeCours">Durée du Cours (en minutes) :</label>
            <input type="number" id="dureeCours" name="dureeCours" required min="1" value="<?php echo isset($leCours[0]['dureeCours']) ? htmlspecialchars($leCours[0]['dureeCours']) : ''; ?>"><br>
        </div>
        <div>
            <label>Niveau :</label><br>
            <?php if (empty($lesNiveaux)) : ?>
                <p>Aucun niveau disponible</p>
            <?php else : ?>
                <?php foreach ($lesNiveaux as $niveau) : ?>
                    <div>
                    <input type="radio" id="niveau<?php echo htmlspecialchars($niveau['niveauA']); ?>" name="niveauCours" value="<?php echo htmlspecialchars($niveau['niveauA']); ?>"
                    <?php echo (isset($leCours[0]['niveauCours']) && $leCours[0]['niveauCours'] == $niveau['niveauA']) ? 'checked' : ''; ?>>
                        <label for="niveau<?php echo htmlspecialchars($niveau['niveauA']); ?>"><?php echo htmlspecialchars($niveau['niveauA']); ?></label><br>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <br>
        <button type="submit" name="modifier" class="btn border-1 border-dark btn-base">Modifier</button>
    </form>
</div>