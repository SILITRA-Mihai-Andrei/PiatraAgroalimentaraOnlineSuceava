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

if(isset($_GET['produs'])){
    $product = ProductClass::loadProductById($db, $_GET['produs']);
    if(isset($_GET['addToCard']) and $user != NULL){
        $result = $db->query("SELECT id_user FROM bag WHERE id_user=".$user->getId()." and id_produs=".$product->getId());
        if($result == FALSE or $result->rowCount()==0){
            $db->query("INSERT INTO bag VALUES(".$user->getId().", ".$product->getId().", ".
                (isset($_GET['amount']) ? $_GET['amount'] : 1).")");
        }
        else{
            $db->query("UPDATE bag SET id_user=".$user->getId().", id_produs=".$product->getId().
                ", amount=".(isset($_GET['amount']) ? $_GET['amount'] : 1)." WHERE id_user=".
                $user->getId()." and id_produs=".$product->getId());
        }
        header("Location: ./produse?produs=".$_GET['produs']);
    }
}
else{
    header("Location: not-found.html");
}

if(isset($_GET['addFavorite']) and $user != NULL){
    $db->query("INSERT INTO favorites VALUES (".$user->getId().", ".$_GET['addFavorite'].")");
    header("Location: /produse?produs=".$product->getId());
}
elseif(isset($_GET['removeFavorite']) and $user != NULL){
    $db->query("DELETE FROM favorites WHERE id_user=".$user->getId()." AND id_product=".$_GET['removeFavorite']);
    header("Location: /produse?produs=".$product->getId());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?php echo $product->getName() ?>
    </title>
    <?php echo getHead(); ?>
</head>

<body>
    <!-- Page Preloder 
    <div id="preloder">
        <div class="loader"></div>
    </div>-->

    <?php echo getHeader($db, $user); ?>
    <?php $isFavorite = isFavoriteProduct($db, $user, $product->getId()); ?>

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src=
                                <?php 
                                    $product_image = getProductImage($db, $product);
                                    echo "images/products/$product_image";
                                 ?>
                                 alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">

                            <?php 
                                $counter = 1;
                                $file = "images/products/".$product->getId()."_".$counter.".jpg";
                                while(file_exists($file)){
                                    echo '<img data-imgbigurl="'.$file.'"
                                        src="'.$file.'" alt="">';
                                        $file = "images/products/".$product->getId()."_".++$counter.".jpg";;
                                }
                            ?>

                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5">
                    <div class="product__details__text">
                        <h3>
                            <div style="float: right; text-align: center;">
                                <b style="font-size: 14px;"> <?php echo $product->getSellerName() ?> </b>
                                <br>
                                <img 
                                <?php 
                                    echo 'src="images/avatars/'.
                                    $db->query("SELECT link FROM avatars WHERE id=".$product->getSeller())->fetchColumn(); 
                                    echo '"';
                                ?> 
                                    style="width: 150px; height: 150px; border-radius: 50%;"> 
                            </div>
                            <?php echo $product->getName() ?>
                        </h3>
                        
                        <div class="product__details__price">
                            <?php echo $product->getPrice()." Lei" ?>
                        </div>       
                                         
                        <div class="product__details__rating">
                            <span>
                                <?php echo $product->getAmount()." ".$product->getAmountType() ?>
                            </span>
                        </div>
                        <br><br>
                        <p>
                            <?php echo $product->getDescription()!=NULL ? $product->getDescription() : 
                                    "Acest produs nu are nici o descriere!" ?>
                        </p>
                        
                        <div class="custom_quantity">
                            <a 
                                <?php
                                    if($user != NULL){
                                        echo ' href="?produs='.$product->getId().'&quantity='.
                                        (isset($_GET['quantity']) ? 
                                            ($_GET['quantity']>1 ? $_GET['quantity']-1 : 1 ) : 1).'"';
                                    }
                                ?>
                            >
                                <div class="custom_quantity_btn minusQuantity"> - </div></a>
                            <span style="vertical-align: middle;">
                                <?php 
                                    if($user != NULL){
                                        $amount_db = $db->query("SELECT amount FROM bag WHERE id_produs=".
                                            $product->getId()." AND id_user=".$user->getId());
                                        echo isset($_GET['quantity']) ? $_GET['quantity'] : 
                                                ($amount_db==FALSE or $amount_db->rowCount()==0 ? 1 : $amount_db->fetchColumn());
                                    }
                                    else{
                                        echo "Necesară autentificare!";
                                    }
                                ?>
                            </span>
                            <a 
                                <?php
                                    if($user != NULL){
                                        echo ' href="?produs='.$product->getId().'&quantity='.
                                        (isset($_GET['quantity']) ? $_GET['quantity']+1 : 2).'"';
                                    }
                                ?>
                            >
                                <div class="custom_quantity_btn plusQuantity"> + </div></a>
                        </div>  
                        
                        <br>
                        <a class="primary-btn " 
                            <?php echo $product->getInventory()==0 ? " style='background-color: gray;'" : 
                                                    "href='/produse?produs=".$product->getId()."&addToCard=1"
                                                    ."&amount=".(isset($_GET['quantity']) ? $_GET['quantity'] : 1 )."'" ?>  
                        > ADAUGĂ ÎN COȘ</a>
                        <a class="favorite-btn"
                            <?php 
                                echo $user==NULL ? "" : ('href="'.currentUrl().
                                        ($isFavorite ? "removeFavorite=" : "addFavorite=").$product->getId()).'"';
                            ?>
                        >
                            <i style="color: <?php echo ($isFavorite ? 'red' : 'black').';" class="fa '.
                                ($isFavorite ? 'fa-heart' : 'fa-heart-o')?>"></i>  
                        </a>
                        <ul>
                            <li><b>Stoc</b> <span>
                                <?php echo ($product->getInventory()>0 ? $product->getInventory()." ".
                                    $product->getInventoryAmountType() : 
                                    "<span style='color: red;'>TERMINAT</span>") ?>    
                            </span></li>
                            <li><b>Depozit</b> 
                                <?php 
                                    $deposit = $db->query("SELECT ".STR_DEPOSIT_DB." FROM users WHERE ".STR_ID_DB."=".
                                            $product->getSeller())->fetchColumn();
                                    echo $deposit==NULL ? "<span><samp>Doar livrare prin curier!</samp></span>" :
                                                        "<span>".$deposit."</span>";
                                    echo "</li>";
                                ?>
                            <li><b>Capacitate</b> 
                            <span>
                                    <?php 
                                        echo $product->getAmount()." ".$product->getAmountType();
                                    ?>
                            </span></li>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active">Descriere</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>
                                        <?php echo $product->getSellerName() ?> spune despre acest produs:</h6>
                                    <p>
                                        <?php echo $product->getDescription()!=NULL ? $product->getDescription() : 
                                    "Acest produs nu are nici o descriere!" ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

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