<?php
require_once("connexion.php");
use bdClasses\adherant;
use bdClasses\moniteur;
use bdClasses\personne;
use bdClasses\poney;
$connexion=connexionBd();

function getAdherantFromId(int $idA):Adherant{
    $adherantAttrsGenerauxBd="select * from PERSONNE where id=$idA";
    $adherantBd="select * from ADHERANT where idA=$idA";

    $adherant=null;
    foreach($connexion->query($adherantBd) as $row){
        $poidsA=$row["poidsA"];
        $niveauA=$row["niveauA"];
    }
    foreach($connexion->query($adherantAttrsGenerauxBd) as $row){
        $prenomA=$row["prenom"];
        $nomA=$row["nom"];
        $adresseA=$row["adresse"];
        $mailA=$row["mail"];
        $ageA=$row["age"];
    }
    $adherant=new Adherant($idA, $prenomA, $nomA, $adresseA, $mailA, $ageA, $poidsA, $niveauA);
    return $adherant;
}

function getMoniteurFromId(int $idM):Moniteur{
    $moniteurAttrsGenerauxBd="select * from PERSONNE where id=$idM";
    $moniteurBd="select * from MONITEUR where idM=$idM";

    $moniteur=null;
    foreach($connexion->query($moniteurBd) as $row){
        $salaireM=$row["salaireM"];
        $anneeRecrutement=$row["anneeRecrutement"];
    }
    foreach($connexion->query($moniteurAttrsGenerauxBd) as $row){
        $prenomM=$row["prenom"];
        $nomM=$row["nom"];
        $adresseM=$row["adresse"];
        $mailM=$row["mail"];
        $ageM=$row["age"];
    }
    $moniteur=new Moniteur($idM, $prenomM, $nomM, $adresseM, $mailM, $ageM, $salaireM, $anneeRecrutement);
    return $moniteur;
}

function getPoneyFromId(int $idP):Poney{
    $poneyBd="select * from PONEY where idP=$idP";
    $poney=null;
    foreach($connexion->query($poneyBd) as $row){
        $nomP=$row["nomP"];
        $poidsMaxP=$row["poidsMax"];
    }
    $poney=new Poney($idP, $nomP, $poidsMaxP);
    return $poney;
}

function getCoursFromId($idC):Cours{
    $coursBd="select * from COURS where idC=$idC";
    $cours=null;
    foreach($connexion->query($coursBd) as $row){
        $idC=$row["idC"];
        $nomCours=$row["nomC"];
        $nbPersonnesMax=$row["nbPersMax"];
        $dureeCours=$row["dureeC"];
        $idM=$row["idM"];
        $moniteur=getMoniteurFromId($idM);
        $dateCours=$row["dateC"];
        $heureCours=$row["heureC"];
        $niveauCours=$row["niveauC"];
    }
    $cours=new Cours($idC, $nomCours, $nbPersonnesMax, $dureeCours, $dateCours, $heureCours, $niveauCours);
    return $cours;
}

