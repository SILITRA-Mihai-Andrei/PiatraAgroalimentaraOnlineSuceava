<?php

require_once('variables.php');
require_once('strings.php');
require_once ("utils.php");
require_once('UserClass.php');
require_once('ProductClass.php');

session_start();
if( isset($_GET['logout'])){
    session_destroy();
    header("Location: /login.php");
}

$user = NULL;
if(isset($_SESSION[STR_SESSION_USER])){
    $user = $_SESSION[STR_SESSION_USER];
}

if( $user == NULL ){
    echo '<script>alert("'.STR_MUST_LOGIN_TEXT.'");</script>';
    header("Location: /market");
}

if( isset($_GET['remove']) and $user != NULL ){
    $db->query("DELETE FROM bag WHERE id_produs = ".$_GET['remove']." AND id_user=".$user->getId());
}

if( (isset($_GET['minus']) or isset($_GET['plus'])) and $user != NULL ){
    $db->query("UPDATE bag SET amount=amount".
    (isset($_GET['minus']) ? "-" : "+")."1".
    " WHERE id_produs=".
    (isset($_GET['minus']) ? $_GET['minus'] : $_GET['plus']).
    " AND id_user=".$user->getId()." AND amount".(isset($_GET['minus']) ? ">" : ">=")."0");
    header("Location: /cumparaturi");
}

$sellers = $db->query("SELECT DISTINCT products.seller AS seller, sellers.NumeComplet AS name 
                        FROM products, users AS sellers, users AS buyers, bag 
                        WHERE products.seller=sellers.idUtilizator 
                            AND bag.id_user=buyers.idUtilizator 
                            AND bag.id_produs=products.id  
                            AND buyers.idUtilizator=".$user->getId());

if(isset($_GET['finish'])){  
    $buyer = $user->getId();          
    foreach($sellers as $seller){
        $sellerID = $seller['seller'];
        $bag = $db->query("SELECT name, products.id AS id, bag.amount AS amount 
                            FROM products, bag
                            WHERE id_produs = products.id 
                                AND seller=$sellerID 
                                AND id_user=".$user->getId());

        $id = $db->query("SELECT MAX(id) FROM orders")->fetchColumn() + 1;
        foreach($bag as $product){
            $db->query("INSERT INTO orders VALUES($id, $sellerID, $buyer, ".$product['id'].", ".$product['amount'].")");
            $db->query("DELETE FROM bag WHERE id_produs=".$product['id']);
            //header("Location: /cumparaturi");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Coșul de cumpărături</title>
    <?php echo getHead(); ?>
</head>

<body>
    <!-- Page Preloder 
    <div id="preloder">
        <div class="loader"></div>
    </div>-->

    <?php echo getHeader($db, $user); ?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="images/2.jpg">
        <div class="container">
            <div class="row">
                <?php echo getSecondHeader($db, FALSE); ?>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    
    <?php
        if($user != NULL){
            if($sellers->rowCount()>0){
                $cards = "";
            $subtotal = $total = 0;
            
            foreach($sellers as $seller){
                $sellerID = $seller['seller'];
                $bag = $db->query("SELECT name, products.id AS id, price, bag.amount AS amount, link 
                                    FROM products, bag, products_image 
                                    WHERE id_produs = products.id 
                                        AND products_image.id=products.id 
                                        AND seller=$sellerID 
                                        AND id_user=".$user->getId());
                $cards = $cards.'
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Produse vândute de '.$seller['name'].'</th>
                                <th>Preț</th>
                                <th>Cantitate</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                    <tbody>';                            
                foreach($bag as $product){
                    $cards = $cards.getShopcartProductCard($product);
                    $total = $total + ($product['price'] * $product['amount']);
                }
                $cards = $cards.'
                    </tbody>
                </table><br><br><br>';
            }
            
            $subtotal = $total;

            echo '<!-- Shoping Cart Section Begin -->
            <section class="shoping-cart spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shoping__cart__table">
                                '.$cards.'
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shoping__cart__btns">
                                <a href="/market" class="primary-btn cart-btn">CONTINUĂ CUMPĂRĂTURILE</a>
                                <a href="/cumparaturi" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                                    ACTUALIZEAZĂ</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="shoping__continue">
                                <div class="shoping__discount">
                                    <h5>Coduri de reducere</h5>
                                    <form action="#">
                                        <input type="text" placeholder="Introdu codul de reducere">
                                        <button type="submit" class="site-btn">APLICĂ CUPONUL</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="shoping__checkout">
                                <h5>Total de plată</h5>
                                <ul>
                                    <li>Subtotal <span>
                                        '.$subtotal.'.00 Lei
                                    </span></li>
                                    <li>Total <span>
                                        '.$total.'.00 Lei
                                    </span></li>
                                </ul>
                                <a href="?finish=true" class="primary-btn">FINALIZEAZĂ CUMPĂRĂTURILE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Shoping Cart Section End -->
            ';
            }
            else{
                echo "<div style='padding: 5%;'>Nu ai produse în coș!</div>";
            }
            
        }   
    ?>

    <?php echo getFooter(); ?>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>