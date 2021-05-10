<?php 

require_once('variables.php');
require_once('strings.php');
require_once ("utils.php");
require_once('UserClass.php');
require_once('ProductClass.php');

$sep = "#";

$user = NULL;

if(isset($_GET['send'])){
    $order = $_GET['send'];
    $db->query("DELETE FROM orders WHERE id=$order");
    exit;
}

if(isset($_GET["user"]) and isset($_GET["pass"])){
    $user = UserClass::loadUserByUserAndPassword($db, $_GET["user"], $_GET['pass']);
    if($user == NULL){
        echo "Date de logare invalide!";
        exit;
    }
    else{
        $login = "users.".(isEmail($_GET['user']) ? "Email" : "user")."='".$_GET['user']."'";
        $result = $db->query("SELECT avatars.link AS avatar, users.NumeComplet AS name, users.Email as email, users.Telefon 
                        AS mobile, users.Localitate AS address1, users.Adresa AS address2, users.Depozit AS deposit 
                        FROM users, avatars WHERE users.idUtilizator=avatars.id AND $login;");
        foreach($result as $info){
            $mobile = $info['mobile'] == "" ? " " : $info['mobile'];
            $deposit = $info['deposit'] == "" ? " " : $info['deposit'];
            echo $info['avatar'].$sep.$info['name'].$sep.$info['email'].$sep.$mobile
                .$sep.$info['address1']." ".$info['address2'].$sep.$deposit;
        }

        echo "&";

        $login = (isEmail($_GET['user']) ? "Email" : "user")."='".$_GET['user']."'";
        $result = $db->query("SELECT orders.id AS ID, link, name AS product, price, amount_type, orders.amount AS amount, buyers.NumeComplet AS name, 
                                buyers.Email AS email, buyers.Telefon AS mobile, buyers.Localitate AS address1, buyers.Adresa AS address2
                                FROM orders, users as sellers, users as buyers, products, products_image 
                                WHERE orders.seller=sellers.idUtilizator AND orders.buyer=buyers.idUtilizator
                                    AND orders.product=products.id 
                                    AND products.id=products_image.id
                                    AND sellers.$login;");
        foreach($result as $info){
            $amount_type = $info['amount_type'] == "" ? " " : $info['amount_type'];
            $mobile = $info['mobile'] == "" ? " " : $info['mobile'];
            echo $info['ID'].$sep.$info['link'].$sep.$info['product'].$sep.$info['price'].$sep.$amount_type
                .$sep.$info['amount'].$sep.$info['name'].$sep.$info['email'].$sep
                .$mobile.$sep.$info['address1']." ".$info['address2']."+";
        }
    }   
}
else{
    echo "Date de logare invalide!";
    exit;
}

?>