<?php

require_once("User.php");

class UserExtended extends User {
    
public $facultate_nume;

public function __construct () {}
public function UserExtended() {}

public static function loadUserById ($pdo, $id) {
    $result = $pdo->prepare('SELECT * FROM users, facultati WHERE users.id=facultati.id AND users.id=?');
    $result->execute([$id]);
    return $result->fetchObject(__CLASS__);
 }

public function getFacultateNume(){
    return $this->facultate_nume;
}

}
