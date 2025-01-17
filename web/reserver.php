<?php
$cssFile = "styles/reserver.css";
include 'header.php';

session_start();
$idA = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

if (isset($_GET['idC'])) {
    $idC = $_GET['idC'];
}

function getPoneys($connexion) {
    $sql = "SELECT idP, nomP AS nomPoney FROM PONEY";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$lesPoneys = getPoneys($connexion);

// Fonction pour insérer la réservation
function addReservation($idA, $idC, $idP, $connexion): void {
    $insertReservation = "INSERT INTO RESERVER (idA, idP, idC) VALUES (:idA, :idP, :idC)";
    $stmt = $connexion->prepare($insertReservation);
    $stmt->bindParam(':idA', $idA, PDO::PARAM_INT);
    $stmt->bindParam(':idC', $idC, PDO::PARAM_INT);
    $stmt->bindParam(':idP', $idP, PDO::PARAM_INT);
    $stmt->execute();
}

if (isset($_POST['idPoney'])) {
    $idPoney = $_POST['idPoney']; // ID du poney sélectionné dans le formulaire
    addReservation($idA, $idC, $idPoney, $connexion); // Insertion dans la base
    header("Location: accueil.php");
}

?>

<div class="titre">
    <h1>Réserver le cours :</h1>
</div>
<div class="titre-deux">
    <h2 class="pt-4">Choisissez un poney :</h2>
</div>
<div class="poneys">
    <form action="reserver.php?idC=<?php echo urlencode($idC); ?>" method="POST">
        <?php if (empty($lesPoneys)) : ?>
            <p>Aucun poney disponible</p>
        <?php else : ?>
            <?php foreach ($lesPoneys as $poney) : ?>
                <div>
                    <input type="radio" id="idPoney<?php echo $poney['idP']; ?>" name="idPoney" value="<?php echo $poney['idP']; ?>">
                    <label for="idPoney<?php echo $poney['idP']; ?>"><?php echo htmlspecialchars($poney['nomPoney']); ?></label><br>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <br>
        <button type="submit" name="reserver" class="btn border-1 border-dark btn-base">Réserver</button>
    </form>
</div>
</body>
</html>
