<?php

namespace bdClasses;
class Cours{
    private int $idC;
    private String $nomCours;
    private int $nbPersonnesMax;
    private int $dureeCours;
    private String $dateCours;
    private String $heureCours;
    private String $niveauCours;
    private int $idM;

    public function __construct(int $idC, String $nomCours, int $nbPersonnesMax, int $dureeCours, String $dateCours, String $heureCours, String $niveauCours, int $idM){
        $this->$idC=$idC;
        $this->$nomCours=$nomCours;
        $this->$nbPersonnesMax=$nbPersonnesMax;
        $this->$dureeCours=$dureeCours;
        $this->$dateCours=$dateCours;
        $this->$heureCours=$heureCours;
        $this->$niveauCours=$niveauCours;
        $this->$idM=$idM;
    }

    public function getId():int{
        return $this->$idC;
    }

    public function getNomCours():String{
        return $this->$nomCours;
    }

    public function getNbPersonnesMax():int{
        return $this->$nbPersonnesMax;
    }

    public function getDureeCours():int{
        return $this->$dureeCours;
    }

    public function getDateCours():String{
        return $this->$dateCours;
    }

    public function getHeureCours():String{
        return $this->$heureCours;
    }

    public function getNiveauCours():String{
        return $this->$niveauCours;
    }

    public function getIdMoniteur():int{
        return $this->$idM;
    }

    public function setId(int $idC):void{
        $this->$idC=$idC;
    }

    public function setNomCours(String $nomCours):void{
        $this->$nomCours=$nomCours;
    }

    public function setNbPersonnesMax(int $nbPersonnesMax):void{
        $this->$nbPersonnesMax=$nbPersonnesMax;
    }

    public function setDureeCours(int $dureeCours):void{
        $this->$dureeCours=$dureeCours;
    }

    public function setDateCours(String $dateCours):void{
        $this->$dateCours=$dateCours;
    }

    public function setHeureCours(String $heureCours):void{
        $this->$heureCours=$heureCours;
    }

    public function setNiveauCours(String $niveauCours):void{
        $this->$niveauCours=$niveauCours;
    }

    public function setIdMoniteur(int $idM):void{
        $this->$idM=$idM;
    }

    public function dateIsIn7DaysMaximum(String $todayDate, String $maxDate):bool{
        return $todayDate<=$dateCours && $dateCours<=$maxDate;
    }

    public function getThisIfIn7Days(String $todayDate, String $maxDate):Cours{
        if(dateIsIn7DaysMaximum($todayDate, $maxDate)){
            return $this;
        }
        return null;
    }
}
?>