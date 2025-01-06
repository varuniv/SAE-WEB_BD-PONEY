<?php
require_once("connexion.php");
$connexion=connexionBd();

function getAdherantFromId($idA){
    $adherantAttrsGenerauxBd="select * from PERSONNE where id=$idA";
    $adherantBd="select * from ADHERANT where idA=$idA";

    $adherant=null;
    // Créer l'adhérant
}

// TODO: infos adherent, cours, moniteurs, poneys, reservations adherents (planning)
?>