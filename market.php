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

if( isset($_GET['buy']) and $user != NULL ){
    $db->query("INSERT INTO bag VALUES (".$user->getId().", ".$_GET['buy'].", 1)");
    header("Location: ". $cumparaturi_page_server."?id=".$_GET['buy']);
}
elseif(isset($_GET['addToCard']) and $user != NULL){
    $db->query("INSERT INTO bag VALUES (".$user->getId().", ".$_GET['addToCard'].", 1)");
    header("Location: ".$market_page_server);
}

if(isset($_GET['addFavorite']) and $user != NULL){
    $db->query("INSERT INTO favorites VALUES (".$user->getId().", ".$_GET['addFavorite'].")");
    header("Location: ".$market_page_server);
}
elseif(isset($_GET['removeFavorite']) and $user != NULL){
    $db->query("DELETE FROM favorites WHERE id_user=".$user->getId()." AND id_product=".$_GET['removeFavorite']);
    header("Location: ".$market_page_server);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Market</title>
    <?php echo getHead(); ?>
</head>

<body>
    <!-- Page Preloder 
    <div id="preloder">
        <div class="loader"></div>
    </div>-->

    <?php echo getHeader($db, $user); ?>

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                
                <?php echo getSecondHeader($db); ?>

                    <?php
                        $products = ProductClass::loadProducts($db);
                        $counter = 0;
                        $found = 0;
                        echo '<div class="row">';
                        foreach ($products as $product){
                            if(isset($_GET['search'])){
                                if(!empty($_GET['search'])){
                                    $product_name = mb_strtolower($product->getName(),'UTF-8');
                                    $search = mb_strtolower($_GET['search'],'UTF-8');
                                    if (strpos(" ".$product_name, $search) == FALSE and strpos(" ".$search, $product_name) == FALSE) {
                                            continue;
                                    }
                                }                                
                            }
                            if(isset($_GET['category'])){
                                if($_GET['category'] != $product->getCategoryName()){
                                    continue;
                                }
                            }
                            $found++;
                            if($counter!=0 and ++$counter % 3 == 0) 
                                echo '</div><div class="row">';
                            echo getCard($db, $product, $user);
                        }
                        echo '</div>';
                        if(count($products) == 0 or $found == 0) echo 'Nici un produs găsit.';                       
                    ?>
                    

                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Produse speciale</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">Toate</li>
                            <?php
                                $special_categories = $db->query('SELECT name FROM categories WHERE special=1');
                                foreach($special_categories as $sc){
                                    echo '<li data-filter=".'.$sc["name"].'">'.$sc["name"].'</li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                
                <?php 
                    $special_products = ProductClass::loadProducts($db, TRUE);
                    foreach($special_products as $sp){
                        echo getSpecialCard($db, $sp, $user);
                    }    
                ?>
            
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Cele mai noi produse</h4>
                        <div class="latest-product__slider owl-carousel">

                                <?php
                                    $counter = 1;
                                    $special_products = ProductClass::loadProducts($db);
                                    echo '<div class="latest-product__slider__item">';
                                    foreach($special_products as $sp){
                                        if($counter++ % 3 == 0) {
                                            echo '</div><div class="latest-product__slider__item">';
                                        }
                                        echo getLatestProductCard($db, $sp, $user);
                                    }
                                    echo '</div>';
                                    if(count($special_products) == 0){
                                        echo 'Nici un produs găsit.';
                                    } 
                                ?>
                                
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Cele mai populare</h4>
                        <div class="latest-product__slider owl-carousel">

                                <?php
                                    $counter = 1;
                                    $special_products = ProductClass::loadProducts($db);
                                    echo '<div class="latest-product__slider__item">';
                                    foreach($special_products as $sp){
                                        if($counter++ % 3 == 0) {
                                            echo '</div><div class="latest-product__slider__item">';
                                        }
                                        echo getLatestProductCard($db, $sp);
                                    }
                                    echo '</div>';
                                    if(count($special_products) == 0){
                                        echo 'Nici un produs găsit.';
                                    } 
                                ?>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Cele mai vandute</h4>
                        <div class="latest-product__slider owl-carousel">
                            
                                <?php
                                    $counter = 1;
                                    $special_products = ProductClass::loadProducts($db);
                                    echo '<div class="latest-product__slider__item">';
                                    foreach($special_products as $sp){
                                        if($counter++ % 3 == 0) {
                                            echo '</div><div class="latest-product__slider__item">';
                                        }
                                        echo getLatestProductCard($db, $sp);
                                    }
                                    echo '</div>';
                                    if(count($special_products) == 0){
                                        echo 'Nici un produs găsit.';
                                    } 
                                ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

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