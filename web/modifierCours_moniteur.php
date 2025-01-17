<?php
$cssFile = "styles/gestionCours.css";
include 'header_moniteur.php';

session_start();
$idM = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

require_once("../bd/selects.php");


if (isset($_GET['idC'])) {
    $idC = $_GET['idC'];
}



$leCours= getLeCours($connexion, $idC);



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

if (isset($_POST['cancelCours']) && isset($_POST['idCancel'])) {
    $idCancel = $_POST['idCancel'];
    
    cancelCours($idCancel, $connexion);
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

            <label for="dureeCours">Durée du Cours (en heures) :</label>
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
<div class="cancel_cours_div">
    <form method="POST" onsubmit="return confirmCancel()">
        <input type="hidden" name="idCancel" value="<?php echo htmlspecialchars($idC); ?>">
        <button type="submit" name="cancelCours" class="btn border-1 border-dark btn-base">Annuler le cours</button>
    </form>
 </div>
 <script type="text/javascript">
    function confirmCancel() {
        return confirm("Êtes-vous sûr de vouloir faire cette action ?");
    }
</script>
</body>
</html>