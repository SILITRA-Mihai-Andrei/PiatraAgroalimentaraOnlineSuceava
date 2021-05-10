<?php

class User {
    
public $id;
public $nume;
public $facultate;

public function __construct () {}
public function User() {}

public static function loadUserById ($pdo, $id) {
    $result = $pdo->prepare('SELECT * FROM users WHERE id=?');
    $result->execute([$id]);
    return $result->fetchObject(__CLASS__);
 }

public function getId(){
    return $this->id;
}

public function getNume(){
    return $this->nume;
}

public function getFacultate(){
    return $this->facultate;
}

}
