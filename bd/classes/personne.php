<?php
abstract class Personne{
    private int $id;
    private String $prenom;
    private String $nom;
    private String $adresse;
    private String $mail;
    private int $age;

    public function __construct(int $id, String $prenom, String $nom, String $adresse, String $mail, int $age){
        $this->$id=$id;
        $this->$prenom=$prenom;
        $this->$nom=$nom;
        $this->$adresse=$adresse;
        $this->$mail=$mail;
        $this->$age=$age;
    }

    public function getId():int{
        return $this->$id;
    }

    public function getPrenom():String{
        return $this->$prenom;
    }

    public function getNom():String{
        return $this->$nom;
    }

    public function getAdresse():String{
        return $this->$adresse;
    }

    public function getMail():String{
        return $this->$mail;
    }

    public function getAge():int{
        return $this->$age;
    }

    public function setId(int $id):void{
        $this->$id=$id;
    }

    public function setPrenom(String $prenom):void{
        $this->$prenom=$prenom;
    }

    public function setNom(String $nom):void{
        $this->$nom=$nom;
    }

    public function setAdresse(String $adresse):void{
        $this->$adresse=$adresse;
    }

    public function setMail(String $mail):void{
        $this->$mail=$mail;
    }

    public function setAge(int $age):void{
        $this->$age=$age;
    }
}
?>