<?php

namespace bdClasses;
class Reservation{
    private Cours $cours;
    private Poney $poney;

    public function __construct(Cours $cours, Poney $poney){
        $this->$cours=$cours;
        $this->$poney=$poney;
    }

    public function getCours():Cours{
        return $this->$cours;
    }

    public function getPoney():Poney{
        return $this->$poney;
    }

    public function setCours(Cours $cours):void{
        $this->$cours=$cours;
    }

    public function setPoney(Poney $poney):void{
        $this->$poney=$poney;
    }
}
?>