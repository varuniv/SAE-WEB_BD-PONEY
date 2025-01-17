<?php
$cssFile = "styles/accueil.css";
include 'header.php';

session_start();
$idA = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

require_once("../bd/selects.php");



if (isset($_POST['cancel']) && isset($_POST['idCancel'])) {
    $idCancel = $_POST['idCancel'];
    
    cancelReservation($idCancel,$connexion);
}




$coursProchains = getReservations7ProchainJours($idA, $connexion)
?>
<div class="titre">
    <h1>Accueil</h1>
</div>
<div class="accueil_div">
    <a class="btn border-1 border-dark btn-base p-3" href="planning.php">Consulter les plannings de cours</a>
    <a class="btn border-1 border-dark btn-base p-3" href="compte.php">Consulter mes informations</a>
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
                <div class="f_ligne">
                    <div style="margin-right:10px;">
                        <img src="img/icon_cheval.png" alt="Icon de cheval" style="width: 50px; height: 50px;">
                    </div>
                    <div style="display: flex; align-items: center;">
                        <p style="margin-bottom: 0 !important;"><?php echo htmlspecialchars($cours['nomPoney']); ?></p>
                    </div>
                </div>
                <div>
                    <form method="POST" onsubmit="return confirmCancel()">
                        <input type="hidden" name="idCancel" value="<?php echo htmlspecialchars($cours['idC']); ?>">
                        <button type="submit" name="cancel" class="btn border-1 border-dark btn-base">Annuler la réservation</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


<script type="text/javascript">
    function confirmCancel() {
        return confirm("Êtes-vous sûr de vouloir faire cette action ?");
    }
</script>

</body>
</html>