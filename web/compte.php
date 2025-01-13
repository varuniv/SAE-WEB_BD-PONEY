<?php
$cssFile = "styles/compte.css";
include 'header.php';

session_start();
$idA = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

function getReservations($idA, $connexion) {

    $sql = "
        SELECT c.nomC AS nomCours, c.dateC AS dateCours, c.heureC AS heureCours, c.dureeC AS dureeCours, c.niveauC AS niveauCours, p.nomP AS nomPoney,r.idC AS idC
        FROM RESERVER r
        INNER JOIN COURS c ON r.idC = c.idC
        INNER JOIN PONEY p ON r.idP = p.idP
        WHERE r.idA = :idA
    ";
    

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':idA', $idA, PDO::PARAM_INT);;
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cancelReservation($idC) {
    $deleteReservationRequest = "DELETE FROM RESERVER WHERE idC = :idC";
    $connexion = connexionBd();
    $stmt = $connexion->prepare($deleteReservationRequest);
    $stmt->bindParam(':idC', $idC, PDO::PARAM_INT);
    $stmt->execute();
    
    

}

if (isset($_POST['cancel']) && isset($_POST['idCancel'])) {
    $idCancel = $_POST['idCancel'];
    
    cancelReservation($idCancel);
}

$coursProchains = getReservations($idA, $connexion)
?>

    <div class="titre">
        <h1>Informations du compte :<h1>
    </div>
    <div class="compte_div">
        <h3>Michel</h3>
    </div>
    <div class="titre-deux">
        <h2>Mes réservations :<h2>
    </div>
    <div class="planning_div">
        <?php if (empty($coursProchains)) : ?>
            <p>Aucun cours réservé</p>
        <?php else : ?>
            <?php foreach ($coursProchains as $cours) : ?>
                <div class="cours_div">
                    <div>
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