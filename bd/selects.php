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

function getTodayDate():String{
    $todayDateRequest="select GETDATE() today";
    foreach($connexion->query($todayDate) as $row){
        $todayDate=$row["today"];
        return $todayDate;
    }
}

function getMaxDate($todayDate):String{
    $maxDateRequest="select DATE_SUB($todayDate, INTERVAL -7 DAY) maxDate";
    foreach($connexion->query($maxDateRequest) as $row){
        $maxDate=$row["maxDate"];
        return $maxDate;
    }
}

function getReservations7ProchainJours(int $idA):Reservations{
    $todayDate=getTodayDate();
    $maxDate=getMaxDate($todayDate);
    $reservations7ProchainsJours=new Reservations($idA);
    $idCoursReserves="select idC,idP from RESERVER where idA=$idA";
    foreach($connexion->query($idCoursReserves) as $row){
        $idC=$row["idC"];
        $idP=$row["idP"];
        $cours=getCoursFromId($idC);
        if($cours->getThisIfIn7Days($todayDate, $maxDate)!=null){
            $poney=getPoneyFromId($idP);
            $validReservation=new Reservation($cours, $poney);
            $reservations7ProchainsJours->addReservation($validReservation);
        }
    }
    return $reservations7ProchainsJours;
}

// TODO: infos adherent, cours, moniteurs, poneys, reservations adherents (planning)
?>