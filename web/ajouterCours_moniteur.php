<?php
$cssFile = "styles/gestionCours.css";
include 'header_moniteur.php';

session_start();
$idM = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

require_once("../bd/selects.php");



$lesNiveaux = getNiveaux($connexion);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter'])) {
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

    addCours($connexion, $idM, $nomCours, $dureeCours, $dateCreneau, $heureCreneau, $niveauCours);

    header("Location: accueil_moniteur.php");
    
}
?>


<div class="titre">
    <h1>Modifier le cours :</h1>
</div>
<div>
    <form action="ajouterCours_moniteur.php" method="POST">
        <div>
            <label for="dateCreneau">Date :</label>
            <input type="date" id="dateCreneau" name="dateCreneau" required value=""><br>
            <label for="heureCreneau">Heure :</label>
            <input type="time" id="heureCreneau" name="heureCreneau" required value=""><br>
        </div>
        <div>
            <label for="nomCours">Nom du Cours :</label>
            <input type="text" id="nomCours" name="nomCours" required value=""><br>
            <label for="dureeCours">Durée du Cours (en heures) :</label>
            <input type="number" id="dureeCours" name="dureeCours" required min="1" value=""><br>
        </div>
        <div>
            <label>Niveau :</label><br>
            <?php if (empty($lesNiveaux)) : ?>
                <p>Aucun niveau disponible</p>
            <?php else : ?>
                <?php foreach ($lesNiveaux as $niveau) : ?>
                    <div>
                        <input type="radio" id="niveau<?php echo htmlspecialchars($niveau['niveauA']); ?>" name="niveauCours" value="<?php echo htmlspecialchars($niveau['niveauA']);?>">
                        <label for="niveau<?php echo htmlspecialchars($niveau['niveauA']); ?>"><?php echo htmlspecialchars($niveau['niveauA']); ?></label><br>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <br>
        <button type="submit" name="ajouter" class="btn border-1 border-dark btn-base">Ajouter</button>
    </form>
</div>