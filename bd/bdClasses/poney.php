<?php

namespace classes;
class Poney{
    private int $idP;
    private String $nomP;
    private int $poidsMax;

    public function __construct(int $idP, String $nomP, int $poidsMax){
        $this->$idP=$idP;
        $this->$nomP=$nomP;
        $this->$poidsMax=$poidsMax;
    }

    public function getId():int{
        return $this->$idP;
    }

    public function getNom():String{
        return $this->$nomP;
    }

    public function getPoidsMax():int{
        return $this->$poidsMax;
    }

    public function setId(int $idP):void{
        $this->$idP=$idP;
    }

    public function setNom(String $nom):void{
        $this->$nomP=$nomP;
    }

    public function setPoidsMax(int $poidsMax):void{
        $this->$poidsMax=$poidsMax;
    }
}
?>