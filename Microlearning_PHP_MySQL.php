<?php

require_once('User.php');

// Variabile pentru conexiunea cu baza de date
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laboratoare";

$db = new PDO("mysql:host=$servername; dbname=$dbname; charset=utf8", $username, $password);


$id = 4;
$command = "SELECT * FROM users WHERE id=$id";
$result = $db->query($command);
if($result == FALSE or $result == NULL){
    echo "Comanda incorecta!"."<br>";
    print_r($db->errorInfo());
}
else if($result->rowCount()==0){
    echo "Nici o inregistrare selectata!"."<br>";
}
else{
    echo "Comanda reusita!"."<br>"  ;
    $user = $result->fetchObject("User");
    echo $user->getNume();
}

?>