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

function addReservation($idA, $idC, $idP, $connexion):void{
    $insertReservation="insert into RESERVER values($idA, $idP, $idC)";
    $stmt=$connexion->prepare($insertReservation);
    $stmt->execute();
}

if (isset($_POST['idPoney'])) {
    $idPoney = $_POST['idPoney'];
    addReservation($idA, $idC ,$idPoney, $connexion);
}

?>

    <div class="titre">
        <h1>Réserver le cours :<h1>
    </div>
    <div class="titre-deux">
        <h2 class="pt-4">Choisissez un poney :</h2>
    </div>
    <div class="poneys">
        <form method="POST">
            <?php if (empty($lesPoneys)) : ?>
                <p>Aucun poney disponible</p>
            <?php else : ?>
                <?php foreach ($lesPoneys as $poney) : ?>
                    <div>
                    <input type="radio" id="idPoney" name="choix" value=<?php echo htmlspecialchars($poney['idP']); ?>>
                    <label for=<?php echo htmlspecialchars($poney['nomPoney']); ?>><?php echo htmlspecialchars($poney['nomPoney']); ?></label><br>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <br>
            <button type="submit" name="reserver" class="btn border-1 border-dark btn-base">Réserver</button>
        </form>
    </body>
</html>