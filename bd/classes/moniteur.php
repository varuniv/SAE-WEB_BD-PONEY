<?php
class Moniteur extends Personne{
    private int $idM;
    private int $salaire;
    private int $anneeRecrutement;

    public function __construct(int $idM, String $prenom, String $nom, String $adresse, String $mail, int $age, int $salaire, int $anneeRecrutement){
        parent::__construct($idM, $prenom, $nom, $adresse, $mail, $age);
        $this->$idM=$idM;
        $this->$salaire=$salaire;
        $this->$anneeRecrutement=$anneeRecrutement;
    }

    public function getId():int{
        return $this->$idM;
    }

    public function getSalaire():int{
        return $this->$salaire;
    }

    public function getAnneeRecrutement():int{
        return $this->$anneeRecrutement;
    }

    public function setId(int $idM):void{
        parent::setId($idM);
        $this->idM=$idM;
    }
}
?>