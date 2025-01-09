<?php

namespace bdClasses;
use bdClasses\reservation;
class Reservations{
    private int $idA;
    private array $reservations;

    public function __construct(int $idA){
        $this->$idA=$idA;
        $this->$reservations=array();
    }

    public function addReservation(Reservation $reservation):void{
        array_push($this->$reservations, $reservation);
    }

    public function removeReservation(Reservation $reservation):void{
        array_diff($this->$reservations, $reservation);
    }
}
?>