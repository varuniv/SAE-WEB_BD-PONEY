<?php

namespace classes;
class Adherant extends Personne{
    private int $idA;
    private int $poids;
    private String $niveau;

    public function __construct(int $idA, String $prenom, String $nom, String $adresse, String $mail, int $age, int $poids, String $niveau){
        parent::__construct($idA, $prenom, $nom, $adresse, $mail, $age);
        $this->$idA=$idA;
        $this->$poids=$poids;
        $this->$niveau=$niveau;
    }

    public function getId():int{
        return $this->$idA;
    }

    public function getPoids():int{
        return $this->$poids;
    }

    public function getNiveau():String{
        return $this->$niveau;
    }

    public function setId(int $idA):void{
        parent::setId($idA);
        $this->$idA=$idA;
    }

    public function setPoids(int $poids):void{
        $this->$poids=$poids;
    }

    public function setNiveau(String $niveau):void{
        $this->$niveau=$niveau;
    }

    public function __toString():String{
        $attrsGeneraux=parent::__toString();
        $adherant="Id de ladhérant: $idA, $attrsGeneraux, Poids: $poids, Niveau: $niveau";
        return $adherant;
    }
}

?>