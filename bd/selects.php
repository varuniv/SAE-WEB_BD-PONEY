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

function getReservations7ProchainJours($idA, $connexion) {
    $todayDate = date('Y-m-d');
    $maxDate = date('Y-m-d', strtotime('+7 days'));

    $sql = "
        SELECT c.nomC AS nomCours, c.dateC AS dateCours, c.heureC AS heureCours, c.dureeC AS dureeCours, c.niveauC AS niveauCours, p.nomP AS nomPoney
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

function getReservations($idA, $connexion) {

    $sql = "
        SELECT c.nomC AS nomCours, c.dateC AS dateCours, c.heureC AS heureCours, c.dureeC AS dureeCours, c.niveauC AS niveauCours, p.nomP AS nomPoney
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
?>