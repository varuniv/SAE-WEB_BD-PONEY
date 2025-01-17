<?php
$cssFile = "styles/reserver.css";
include 'header.php';

session_start();
$idA = $_SESSION["user_id"];

require_once("../bd/connexion.php");
$connexion = connexionBd();

require_once("../bd/selects.php");

if (isset($_GET['idC'])) {
    $idC = $_GET['idC'];
}

$lesPoneys = getPoneys($connexion);

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
