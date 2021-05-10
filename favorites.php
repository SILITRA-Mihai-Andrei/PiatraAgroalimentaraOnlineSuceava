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
    header("Location: /favorites");
}

if( isset($_GET['remove']) and $user != NULL ){
    $db->query("DELETE FROM favorites WHERE id_produs = ".$_GET['remove']." AND id_user=".$user->getId());
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Favorite</title>
    <?php echo getHead(); ?>
</head>

<body>
    <!-- Page Preloder 
    <div id="preloder">
        <div class="loader"></div>
    </div>-->

    <?php echo getHeader($db, $user); ?>
    
    <?php
        if($user != NULL){
            $bag = $db->query("SELECT name, products.id AS id, price, bag.amount AS amount, link 
            FROM products, bag, products_image 
            WHERE id_produs = products.id AND products_image.id=products.id AND id_user=".$user->getId());
            $cards = "";
            $subtotal = $total = 0;                                    
            foreach($bag as $product){
                $cards = $cards.
                '<tr>
                    <td class="shoping__cart__item">
                        <img src="images/products/'.$product['link'].'" alt="">
                        <h5>'.$product['name'].'</h5>
                    </td>
                    <td class="shoping__cart__price">
                        '.$product['price'].' Lei
                    </td>
                </tr>';
                $total = $total + ($product['price'] * $product['amount']);
            }
            $subtotal = $total;

            echo '<!-- Shoping Cart Section Begin -->
            <section class="shoping-cart spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shoping__cart__table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="shoping__product">Produse</th>
                                            <th>Preț</th>
                                        </tr>
                                    </thead>
                                    <tbody>
        
                                        '.$cards.'

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Shoping Cart Section End -->
            ';
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