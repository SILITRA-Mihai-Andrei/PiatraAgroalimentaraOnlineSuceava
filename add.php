<?php 

require_once('variables.php');

if(!isset($_GET['user'])){
    echo '<div name="no_user">Trebuie să fii logat cu un cont!</div>';
}
else{
    if(isset($_GET['pass'])){
        $result = $db->query("SELECT idUtilizator, Tip FROM users WHERE user=".$_GET['user']." AND Parola=".$_GET['pass']);
    }
    else{
        $result = $db->query("SELECT idUtilizator, Tip FROM users WHERE user=".$_GET['user']);
    }
    if($result == FALSE or $result->rowCount() == 0){
        echo '<div name"not_found">Nu s-a găsit nici un cont cu aceste date!</div>';
    }
    else{
        $id = 0;
        $tip = 0;
        foreach($result as $user){
            $id = $user['idUtilizator'];
            $tip = $user['Tip'];
            break;
        }
        if($tip == 0 and $id > 0){
            echo '<div name"not_seller">Nu ești înregistrat ca vânzător!</div>';
        }
        else{
            echo '<div name"seller_id">'.$id.'</div>
                <div name="seller_tip">Vânzător</div>';
            if(isset($_GET['add'])){
                $product = $_GET['add'];
                $result = $db->query("INSERT INTO products VALUES($product)");
                if($result == FALSE){
                    echo '<div name="insert_failed">Date invalide!</div>';
                }
                else{
                    echo '<div name="insert_successful">Produs înregistrat!</div>';
                    $productInfoArray = explode(',', $_GET['add']);
                    $newId = $db->query("SELECT id FROM products WHERE name=".$productInfoArray['1']." AND seller=$id")->fetchColumn();
                    $db->query("INSERT INTO inventories VALUES($newId, ".
                        (isset($_GET['stoc']) ? $_GET['stoc'] : "0").", ".$productInfoArray['6'].")");
                    $db->query("INSERT INTO products_image VALUES($newId, default.jpg)");
                }
            }
        }
    }
}

?>

<html>
<head>
    <title>Adaugă un produs</title>
    <meta charset="UTF-8">
    <meta name="description" content="Piata agroalimentară SUCEAVA">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="piata, agro, agroalimentara, suceava, on-line, cumparaturi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/logo.png">
</head>

<body></body>

</html>