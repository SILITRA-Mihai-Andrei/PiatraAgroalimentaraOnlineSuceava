<?php
class UserClass {
    
public $idUtilizator;
public $user;
public $Email;
public $NumeComplet;
public $Telefon;
public $Localitate;
public $Adresa;
public $Tip;
public $Depozit;
public $Parola;

public function __construct () {}

public function getId(){
    return $this->idUtilizator;
}

public function getUser(){
    return $this->user;
}

public function getEmail(){
    return $this->Email;
}

public function getNumeComplet() {
    return $this->NumeComplet;
}

public function getTelefon(){
    return $this->Telefon;
}

public function getLocalitate(){
    return $this->Localitate;
}

public function getAdresa(){
    return $this->Adresa;
}

public function getTip(){
    return $this->Tip;
}

public function getDepozit(){
    return $this->Depozit;
}

public function getParola(){
    return $this->Parola;
}

}