function getCours7ProchainJours($idM, $connexion) {
    $todayDate = date('Y-m-d');
    $maxDate = date('Y-m-d', strtotime('+7 days'));

    $sql = "SELECT C.idC, C.nomC AS nomCours, C.dateC AS dateCours, C.heureC AS heureCours, C.dureeC AS dureeCours, C.niveauC AS niveauCours
            FROM COURS C
            JOIN MONITEUR M ON C.idM = M.idM
            WHERE M.idM = :idM
            AND C.dateC BETWEEN :todayDate AND :maxDate;";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':idM', $idM, PDO::PARAM_INT);
    $stmt->bindParam(':todayDate', $todayDate);
    $stmt->bindParam(':maxDate', $maxDate);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReservations7ProchainJours($idA, $connexion) {
    $todayDate = date('Y-m-d');
    $maxDate = date('Y-m-d', strtotime('+7 days'));

    $sql = "
        SELECT c.nomC AS nomCours, c.dateC AS dateCours, c.heureC AS heureCours, c.dureeC AS dureeCours, c.niveauC AS niveauCours, p.nomP AS nomPoney, r.idC AS idC
        FROM RESERVER r
        INNER JOIN COURS c ON r.idC = c.idC
        INNER JOIN PONEY p ON r.idP = p.idP
        WHERE r.idA = :idA
        AND c.dateC BETWEEN :todayDate AND :maxDate
    ";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':idA', $idA, PDO::PARAM_INT);
    $stmt->bindParam(':todayDate', $todayDate);
    $stmt->bindParam(':maxDate', $maxDate);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getIdCoursMax($connexion){
    $sql = "SELECT MAX(idC) FROM COURS";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $idMax = $stmt->fetchColumn();
    return (int) $idMax;
}



function addCours($connexion, $idM, $nomCours, $dureeCours, $dateCreneau, $heureCreneau, $niveauCours) {
    $idC= getIdCoursMax($connexion) + 1;
    $sql = "INSERT INTO COURS values (:idC, :nomCours, 10, :dureeCours, :idM, :dateCreneau, :heureCreneau, :niveauCours)";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':idM', $idM);
    $stmt->bindParam(':nomCours', $nomCours);
    $stmt->bindParam(':dureeCours', $dureeCours, PDO::PARAM_INT);
    $stmt->bindParam(':dateCreneau', $dateCreneau);
    $stmt->bindParam(':heureCreneau', $heureCreneau);
    $stmt->bindParam(':niveauCours', $niveauCours);
    $stmt->bindParam(':idC', $idC, PDO::PARAM_INT);
    $stmt->execute();
}

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

function getReservations($idA, $connexion) {

    $sql = "
        SELECT c.nomC AS nomCours, c.dateC AS dateCours, c.heureC AS heureCours, c.dureeC AS dureeCours, c.niveauC AS niveauCours, p.nomP AS nomPoney,r.idC AS idC
        FROM RESERVER r
        INNER JOIN COURS c ON r.idC = c.idC
        INNER JOIN PONEY p ON r.idP = p.idP
        WHERE r.idA = :idA
    ";
    

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':idA', $idA, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cancelReservation($idC, $connexion) {
    $deleteReservationRequest = "DELETE FROM RESERVER WHERE idC = :idC";
    $stmt = $connexion->prepare($deleteReservationRequest);
    $stmt->bindParam(':idC', $idC, PDO::PARAM_INT);
    $stmt->execute();
    
}

function getPersonneByEmail($email, $connexion) {
    $sql = "SELECT * FROM PERSONNE WHERE mail = :email";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

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

function cancelCours($idC, $connexion) {
    $deleteCours= "DELETE FROM COURS WHERE idC = :idC";
    $stmt = $connexion->prepare($deleteCours);
    $stmt->bindParam(':idC', $idC, PDO::PARAM_INT);
    $stmt->execute();
}

function getLeCours($connexion, $idC) {

    $sql = "SELECT idC, nomC AS nomCours, dateC AS dateCours, heureC AS heureCours, dureeC AS dureeCours, niveauC AS niveauCours FROM COURS WHERE idC= :idC";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':idC', $idC, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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

function getPoneys($connexion) {
    $sql = "SELECT idP, nomP AS nomPoney FROM PONEY";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour insérer la réservation
function addReservation($idA, $idC, $idP, $connexion): void {
    $insertReservation = "INSERT INTO RESERVER (idA, idP, idC) VALUES (:idA, :idP, :idC)";
    $stmt = $connexion->prepare($insertReservation);
    $stmt->bindParam(':idA', $idA, PDO::PARAM_INT);
    $stmt->bindParam(':idC', $idC, PDO::PARAM_INT);
    $stmt->bindParam(':idP', $idP, PDO::PARAM_INT);
    $stmt->execute();
}
?>